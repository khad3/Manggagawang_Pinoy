<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Applicant\ApplicantPortfolioModel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Applicant\RegisterModel;
use App\Models\Applicant\PersonalModel as PersonalInfo;
use App\Models\Applicant\ExperienceModel as WorkBackground;
use App\Models\Applicant\TemplateModel as Template;
use App\Models\Applicant\ApplicantFriendModel as AddFriend;
use App\Models\Applicant\SendMessageModel as SendMessage;
use App\Models\Applicant\SavedJobModel as SavedJob;

use App\Models\Applicant\ApplyJobModel as ApplyJob;
use App\Models\Admin\AnnouncementModel;
use App\Notifications\Applicant\FriendRequestNotification;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


use App\Models\Employer\AccountInformationModel as EmployerInfo;

use Illuminate\Support\Facades\DB;
use App\Models\Employer\JobDetailModel;

use App\Mail\Applicant\VerifyEmail as VerifyEmail;
use App\Models\Applicant\ApplicantPostCommentModel;
use App\Models\Applicant\ApplicantPostModel;
use App\Models\Applicant\ApplicantUrlModel;
use App\Models\Applicant\ExperienceModel;
use Faker\Provider\ar_EG\Person;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\App;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Support\Facades\Auth;


class ApplicantController extends Controller
{


    //index
    public function index(){
        return view('landingpage.index');
    }

    public function topWorkers(){
        return view('landingpage.topworker');
    }

    public function aboutUs(){
        return view('landingpage.aboutus');
    }


    //Registration form
    public function ShowRegistrationForm(){
        
        return view('applicant.auth.register');
    }
    //Register Store
  public function Register(Request $request){
    $request->validate([
        'username' => 'required|string|max:50',
        'email' => 'required|email|unique:applicants,email',
        'password' => [
            'required',
            'string',
            'min:8',             // at least 8 characters
            'regex:/[a-zA-Z]/',  // must contain letters
            'regex:/[0-9]/',     // must contain digits
            'regex:/[\W]/'       // must contain symbols (non-word chars)
        ],
        'password_confirmation' => 'required|same:password',
        'terms' => 'accepted',
    ]);

    $verificationCode = mt_rand(100000, 999999);
    $expirationDate = Carbon::now()->addMinutes(10);

    // Create the applicant and save verification code + expiration
    $applicant = RegisterModel::create([
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'verification_code' => $verificationCode,
        'term' => 'accepted',
        'email_verification_code_expires_at' => $expirationDate,
        'is_verified' => false, 
    ]);

    session(['applicant_id' => $applicant->id]);
    // Send the verification code by email
    Mail::to($applicant->email)->send(new VerifyEmail($verificationCode));

    return redirect()->route('verification.display')->with([
        'success' => 'Registration successful. Please input the 6-digit code sent to your email.',
        'email' => $applicant->email
    ]);
} 

public function ShowVerifyForm(){
    
    return view('applicant.auth.verification');
}

   public function Verify(Request $request)
{
    // Validate the code only
    $request->validate([
        'verification_code' => 'required|numeric|digits:6',
    ]);

    // Find the applicant using the code
    $applicant = RegisterModel::where('verification_code', $request->verification_code)->first();

    // If no applicant found with this code
    if (!$applicant) {
        return back()->withErrors(['verification_code' => 'Invalid verification code.']);
    }

    // Check if the verification code has expired
    if ($applicant->email_verification_code_expires_at && $applicant->email_verification_code_expires_at < now()) {
        return back()->withErrors(['verification_code' => 'Verification code has expired.']);
    }

    // Mark the applicant as verified and clear the verification code
    $applicant->is_verified = 1;
    $applicant->email_verification_code_expires_at = null;
    $applicant->save();

    return redirect()->route('info.personal')->with('success', 'Email verified successfully.');
}

public function ShowPersonalInfoForm()
{
    $applicantId = session('applicant_id'); // adjust if you use a different key
    $applicant = RegisterModel::findOrFail($applicantId);

    return view('applicant.auth.personal', compact('applicant'));
}

public function PersonalInfo(Request $request)
{

    $applicantId = session('applicant_id');
    $request->validate([
        'first_name'    => 'required|string|max:50',
        'last_name'     => 'required|string|max:50',
        'gender'        => 'required|in:Male,Female,Other',
        'house_street'  => 'required|string|max:100',
        'city'          => 'required|string|max:50',
        'province'      => 'required|string|max:80',
        'zipcode'       => 'required|numeric|digits:4',
        'barangay'      => 'required|string|max:80',
        'id'  => 'required|exists:applicants,id',
    ]);

    $applicant = RegisterModel::findOrFail($applicantId);

    $personal_info = new PersonalInfo($request->only([
        'first_name', 'last_name', 'gender', 'house_street', 'city', 'province', 'zipcode', 'barangay'
    ]));

    // Save via relation
    $applicant->personal_info()->save($personal_info);

    return redirect()->route('applicant.info.workbackground.display')
        ->with('success', 'Personal information saved successfully.');
}


// Work background and also send profile picture
public function ShowWorkBackgroundForm()
{
    $applicantId = session('applicant_id');
    $applicant = RegisterModel::findOrFail($applicantId);
    return view('applicant.auth.workbackground', compact('applicant'));
}


public function WorkBackground(Request $request)
{
    $applicantId = session('applicant_id');

    $request->validate([
        'position' => 'required|string',
        'other_position' => 'nullable|string',
        'work_duration' => 'required|numeric',
        'work_duration_unit' => 'required|string',
        'employed' => 'required|string',
        'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $applicant = RegisterModel::findOrFail($applicantId);

    // Store the image
    $imagePath = $request->file('profile_picture')->store('profile_picture', 'public');

    // Create the WorkBackground entry
    $work_background = new WorkBackground([
        'position' => $request->position,
        'other_position' => $request->other_position,
        'work_duration' => $request->work_duration,
        'work_duration_unit' => $request->work_duration_unit,
        'employed' => $request->employed,
        'profileimage_path' => $imagePath,
    ]);

    // Save via relation
    $applicant->work_background()->save($work_background);

    return redirect()->route('applicant.info.template.display')
        ->with('success', 'Work background saved successfully.');
}

//Final step to register 
public function ShowTemplateFormForm()
{
    $applicantId = session('applicant_id');

    if (!$applicantId) {
        return redirect()->route('some.previous.step')->withErrors('Applicant ID not found in session!');
    }

    $personalInfo = PersonalInfo::where('applicant_id', $applicantId)->first();
    $workBackground = WorkBackground::where('applicant_id', $applicantId)->first();

    if (!$personalInfo || !$workBackground) {
        return redirect()->route('some.previous.step')->withErrors('Incomplete applicant data!');
    }

    return view('applicant.auth.finalStepTemplate', [
        'personalinfo' => $personalInfo,
        'workexperience' => $workBackground
    ]);
}

public function TemplateForm(Request $request)
{
    $applicantId = session('applicant_id');

    if (!$applicantId) {
        return back()->withErrors('Applicant ID not found in session!');
    }

    // Validate common fields
    $request->validate([
        'description' => 'required|string|min:50',
    ]);

    // Optional: Validate file OR YouTube link (not both required, but at least one)
    if ($request->hasFile('sample_work')) {
        $request->validate([
            'sample_work' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png,mp4|max:10240', // 10MB
        ]);
    } elseif ($request->filled('sample_work_url')) {
        $request->validate([
            'sample_work_url' => ['required', 'url', 'regex:/^https?:\/\/(www\.)?(youtube\.com\/watch\?v=|youtu\.be\/).+/'],
        ]);

    }

    // Get related records
    $personalInfo = PersonalInfo::where('applicant_id', $applicantId)->first();
    if (!$personalInfo) {
        return back()->withErrors('No personal info found for applicant.');
    }

    $workBackground = WorkBackground::where('applicant_id', $applicantId)->first();
    if (!$workBackground) {
        return back()->withErrors('No work experience found for applicant.');
    }

    // Handle file upload
    $sampleWorkFile = null;
    if ($request->hasFile('sample_work')) {
        $sampleWorkFile = $request->file('sample_work')->store('sample_works', 'public');
    }

    // Create new template
    $template = new Template([
        'description' => $request->description,
        'sample_work' => $sampleWorkFile, // this can be null
        'sample_work_url' => $request->sample_work_url, // this can also be null
        'applicant_id' => $applicantId,
        'personal_info_id' => $personalInfo->id,
        'work_experience_id' => $workBackground->id,
    ]);

    $template->save();

    return redirect()->route('applicant.login.display')
        ->with('success', 'Registered successfully.');
}


//Login applicant
public function ShowLoginForm()
{
    return view('applicant.auth.login');
}

public function Login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    // Find the applicant by email
    $applicant = RegisterModel::with('personal_info')->where('email', $request->email)->first();

    // Check if applicant exists and password is correct
    if (!$applicant || !Hash::check($request->password, $applicant->password)) {
        return back()->withErrors(['email' => 'Invalid email or password.']);
    }

     // ✅ Update last seen to NOW
    $applicant->last_seen = now();
    $applicant->save();

    

    // Store applicant session (custom auth logic)
    session([
        'applicant_id' => $applicant->id,
    ]);

    return redirect()->route('applicant.info.homepage.display')->with('success', 'Welcome to mangagawang pinoy, ' . $applicant->personal_info->first_name);
}

//Homepage
public function ShowHomepage()
{
    $applicantId = session('applicant_id');

    if (!$applicantId) {
        return redirect()->route('applicant.login.display');
    }

    $applicantCounts = RegisterModel::count();

    // Get the logged-in applicant's personal and work info
    $retrievePersonal = RegisterModel::with(['personal_info', 'work_background'])
        ->where('id', $applicantId)
        ->first();

    // Get all the employer and also the active post
    $JobPostRetrieved = \App\Models\Employer\JobDetailModel::with(
        'employer',
        'interviewScreening',
        'workerRequirement',
        'specialRequirement'
    )->get()->sortDesc();

    $publishedCounts = \App\Models\Employer\JobDetailModel::where('status_post', 'published')->count();
    $retrievedAddressCompany = \App\Models\Employer\CompanyAdressModel::get();

    // ✅ Get applicant's saved jobs (job IDs only)
    $savedJobIds = \DB::table('saved_job_table')
        ->where('applicant_id', $applicantId)
        ->pluck('job_id')
        ->toArray();

    //Retrieved the tesda certified
   $tesdaCertification = \App\Models\Applicant\TesdaUploadCertificationModel::where('applicant_id', $applicantId)
    ->latest()
    ->first();

    $tesdaCertificateCounts = \App\Models\Applicant\TesdaUploadCertificationModel::where('status', 'approved')->count();

     //retrieved the applied jobs
    $appliedJobs = ApplyJob::with([
        'job' => function ($query) {
            $query->with([
                'employer.addressCompany',   // employer + company address
                'interviewScreening',
                'workerRequirement',
                'specialRequirement',
                'employer.personal_info',
            ]);
        }
    ])->where('applicant_id', $applicantId)->get();
    

     // Get only announcements targeted to applicants and published
    $notifications = AnnouncementModel::where('target_audience', 'applicants')
        ->where('status',['published','scheduled'])
        ->orderBy('created_at', 'desc')
        ->take(5) // limit to 5 latest
        ->get();


     $unreadCount = AnnouncementModel::where('target_audience', 'applicants')
    ->where('is_read', false)
    ->count();

    



    return view('applicant.homepage.homepage', compact(
        'retrievePersonal',
        'applicantCounts',
        'JobPostRetrieved',
        'publishedCounts',
        'retrievedAddressCompany',
        'savedJobIds',
        'tesdaCertification',
        'tesdaCertificateCounts',
        'appliedJobs',
        'notifications',
        'unreadCount'
    ));
}

 // Mark a single notification as read
// app/Http/Controllers/NotificationController.php
public function ReadNotification($id)
{
    $notification = AnnouncementModel::findOrFail($id);
    $notification->is_read = 1; // mark as read
    $notification->save();

    return response()->json(['success' => true]);
}

public function ReadlAllnotifications()
{
    // Assuming you store notifications in a Notification model
    AnnouncementModel::where('is_read', 0)->update(['is_read' => 1]);

    return response()->json(['success' => true]);
}




public function fetchMessages($id)
{
    $authId = auth()->user()->id;
    $messages = SendMessage::where(function($query) use ($id, $authId) {
        $query->where('sender_id', $authId)->where('receiver_id', $id);
    })->orWhere(function($query) use ($id, $authId) {
        $query->where('sender_id', $id)->where('receiver_id', $authId);
    })->orderBy('created_at')->get();

    $messagesFormatted = $messages->map(function ($msg) {
        return [
            'sender_id' => $msg->sender_id,
            'receiver_id' => $msg->receiver_id,
            'message' => $msg->message,
            'image_path' => $msg->image_path,
            'is_read' => $msg->is_read,
            'time' => \Carbon\Carbon::parse($msg->created_at)->format('g:i A'),
        ];
    });

    return response()->json(['messages' => $messagesFormatted]);
}

public function markAsRead($id)
{
    $authId = auth()->user()->id;
    SendMessage::where('sender_id', $id)
        ->where('receiver_id', $authId)
        ->where('is_read', false)
        ->update(['is_read' => true]);

    return response()->json(['status' => 'read']);
}


public function startTyping(Request $request)
{
    $applicantID = session('applicant_id'); // or auth()->id();
    RegisterModel::where('id', $applicantID)->update(['typing_indicator' => true]);

    return response()->json(['status' => 'started']);
}

public function stopTyping(Request $request)
{
    $applicantID = session('applicant_id');
    RegisterModel::where('id', $applicantID)->update(['typing_indicator' => false]);

    return response()->json(['status' => 'stopped']);
}

public function checkTyping($receiver_id)
{
    $receiver = RegisterModel::find($receiver_id);
    return response()->json([
        'is_typing' => $receiver ? (bool)$receiver->typing_indicator : false
    ]);
}

public function getUnreadCounts(Request $request)
{
    $applicantId = auth()->id(); // or however you get the current user ID
    
    $unreadCounts = SendMessage::where('receiver_id', $applicantId)
        ->where('is_read', false)
        ->select('sender_id', DB::raw('count(*) as count'))
        ->groupBy('sender_id')
        ->pluck('count', 'sender_id')
        ->toArray();
    
    return response()->json(['unread_counts' => $unreadCounts]);
}


//View the calling carrd
public function ViewCallingCard() {
    $applicantID = session('applicant_id');
 
    // Fetch applicant profile
    $retrievedProfile = RegisterModel::with('personal_info', 'work_background', 'template')
        ->where('id', $applicantID)
        ->first();
 
    if (!$retrievedProfile) {
        return back()->withErrors('No profile found');
    }
 
    // Fetch portfolio (latest)
    $retrievedPortfolio = ApplicantPortfolioModel::with('personalInfo', 'workExperience')
        ->where('applicant_id', $applicantID)
        ->get();
 
    // Fetch youtube/video link (latest)
    $retrievedYoutube = ApplicantUrlModel::with('personalInfo', 'workExperience')
        ->where('applicant_id', $applicantID)
        ->get();
 
    return view('applicant.callingcard.arcallingcard', compact(
        'retrievedProfile',
        'retrievedPortfolio',
        'retrievedYoutube'
    ));
}




//logout the applicant
public function logout()
{
    $user = Auth::guard('applicant')->user();

    if ($user) {
        // Update using DB query to be 100% sure
        RegisterModel::where('id', $user->id)->update(['last_seen' => null]);
    }

    Auth::guard('applicant')->logout();
    session()->invalidate();
    session()->regenerateToken();

    return redirect()->route('applicant.login.display');
}




//send messages to friends
public function sendMessage(Request $request)
{
    try {
        $applicantID = session('applicant_id');

        // Ensure session is valid
        if (!$applicantID) {
            return redirect()->back()->with('error', 'You must be logged in to send a message.');
        }

        // Validate input
        $validatedData = $request->validate([
            'message' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'receiver_id' => 'required|exists:applicants,id',
        ]);

        // Prevent sending empty messages without a photo
        if (empty($validatedData['message']) && !$request->hasFile('photo')) {
            return redirect()->back()->with('error', 'Cannot send an empty message.');
        }

        // Create and populate message
        $message = new SendMessage();
        $message->sender_id = $applicantID;
        $message->receiver_id = $validatedData['receiver_id'];
        $message->message = $validatedData['message'] ?? null;
        $message->is_read = false;

        // Handle image upload if exists
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('uploads/messages'), $photoName);
            $message->image_path = 'uploads/messages/' . $photoName;
        }

        $message->save();

    //     // Reset typing status
    // $sender = RegisterModel::find(auth()->id());
    // if ($sender) {
    //     $sender->typing_indicator = false;
    //     $sender->save();
    // }

        return redirect()->back()->with('success', 'Message sent successfully.');

    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->validator)->withInput();
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to send message. ' . $e->getMessage());
    }
}



//Update last seen
public function updateLastSeen()
{
    $applicant = auth('applicant')->user();

    if ($applicant) {
        $applicant->last_seen = now();
        $applicant->save();

        return response()->noContent(); 
    }

    return response()->json(['message' => 'Unauthorized'], 401); 
}



//resume builder
public function ViewResume(){


    //retrieve all the personal information
    $retrievedProfiles = RegisterModel::with('personal_info' , 'work_background' , 'template')->where('id' , session('applicant_id'))->first();

    if(!$retrievedProfiles) {
        return back()->withErrors('No profile found');
    }

    return view('applicant.resumebuilder.resume', compact('retrievedProfiles'));


}

//Unfriend button
public function unFriend($id)
{
   $applicantID = session('applicant_id');
    $me = $applicantID;

    // Make sure we have a logged in user
    if (!$me) {
        return back()->with('error', 'You must be logged in to unfriend.');
    }

    // Validate the ID parameter
    if (!$id || !is_numeric($id)) {
        return back()->with('error', 'Invalid user ID.');
    }

    // Prevent users from unfriending themselves
    if ($me == $id) {
        return back()->with('error', 'You cannot unfriend yourself.');
    }

    // Delete the friendship record (works both directions)
    $deleted = AddFriend::where(function ($query) use ($me, $id) {
            $query->where('request_id', $me)
                  ->where('receiver_id', $id);
        })
        ->orWhere(function ($query) use ($me, $id) {
            $query->where('request_id', $id)
                  ->where('receiver_id', $me);
        })
        ->delete();

    if ($deleted > 0) {
        return back()->with('success', 'You have successfully unfriended this user.');
    }

    return back()->with('error', 'No friendship record found or you are not friends with this user.');
}


//View the application status
public function ViewApplicationStatus()
{
    $applicantId = session('applicant_id');

    //  Retrieve applicant's saved jobs with job details + employer + company address
    $retrievedSavedJobs = SavedJob::with([
        'job' => function ($query) {
            $query->with([
                'employer.addressCompany',   // employer + company address
                'interviewScreening',
                'workerRequirement',
                'specialRequirement',
                'employer.personal_info',
            ]);
        }
    ])->where('applicant_id', $applicantId)->get();

    // Published jobs count (optional)
    $publishedCounts = JobDetailModel::where('status_post', 'published')->count();

    $tesdaCertification = \App\Models\Applicant\TesdaUploadCertificationModel::where('applicant_id', $applicantId)
    ->latest()
    ->first();

    //Retrieved the numbers of pending interview
   $statuses = ['pending', 'interview', 'approved', 'rejected', 'being_reviewed'];

$pendingInterviewsCounts = [];

foreach ($statuses as $status) {
    $pendingInterviewsCounts[$status] = ApplyJob::where('applicant_id', $applicantId)
        ->where('status', $status)
        ->count();
}

$pendingInterviewsCounts['total'] = ApplyJob::where('applicant_id', $applicantId)->count();


    //retrieved the applied jobs
    $appliedJobs = ApplyJob::with([
        'job' => function ($query) {
            $query->with([
                'employer.addressCompany',   // employer + company address
                'interviewScreening',
                'workerRequirement',
                'specialRequirement',
                'employer.personal_info',
            ]);
        }
    ])->where('applicant_id', $applicantId)->get();

    return view('applicant.my_application.applicantion', compact(
        'retrievedSavedJobs',
        'publishedCounts',
        'tesdaCertification',
        'appliedJobs',
        'pendingInterviewsCounts'
    ));
}


//Remove the saved job
public function unSavedJob($id)
{
    $applicantId = session('applicant_id');

    $savedJob = DB::table('saved_job_table')
        ->where('job_id', $id)
        ->where('applicant_id', $applicantId);

    if ($savedJob->exists()) {
        $savedJob->delete();
        return back()->with('success', 'Job removed from saved list.');
    }

    return back()->with('error', 'Job not found in saved list.');
}


//saved jobs 
public function toggleSaveJob($jobId)
{
    $applicantId = session('applicant_id');

    $savedJob = DB::table('saved_job_table')
        ->where('job_id', $jobId)
        ->where('applicant_id', $applicantId);

    if ($savedJob->exists()) {
        // Unsave
        $savedJob->delete();
        return back()->with('success', 'Job removed from saved list.');
    } else {
        // Save
        DB::table('saved_job_table')->insert([
            'job_id' => $jobId,
            'applicant_id' => $applicantId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return back()->with('success', 'Job saved successfully!');
    }
}






//Applying job
public function applyJob(Request $request)
{
    $applicantId = session('applicant_id');

    if (!$applicantId) {
        return back()->withErrors(['error' => 'No applicant selected.']);
    }

    $request->validate([
        'job_id' => 'required|exists:job_details_employer,id',
        'phone_number' => 'required|string',
        'cover_letter' => 'nullable|string',
        'additional_info' => 'nullable|string',
        'resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        'tesda_certificate' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
    ]);

    // ✅ Use updateOrCreate to handle re-apply
    ApplyJob::updateOrCreate(
        [
            'job_id' => $request->job_id,
            'applicant_id' => $applicantId,
        ],
        [
            'cellphone_number' => $request->phone_number,
            'cover_letter' => $request->cover_letter,
            'additional_information' => $request->additional_info,
            'resume' => $request->hasFile('resume')
                ? $request->file('resume')->store('resumes', 'public')
                : null,
            'tesda_certification' => $request->hasFile('tesda_certificate')
                ? $request->file('tesda_certificate')->store('tesda_certificates', 'public')
                : null,
            'status' => 'pending', // reset status every reapply
        ]
    );

    return back()->with('success', 'Your application has been submitted successfully.');
}



//cancel job
public function cancelApplication(Request $request)
{
    $applicantId = session('applicant_id');
    $jobId = $request->input('job_id'); // ✅ get job_id from form

    ApplyJob::where('job_id', $jobId)
        ->where('applicant_id', $applicantId)
        ->delete();

    return back()->with('success', 'Application cancelled successfully.');
}



}