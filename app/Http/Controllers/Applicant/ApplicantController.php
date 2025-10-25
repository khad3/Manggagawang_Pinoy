<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Applicant\ApplicantPortfolioModel;
use App\Models\Employer\InterviewScreeningModel;
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
use App\Models\Employer\SendMessageModel as EmployerSendMessage;
use Illuminate\Support\Facades\Crypt;
use App\Models\Applicant\ApplyJobModel as ApplyJob;
use App\Models\Admin\AnnouncementModel;
use App\Notifications\Applicant\FriendRequestNotification;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


use App\Models\Employer\AccountInformationModel as EmployerInfo;

use Illuminate\Support\Facades\DB;
use App\Models\Employer\JobDetailModel;

use App\Mail\Applicant\VerifyEmail as VerifyEmail;
use App\Models\Admin\SuspensionModel;
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


    //Forgotpassword
    public function forgotPassword(){
        return view('applicant.forgotpassword.forgot_password');
    }



    public function forgotPasswordStore(Request $request)
{
    $request->validate([
        'email' => 'required|email',
    ]);

    $user = RegisterModel::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors([
            'email' => 'No account found with this email address.'
        ])->withInput()->with('step', 1);
    }

    // Generate a new code and set expiration
    $newCode = mt_rand(100000, 999999);
    $expiration = Carbon::now()->addMinutes(10);

    $user->update([
        'verification_code' => $newCode,
        'email_verification_code_expires_at' => $expiration,
    ]);

    // Send verification code to email
    Mail::to($user->email)->send(new VerifyEmail($newCode));

    // Store email in session for later steps - FIXED: consistent key name
    session()->put('email', $user->email);

    // Return with only verification code for debugging (remove in production)
    return back()
        ->with('success', 'A verification code has been sent to your email address.')
        ->with('step', 2)
        ->with('code', $newCode); //  show only the code in session (for testing)
}


//verify the email codes for forgot password
public function verifyCode(Request $request)
{
    $request->validate([
        'verification_code' => 'required|numeric|digits:6',
    ]);

    // FIXED: Use 'email' instead of 'forgot_email' to match forgotPasswordStore
    $email = session('email');
    if (!$email) {
        return back()->withErrors(['verification_code' => 'Session expired. Please try again.'])->with('step', 1);
    }

    $user = RegisterModel::where('email', $email)
        ->where('verification_code', $request->verification_code)
        ->first();

    if (!$user) {
        return back()->withErrors(['verification_code' => 'Invalid verification code.'])->with('step', 2);
    }

    if ($user->email_verification_code_expires_at && $user->email_verification_code_expires_at < now()) {
        return back()->withErrors(['verification_code' => 'Verification code has expired.'])->with('step', 2);
    }

    // FIXED: Don't mark as verified here, only after password reset
    // Don't clear the verification code yet, we need it for the reset step
    
    // Keep email in session for password reset
    session()->put('email', $email);
    session()->put('code_verified', true); // Add verification flag

    return back()->with('success', 'Email verified successfully.')
                 ->with('step', 3);
}

/**
 * Step 3: Reset Password
 */
public function resetPassword(Request $request)
{
    // Get stored email from session
    $email = session('email');

    if (!$email) {
        return back()
            ->withErrors(['email' => 'Your session has expired. Please request a new password reset.'])
            ->with('step', 1);
    }

    // Check if code was verified
    if (!session('code_verified')) {
        return back()
            ->withErrors(['verification_code' => 'Please verify your email first.'])
            ->with('step', 2);
    }

    // Validate new password
    $request->validate([
        'password' => [
            'required',
            'string',
            'min:8',               // At least 8 characters
            'regex:/[a-z]/',       // Must contain lowercase
            'regex:/[A-Z]/',       // Must contain uppercase
            'regex:/[0-9]/',       // Must contain digits
        ],
        'password_confirmation' => 'required|same:password',
    ], [
        'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, and one number.',
        'password.min'   => 'Password must be at least 8 characters long.',
    ]);

    //  Find the user
    $user = RegisterModel::where('email', $email)->first();

    if (!$user) {
        return back()
            ->withErrors(['email' => 'No account found with this email address.'])
            ->with('step', 1);
    }

    // Prevent using the same password
    if (Hash::check($request->password, $user->password)) {
        return back()
            ->withErrors(['password' => 'Your new password must be different from your current password.'])
            ->with('step', 3)
            ->with('email', $email); // Keep email in session
    }

    // Update the password securely
    $user->update([
        'password' => Hash::make($request->password),
        'verification_code' => null, // Clear the code
        'email_verification_code_expires_at' => null,
    ]);

    //  Mark as verified
    $user->is_verified = 1;
    $user->save();

    //  Clear the session after successful reset
    session()->forget('email');
    session()->forget('step');
    session()->forget('code_verified');

    // FIXED: Use redirect with success message
    return redirect()->route('applicant.login.display')
        ->with('password_reset_success', true)
        ->with('success', 'Your password has been reset successfully. You may now log in.');
}







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


    //Encrypt the email

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
        'email' => $request->email
    ]);
} 

public function ShowVerifyForm(){
    
    return view('applicant.auth.verification');
}

public function resend(Request $request)
{
    $applicantId = session('applicant_id');

    if (!$applicantId) {
        return response()->json(['message' => 'No applicant found in session.'], 400);
    }

    $applicant = RegisterModel::find($applicantId);

    if (!$applicant) {
        return response()->json(['message' => 'Applicant not found.'], 404);
    }

    // Generate new code
    $newCode = mt_rand(100000, 999999);
    $expiration = Carbon::now()->addMinutes(10);

    $applicant->update([
        'verification_code' => $newCode,
        'email_verification_code_expires_at' => $expiration,
    ]);

    // 🟢 Debug log
    \Log::info("Resend Code for {$applicant->email}: $newCode");

    // Send email
    Mail::to($applicant->email)->send(new VerifyEmail($newCode));

    return response()->json([
        'message' => 'A new verification code has been sent to your email.',
    ]);
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
        'id'            => 'required|exists:applicants,id',
    ]);

    $applicant = RegisterModel::findOrFail($applicantId);

    // Encrypt each field before saving
    $personal_info = new PersonalInfo([
        'first_name'   => Crypt::encrypt($request->first_name),
        'last_name'    => Crypt::encrypt($request->last_name),
        'gender'       => Crypt::encrypt($request->gender),
        'house_street' => Crypt::encrypt($request->house_street),
        'city'         => Crypt::encrypt($request->city),
        'province'     => Crypt::encrypt($request->province),
        'zipcode'      => Crypt::encrypt($request->zipcode),
        'barangay'     => Crypt::encrypt($request->barangay),
    ]);

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
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $applicant = RegisterModel::findOrFail($applicantId);

    // Store the image (path is not encrypted)
    $imagePath = $request->file('profile_picture')->store('profile_picture', 'public');

    // Encrypt fields before saving
    $work_background = new WorkBackground([
        'position'           => Crypt::encrypt($request->position),
        'other_position'     => $request->other_position ? Crypt::encrypt($request->other_position) : null,
         'work_duration'      => $request->work_duration, // keep numeric, no encryption
        'work_duration_unit' => $request->work_duration_unit,
        'employed'           => $request->employed,
        'profileimage_path'  => $imagePath, // keep path unencrypted
    ]);

    // Save via relation
    $applicant->work_background()->save($work_background);

    return redirect()->route('applicant.info.template.display')
        ->with('success', 'Work background saved successfully.');
}
/**
 * Helper to safely decrypt a value
 */
private function safeDecrypt($value)
{
    try {
        return $value ? Crypt::decrypt($value) : null;
    } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
        return $value; // return original if decryption fails
    }
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

// Helper function to safely decrypt


// Decrypted arrays
$personalInfoDecrypted = $personalInfo ? [
    'first_name'   => $this->safeDecrypt($personalInfo->first_name),
    'last_name'    => $this->safeDecrypt($personalInfo->last_name),
    'gender'       => $this->safeDecrypt($personalInfo->gender),
    'house_street' => $this->safeDecrypt($personalInfo->house_street),
    'city'         => $this->safeDecrypt($personalInfo->city),
    'province'     => $this->safeDecrypt($personalInfo->province),
    'zipcode'      => $this->safeDecrypt($personalInfo->zipcode),
    'barangay'     => $this->safeDecrypt($personalInfo->barangay),
] : [];

$workBackgroundDecrypted = $workBackground ? [
    'position'           => $this->safeDecrypt($workBackground->position),
    'other_position'     => $this->safeDecrypt($workBackground->other_position),
    'work_duration'      => $workBackground->work_duration, // numeric, do not decrypt
    'work_duration_unit' => $this->safeDecrypt($workBackground->work_duration_unit),
    'employed'           => $this->safeDecrypt($workBackground->employed),
    'profileimage_path'  => $workBackground->profileimage_path,
] : [];


    if (!$personalInfo || !$workBackground) {
        return redirect()->route('some.previous.step')->withErrors('Incomplete applicant data!');
    }

    return view('applicant.auth.finalStepTemplate', compact('personalInfoDecrypted', 'workBackgroundDecrypted'));
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

    //encrypt data
    $encrypted_description = $request->description ? Crypt::encrypt($request->description) : null;
    $encrypted_sample_work = $sampleWorkFile ? Crypt::encrypt($sampleWorkFile) : null;
    $encrypted_sample_work_url = $request->sample_work_url ? Crypt::encrypt($request->sample_work_url) : null;

    // Create new template
    $template = new Template([
        'description' => $encrypted_description,
        'sample_work' => $encrypted_sample_work, // this can be null
        'sample_work_url' => $encrypted_sample_work_url, // this can also be null
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

public function login(Request $request)
{
    // Validate the request
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    
    $applicant = RegisterModel::with('personal_info')
        ->where('email', $request->email)
        ->first();

        
    $applicant_name_decrypted = $applicant && $applicant->personal_info ?[
        'first_name' => $this->safeDecrypt($applicant->personal_info->first_name),
        
    ]:[];

   
    if (!$applicant) {
        return back()->withErrors([
            'email' => 'No account found with this email address.',
        ])->withInput($request->only('email'));
    }

    // 4Check if the account is banned
    if (strtolower($applicant->status) === 'banned') {
        return back()->withErrors([
            'email' => 'Your account has been banned. Please contact support for assistance.',
        ])->withInput($request->only('email'));
    }

    // 5Verify password
    if (!Hash::check($request->password, $applicant->password)) {
        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput($request->only('email'));
    }

    
    $applicant->last_login = now();
    $applicant->last_seen = now();
    
    $applicant->save();

    
    session([
        'applicant_id' => $applicant->id,
    ]);

    
    
    return redirect()
        ->route('applicant.info.homepage.display')
        ->with('success', 'Welcome back, ' . ($applicant_name_decrypted['first_name'] ?? 'Applicant') . '!');
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


    //get the decrypted data
    $retrieveDataDecrypted = $retrievePersonal ? [
        'first_name' => $this->safeDecrypt($retrievePersonal->personal_info->first_name),
        'last_name' => $this->safeDecrypt($retrievePersonal->personal_info->last_name),
        'gender' => $this->safeDecrypt($retrievePersonal->personal_info->gender),
        'house_street' => $this->safeDecrypt($retrievePersonal->personal_info->house_street),
        'city' => $this->safeDecrypt($retrievePersonal->personal_info->city),
        'state' => $this->safeDecrypt($retrievePersonal->personal_info->state),
        'zipcode' => $this->safeDecrypt($retrievePersonal->personal_info->zipcode),
        'country' => $this->safeDecrypt($retrievePersonal->personal_info->country),

        //Work Experience
        'position' => $this->safeDecrypt($retrievePersonal->work_background->position),
        'other_position' => $this->safeDecrypt($retrievePersonal->work_background->other_position),
        'work_duration' => $retrievePersonal->work_background->work_duration,
        'work_duration_unit' => $retrievePersonal->work_background->work_duration_unit,
        'employed' => $retrievePersonal->work_background->employed,


    ] : [];

    // Get all the employer and also the active post
    $JobPostRetrieved = \App\Models\Employer\JobDetailModel::with(
        'employer',
        'interviewScreening',
        'workerRequirement',
        'specialRequirement'
    )->get()->sortDesc();

    $publishedCounts = \App\Models\Employer\JobDetailModel::where('status_post', 'published')->count();
    $retrievedAddressCompany = \App\Models\Employer\CompanyAdressModel::get();

    //  Get applicant's saved jobs (job IDs only)
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
    $notifications = AnnouncementModel::whereIn('target_audience', ['applicants' , 'all'])
        ->where('status',['published','scheduled'])
        ->orderBy('created_at', 'desc')
        ->take(5) // limit to 5 latest
        ->get();


     $unreadCount = AnnouncementModel::where('target_audience', 'applicants')
    ->where('is_read', false)
    ->count();

    
   $suspendedApplicant = RegisterModel::where('id', $applicantId)->where('status', 'suspended')
    ->with(['suspension' => function ($q) {
        $q->latest()->first(); // get latest suspension if multiple
    }])
    ->first();

$isSuspended = false;
$suspension = $suspendedApplicant?->suspension;

// If applicant has suspension record
if ($suspendedApplicant && $suspension) {
    $endDate = $suspension->created_at->copy()->addDays($suspension->suspension_duration);

    if (now()->lt($endDate)) {
        // Still suspended
        $isSuspended = true;

        if ($suspendedApplicant->status !== 'suspended') {
            $suspendedApplicant->status = 'suspended';
            $suspendedApplicant->save();
        }
    } else {
        //  Suspension expired
        if ($suspendedApplicant->status !== 'active') {
            $suspendedApplicant->status = 'active';
            $suspendedApplicant->save();
        }
    }
}


//Retrieve the employer messages
// Retrieve the employer messages
$messages = EmployerSendMessage::with(['employer.addressCompany', 'employer.personal_info'])
    ->where('applicant_id', $applicantId)
    ->orderBy('created_at', 'asc') // optional: keep chronological
    ->get()
    ->map(function ($msg) {
        if ($msg->message) {
            try {
                $msg->message = Crypt::decryptString($msg->message);
            } catch (\Exception $e) {
                $msg->message = '[Unable to decrypt message]';
            }
        }
        return $msg;
    });


    $reportedJobIds = \App\Models\Report\ReportModel::where('reporter_id', $applicantId)
        ->where('reporter_type', 'applicant')
        ->pluck('reported_id') // make sure reported_id is the job_id in your report table
        ->toArray();

       $notificationsSchedule = \App\Models\Employer\SendNotificationToApplicantModel::where('receiver_id', $applicantId)
    ->where('type', 'scheduled_interview') // double-check this value in DB

    ->orderBy('created_at', 'desc')
    ->take(5)
    ->get();

    $unreadCountNotificationSchedule = \App\Models\Employer\SendNotificationToApplicantModel::where('receiver_id', $applicantId)
    ->where('type', 'scheduled_interview') // double-check this value in DB
    ->where('is_read', false)
    ->count();

    // Merge both collections
$allNotifications = $notifications->merge($notificationsSchedule)->sortByDesc('created_at');

   
    return view('applicant.homepage.homepage', compact(
        'allNotifications',
        'notificationsSchedule',
        'retrieveDataDecrypted',
        'retrievePersonal',
        'reportedJobIds',
        'applicantCounts',
        'JobPostRetrieved',
        'publishedCounts',
        'retrievedAddressCompany',
        'savedJobIds',
        'tesdaCertification',
        'tesdaCertificateCounts',
        'appliedJobs',
        'notifications',
        'unreadCount',
        'isSuspended',
        'suspension',
        'messages'
       
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

private function safe_decrypt($value)
{
    try {
        return $value ? Crypt::decrypt($value) : null;
    } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
        return $value; // return original if decryption fails
    }
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

    //decrypt personal info of group creator
    if ($retrievedProfile->personal_info) {
        $retrievedProfile->personal_info->first_name = $this->safe_decrypt($retrievedProfile->personal_info->first_name);
        $retrievedProfile->personal_info->last_name  = $this->safe_decrypt($retrievedProfile->personal_info->last_name);
    }
 
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

        // Prevent sending completely empty messages
        if (empty($validatedData['message']) && !$request->hasFile('photo')) {
            return redirect()->back()->with('error', 'Cannot send an empty message.');
        }

        // Encrypt message if it exists
        $encryptedMessage = null;
        if (!empty($validatedData['message'])) {
            $encryptedMessage = Crypt::encryptString($validatedData['message']);
        }

        // Create new message
        $message = new SendMessage();
        $message->sender_id = $applicantID;
        $message->receiver_id = $validatedData['receiver_id'];
        $message->message = $encryptedMessage;
        $message->is_read = false;

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '_' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('uploads/messages'), $photoName);
            $message->image_path = 'uploads/messages/' . $photoName;
        }

        $message->save();

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
public function ViewResume()
{
    // Retrieve applicant profile with related data
    $retrievedProfiles = RegisterModel::with('personal_info', 'work_background', 'template')
        ->where('id', session('applicant_id'))
        ->first();

    if (!$retrievedProfiles) {
        return back()->withErrors('No profile found');
    }

    // Decrypt personal info if exists
    if ($retrievedProfiles->personal_info) {
        $retrievedProfiles->personal_info->first_name = $this->safe_decrypt($retrievedProfiles->personal_info->first_name);
        $retrievedProfiles->personal_info->last_name  = $this->safe_decrypt($retrievedProfiles->personal_info->last_name);
        $retrievedProfiles->personal_info->house_street = $this->safe_decrypt($retrievedProfiles->personal_info->house_street);
        $retrievedProfiles->personal_info->city       = $this->safe_decrypt($retrievedProfiles->personal_info->city);
        $retrievedProfiles->personal_info->province   = $this->safe_decrypt($retrievedProfiles->personal_info->province);
        $retrievedProfiles->personal_info->zipcode    = $this->safe_decrypt($retrievedProfiles->personal_info->zipcode);
        $retrievedProfiles->personal_info->barangay   = $this->safe_decrypt($retrievedProfiles->personal_info->barangay);
       
    }

    // Decrypt work background if exists
    if ($retrievedProfiles->work_background) {

        $retrievedProfiles->work_background->position       = $this->safe_decrypt($retrievedProfiles->work_background->position);
        $retrievedProfiles->work_background->other_position = $this->safe_decrypt($retrievedProfiles->work_background->other_position);
    }

    // Decrypt template if exists
    if ($retrievedProfiles->template) {
        $retrievedProfiles->template->description      = $this->safe_decrypt($retrievedProfiles->template->description);
        $retrievedProfiles->template->sample_work_url  = $this->safe_decrypt($retrievedProfiles->template->sample_work_url);
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


    //Retrieve the employer Preferred interview location
    $preferredScreening = ApplyJob::with([
        'job' => function ($query) {
            $query->with([
                'employer.addressCompany',   // employer + company address
                'employer.interviewPreparation',
                'workerRequirement',
                'specialRequirement',
                'employer.personal_info',
            ]);
        }
    ])->where('applicant_id', $applicantId)->whereIn('status', ['pending', 'interview', 'approved', 'rejected', 'being_reviewed'])->latest('updated_at') // ✅ get the most recent status
->first();;
   

    return view('applicant.my_application.applicantion', compact(
        'preferredScreening',
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