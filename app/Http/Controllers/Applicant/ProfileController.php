<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Applicant\ApplicantPostModel;
use App\Models\Applicant\ApplicantPortfolioModel;
use App\Models\Applicant\ApplicantUrlModel;
use App\Models\Applicant\RegisterModel;
use App\Models\Applicant\TesdaUploadCertificationModel as TesdaCertification;
use App\Models\Applicant\ExperienceModel as WorkBackground;
use App\Models\Applicant\PersonalModel as PersonalInfo;
use App\Models\Applicant\ApplicantFriendModel as AddFriend;
use App\Models\Applicant\TemplateModel as Template;
use App\Models\Applicant\ApplicantPostLikeModel as PostLike;
use App\Models\Applicant\ApplicantPostCommentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{   
    //Decrrpyted
    private function isSerialized($value)
{
    if (!is_string($value)) return false;
    return preg_match('/^([adObis]):/', $value) === 1;
}

private function cleanDecryptedString($value)
{
    if (empty($value)) return '';

    // Remove serialized fragments (like s:7:"Name";)
    $value = preg_replace('/s:\d+:"([^"]+)";/', '$1', $value);

    // Remove leftover symbols and trim spaces
    $value = trim(preg_replace('/[^A-Za-z0-9\s,.@-]/', '', $value));

    return $value;
}


private function safeDecrypt($value)
{
    if (empty($value)) return null;

    try {
        // Try decrypting first
        $decrypted = Crypt::decryptString($value);
    } catch (\Exception $e) {
        // Not encrypted, use as-is
        $decrypted = $value;
    }

    // 🧹 If decrypted value looks serialized (like s:7:"Rogelio";), unserialize it safely
    if ($this->isSerialized($decrypted)) {
        try {
            $decrypted = unserialize($decrypted);
        } catch (\Exception $e) {
            // Ignore if unserialize fails
        }
    }

    // 🧽 Clean any remaining serialized fragments
    return $this->cleanDecryptedString($decrypted);
}

    
    //View profile page
    public function ViewProfilePage() {
        $applicantID = session('applicant_id');
        $retrievedProfile = RegisterModel::with('personal_info' , 'work_background' , 'template')->find($applicantID);

        $retrievedDecrytedProfile = $retrievedProfile ? [
            'personal_info' => [
                'first_name' => $this->safeDecrypt($retrievedProfile->personal_info->first_name),
                'last_name' => $this->safeDecrypt($retrievedProfile->personal_info->last_name),
                'gender' => $this->safeDecrypt($retrievedProfile->personal_info->gender),
                'house_street' => $this->safeDecrypt($retrievedProfile->personal_info->house_street),
                'city' => $this->safeDecrypt($retrievedProfile->personal_info->city),
                'province' => $this->safeDecrypt($retrievedProfile->personal_info->province),
                'zipcode' => $this->safeDecrypt($retrievedProfile->personal_info->zipcode),
                'barangay' => $this->safeDecrypt($retrievedProfile->personal_info->barangay),
            ],

            'work_background' => [
                'position' => $this->safeDecrypt($retrievedProfile->work_background->position),
                'other_position' => $this->safeDecrypt($retrievedProfile->work_background->other_position),
                'work_duration' => $retrievedProfile->work_background->work_duration,
                'work_duration_unit' => $retrievedProfile->work_background->work_duration_unit,
                'profileimage_path' => $retrievedProfile->work_background->profileimage_path,
                'cover_photo_path' => $retrievedProfile->work_background->cover_photo_path,
            ],

            'template' => [
                'description' => $this->safeDecrypt($retrievedProfile->template->description),
                'sample_work' => $this->safeDecrypt($retrievedProfile->template->sample_work),
                'sample_work_url' => $this->safeDecrypt($retrievedProfile->template->sample_work_url),
            ]
        ]:[];

      $retrievedPosts = ApplicantPostModel::with('personalInfo', 'workBackground', 'likes', 'comments')
    ->where('applicant_id', $applicantID)
    ->get()
    ->reverse();

// Attach decrypted info to each post
foreach ($retrievedPosts as $post) {
    if ($post->personalInfo) {
        $post->retrievedDecryptedProfile = [
            'personal_info' => [
                'first_name'   => $this->safeDecrypt($post->personalInfo->first_name),
                'last_name'    => $this->safeDecrypt($post->personalInfo->last_name),
                'gender'       => $this->safeDecrypt($post->personalInfo->gender),
                'house_street' => $this->safeDecrypt($post->personalInfo->house_street),
                'city'         => $this->safeDecrypt($post->personalInfo->city),
                'province'     => $this->safeDecrypt($post->personalInfo->province),
                'zipcode'      => $this->safeDecrypt($post->personalInfo->zipcode),
                'barangay'     => $this->safeDecrypt($post->personalInfo->barangay),
            ],
        ];
    } else {
        $post->retrievedDecryptedProfile = null;
    }
}
        $retrievedPortfolio = ApplicantPortfolioModel::with('personalInfo' , 'workExperience')->where('applicant_id' , $applicantID)->get()->reverse();
        $retrievedYoutube = ApplicantUrlModel::with('personalInfo' , 'workExperience')->where('applicant_id' , $applicantID)->get()->reverse();
        $retrievedTesdaCertifacation = TesdaCertification::where('applicant_id' , $applicantID)->get()->reverse();
return view('applicant.profile.profile', compact(
    'retrievedProfile',
    'retrievedPosts',
    'retrievedPortfolio',
    'retrievedYoutube',
    'retrievedTesdaCertifacation',
    'retrievedDecrytedProfile',
))->with('success', 'Your post has been successfully published.');
    }

    //add cover photo
    public function AddCoverPhoto(Request $request){
        $request->validate([
            'cover_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        //Handle Cover Photo (stored under storage/app/public/cover_photo)
        $imagePath = $request->file('cover_photo')->store('cover_photo', 'public');
        $workBackground = WorkBackground::firstOrNew(['applicant_id' => session('applicant_id')]);
        $workBackground->cover_photo_path = $imagePath;
        $workBackground->save();

        return redirect()->back()->with('success', 'Cover photo updated successfully.');
    }

    //delete cover photo
    public function DeleteCoverPhoto(){
        $workBackground = WorkBackground::where('applicant_id', session('applicant_id'))->first();
        $workBackground->cover_photo_path = null;
        $workBackground->save();
        return redirect()->back()->with('success', 'Cover photo deleted successfully.');
    }

    //Add the edit profile page 
    public function EditProfile(Request $request, $id){
        $request->validate([
            'first_name'         => 'required|string',
            'last_name'          => 'required|string',
            'position'           => 'required|string',
            'other_position'     => 'nullable|string',
            'work_duration'      => 'required|numeric',
            'work_duration_unit' => 'required|string',
            'profile_picture'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        //Update Personal Info
        $applicant = PersonalInfo::findOrFail($id);
        $applicant->first_name = $request->first_name;
        $applicant->last_name  = $request->last_name;
        $applicant->save();

        //Update or Create Work Background
        $workBackground = WorkBackground::firstOrNew(['applicant_id' => $id]);

        //If "Other" is selected, use the custom input
        $workBackground->position = $request->position === 'Other' ? $request->other_position : $request->position;

        $workBackground->work_duration       = $request->work_duration;
        $workBackground->work_duration_unit  = $request->work_duration_unit;

        // Handle Profile Picture
        if ($request->hasFile('profile_picture')) {
            $imagePath = $request->file('profile_picture')->store('profile_picture', 'public');
            $workBackground->profileimage_path = $imagePath;
        }
        $workBackground->save();
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    //add applicant post 
    public function ApplicantPost(Request $request) {
        $applicantId = session('applicant_id');

        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'personal_info_id' => 'required|exists:personal_info,id',
            'work_experience_id' => 'required|exists:work_experiences,id',
        ]);

        $post = new ApplicantPostModel();
        $post->content = $request->input('content');
        $post->applicant_id = $applicantId;
        $post->personal_info_id = $request->input('personal_info_id');
        $post->work_experience_id = $request->input('work_experience_id');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('applicant_post', $filename, 'public');
            $post->image_path = $path;
        }   

        if ($post->save()) {
            return redirect()->back()->with('success', 'Post added successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to save post.');
        }
    }

    //edit the applicant post
    public function ApplicantEditPost(Request $request, $id){
        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $post = ApplicantPostModel::findOrFail($id);
        // Update content
        $post->content = $request->input('content');
        // Only update image if a new one is uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('applicant_post', $filename, 'public');
            $post->image_path = $path;
        }
        $post->save();
        return redirect()->back()->with('success', 'Post updated successfully.');
    }

    //Delete the applicant post
    public function ApplicantDeletePost($id){
        $post = ApplicantPostModel::findOrFail($id);
        $post->delete();
        return redirect()->back()->with('success', 'Post deleted successfully.');
    }

    //Add portfolio picture 
    public function AddPortfolio(Request $request){
        $applicantId = session('applicant_id');
        $request->validate([
            'sample_work_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sample_work_title' => 'required|string',
            'sample_work_description' => 'required|string',
            'personal_info_id' => 'required|exists:personal_info,id',
            'work_experience_id' => 'required|exists:work_experiences,id',
            'template_final_step_register_id' => 'required|exists:template_final_step_register,id',
            'applicant_id' => 'required|exists:applicants,id',
        ]);
        $addPortfolio = new ApplicantPortfolioModel();
        // Save uploaded image
        if ($request->hasFile('sample_work_image')) {
            $image = $request->file('sample_work_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('applicant_portfolio', $filename, 'public');
            $addPortfolio->sample_work_image = $path;
        }
        // Set other fields
        $addPortfolio->sample_work_title = $request->input('sample_work_title');
        $addPortfolio->sample_work_description = $request->input('sample_work_description');
        $addPortfolio->personal_info_id = $request->input('personal_info_id');
        $addPortfolio->work_experience_id = $request->input('work_experience_id');
        $addPortfolio->template_final_step_register_id = $request->input('template_final_step_register_id');
        $addPortfolio->applicant_id = $request->input('applicant_id');

        if ($addPortfolio->save()) {
            return redirect()->back()->with('success', 'Portfolio added successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to save portfolio.');
        }
    }

    //delete portfolio
    public function DeletePortfolio($id) {
        $portfolio = ApplicantPortfolioModel::find($id);
        $portfolio->delete();
        return redirect()->back()->with('success', 'Portfolio deleted successfully.');
    }

    //Add youtube link to the profile portfolio
    public function AddYoutubeVideo(Request $request) {
        $applicantId = session('applicant_id');

        $request->validate([
            'youtube_link' => 'required|url',
            'youtube_title' => 'required|string',
            'personal_info_id' => 'required|exists:personal_info,id',
            'work_experience_id' => 'required|exists:work_experiences,id',
            'applicant_id' => 'required|exists:applicants,id', 
        ]);

        $addYoutubeUrl = new ApplicantUrlModel();

        $addYoutubeUrl->sample_work_url = $request->input('youtube_link');
        $addYoutubeUrl->sample_work_title = $request->input('youtube_title');
        $addYoutubeUrl->personal_info_id = $request->input('personal_info_id');
        $addYoutubeUrl->work_experience_id = $request->input('work_experience_id');
        $addYoutubeUrl->applicant_id = $request->input('applicant_id');

        if ($addYoutubeUrl->save()) {
            return redirect()->back()->with('success', 'YouTube portfolio added successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to save YouTube portfolio.');
        }
    }

    public function DeleteYoutubeVideo($id) {
        $portfolio = ApplicantUrlModel::find($id);
        $portfolio->delete();
        return redirect()->back()->with('success', 'YouTube portfolio deleted successfully.');
    }

    //get the applicant profile
    public function getApplicantProfile($id){
        $currentApplicantId = session('applicant_id'); // logged-in applicant
        $targetApplicantId = $id; // the profile being stalked

       // Load main applicant profile and relationships
    $retrievedProfile = RegisterModel::with(['personal_info', 'work_background', 'template'])->findOrFail($id);

    // Return decrypted profile safely
    $retrievedDecryptedProfile = $retrievedProfile ? [
        'personal_info' => [
            'first_name' => $this->safeDecrypt($retrievedProfile->personal_info->first_name ?? ''),
            'last_name' => $this->safeDecrypt($retrievedProfile->personal_info->last_name ?? ''),
            'gender' => $this->safeDecrypt($retrievedProfile->personal_info->gender ?? ''),
            'house_street' => $this->safeDecrypt($retrievedProfile->personal_info->house_street ?? ''),
            'city' => $this->safeDecrypt($retrievedProfile->personal_info->city ?? ''),
            'province' => $this->safeDecrypt($retrievedProfile->personal_info->province ?? ''),
            'zipcode' => $this->safeDecrypt($retrievedProfile->personal_info->zipcode ?? ''),
            'barangay' => $this->safeDecrypt($retrievedProfile->personal_info->barangay ?? ''),
        ],

        'work_background' => [
            'position' => $this->safeDecrypt($retrievedProfile->work_background->position ?? ''),
            'other_position' => $this->safeDecrypt($retrievedProfile->work_background->other_position ?? ''),
            'work_duration' => $retrievedProfile->work_background->work_duration ?? '',
            'work_duration_unit' => $retrievedProfile->work_background->work_duration_unit ?? '',
            'profileimage_path' => $retrievedProfile->work_background->profileimage_path ?? '',
            'cover_photo_path' => $retrievedProfile->work_background->cover_photo_path ?? '',
        ],

        'template' => [
            'description' => $this->safeDecrypt($retrievedProfile->template->description ?? ''),
            'sample_work' => $this->safeDecrypt($retrievedProfile->template->sample_work ?? ''),
            'sample_work_url' => $this->safeDecrypt($retrievedProfile->template->sample_work_url ?? ''),
        ]
    ] : [];


   
        // Load target applicant's posts
      // Load target applicant's posts
$retrievedPosts = ApplicantPostModel::with(['personalInfo', 'workBackground', 'likes', 'comments.applicant.personal_info'])
    ->where('applicant_id', $targetApplicantId)
    ->latest()
    ->get();

// Attach decrypted profile to each post
foreach ($retrievedPosts as $post) {
    if ($post->personalInfo) {
        $post->retrievedDecryptedProfile = [
            'personal_info' => [
                'first_name'   => $this->safeDecrypt($post->personalInfo->first_name),
                'last_name'    => $this->safeDecrypt($post->personalInfo->last_name),
                'gender'       => $this->safeDecrypt($post->personalInfo->gender),
                'house_street' => $this->safeDecrypt($post->personalInfo->house_street),
                'city'         => $this->safeDecrypt($post->personalInfo->city),
                'province'     => $this->safeDecrypt($post->personalInfo->province),
                'zipcode'      => $this->safeDecrypt($post->personalInfo->zipcode),
                'barangay'     => $this->safeDecrypt($post->personalInfo->barangay),
            ],
        ];
    } else {
        $post->retrievedDecryptedProfile = null;
    }

     // 🔹 Decrypt each comment’s applicant personal info
    if ($post->comments && $post->comments->count() > 0) {
        foreach ($post->comments as $comment) {
            if ($comment->applicant && $comment->applicant->personal_info) {
                $comment->decryptedPersonalInfo = [
                    'first_name' => $this->safeDecrypt($comment->applicant->personal_info->first_name),
                    'last_name'  => $this->safeDecrypt($comment->applicant->personal_info->last_name),
                    'gender'     => $this->safeDecrypt($comment->applicant->personal_info->gender),
                ];
            } else {
                $comment->decryptedPersonalInfo = null;
            }
        }
    }
}

        $retrievedPortfolio = ApplicantPortfolioModel::with('personalInfo', 'workExperience')
            ->where('applicant_id', $id)->latest()->get();

        $retrievedYoutube = ApplicantUrlModel::with('personalInfo' , 'workExperience')
            ->where('applicant_id' , $id)->get()->reverse();

        // Check if a friend request exists between the logged-in applicant and the target
        $friendRequest = AddFriend::where(function ($query) use ($currentApplicantId, $targetApplicantId) {
            $query->where('request_id', $currentApplicantId)
                ->where('receiver_id', $targetApplicantId);
        })->orWhere(function ($query) use ($currentApplicantId, $targetApplicantId) {
            $query->where('request_id', $targetApplicantId)
                ->where('receiver_id', $currentApplicantId);
        })->first();

        // Inject relationship states into the profile
        $retrievedProfile->alreadySent = $friendRequest !== null;
        $retrievedProfile->friendRequestId = $friendRequest?->id;
        $retrievedProfile->friendRequestStatus = $friendRequest?->status;
        $retrievedProfile->isReceiver = $friendRequest?->receiver_id == $currentApplicantId;


        $tesdaCertification = \App\Models\Applicant\TesdaUploadCertificationModel::where('applicant_id', $targetApplicantId)
        ->latest()
        ->get();

        return view('applicant.homepage.getprofile.getprofile', compact('retrievedProfile', 'retrievedPosts', 'retrievedPortfolio','retrievedYoutube', 'tesdaCertification','currentApplicantId' , 'retrievedDecryptedProfile'))->with('success', 'Your post has been successfully posted.');
    }


    //update profile
    public function updateProfile(Request $request){
        $request->validate([
            'email' => 'required|email',
            'house_street' => 'required|string',
            'barangay' => 'required|string',
            'city' => 'required|string',
            'province' => 'required|string',
            'description' => 'required|string',
        ]);

        $applicantID = session('applicant_id');

        if (!$applicantID) {
            return back()->withErrors(['error' => 'No applicant selected.']);
        }

        // Update email in RegisterModel
        RegisterModel::where('id', $applicantID)->update([
            'email' => $request->email,
        ]);

        // Update personal info
        PersonalInfo::where('applicant_id', $applicantID)->update([
            'house_street' => $request->house_street,
            'barangay' => $request->barangay,
            'city' => $request->city,
            'province' => $request->province,
        ]);

        // Update template description
        Template::where('applicant_id', $applicantID)->update([
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    //Add like button to applicant post on profile
    public function toggleLike( $postId){
        $applicantId = session('applicant_id'); // or auth()->guard('applicant')->id();

        $like = PostLike::where('post_id', $postId)
                    ->where('applicant_id', $applicantId)
                    ->first();

        if ($like) {
            //Unlike
            $like->delete();
                return redirect()->back()->with('success', 'You unliked the post!');
            } else {
            // Like
            PostLike::create([
                'post_id' => $postId,
                'applicant_id' => $applicantId,
                'likes' => 1, 
            ]);
            return redirect()->back()->with('success', 'You liked the post!');
        }
    }

    //add comment on applicant post
    public function ApplicantAddComments(Request $request){
        $applicantId = session('applicant_id');
        $request->validate([
            'post_id' => 'required|exists:applicant_posts,id',
            'comment' => 'required|string',
        ]);
        $comment = new ApplicantPostCommentModel();
        $comment->post_id = $request->input('post_id');
        $comment->applicant_id = $applicantId;
        $comment->comment = $request->input('comment');
        $comment->save();
        return redirect()->back()->with('success', 'Comment added successfully.');

    }

    
    //delete comment on applicant post
    public function ApplicantDeleteComments($postId){
        $comment = ApplicantPostCommentModel::findOrFail($postId);
        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
    //aDD TESDA CERTIFICATE
    public function addTesdaCertificate(Request $request){
        $applicantId = session('applicant_id');
            if (!$applicantId) {
                return back()->withErrors(['error' => 'No applicant selected.']);
            }
        // Validation
        $request->validate([
            'certificate_file' => 'required|mimes:pdf,doc,docx|max:5120',
            'certification_program' => 'required|string|max:255',
            'other_certification_program' => 'nullable|string|max:255',
            'date_obtained' => 'required|date',
        ]);
        // Create new TesdaCertification
        $tesda_certificate = new TesdaCertification();
        $tesda_certificate->applicant_id = $applicantId;
        $tesda_certificate->status = 'pending';
        // $tesda_certificate->certification_number = null ;
        //  If program is "other", use the "other" input field
        if ($request->certification_program === 'Other') {
            $tesda_certificate->certification_program = $request->other_certification_program;
            $tesda_certificate->certification_program_other = $request->other_certification_program;
        } else {
            $tesda_certificate->certification_program = $request->certification_program;
            $tesda_certificate->certification_program_other = null; // not needed
        }
        $tesda_certificate->certification_date_obtained = $request->date_obtained;
        // Handle file upload
        if ($request->hasFile('certificate_file')) {
            $path = $request->file('certificate_file')->store('tesda_certificates', 'public');
            $tesda_certificate->file_path = $path;
            $tesda_certificate->save(); // store path in DB
        }
        $tesda_certificate->save();
        return back()->with('success', 'Your TESDA Certification has been submitted and will be reviewed by TESDA officers. Please wait, thank you!');
    }
    //delete tesda certificate
    public function deleteTesdaCertificate($id){
        $tesda_certificate = TesdaCertification::findOrFail($id);
        $tesda_certificate->delete();
        return back()->with('success', 'TESDA Certification deleted successfully.');
    }


public function restoreDefault(Request $request)
{
    $applicantId = session('applicant_id');

    $profile = WorkBackground::where('applicant_id', $applicantId)->first();

    if ($profile && $profile->profileimage_path) {
        // delete current image
        Storage::disk('public')->delete($profile->profileimage_path);

        // remove stored file path
        $profile->profileimage_path = null;
        $profile->save();
    }

    return response()->json([
        'message' => 'Profile photo restored to default successfully.'
    ]);
}













}
