<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Employer\JobDetailModel as JobDetails;
use App\Models\Employer\AccountInformationModel as AccountInformation;
use App\Models\Employer\PersonalInformationModel as PersonalInformation;
use App\Models\Employer\CompanyAdressModel as CompanyAdress;
use App\Models\Employer\EmergencyContactModel as EmergencyContact;
use App\Models\Employer\CommunicationPreferenceModel as CommunicationPreference;
use App\Models\Employer\AdditionalInformationModel as AdditionalInformation;
use App\Models\Employer\TesdaPriorityModel as CertPriority;
use App\Models\Employer\HiringTimelineModel as HiringTimeline;
use App\Models\Employer\WorkerRequirementModel as WorkerRequirement;
use App\Models\Employer\SpecialRequirementModel as SpecialRequirement;
use App\Models\Employer\InterviewScreeningModel as InterviewScreening;
use App\Models\Employer\SendRatingModel as Rating;

use App\Models\Applicant\PersonalModel as Applicants;
use App\Models\Applicant\ApplicantPortfolioModel as ApplicantPortfolioModel;
use App\Models\Applicant\ApplicantUrlModel as ApplicantUrlModel;
use App\Models\Applicant\ApplicantPostModel as ApplicantPostModel;

use App\Mail\Employer\VerifyEmail as EmployerVerificationMail;
use App\Models\Applicant\RegisterModel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use Faker\Provider\ar_EG\Person;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Support\Facades\Hash;

class EmployerController extends Controller
{
    
    //View registration form
    public function ShowRegistrationForm() {
        return view('employer.auth.registration');
    }

    //Add job details
    public function addJobDetails(Request $request)
{
    $validated = $request->validate([
        'job_title' => 'required|string',
        'job_department' => 'required|string',
        'job_location' => 'required|string',
        'job_work_type' => 'required|string',
        'job_experience' => 'required|string',
        'job_salary_range' => 'required|string',
        'job_description' => 'required|string',
        'job_additional_requirements' => 'nullable|string',

        'none_certifications' => 'nullable',
        'job_tesda_certification' => 'nullable|array',
        'job_tesda_certification.*' => 'nullable|string',

        'other_certification' => 'nullable|string',

        'job_non_tesda_certification' => 'nullable|array',
        'job_non_tesda_certification.*' => 'nullable|string',

        'job_benefits' => 'nullable|array', // ✅ Accept array
        'job_benefits.*' => 'nullable|string',
    ]);

    $job = new JobDetails();
    $job->title = $validated['job_title'];
    $job->department = $validated['job_department'];
    $job->location = $validated['job_location'];
    $job->work_type = $validated['job_work_type'];
    $job->job_salary = $validated['job_salary_range'];
    $job->experience_level = $validated['job_experience'];
    $job->job_description = $validated['job_description'];
    $job->additional_requirements = $validated['job_additional_requirements'] ?? null;

    // Certifications
    $isNoneCert = $request->has('none_certifications');
    $job->none_certifications = $isNoneCert ? 1 : 0;

    if ($isNoneCert) {
        $job->tesda_certification = null;
        $job->none_certifications_qualification = !empty($validated['job_non_tesda_certification'])
            ? implode(',', $validated['job_non_tesda_certification'])
            : null;
    } else {
        $certifications = $validated['job_tesda_certification'] ?? [];

        if (in_array('Other', $certifications) && !empty($validated['other_certification'])) {
            $certifications[] = $validated['other_certification'];
        }

        $job->tesda_certification = !empty($certifications) ? implode(',', $certifications) : null;
        $job->none_certifications_qualification = null;
    }

    $job->other_certifications = $validated['other_certification'] ?? null;

    // ✅ Save benefits
    $job->benefits = !empty($validated['job_benefits'])
        ? implode(',', $validated['job_benefits'])
        : null;

    $job->save();

    session(['job_id' => $job->id]);

    return redirect()->route('employer.contact.display');
    }


    //View the contact form
    public function ShowContactForm() {
        return view('employer.auth.contact');
    }


    //Add the contact details
   public function addContactDetails(Request $request)
{
    $jobId = session('job_id');
    $employerId = session('employer_id');

    if (!$jobId) {
        return redirect()->route('employer.register.display');
    }

    // --- Create Account Information ---
    $request->validate([
        'account_email' => 'required|email|unique:employer_account,email',
        'password' => [
            'required',
            'string',
            'min:8',
            'regex:/[a-zA-Z]/',
            'regex:/[0-9]/',
            'regex:/[\W]/'
        ],
        'password_confirmation' => 'required|same:password',
    ]);

    $employer = new AccountInformation();
    $employer->email = $request->input('account_email');
    $employer->password = Hash::make($request->input('password'));
    $employer->save();

    // Optional: Update session employer_id after saving
    session(['employer_id' => $employer->id]);

    // --- Update Job with Employer ID ---
    $job = JobDetails::find($jobId);
    if ($job) {
        $job->employer_id = $employer->id;
        $job->save();
    }

    // --- Personal Info ---
    $request->validate([
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|email|unique:employer_personal_info,email',
        'phone_number' => 'required|digits:11',
        'employer_job_title' => 'required|string',
        'employer_department' => 'required|string',
    ]);

    $personalInfo = new PersonalInformation();
    $personalInfo->first_name = $request->input('first_name');
    $personalInfo->last_name = $request->input('last_name');
    $personalInfo->email = $request->input('email');
    $personalInfo->phone_number = $request->input('phone_number');
    $personalInfo->employer_id = $employer->id;
    $personalInfo->employer_job_title = $request->input('employer_job_title');
    $personalInfo->employer_department = $request->input('employer_department');
    $personalInfo->save();

    // --- Company Address ---
    $request->validate([
        'company_name' => 'required|string',
        'complete_address' => 'required|string',
        'municipality' => 'required|string',
        'province' => 'required|string',
        'zip_code' => 'required|digits:4',
    ]);

    $companyAddress = new CompanyAdress();
    $companyAddress->employer_id = $employer->id;
    $companyAddress->personal_info_id = $personalInfo->id;
    $companyAddress->company_name = $request->input('company_name');
    $companyAddress->company_complete_address = $request->input('complete_address');
    $companyAddress->company_municipality = $request->input('municipality');
    $companyAddress->company_province = $request->input('province');
    $companyAddress->company_zipcode = $request->input('zip_code');
    $companyAddress->save();

    // --- Emergency Contact ---
    $request->validate([
        'emergency_contact_name' => 'required|string',
        'emergency_contact_number' => 'required|digits:11',
        'emergency_contact_relationship' => 'required|string|in:Company Owner, Manager/Supervisor, Safety Officer,HR Representative,Business Partner,Other'
    ]);

    $emergencyContact = new EmergencyContact();
    $emergencyContact->employer_id = $employer->id;
    $emergencyContact->personal_info_id = $personalInfo->id;
    $emergencyContact->first_name = $request->input('emergency_contact_name');
    $emergencyContact->last_name = $request->input('emergency_contact_relationship');
    $emergencyContact->phone_number = $request->input('emergency_contact_number');
    $emergencyContact->save();

    // --- Communication Preferences ---
    $request->validate([
        'contact_method' => 'required|string|in:email,phone,sms',
        'contact_time' => 'required|string|in:morning,afternoon,evening,anytime',
        'language_preference' => 'required|string',
    ]);

    $preference = new CommunicationPreference();
    $preference->employer_id = $employer->id;
    $preference->personal_info_id = $personalInfo->id;
    $preference->contact_method = $request->input('contact_method');
    $preference->contact_time = $request->input('contact_time');
    $preference->language_preference = $request->input('language_preference');
    $preference->save();

    // --- Additional Information ---
    $request->validate([
        'typical_working_hours' => 'required|string',
        'special_instructions' => 'required|string',
    ]);

    $additional = new AdditionalInformation();
    $additional->employer_id = $employer->id;
    $additional->personal_info_id = $personalInfo->id;
    $additional->typical_working_hours = $request->input('typical_working_hours');
    $additional->special_intructions_or_notes = $request->input('special_instructions');
    $additional->save();

    return redirect()->route('employer.hiringpreference.display')->with('success', 'Registration successful!');
}




    //View the hiring preference form
    public function ShowHiringPreferenceForm() {
        return view('employer.auth.hiringpreference');
    }

   public function AddHiringPreference(Request $request)
{
    $employer_id = session('employer_id');

    // Retrieve personal_info_id (scalar)
    $personal_info_id = PersonalInformation::where('employer_id', $employer_id)->value('id');

    // Validate TESDA certification priority
    $request->validate([
        'tesda_certi_priority' => 'required|string',
    ]);

    $tesdaPriority = new CertPriority();
    $tesdaPriority->employer_id = $employer_id;
    $tesdaPriority->personal_info_id = $personal_info_id;
    $tesdaPriority->tesda_priority = $request->tesda_certi_priority;
    $tesdaPriority->save();

    // Validate Hiring Timeline
    $request->validate([
        'hiring_timeline' => 'required|string',
    ]);

    $hiringTimeline = new HiringTimeline();
    $hiringTimeline->employer_id = $employer_id;
    $hiringTimeline->personal_info_id = $personal_info_id;
    $hiringTimeline->hiring_timeline = $request->hiring_timeline;
    $hiringTimeline->save();

    // Validate Worker Requirements
    $request->validate([
        'workers_needed' => 'required|string',
        'project_duration' => 'required|string',
        'worker_experience' => 'required|array',
    ]);

    $workerRequirement = new WorkerRequirement();
    $workerRequirement->employer_id = $employer_id;
    $workerRequirement->personal_info_id = $personal_info_id;
    $workerRequirement->number_of_workers = $request->workers_needed;
    $workerRequirement->project_duration = $request->project_duration;
    $workerRequirement->skill_requirements = json_encode($request->worker_experience); // Save as JSON
    $workerRequirement->save();

    // Validate Interview Screening
    $request->validate([
        'preferred_screening_method' => 'required|array',
        'preferred_interview_location' => 'required|string',
    ]);

    $interviewScreening = new InterviewScreening();
    $interviewScreening->employer_id = $employer_id;
    $interviewScreening->personal_info_id = $personal_info_id;
    $interviewScreening->preferred_screening_method = json_encode($request->preferred_screening_method); // Save as JSON
    $interviewScreening->preferred_interview_location = $request->preferred_interview_location;
    $interviewScreening->save();

    // Validate Special Requirements
    $request->validate([
        'special_requirements' => 'nullable|array',
        'additional_requirements' => 'nullable|string',
    ]);

    $specialRequirements = new SpecialRequirement();
    $specialRequirements->employer_id = $employer_id;
    $specialRequirements->personal_info_id = $personal_info_id;
    $specialRequirements->special_requirements = json_encode($request->special_requirements); // Save as JSON
    $specialRequirements->additional_requirements_or_notes = $request->additional_requirements;
    $specialRequirements->save();

    return redirect()->route('employer.reviewregistration.display')
        ->with('success', 'Registration successful!');
}



    //View the review registration form
    public function ShowReviewRegistrationForm() {


    $employer_id = session('employer_id');

    $retriedAccountInfo = AccountInformation::where('id', $employer_id)->first();
    $retrievedPersonalInfo = PersonalInformation::where('employer_id', $employer_id)->first();
    $retrievedJobDetail = JobDetails::where('employer_id', $employer_id)->first();
    $retrievedInterviewScreening = InterviewScreening::where('employer_id', $employer_id)->first();
    $retrievedWorkerRequirement = WorkerRequirement::where('employer_id', $employer_id)->first();
    $retrievedCertPriority = CertPriority::where('employer_id', $employer_id)->first();
    $retrievedHiringTimeline = HiringTimeline::where('employer_id', $employer_id)->first();
    $retrievedSpecialRequirement = SpecialRequirement::where('employer_id', $employer_id)->first();
    $retrievedCompanyAddress = CompanyAdress::where('employer_id', $employer_id)->first();
    $retrievedCommunication = CommunicationPreference::where('employer_id', $employer_id)->first();

    return view('employer.auth.reviewregistration', compact(
        'retrievedPersonalInfo',
        'retrievedJobDetail',
        'retrievedInterviewScreening',
        'retrievedWorkerRequirement',
        'retrievedCertPriority',
        'retrievedHiringTimeline',
        'retrievedSpecialRequirement',
        'retrievedCompanyAddress',
        'retrievedCommunication',
        'retriedAccountInfo'

    ));
}


    //View the success form
    public function ShowSuccessForm() {
        return view('employer.auth.successful' );
    }


    //Send email
public function sendVerificationEmail(Request $request)
{
    $email = trim(strtolower($request->account_email));

    $employer = AccountInformation::where('email', $email)->first();

    if (!$employer) {
        return redirect()->route('employer.register.display')->with('error', 'Email not found...');
    }

    $verifyUrl = route('employer.verify', ['email' => $email]);

    Mail::to($email)->send(new EmployerVerificationMail($verifyUrl));

    return redirect()->route('employer.successregistration.display')
        ->with('success', 'Verification email sent!');
}



//Display the email verification form
public function verifyEmail($email)
{
    $employer = AccountInformation::where('email', $email)->first();

    if (!$employer) {
        return redirect()->route('employer.register.display')->with('error', 'Email not found.');
    }

    $employer->email_verified_at = now();
    $employer->save();

    return redirect()->route('employer.login.display')->with('success', 'Email verified successfully.');
}

//View the login form
public function ShowLoginForm() {
    return view('employer.auth.employerlogin'); 
}


//Validate the email and apssword
public function login(Request $request)
{
    // Validate input
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // Check for employer record
    $employer = AccountInformation::where('email', $credentials['email'])->first();

    // Check password and handle failed login
    if (!$employer || !Hash::check($credentials['password'], $employer->password)) {
        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
    }

    // Optional: Check if email is verified
    if (is_null($employer->email_verified_at)) {
        return back()->withErrors(['email' => 'Please verify your email address first.'])->withInput();
    }

    // Store session (custom auth)
    session([
        'employer_id' => $employer->id,
        'employer_email' => $employer->email,
        'employer_name' => $employer->first_name ?? 'Employer',
    ]);

    return redirect()->route('employer.info.homepage.display')
                     ->with('success', 'Login successful.');
}


//View the homepage of employer
public function ShowHomepage() {


    //retrieve the list of applicants
    $retrievedApplicants = RegisterModel::with(['personal_info', 'work_background' ])->paginate(10);

    if ($retrievedApplicants->isEmpty()) {
        return view('employer.homepage.homepage');
    }

    $employerId = session('employer_id');



    if (!$employerId) {
        return redirect()->route('employer.login.display');
    }

    $JobPostRetrieved = JobDetails::with('employer' , 'interviewScreening' , 'workerRequirement' , 'specialRequirement')->where('employer_id', $employerId)->get()->sortDesc();


    //Rating
     //Rating
   foreach ($retrievedApplicants as $applicant) {
    $applicant_id = $applicant->id;

    $ratings = Rating::with('employer')
        ->where('applicant_id', $applicant_id)
        ->get();

    $averageRating = round($ratings->avg('rating'), 1);
    $totalReviews = $ratings->count();
    $uniqueEmployerCount = $ratings->pluck('employer.id')->unique()->count();

    // Attach data to the model
    $applicant->rating = $averageRating;
    $applicant->total_reviews = $totalReviews;
    $applicant->unique_employers = $uniqueEmployerCount;
}

    // Get the logged-in employer's personal and work info
    $retrievePersonal = PersonalInformation::where('employer_id', $employerId)->first();

    return view('employer.homepage.homepage' , compact('retrievePersonal' , 'retrievedApplicants' , 'JobPostRetrieved'));

}


//Get the profile picture of the applicant
public function viewApplicantProfile($applicantID) 
{
    $retrievedProfile = RegisterModel::with('personal_info', 'work_background', 'template')->find($applicantID);
    if (!$retrievedProfile) {
        abort(404);
    }


    $applicant_id = $retrievedProfile->id; // or however you get the applicant ID

    $retrievedRating = Rating::with('addressCompany', 'employer', 'personalInfo')
    ->where('applicant_id', $applicant_id)
    ->latest()
    ->get();

    // Compute average rating for this applicant
    $averageRating = round($retrievedRating->avg('rating'), 1);

    // Count total reviews for this applicant
    $totalReviews = $retrievedRating->count();

    // Count unique employers who reviewed this applicant
    $uniqueEmployerCount = $retrievedRating->pluck('employer.id')->unique()->count();




    $retrievedPosts = ApplicantPostModel::with('personalInfo', 'workBackground')
        ->where('applicant_id', $applicantID)->latest()->get();

    $retrievedPortfolio = ApplicantPortfolioModel::with('personalInfo', 'workExperience')
        ->where('applicant_id', $applicantID)->latest()->get();

    $retrievedYoutube = ApplicantUrlModel::with('personalInfo', 'workExperience')
        ->where('applicant_id', $applicantID)->latest()->get();


   $tesdaCertification = \App\Models\Applicant\TesdaUploadCertificationModel::where('status', 'approved')
    ->where('applicant_id', $applicantID)
    ->orderBy('updated_at', 'desc')
    ->get();


    return view('employer.homepage.getprofile.getprofile', compact(
        'retrievedProfile',
        'retrievedPosts',
        'retrievedPortfolio',
        'retrievedYoutube',
        'retrievedRating',
        'averageRating',
        'totalReviews',
        'uniqueEmployerCount',
        'tesdaCertification'
    ));
}





//logout
public function logout() {
    Auth::guard('employer')->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect()->route('employer.login.display');
}


// add job post

public function addJobPost(Request $request)
{
   $employer_id = session('employer_id');  
   
   $personalInfoID = PersonalInformation::where('employer_id', $employer_id)->value('id');

   $validated = $request->validate([
        'job_title' => 'required|string',
        'job_department' => 'required|string',
        'other_department' => 'nullable|string',
        'job_type' => 'required|string',
        'job_location' => 'required|string',
        'job_work_type' => 'required|string',
        'job_experience' => 'required|string',
        'job_salary_range' => 'required|string',
        'job_description' => 'required|string',
        'job_additional_requirements' => 'nullable|string',

        'none_certifications' => 'nullable',
        'job_tesda_certification' => 'nullable|array',
        'job_tesda_certification.*' => 'nullable|string',

        'other_certification' => 'nullable|string',

        'job_non_tesda_certification' => 'nullable|array',
        'job_non_tesda_certification.*' => 'nullable|string',

        'job_benefits' => 'nullable|array', 
        'job_benefits.*' => 'nullable|string',
        

    ]);
     $status = $request->input('action') === 'publish' ? 'published' : 'draft';

    $job = new JobDetails();
    $job->title = $validated['job_title'];
    $job->job_type = $validated['job_type'];
    $job->location = $validated['job_location'];
    $job->work_type = $validated['job_work_type'];
    $job->job_salary = $validated['job_salary_range'];
    $job->experience_level = $validated['job_experience'];
    $job->job_description = $validated['job_description'];
    $job->additional_requirements = $validated['job_additional_requirements'] ?? null;
    $job->employer_id = $employer_id;
    $job->status_post = $status;
 

    //Departmnet
   $jobDepartment = $request->input('job_department');
$isOther = $jobDepartment === 'Other';

if ($isOther) {
    $job->other_department = $request->input('other_department'); 
    $job->department = null; 
} else {
    $job->department = $jobDepartment; 
    $job->other_department = null;
}





    // Certifications
    $isNoneCert = $request->has('none_certifications');
    $job->none_certifications = $isNoneCert ? 1 : 0;

    if ($isNoneCert) {
        $job->tesda_certification = null;
        $job->none_certifications_qualification = !empty($validated['job_non_tesda_certification'])
            ? implode(',', $validated['job_non_tesda_certification'])
            : null;
    } else {
        $certifications = $validated['job_tesda_certification'] ?? [];

        if (in_array('Other', $certifications) && !empty($validated['other_certification'])) {
            $certifications[] = $validated['other_certification'];
        }

        $job->tesda_certification = !empty($certifications) ? implode(',', $certifications) : null;
        $job->none_certifications_qualification = null;
    }

    $job->other_certifications = $validated['other_certification'] ?? null;

    // ✅ Save benefits
    $job->benefits = !empty($validated['job_benefits'])
        ? implode(',', $validated['job_benefits'])
        : null;

    $job->save();

    $jobId = $job->id;

    // --- Communication Preferences ---
    $request->validate([
        'contact_method' => 'required|string|in:email,phone,sms',
        'contact_time' => 'required|string|in:morning,afternoon,evening,anytime',
        'language_preference' => 'required|string',
    ]);

    $preference = new CommunicationPreference();
    $preference->job_id = $jobId;
    $preference->employer_id = $employer_id;
    $preference->personal_info_id = $personalInfoID;
    $preference->contact_method = $request->input('contact_method');
    $preference->contact_time = $request->input('contact_time');
    $preference->language_preference = $request->input('language_preference');
    $preference->save();

    // Validate Interview Screening
    $request->validate([
        'preferred_screening_method' => 'required|array',
        'preferred_interview_location' => 'required|string',
    ]);

    $interviewScreening = new InterviewScreening();
    $interviewScreening->job_id = $jobId;
    $interviewScreening->employer_id = $employer_id;
    $interviewScreening->personal_info_id = $personalInfoID;
    $interviewScreening->preferred_screening_method = json_encode($request->preferred_screening_method); 
    $interviewScreening->preferred_interview_location = $request->preferred_interview_location;
    $interviewScreening->save();

    // Validate Special Requirements
    $request->validate([
        'special_requirements' => 'nullable|array',
        'additional_requirements' => 'nullable|string',
    ]);

    $specialRequirements = new SpecialRequirement();
    $specialRequirements->job_id = $jobId;
    $specialRequirements->employer_id = $employer_id;
    $specialRequirements->personal_info_id = $personalInfoID;
    $specialRequirements->special_requirements = json_encode($request->special_requirements); 
    $specialRequirements->additional_requirements_or_notes = $request->additional_requirements;
    $specialRequirements->save();



    return back()->with('success', 'Job posting created successfully.');

}


//send review with starts
public function sendReview(Request $request) {
    

    $employer_id = session('employer_id');

    $retrievedId = AccountInformation::with('addressCompany')->where('id', $employer_id)->first();

    $request->validate([
        'applicant_id'=>'required|exists:applicants,id',
        'rating' => 'required|integer|min:1|max:5',
        'review_comment'=>'required|string',
    ]);

    //insert into database
    $review = new Rating();
    $review->applicant_id = $request->input('applicant_id');
    $review->employer_id = $retrievedId->id;
    $review->rating = $request->input('rating');
    $review->review_comments = $request->input('review_comment');
    $review->save();

    return back()->with('success', 'Review sent successfully.');
}


//Update job  status post
public function updateJobStatus($id) {
    

    
    $job = JobDetails::findOrFail($id);

    if($job->status_post === 'published') {
        $job->status_post = 'draft';
    }

    else{
        $job->status_post = 'published';
    }
   
    $job->save();

    return back()->with('success', 'Job status updated successfully.');

}

//delete the post
public function deleteJobPost($id) {

    $job = JobDetails::findOrFail($id);
    $job->delete();

    return back()->with('deleted', 'Job post deleted successfully.');
}

}