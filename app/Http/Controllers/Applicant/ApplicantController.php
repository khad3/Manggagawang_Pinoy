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
use App\Models\Applicant\PostModel as Post;
use App\Models\Applicant\CommentModel as Comment;
use App\Models\Applicant\ReplyModel as ReplyComment;
use App\Models\Applicant\LikeModel as ForumLike;
use App\Models\Applicant\GroupModel as Group;
use App\Models\Applicant\ParticipantModel as Participants;  
use App\Models\Applicant\PostSpecificGroupModel as GroupPost;
use App\Models\Applicant\GroupCommentModel as GroupComment;
use App\Models\Applicant\GroupLikeModel as GroupLike;
use App\Models\Applicant\ApplicantFriendModel as AddFriend;
use App\Models\Applicant\SendMessageModel as SendMessage;
use App\Models\Applicant\SavedJobModel as SavedJob;
use App\Models\Applicant\TesdaUploadCertificationModel as TesdaCertification;
use App\Notifications\Applicant\FriendRequestNotification;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


use App\Models\Employer\AccountInformationModel as EmployerInfo;

use Illuminate\Support\Facades\DB;
use App\Models\Employer\JobDetailModel;

use App\Mail\Applicant\VerifyEmail as VerifyEmail;
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
    $applicant = RegisterModel::where('email', $request->email)->first();

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

    return redirect()->route('applicant.info.homepage.display')->with('success', 'Login successful.');
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

    

    return view('applicant.homepage.homepage', compact(
        'retrievePersonal',
        'applicantCounts',
        'JobPostRetrieved',
        'publishedCounts',
        'retrievedAddressCompany',
        'savedJobIds' 
    ));
}



public function ShowForum()
{
    $currentApplicantId = session('applicant_id');

    $posts = Post::with([
        'likes',
        'personalInfo',
        'comments.replies.applicant.personal_info',
        'workBackground',
        'comments.applicant.personal_info'
    ])->orderBy('created_at', 'desc')->get();

   $posts->map(function ($post) use ($currentApplicantId) {
    $targetApplicantId = $post->applicant_id;

    $friendRequest = AddFriend::where(function($query) use ($currentApplicantId, $targetApplicantId) {
        $query->where('request_id', $currentApplicantId)
              ->where('receiver_id', $targetApplicantId);
    })->orWhere(function($query) use ($currentApplicantId, $targetApplicantId) {
        $query->where('request_id', $targetApplicantId)
              ->where('receiver_id', $currentApplicantId);
    })->first();

    $post->alreadySent = $friendRequest !== null;
    $post->friendRequestId = $friendRequest?->id;
    $post->friendRequestStatus = $friendRequest?->status;
    $post->isReceiver = $friendRequest?->receiver_id == $currentApplicantId;

    return $post;
    });

    $categories = Post::distinct()->pluck('category')->toArray();

    return view('applicant.community_form.forums', compact('posts', 'categories'));
}



//Create post sa community forum
public function CreatePost(Request $request)
{
    $applicantId = session('applicant_id');

    $request->validate([
        'post_title' => 'required|string|max:255',
        'post_content' => 'required|string',
        'post_topic' => 'required|string',
        'post_media' => 'nullable|file|mimes:jpeg,png,jpg,mp4,mov,avi|max:20480', // max 20MB
      
    ]);

    // Get the applicant's personal_info_id
    $personalInfo = PersonalInfo::where('applicant_id', $applicantId)->first();
    $workBackground = WorkBackground::where('applicant_id', $applicantId)->first();

    if (!$personalInfo) {
        return redirect()->back()->withErrors('Personal information not found.');
    }

    $mediaPath = null;
    if ($request->hasFile('post_media')) {
        $mediaPath = $request->file('post_media')->store('post_media', 'public');
    }

    $post = new Post([
        'title' => $request->post_title,
        'content' => $request->post_content,
        'applicant_id' => $applicantId,
        'personal_info_id' => $personalInfo->id, // ✅ Added this line
        'work_experience_id' => $workBackground->id,
        'image_path' => $mediaPath,
        'category' => $request->post_topic,
    ]);

    $post->save();

    return redirect()->route('applicant.forum.display')->with('success', 'Post created successfully.');
}

//Delete posts sa community forum with custom auth (kumbaga sino nakalog in makikita nila yung delete post)
public function DeletePost($id)
{
    $post = Post::findOrFail($id);
    $applicantId = session('applicant_id');

    if (!$applicantId || $applicantId !== $post->applicant_id) {
        abort(403, 'Unauthorized action.');
    }

    $post->delete();

    return redirect()->route('applicant.forum.display')->with('success', 'Post deleted successfully.');
}


//Add comments
public function AddComments(Request $request)
{
    $applicantId = session('applicant_id');

    // Validate input
    $request->validate([
        'comment' => 'required|string',
        'post_id' => 'required|exists:forum_posts,id',
    ]);

    // Find the applicant by id (assuming 'id' is the primary key)
    $applicant = RegisterModel::find($applicantId);
    if (!$applicant) {
        return redirect()->back()->withErrors('Applicant not found or not logged in.');
    }

    // Find the post by id (assuming 'id' is the primary key in forum_posts table)
    $post = Post::where('id', $request->post_id)->first();
    if (!$post) {
        return redirect()->back()->withErrors('Post not found.');
    }

    // Create and save the comment
    $comment = new Comment([
        'comment' => $request->comment,
        'forum_post_id' => $post->id,
        'applicant_id' => $applicant->id,
    ]);

    $comment->save();

    return redirect()->route('applicant.forum.display')->with('success', 'Comment added successfully.');
}
//Delete comments parent 
public function DeleteComment($id) {

    $comment = Comment::findOrFail($id);
    $comment->delete();

    return redirect()->route('applicant.forum.display')->with('success', 'Comment deleted successfully.');
}

//Delete reply comments child
public function DeleteReplyComment($id) {

    $reply = ReplyComment::findOrFail($id);
    $reply->delete();
    return redirect()->route('applicant.forum.display')->with('success', 'Reply deleted successfully.');
}

//reply to the comments
public function ReplyComments(Request $request)
{
    $request->validate([
        'reply_comment' => 'required|string',
    ]);

    $reply = new ReplyComment([
        'reply' => $request->reply_comment,
        'forum_comment_id' => $request->comment_id,
        'applicant_id' => session('applicant_id'),
    ]);

    $reply->save();

    return redirect()->route('applicant.forum.display')->with('success', 'Reply added successfully.');
}
 
//Adding likes
public function LikePost($id)
{
    $applicantId = session('applicant_id');

    if (!$applicantId) {
        return redirect()->back()->with('error', 'You must be logged in to like a post.');
    }

    // Check if the applicant already liked this post
    $existingLike = ForumLike::where('forum_post_id', $id)
        ->where('applicant_id', $applicantId)
        ->first();

    if ($existingLike) {
        // Toggle: if liked (likes=1), then dislike (likes=0) or remove the record
        // Option 1: Delete the like record (simpler)
        $existingLike->delete();

        // Option 2: Or update likes to 0 instead of deleting
        // $existingLike->likes = 0;
        // $existingLike->save();

        return redirect()->back()->with('success', 'You unliked the post.');
    } else {
        // Create a new like record
        ForumLike::create([
            'forum_post_id' => $id,
            'applicant_id' => $applicantId,
            'likes' => 1,
        ]);

        return redirect()->back()->with('success', 'Post liked successfully.');
    }
}


//View my post
public function ViewMyPost() {
    $applicantId = session('applicant_id');
    $posts = Post::where('applicant_id', $applicantId)->get()->sortByDesc('created_at');

    $categories = Post::distinct()->pluck('category')->toArray();
    return view('applicant.community_form.viewmypost', compact('posts' , 'categories')); 

}


//View group forum form
public function ShowGroupForum() {
    return view('applicant.community_form.groupforum');

}


//View list of group forum kumabaga ito yung display
public function DisplayGroupForum()
{
    $applicant_id = session('applicant_id');

    $listOfGroups = Group::with(['members', 'personalInfo'])
        ->withCount('members')
        ->orderByDesc('created_at')
        ->get();

    return view('applicant.community_form.viewgroup', compact('listOfGroups', 'applicant_id'));
}


//Add group forum
public function AddGroupForum(Request $request) {


    $applicantId = session('applicant_id');
    $request->validate([
        'group_title'   => 'required|string|max:100',
        'group_description'   => 'required|string|max:100',
        'group_privacy' => 'required|string|max:100',
        
    ]);

    $personalInfo = PersonalInfo::where('applicant_id', $applicantId)->first();

    if (!$personalInfo) {
        return redirect()->back()->withErrors('Personal information not found.');
    }

    $personalInfoId = $personalInfo->id;
    $newGroup = new Group([
        'group_name' => $request->group_title,
        'group_description' => $request->group_description,
        'privacy' => $request->group_privacy,
        'applicant_id' => $applicantId,
        'personal_info_id' => $personalInfoId,
    ]);

    $newGroup->save();

    return redirect()->route('applicant.forum.display')->with([
        'success' => 'Group created successfully.'
    ]);
}

//For request and join group forum
public function RequestAndJoinGroup(Request $request)
{
    $request->validate([
        'group_id' => 'required|exists:group_community,id',
    ]);

    $applicantId = session('applicant_id');

    if (!$applicantId) {
        return redirect()->back()->with('error', 'You must be logged in to join a group.');
    }

    $groupId = $request->group_id;
    $group = Group::findOrFail($groupId);

    $applicantPersonalInfo = PersonalInfo::where('applicant_id', $applicantId)->first();
    if (!$applicantPersonalInfo) {
        return redirect()->back()->with('error', 'Personal information not found.');
    }

    // Check if already requested or approved
    $existingMember = $group->members()
        ->wherePivot('applicant_id', $applicantId)
        ->first();

    if ($existingMember) {
        $status = $existingMember->pivot->status;
        if ($status === 'approved') {
            return redirect()->back()->with('info', 'You are already a member of the "' . $group->group_name . '" group.');
        } elseif ($status === 'pending') {
            return redirect()->back()->with('info', 'Your join request to "' . $group->group_name . '" is still pending approval.');
        }
    }

    // Set status based on group type
    $status = $group->privacy === 'public' ? 'approved' : 'pending';

    // Attach request to group
    $group->members()->attach($applicantId, [
        'personal_info_id' => $applicantPersonalInfo->id,
        'status' => $status,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Response messages
    if ($group->privacy === 'public') {
        return redirect()->back()->with('success', 'You successfully joined the public group: "' . $group->group_name . '".');
    } else {
        return redirect()->back()->with('success', 'Join request sent to "' . $group->group_name . '". Please wait for the creator\'s approval.');
    }
}
//View the specific group //SI applicant toj
public function ViewSpecificGroup($id)
{
    $applicantId = session('applicant_id');

    $group = Group::with([
        'personalInfo',
        'members.personal_info'
    ])->withCount('members')->find($id);

    if (!$group) {
        return redirect()->back()->with('error', 'Group not found.');
    }

    $retrievePosts = GroupPost::with([
        'work_background',
            'likes',
            'personalInfo',
            'comments.personal_info',
            'comments.applicant.work_background'
        ])
        ->withCount('comments') // <- this adds $post->comments_count
        ->where('group_community_id', $id)
        ->latest()
        ->get();

    $members = $group->members->filter(fn($member) =>
        $member->pivot->status === 'approved' && $member->id !== $group->applicant_id
    );

    return view('applicant.community_form.viewspecificgroup', compact(
        'group', 'members', 'applicantId', 'retrievePosts'
    ));
}


//Add like for the group forum
public function AddLikeGroup(Request $request, $groupId, $postId)
{
    $applicantId = session('applicant_id');

    $applicant = RegisterModel::with('personal_info')->find($applicantId);
    if (!$applicant || !$applicant->personal_info) {
        return redirect()->back()->with('error', 'Applicant or personal info not found.');
    }

    $existingLike = GroupLike::where('group_community_id', $groupId)
        ->where('per_group_community_post_id', $postId)
        ->where('applicant_id', $applicantId)
        ->first();

    if ($existingLike) {
        $existingLike->delete();
        return redirect()->back()->with('success', 'Post unliked successfully.');
    }

    GroupLike::create([
        'group_community_id' => $groupId,
        'per_group_community_post_id' => $postId,
        'applicant_id' => $applicantId,
        'personal_info_id' => $applicant->personal_info->id,
        'likes' => 1
    ]);

    return redirect()->back()->with('success', 'Post liked successfully.');
}




//Delete comment 
public function DeleteCommentGroup($groupId, $commentId)
{
    $group = Group::findOrFail($groupId); // ✅ Correct model

    // Prevent deleting from private groups
    if ($group->privacy === 'private') {
        return redirect()->back()->with('error', 'You cannot delete comments in a private group.');
    }

    $comment = GroupComment::findOrFail($commentId);

    // Only allow deletion by the comment owner
    if ($comment->applicant_id !== session('applicant_id')) {
        return redirect()->back()->with('error', 'You can only delete your own comment.');
    }

    $comment->delete();

    return redirect()->route('applicant.forum.creatorviewpage.display', ['groupId' => $groupId])
                     ->with('success', 'Comment deleted successfully.');
}





//Add post for the group forum
public function AddPostGroupCommunity(Request $request, $groupId)
{
    $applicantId = session('applicant_id');

    // Load the group
    $group = Group::with('members')->find($groupId);

    if (!$group) {
        return redirect()->back()->with('error', 'Group not found.');
    }

    // Check if the applicant is a member (including creator)
    $isMember = $group->members->contains('id', $applicantId) || $group->applicant_id == $applicantId;

    if (!$isMember) {
        return redirect()->back()->with('error', 'You are not a member of this group.');
    }

    // Fetch the applicant and their personal info
    $applicant = RegisterModel::with('personal_info')->find($applicantId);
    $personalInfoId = $applicant->personal_info->id ?? null;

    // Validate input
    $validated = $request->validate([
        'title'   => 'required|string|max:255',
        'content' => 'required|string',
        'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle image upload
    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('group_posts', 'public');
    }

    // Create post
    GroupPost::create([
        'title'             => $validated['title'],
        'content'           => $validated['content'],
        'image_path'        => $imagePath,
        'group_community_id'=> $groupId,
        'applicant_id'      => $applicantId,
        'personal_info_id'  => $personalInfoId,
    ]);

    return redirect()->back()->with('success', 'Post added successfully.');
}



// View groups created by the logged-in applicant
public function ViewGroupByCreator() {
    $applicantId = session('applicant_id');

    $listOfGroups = Group::with('personalInfo')
        ->withCount('members')
        ->where('applicant_id', $applicantId) // Only groups created by the current applicant
        ->orderByDesc('created_at')
        ->get();

    return view('applicant.community_form.viewgroupwhocreated', compact('listOfGroups'));
}

//delete the group by applciant who created it
public function DeleteGroupByCreator($id) {

    $group = Group::findOrFail($id);

    // Only the creator can delete
    if ($group->applicant_id !== session('applicant_id')) {
        return redirect()->back()->with('error', 'Unauthorized action.');
    }

    $group->delete();

    return redirect()->route('applicant.forum.viewgroupcreator.display')->with('success', 'Group deleted successfully.');


}

//View the group by my created group co,,unities page //Creator
public function ViewGroupByCreatorPage($id)
{
    $applicantId = session('applicant_id');

    // Load group with creator info and members
    $group = Group::with([
        'personalInfo',
        'members.personal_info'
    ])->withCount('members')->find($id);

    if (!$group) {
        return redirect()->back()->with('error', 'Group not found.');
    }

    // Get posts with comments and commenter info
    $retrievePosts = GroupPost::with([
        'personalInfo', // author of the post
        'comments.personal_info' // eager-load all comments and the commenter’s info
    ])
    ->where('group_community_id', $id)
    ->latest()
    ->get();

    // Filter only approved members
    $members = $group->members->filter(function ($member) use ($group) {
        return $member->pivot->status === 'approved' && $member->id !== $group->applicant_id;
    });

    return view('applicant.community_form.viewspecificgroupbycreator', compact(
        'group',
        'members',
        'applicantId',
        'retrievePosts' // ✅ only pass posts — comments are nested inside
    ));
}




//Add post for specific group forum in my created group co,,unities page

public function AddPostGroupSpecific(Request $request, $groupId)
{
    $applicantId = session('applicant_id');

    // Load the group with its members
    $group = Group::with('members')->find($groupId);

    if (!$group) {
        return redirect()->back()->with('error', 'Group not found.');
    }

    // Check if the applicant is a member or the group creator
    $isMember = $group->members->contains('id', $applicantId) || $group->applicant_id == $applicantId;

    if (!$isMember) {
        return redirect()->back()->with('error', 'You are not a member of this group.');
    }

    // Fetch the applicant and their personal info
    $applicant = RegisterModel::with('personal_info')->find($applicantId);
    $personalInfoId = $applicant->personal_info->id ?? null;

    // Validate input
    $validated = $request->validate([
        'title'   => 'required|string|max:255',
        'content' => 'required|string',
        'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle image upload
    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('group_posts', 'public');
    }

    // Create post
    GroupPost::create([
        'title'             => $validated['title'],
        'content'           => $validated['content'],
        'image_path'        => $imagePath,
        'group_community_id'=> $groupId,
        'applicant_id'      => $applicantId,
        'personal_info_id'  => $personalInfoId,
    ]);

    return redirect()->back()->with('success', 'Post added successfully.');
}

//Add comment for group community forum 
public function AddCommentGroupSpecific(Request $request, $groupId)
{
    $applicantId = session('applicant_id');

    // Load the group with its members
    $group = Group::with('members')->find($groupId);

    if (!$group) {
        return redirect()->back()->with('error', 'Group not found.');
    }

    // Check if the applicant is a member or the group creator
    $isMember = $group->members->contains('id', $applicantId) || $group->applicant_id == $applicantId;

    if (!$isMember) {
        return redirect()->back()->with('error', 'You are not a member of this group.');
    }

    // Fetch the applicant and their personal info
    $applicant = RegisterModel::with('personal_info' , 'work_background')->find($applicantId);
    $personalInfoId = $applicant->personal_info->id ?? null;

    // Validate input (including the post ID to comment on)
    $validated = $request->validate([
        'comment' => 'required|string',
        'per_group_community_post_id' => 'required|exists:per_group_posts,id',
    ]);

    // Create comment
    GroupComment::create([
        'comment'                    => $validated['comment'],
        'group_community_id'        => $groupId,
        'applicant_id'              => $applicantId,
        'personal_info_id'          => $personalInfoId,
        'per_group_community_post_id' => $validated['per_group_community_post_id'],
        'work_experience_id'        => $applicant->work_background->id ?? null
    ]);

    return redirect()->back()->with('success', 'Comment added successfully.');
}



//Approved member by creator
public function approveMember($groupId, $applicantId)
{
    $group = Group::findOrFail($groupId);

    // Only the creator can approve
    if ($group->applicant_id !== session('applicant_id')) {
        return redirect()->back()->with('error', 'Unauthorized action.');
    }

    $group->members()->updateExistingPivot($applicantId, [
        'status' => 'approved',
        'updated_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Membership request approved.');
}



// My post forum edit page 
public function ShowPostPage($id){
    $retrievedPosts = Post::findOrFail($id)->where('id', $id)->get();
    return view('applicant.community_form.editforum' , compact('retrievedPosts'));
}


//Edit post forum 
public function EditPost(Request $request, $id)
{
    // Retrieve the post by ID or throw 404 if not found
    $post = Post::findOrFail($id);

    // Validate input fields
    $validated = $request->validate([
        'post_title'   => 'required|string|max:100',
        'post_topic'   => 'required|string|max:100',
        'post_content' => 'required|string|max:800',
        'post_media'   => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:20480', // max 20MB
    ]);

    // Update basic fields
    $post->title = $validated['post_title'];
    $post->category = $validated['post_topic'];
    $post->content = $validated['post_content'];

    // If media is uploaded, store and update path
    if ($request->hasFile('post_media')) {
        $file = $request->file('post_media');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('post_media', $filename, 'public'); // Stored in storage/app/public/uploads/posts
        $post->image_path = $path;
    }

    // Save updates to the database
    $post->save();

    // Redirect back to forum page with a success message
    return redirect()->route('applicant.forum.viewpost.display')->with('success', 'Post updated successfully.');
}



//Add friend sa applicant 

public function AddFriend(Request $request, $id)
{
    $applicantId = session('applicant_id');
    $friendId = $id;

    if (!RegisterModel::where('id', $friendId)->exists()) {
        return redirect()->back()->with('error', 'The selected user does not exist.');
    }

    $alreadySent = AddFriend::where(function ($query) use ($applicantId, $friendId) {
        $query->where('request_id', $applicantId)
              ->where('receiver_id', $friendId);
    })->orWhere(function ($query) use ($applicantId, $friendId) {
        $query->where('request_id', $friendId)
              ->where('receiver_id', $applicantId);
    })->exists();

    if ($alreadySent) {
        return redirect()->back()->with('error', 'Friend request already sent or already friends.');
    }

    AddFriend::create([
        'request_id' => $applicantId,
        'receiver_id' => $friendId,
        'status' => 'pending',
    ]);

    return redirect()->back()->with('success', 'Friend request sent successfully.');
}




//Cancel friend request
public function CancelFriendRequest($id) {

    $friendRequest = AddFriend::findOrFail($id);

    if (
        $friendRequest->request_id == session('applicant_id') ||
        $friendRequest->receiver_id == session('applicant_id')
    ) {
        $friendRequest->delete();
        return redirect()->back()->with('success', 'Friend request cancelled.');
    }

    return redirect()->back()->with('error', 'Unauthorized action.');

}

//accept friend request
public function AcceptFriendRequest($id) {

    $friendRequest = AddFriend::findOrFail($id);

    if (
        $friendRequest->request_id == session('applicant_id') ||
        $friendRequest->receiver_id == session('applicant_id')
    ) {
        $friendRequest->status = 'accepted';
        $friendRequest->save();
        return redirect()->back()->with('success', 'Friend request accepted.');
    }

    return redirect()->back()->with('error', 'Unauthorized action.');
}


//View Friend sa community forum
public function ViewFriendlistPage(Request $request)
{
    $applicantID = session('applicant_id');

    
    $updatedLastSeen = RegisterModel::where('id', $applicantID)->update([
        'last_seen' => now()
    ]);

    
    $friend_id = $request->query('friend_id');

    // If friend_id is present, mark messages from friend as read
    if ($friend_id) {
        SendMessage::where('sender_id', $friend_id)
            ->where('receiver_id', $applicantID)
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

   
    $retrievedFriends = AddFriend::with([
        'sender.personal_info',
        'receiver.personal_info',
    ])
    ->where('status', 'accepted')
    ->where(function ($query) use ($applicantID) {
        $query->where('request_id', $applicantID)
              ->orWhere('receiver_id', $applicantID);
    })
    ->get();

    // Retrieve messages (both sent and received)
    $retrievedMessages = SendMessage::with('sender.personal_info', 'receiver.personal_info')
        ->where(function ($query) use ($applicantID) {
            $query->where('sender_id', $applicantID)
                  ->orWhere('receiver_id', $applicantID);
        })
        ->get();

    // Applicant info
    $retrievedApplicantInfo = RegisterModel::with(['personal_info', 'work_background', 'template'])
        ->find($applicantID);


        $friendRequests = AddFriend::with(['sender.personal_info', 'sender.work_background'])
    ->where('receiver_id', $applicantID)
    ->where('status', 'pending')
    ->get();




    $receiver_id = $friend_id;
    return view('applicant.friendlist.friendlist', compact(
        'retrievedApplicantInfo',
        'retrievedFriends',
        'applicantID',
        'retrievedMessages',
        'updatedLastSeen',
        'receiver_id',
        'friendRequests'
    ));
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

//View profile page
public function ViewProfilePage() {

    $applicantID = session('applicant_id');

    $retrievedProfile = RegisterModel::with('personal_info' , 'work_background' , 'template')->find($applicantID);

    $retrievedPosts = ApplicantPostModel::with('personalInfo' , 'workBackground')->where('applicant_id' , $applicantID)->get()->reverse();

    $retrievedPortfolio = ApplicantPortfolioModel::with('personalInfo' , 'workExperience')->where('applicant_id' , $applicantID)->get()->reverse();

    $retrievedYoutube = ApplicantUrlModel::with('personalInfo' , 'workExperience')->where('applicant_id' , $applicantID)->get()->reverse();

    $retrievedTesdaCertifacation = TesdaCertification::where('applicant_id' , $applicantID)->get()->reverse();

    return view('applicant.profile.profile' , compact('retrievedProfile' , 'retrievedPosts' , 'retrievedPortfolio' , 'retrievedYoutube' , 'retrievedTesdaCertifacation'));
}

//update profile
public function updateProfile(Request $request)
{
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




//add applicant post 
public function ApplicantPost(Request $request) 
{
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


//Add portfolio picture and url
public function AddPortfolio(Request $request)
{
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

//View the calling carrd
public function ViewCallingCard() {

    $applicantID = session('applicant_id');

    $retrievedProfiles = RegisterModel::with('personal_info' , 'work_background' , 'template')->where('id' , $applicantID)->get();

    if(!$retrievedProfiles) {
        return back()->withErrors('No profile found');
    }

    return view('applicant.callingcard.arcallingcard' , compact('retrievedProfiles'));
}


//get the applicant profile
public function getApplicantProfile($id)
{
    $currentApplicantId = session('applicant_id'); // logged-in applicant
    $targetApplicantId = $id; // the profile being stalked

    // Load main applicant profile and relationships
    $retrievedProfile = RegisterModel::with(['personal_info', 'work_background', 'template'])->findOrFail($id);

    // Load related data
    $retrievedPosts = ApplicantPostModel::with('personalInfo', 'workBackground')
        ->where('applicant_id', $id)->latest()->get();

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

    return view('applicant.homepage.getprofile.getprofile', compact(
        'retrievedProfile',
        'retrievedPosts',
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


//  public function getPortfolioImages($applicant_id)
//     {
//         $images = DB::table('applicants_portfolio')
//             ->where('applicant_id', $applicant_id)
//             ->get();
            
//         return response()->json($images);
//     }
    
//     public function getYouTubeVideos($applicant_id)
//     {
//         $videos = DB::table('applicants_sample_work_url')
//             ->where('applicant_id', $applicant_id)
//             ->get();
            
//         return response()->json($videos);
//     }

// public function generateQr($id)
// {
//     // Validate that ID exists
//     if (!$id) {
//         throw new \InvalidArgumentException('ID parameter is required');
//     }
    
//     // Check if the applicant exists
//     $applicant = RegisterModel::find($id);
//     if (!$applicant) {
//         throw new \Exception('Applicant not found');
//     }
    
//     $url = route('applicant.callingcard.display', ['id' => $id]);
//     return QrCode::size(300)->generate($url);
// }


// // In your controller where you call generateQr
// public function showQrCode($id)
// {
//     try {
//         $qrCode = $this->generateQr($id);
//         return response($qrCode)->header('Content-Type', 'image/svg+xml');
//     } catch (\Exception $e) {
//         return response()->json(['error' => $e->getMessage()], 400);
//     }
// }

//    public function showAr($id)
// {
//     $applicant = RegisterModel::with('personal_info', 'work_background', 'template')->find($id);

//     if (!$applicant) {
//         abort(404, "Applicant not found.");
//     }

//     $images = DB::table('applicants_portfolio')
//         ->where('applicant_id', $id)
//         ->get();

//     $videos = DB::table('applicants_sample_work_url')
//         ->where('applicant_id', $id)
//         ->get();

//     return view('applicant.callingcard.arcallingcard', compact('applicant', 'images', 'videos'));
// }



//resume builder
public function ViewResume()
{


    //retrieve all the personal information
    $retrievedProfiles = RegisterModel::with('personal_info' , 'work_background' , 'template')->where('id' , session('applicant_id'))->first();


    
    if(!$retrievedProfiles) {
        return back()->withErrors('No profile found');
    }

  


    return view('applicant.resumebuilder.resume', compact('retrievedProfiles', 'JobPostRetrieved'));


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

    return view('applicant.my_application.applicantion', compact(
        'retrievedSavedJobs',
        'publishedCounts'
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


public function addTesdaCertificate(Request $request)
{


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


    // ✅ If program is "other", use the "other" input field
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


public function deleteTesdaCertificate($id)
{
    $tesda_certificate = TesdaCertification::findOrFail($id);
    $tesda_certificate->delete();
    return back()->with('success', 'TESDA Certification deleted successfully.');

}




}