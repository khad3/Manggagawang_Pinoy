<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Applicant\ApplicantFriendModel as AddFriend;
use App\Models\Applicant\PostModel as Post;
use App\Models\Applicant\PersonalModel as PersonalInfo;
use App\Models\Applicant\ExperienceModel as WorkBackground;
use App\Models\Applicant\RegisterModel;
use App\Models\Applicant\CommentModel as Comment;
use App\Models\Applicant\ReplyModel as ReplyComment;
use App\Models\Applicant\LikeModel as ForumLike;
use App\Models\Applicant\GroupModel as Group;
use App\Models\Applicant\PostSpecificGroupModel as GroupPost;
use App\Models\Applicant\GroupCommentModel as GroupComment;
use App\Models\Applicant\GroupLikeModel as GroupLike;
use App\Models\Applicant\SendMessageModel as SendMessage;
use App\Models\Applicant\ParticipantModel as GroupJoinRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;


use function App\Http\Controllers\Admin\safeDecrypt;

class CommunityForumController extends Controller
{

    private function safe_decrypt($value)
{
    try {
        return $value ? Crypt::decrypt($value) : null;
    } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
        return $value; // fallback if it cannot be decrypted
    } catch (\Exception $e) {
        return $value; // catches unserialize errors and others
    }
}
 
    // Display the community forum with posts and categories
    public function ShowForum(){
   
        $currentApplicantId = session('applicant_id');

        $posts = Post::with([
            'likes',
            'personalInfo',
            'comments.replies.applicant.personal_info',
            'workBackground',
            'comments.applicant.personal_info'
        ])->orderBy('created_at', 'desc')->get();

        $retrievedDecryptedPersonalInfo = $posts ? [
        'personalInfo' => $posts->map(function ($post) {
            return [
                'first_name' => $post->personalInfo ? $this->safe_decrypt($post->personalInfo->first_name) : null,
                'last_name'  => $post->personalInfo ? $this->safe_decrypt($post->personalInfo->last_name) : null,
            ];
        }),
    ] : [];

    $retrievedDecryptedWorkBackground = $posts ? [

    'workBackground' => $posts->map(function ($post) {
        return [
            'position'       => $post->workBackground ? $this->safe_decrypt($post->workBackground->position) : null,
            'other_position' => $post->workBackground ? $this->safe_decrypt($post->workBackground->other_position) : null,
        ];
    }),

    ] : [];



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

        //retrieve personal information and work background decrypted
        // Decrypt commenters and repliers
    foreach ($posts as $post) {
        foreach ($post->comments as $comment) {
            if ($comment->applicant && $comment->applicant->personal_info) {
                $comment->applicant->personal_info->first_name = $this->safe_decrypt($comment->applicant->personal_info->first_name);
                $comment->applicant->personal_info->last_name  = $this->safe_decrypt($comment->applicant->personal_info->last_name);
            }

            foreach ($comment->replies as $reply) {
                if ($reply->applicant && $reply->applicant->personal_info) {
                    $reply->applicant->personal_info->first_name = $this->safe_decrypt($reply->applicant->personal_info->first_name);
                    $reply->applicant->personal_info->last_name  = $this->safe_decrypt($reply->applicant->personal_info->last_name);
                }
            }
        }
    }


    //retrieve the pending and unread notifications and add friend requests
   
    $friendRequests = AddFriend::where('receiver_id', $currentApplicantId)->where('status', 'pending')->count();

    $pendingJoinGroupRequests = GroupJoinRequest::where('status', 'pending')
    ->whereHas('group', function ($query) use ($currentApplicantId) {
        // Only include groups owned by the logged-in applicant
        $query->where('applicant_id', $currentApplicantId);
    })
    ->where('applicant_id', '!=', $currentApplicantId) // exclude self (the owner)
    ->count();

    
    $unreadMessagesCount = SendMessage::where('receiver_id', $currentApplicantId)
    ->where('is_read', false) // or 0, depending on your database column type
    ->count();

        return view('applicant.community_form.forums', compact('posts', 'categories' , 'retrievedDecryptedPersonalInfo' , 'retrievedDecryptedWorkBackground' , 'friendRequests' , 'pendingJoinGroupRequests' , 'unreadMessagesCount'));
    }



    // Create a new post 
    public function CreatePost(Request $request){
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
            'personal_info_id' => $personalInfo->id, 
            'work_experience_id' => $workBackground->id,
            'image_path' => $mediaPath,
            'category' => $request->post_topic,
        ]);

        $post->save();

        return redirect()->route('applicant.forum.display')->with('success', 'Post created successfully.');
    }



    //Delete posts sa community forum with custom auth (kumbaga sino nakalog in makikita nila yung delete post)
    public function DeletePost($id){
        $post = Post::findOrFail($id);
        $applicantId = session('applicant_id');

        if (!$applicantId || $applicantId !== $post->applicant_id) {
            abort(403, 'Unauthorized action.');
        }

        $post->delete();

        return redirect()->route('applicant.forum.display')->with('success', 'Post deleted successfully.');
    }



  // Add comments (AJAX compatible)
public function AddComments(Request $request)
{
    $applicantId = session('applicant_id');

    $request->validate([
        'comment' => 'required|string',
        'post_id' => 'required|exists:forum_posts,id',
    ]);

    $applicant = RegisterModel::with('personal_info')->find($applicantId);
    if (!$applicant || !$applicant->personal_info) {
        return response()->json(['error' => 'Applicant not found or personal info missing.'], 404);
    }

    $post = Post::with('applicant.personal_info')->find($request->post_id);
    if (!$post) {
        return response()->json(['error' => 'Post not found.'], 404);
    }

    // Create comment
    $comment = Comment::create([
        'comment' => $request->comment,
        'forum_post_id' => $post->id,
        'applicant_id' => $applicant->id,
    ]);

    // Decrypt names safely
    $firstName = $applicant->personal_info->first_name ? $this->safeDecrypt($applicant->personal_info->first_name) : '';
    $lastName = $applicant->personal_info->last_name ? $this->safeDecrypt($applicant->personal_info->last_name) : '';

    // Notify post creator if commenter is not the post creator
    if ($post->applicant_id != $applicantId) {
        $postTitle = $post->title ?? 'your post';
        $postCategory = $post->category ?? '';

        $notificationMessage = "{$firstName} {$lastName} commented on your forum post \"{$postTitle}\"";
        if ($postCategory) {
            $notificationMessage .= " in the {$postCategory} category.";
        } else {
            $notificationMessage .= ".";
        }

        $notification = new \App\Models\Notification\NotificationModel();
        $notification->type = 'applicant';
        $notification->type_id = $post->applicant_id;
        $notification->title = 'New Comment on Your Post';
        $notification->message = $notificationMessage;
        $notification->save();
    }

    // If AJAX request → return JSON
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'comment' => $comment->comment,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'created_at' => $comment->created_at->diffForHumans(),
        ]);
    }

    // If normal form submission
    return redirect()->route('applicant.forum.display')->with('success', 'Comment added successfully.');
}




    //Delete comments parent 
    public function DeleteComment($id) {

        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->route('applicant.forum.display')->with('success', 'Comment deleted successfully.');
    }

    // Reply to a forum comment


public function ReplyComments(Request $request)
{
    $applicantId = session('applicant_id');

    if (!$applicantId) {
        return response()->json(['success' => false, 'error' => 'You must be logged in to reply.'], 403);
    }

    $request->validate([
        'reply_comment' => 'required|string|max:250',
        'comment_id' => 'required|exists:forum_comments,id',
    ]);

    // Fetch the original comment with its post
    $comment = \App\Models\Applicant\CommentModel::with('post')->find($request->comment_id);
    if (!$comment) {
        return response()->json(['success' => false, 'error' => 'Original comment not found.'], 404);
    }

    // Create the reply
    $reply = new \App\Models\Applicant\ReplyModel();
    $reply->reply = $request->reply_comment;
    $reply->forum_comment_id = $request->comment_id;
    $reply->applicant_id = $applicantId;
    $reply->save();

    // Get reply author name
    $replyAuthor = \App\Models\Applicant\RegisterModel::with('personal_info')->find($applicantId);
    $firstName = $replyAuthor->personal_info->first_name ?? '';
    $lastName = $replyAuthor->personal_info->last_name ?? '';

    try {
        $firstName = $this->safeDecrypt($firstName);
        $lastName = $this->safeDecrypt($lastName);
    } catch (\Exception $e) {
        // ignore decrypt error
    }

    // Notification
    if ($comment->applicant_id != $applicantId) { // don't notify self
        $postTitle = $comment->post->title ?? 'your post';
        $replyText = $reply->reply;

        $notificationMessage = "{$firstName} {$lastName} replied to your comment: \"{$replyText}\" on the post \"{$postTitle}\".";
        $notification = new \App\Models\Notification\NotificationModel();
        $notification->type = 'applicant';
        $notification->type_id = $comment->applicant_id; // recipient = original commenter
        $notification->title = 'New Reply to Your Comment';
        $notification->message = $notificationMessage;
        $notification->save();
    }

    return response()->json([
        'success' => true,
        'first_name' => $firstName,
        'last_name' => $lastName,
        'reply' => $request->reply_comment,
        'comment_id' => $request->comment_id,
        'reply_id' => $reply->id,
        'created_at' => $reply->created_at->diffForHumans(),
    ]);
}






    //Delete reply comments child
    public function DeleteReplyComment($id) {

        $reply = ReplyComment::findOrFail($id);
        $reply->delete();

        return redirect()->route('applicant.forum.display')->with('success', 'Reply deleted successfully.');
    }


    // Adding likes (AJAX-compatible)
public function LikePost($id)
{
    $applicantId = session('applicant_id');

    if (!$applicantId) {
        return response()->json(['error' => 'You must be logged in to like a post.'], 401);
    }

    // Check if the applicant already liked this post
    $existingLike = ForumLike::where('forum_post_id', $id)
        ->where('applicant_id', $applicantId)
        ->first();

    if ($existingLike) {
        // Unlike the post
        $existingLike->delete();

        $likeCount = ForumLike::where('forum_post_id', $id)->count();

        return response()->json([
            'message' => 'You unliked the post.',
            'like_count' => $likeCount,
            'liked' => false
        ]);
    } else {
        // Create a new like record
        ForumLike::create([
            'forum_post_id' => $id,
            'applicant_id' => $applicantId,
            'likes' => 1,
        ]);

        // Fetch post creator and personal info of liker
        $post = Post::with('applicant.personal_info')->find($id);
        $liker = RegisterModel::with('personal_info')->find($applicantId);

        if ($post && $liker && $post->applicant_id != $applicantId) {
            $firstName = $liker->personal_info->first_name ? $this->safeDecrypt($liker->personal_info->first_name) : '';
            $lastName = $liker->personal_info->last_name ? $this->safeDecrypt($liker->personal_info->last_name) : '';

            // Send notification to post creator
            $notification = new \App\Models\Notification\NotificationModel();
            $notification->type = 'applicant';
            $notification->type_id = $post->applicant_id; // post creator
            $notification->title = 'New Like on Your Forum Post';

            $postTitle = $post->title ?? 'your post';
            $postCategory = $post->category ? ' in the "' . $post->category . '" category' : '';
            $postContentPreview = $post->content ? ' — "' . Str::limit($post->content, 50) . '"' : '';

            $notification->message = $firstName . ' ' . $lastName . ' liked your forum post "' . $postTitle . '"' 
                . $postCategory 
                . $postContentPreview . '.';

            $notification->save();
        }

        $likeCount = ForumLike::where('forum_post_id', $id)->count();

        return response()->json([
            'message' => 'Post liked successfully.',
            'like_count' => $likeCount,
            'liked' => true
        ]);
    }
}



    //View my post
    public function ViewMyPost() {
        $applicantId = session('applicant_id');
        $posts = Post::where('applicant_id', $applicantId)->get()->sortByDesc('created_at');
        
        // Decrypt data directly into $posts
     foreach ($posts as $post) {

        // --- Decrypt post owner ---
        if ($post->personalInfo) {
            $post->personalInfo->first_name = $this->safe_decrypt($post->personalInfo->first_name);
            $post->personalInfo->last_name  = $this->safe_decrypt($post->personalInfo->last_name);
        }

        if ($post->workBackground) {
            $post->workBackground->position       = $this->safe_decrypt($post->workBackground->position);
            $post->workBackground->other_position = $this->safe_decrypt($post->workBackground->other_position);
        }

        // --- Decrypt commenters ---
        foreach ($post->comments as $comment) {
            if ($comment->applicant && $comment->applicant->personal_info) {
                $comment->applicant->personal_info->first_name = $this->safe_decrypt($comment->applicant->personal_info->first_name);
                $comment->applicant->personal_info->last_name  = $this->safe_decrypt($comment->applicant->personal_info->last_name);
            }

            // --- Decrypt repliers ---
            foreach ($comment->replies as $reply) {
                if ($reply->applicant && $reply->applicant->personal_info) {
                    $reply->applicant->personal_info->first_name = $this->safe_decrypt($reply->applicant->personal_info->first_name);
                    $reply->applicant->personal_info->last_name  = $this->safe_decrypt($reply->applicant->personal_info->last_name);
                }
            }
        }
    }


        $categories = Post::distinct()->pluck('category')->toArray();
        

        return view('applicant.community_form.viewmypost', compact('posts' , 'categories')); 
    }


    //View group forum form
    public function ShowGroupForum() {
        return view('applicant.community_form.groupforum');
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

            return redirect()->route('applicant.forum.display')->with(['success' => 'Group created successfully.']);
        }


    //View list of group forum kumabaga ito yung display
  public function DisplayGroupForum()
{
    $applicant_id = session('applicant_id');

    $listOfGroups = Group::with(['members', 'personalInfo'])
        ->withCount([
            'members',
            // ✅ count only pending members for each group
            'members as pending_members_count' => function ($query) {
                $query->where('group_participants.status', 'pending');
            },
        ])
        ->orderByDesc('created_at')
        ->get();

    // decrypt personal info and determine membership status per group
    foreach ($listOfGroups as $group) {
        if ($group->personalInfo) {
            $group->personalInfo->first_name = $this->safe_decrypt($group->personalInfo->first_name);
            $group->personalInfo->last_name  = $this->safe_decrypt($group->personalInfo->last_name);
        }

        $membership = $group->members->firstWhere('id', $applicant_id);

        if ($membership) {
            $group->membershipStatus = $membership->pivot->status;
        } else {
            $group->membershipStatus = null;
        }
    }

    return view('applicant.community_form.viewgroup', compact('listOfGroups', 'applicant_id'));
}



    //For request and join group forum
   public function RequestAndJoinGroup(Request $request){
    $request->validate([
        'group_id' => 'required|exists:group_community,id',
    ]);

    $applicantId = session('applicant_id');

    if (!$applicantId) {
        return redirect()->back()->with('error', 'You must be logged in to join a group.');
    }

    $group = Group::findOrFail($request->group_id);

    $applicantPersonalInfo = PersonalInfo::where('applicant_id', $applicantId)->first();
    if (!$applicantPersonalInfo) {
        return redirect()->back()->with('error', 'Personal information not found.');
    }

    // Decrypt personal info properly
    try {
        $firstName = $applicantPersonalInfo->first_name ? $this->safeDecrypt($applicantPersonalInfo->first_name) : '';
        $lastName = $applicantPersonalInfo->last_name ? $this->safeDecrypt($applicantPersonalInfo->last_name) : '';
    } catch (\Exception $e) {
        $firstName = 'Unknown';
        $lastName = 'User';
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

    // Send notification to group creator for BOTH pending and approved joins
    $groupOwnerId = $group->applicant_id; // creator of the group
    if ($groupOwnerId) {
        $notification = new \App\Models\Notification\NotificationModel();
        $notification->type = 'applicant';
        $notification->type_id = $groupOwnerId; // send to group creator

        if ($status === 'approved') {
            $notification->title = 'New Member Joined';
            $notification->message = $firstName . ' ' . $lastName
                . ' has suddenly joined your group "' . $group->group_name . '".';
        } else { // pending
            $notification->title = 'New Join Request';
            $notification->message = $firstName . ' ' . $lastName
                . ' wants to join your group "' . $group->group_name . '".';
        }

        $notification->save();
    }

    // Response messages
    if ($status === 'approved') {
        return redirect()->back()->with('success', 'You successfully joined the public group: "' . $group->group_name . '".');
    } else {
        return redirect()->back()->with('success', 'Join request sent to "' . $group->group_name . '". Please wait for the creator\'s approval.');
    }
}


    //Add post for the group forum
    public function AddPostGroupCommunity(Request $request, $groupId){

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

    //Decrypt
    private function safeDecrypt($value) {
        try {
            return $value ? Crypt::decrypt($value) : null;
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return $value; // fallback if it cannot be decrypted
        } catch (\Exception $e) {
            return $value; // catches unserialize errors and others
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

    // Decrypt group creator name
    if ($group->personalInfo) {
        $group->personalInfo->first_name = $this->safeDecrypt($group->personalInfo->first_name);
        $group->personalInfo->last_name  = $this->safeDecrypt($group->personalInfo->last_name);
    }

    // Retrieve posts with related data
    $retrievePosts = GroupPost::with([
        'work_background',
        'likes',
        'personalInfo',
        'comments.personal_info',
        'comments.applicant.work_background'
    ])
    ->withCount('comments')
    ->where('group_community_id', $id)
    ->latest()
    ->get();

    // Decrypt post author and commenters
    foreach ($retrievePosts as $post) {
        // Decrypt post author
        if ($post->personalInfo) {
            $post->personalInfo->first_name = $this->safeDecrypt($post->personalInfo->first_name);
            $post->personalInfo->last_name  = $this->safeDecrypt($post->personalInfo->last_name);
        }

        // Decrypt all commenters
        foreach ($post->comments as $comment) {
            if ($comment->personal_info) {
                $comment->personal_info->first_name = $this->safeDecrypt($comment->personal_info->first_name);
                $comment->personal_info->last_name  = $this->safeDecrypt($comment->personal_info->last_name);
            }
        }
    }

    // Filter and decrypt approved members
    $members = $group->members
        ->filter(fn($member) => $member->pivot->status === 'approved' && $member->id !== $group->applicant_id)
        ->map(function ($member) {
            if ($member->personal_info) {
                $member->personal_info->first_name = $this->safeDecrypt($member->personal_info->first_name);
                $member->personal_info->last_name  = $this->safeDecrypt($member->personal_info->last_name);
            }
            return $member;
        });

    // Decrypt pending join requests
    $retrievedJoinRequests = $group->members()
        ->wherePivot('status', 'pending')
        ->with('personal_info')
        ->withPivot('created_at')
        ->get();

    foreach ($retrievedJoinRequests as $request) {
        if ($request->personal_info) {
            $request->personal_info->first_name = $this->safeDecrypt($request->personal_info->first_name);
            $request->personal_info->last_name  = $this->safeDecrypt($request->personal_info->last_name);
        }
    }

    return view('applicant.community_form.viewspecificgroup', compact(
        'group', 'members', 'applicantId', 'retrievePosts', 'retrievedJoinRequests'
    ));
}



    //Accept join request
    public function AcceptJoinRequest($groupId, $applicantId) {
        $group = Group::findOrFail($groupId);

        // Update pivot to approved
        $group->members()->updateExistingPivot($applicantId, ['status' => 'approved']);

        // Send notification to the applicant
        $applicantPersonalInfo = PersonalInfo::where('applicant_id', $applicantId)->first();

        if ($applicantPersonalInfo) {
            try {
                $firstName = $applicantPersonalInfo->first_name ? Crypt::decryptString($applicantPersonalInfo->first_name) : '';
                $lastName = $applicantPersonalInfo->last_name ? Crypt::decryptString($applicantPersonalInfo->last_name) : '';
            } catch (\Exception $e) {
                $firstName = 'Unknown';
                $lastName = 'User';
            }

        $notification = new \App\Models\Notification\NotificationModel();
        $notification->type = 'applicant'; // recipient type
        $notification->type_id = $applicantId; // notify the applicant
        $notification->title = 'Join Request Approved';
        $notification->message = 'Your request to join the group "' . $group->group_name . '" has been approved. You can now access the group forum.';
        $notification->save();
        }

        return redirect()->back()->with('success', 'Join request accepted and notification sent.');
    }

    //Reject join request
    public function RejectJoinRequest($groupId, $applicantId) {
    $group = Group::findOrFail($groupId);

    // Update pivot to rejected
    $group->members()->updateExistingPivot($applicantId, ['status' => 'rejected']);

    // Send notification to the applicant
    $applicantPersonalInfo = PersonalInfo::where('applicant_id', $applicantId)->first();

    if ($applicantPersonalInfo) {
        try {
            $firstName = $applicantPersonalInfo->first_name ? Crypt::decryptString($applicantPersonalInfo->first_name) : '';
            $lastName = $applicantPersonalInfo->last_name ? Crypt::decryptString($applicantPersonalInfo->last_name) : '';
        } catch (\Exception $e) {
            $firstName = 'Unknown';
            $lastName = 'User';
        }

        $notification = new \App\Models\Notification\NotificationModel();
        $notification->type = 'applicant'; // recipient type
        $notification->type_id = $applicantId; // notify the applicant
        $notification->title = 'Join Request Rejected';
        $notification->message = 'Your request to join the group "' . $group->group_name . '" has been rejected.';
        $notification->save();
    }

    return redirect()->back()->with('success', 'Join request rejected and notification sent.');
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
    public function ViewGroupByCreatorPage($id){
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

        return view('applicant.community_form.viewspecificgroupbycreator', compact('group','members','applicantId','retrievePosts' ));

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
    $post = GroupPost::create([
        'title'             => $validated['title'],
        'content'           => $validated['content'],
        'image_path'        => $imagePath,
        'group_community_id'=> $groupId,
        'applicant_id'      => $applicantId,
        'personal_info_id'  => $personalInfoId,
    ]);

    // -----------------------------------
    // 
    foreach ($group->members as $member) {
        if ($member->id != $applicantId) {
            $notification = new \App\Models\Notification\NotificationModel();
            $notification->type = 'applicant'; 
            $notification->type_id = $member->id; 
            $notification->title = 'New Group Post';
            $notification->message =
                $this->safeDecrypt($applicant->personal_info->first_name) .
                ' posted in "' . $group->group_name . '" group: "' . $validated['title'] . '".';
            $notification->is_read = false;
            $notification->save();
        }
    }

    // 
    if ($group->applicant_id != $applicantId) {
        $notification = new \App\Models\Notification\NotificationModel();
        $notification->type = 'applicant';
        $notification->type_id = $group->applicant_id; // group creator
        $notification->title = 'New Post in Your Group';
        $notification->message =
            $this->safeDecrypt($applicant->personal_info->first_name) .
            ' added a new post in your group "' . $group->group_name . '".';
        $notification->is_read = false;
        $notification->save();
    }

    return redirect()->back()->with('success', 'Post added successfully.');
}



    //Add comment for group community forum \
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
    $applicant = RegisterModel::with('personal_info', 'work_background')->find($applicantId);
    $personalInfoId = $applicant->personal_info->id ?? null;

    // Validate input
    $validated = $request->validate([
        'comment' => 'required|string',
        'per_group_community_post_id' => 'required|exists:per_group_posts,id',
    ]);

    // Create comment
    GroupComment::create([
        'comment' => $validated['comment'],
        'group_community_id' => $groupId,
        'applicant_id' => $applicantId,
        'personal_info_id' => $personalInfoId,
        'per_group_community_post_id' => $validated['per_group_community_post_id'],
        'work_experience_id' => $applicant->work_background->id ?? null,
    ]);

    // -----------------------------------
    // ✅ Create notification for all approved group members except the commenter
    foreach ($group->members as $member) {
        if ($member->id != $applicantId) {
            $notification = new \App\Models\Notification\NotificationModel();
            $notification->type = 'applicant'; // recipient type
            $notification->type_id = $member->id; // ✅ Correct recipient id
            $notification->title = 'New Group Comment';
            $notification->message =
                $this->safeDecrypt($applicant->personal_info->first_name) .
                ' commented in "' . $group->group_name . '" group.';
            $notification->is_read = false;
            $notification->save();
        }
    }

    // ✅ Notify the group creator too (if not the same user)
    if ($group->applicant_id != $applicantId) {
        $notification = new \App\Models\Notification\NotificationModel();
        $notification->type = 'applicant';
        $notification->type_id = $group->applicant_id; // group creator
        $notification->title = 'New Comment in Your Group';
        $notification->message =
            $this->safeDecrypt($applicant->personal_info->first_name) .
            ' commented in your group "' . $group->group_name . '".';
        $notification->is_read = false;
        $notification->save();
    }

    return redirect()->back()->with('success', 'Comment added successfully.');
}




    //Delete comment 
   public function DeleteCommentGroup($groupId, $commentId)
{
    $group = Group::findOrFail($groupId); // Correct model

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

    return redirect()->back()->with('success', 'Comment deleted successfully.');
}



    //Add like for the group forum
    public function AddLikeGroup(Request $request, $groupId, $postId){
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


    // My post forum edit page 
    public function ShowPostPage($id){
        $retrievedPosts = Post::findOrFail($id)->where('id', $id)->get();
        return view('applicant.community_form.editforum' , compact('retrievedPosts'));
    }

    //Edit post forum  
    public function EditPost(Request $request, $id){
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

    // Create the friend request
    AddFriend::create([
        'request_id' => $applicantId,
        'receiver_id' => $friendId,
        'status' => 'pending',
    ]);

    // 🔔 Send notification to the receiver
    $sender = RegisterModel::find($applicantId);
    $firstName = $sender ?$this->safeDecrypt($sender->personal_info->first_name) : 'Someone';
    $lastName = $sender ? $this->safeDecrypt($sender->personal_info->last_name) : '';
    $senderName = trim($firstName . ' ' . $lastName);

    $notification = new \App\Models\Notification\NotificationModel();
    $notification->type = 'applicant'; // recipient type
    $notification->type_id = $friendId; // recipient id
    $notification->title = 'New Friend Request';
    $notification->message = $senderName . ' has sent you a friend request.';
    $notification->is_read = false;
    $notification->save();

    return redirect()->back()->with('success', 'Friend request sent successfully.');
}

    //Cancel friend request
    public function CancelFriendRequest($id) {

        $friendRequest = AddFriend::findOrFail($id);

        if ($friendRequest->request_id == session('applicant_id') || $friendRequest->receiver_id == session('applicant_id')) {
            $friendRequest->delete();
            return redirect()->back()->with('success', 'Friend request cancelled.');
        }
        return redirect()->back()->with('error', 'Unauthorized action.');
    }

    //accept friend request
    public function AcceptFriendRequest($id) {

        $friendRequest = AddFriend::findOrFail($id);

        if ($friendRequest->request_id == session('applicant_id') || $friendRequest->receiver_id == session('applicant_id')) {
            $friendRequest->status = 'accepted';
            $friendRequest->save();
            return redirect()->back()->with('success', 'Friend request accepted.');
        }

        return redirect()->back()->with('error', 'Unauthorized action.');
    }

    //View Friend sa community forum
    public function ViewFriendlistPage(Request $request){
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

    //retrieve the personal info decrypted
  //Decrypt the logged-in applicant’s info
if ($retrievedApplicantInfo && $retrievedApplicantInfo->personal_info) {
    $retrievedApplicantInfo->personal_info->first_name = $this->safe_decrypt($retrievedApplicantInfo->personal_info->first_name);
    $retrievedApplicantInfo->personal_info->last_name  = $this->safe_decrypt($retrievedApplicantInfo->personal_info->last_name);
}

//Decrypt each friend’s personal info
foreach ($retrievedFriends as $friend) {
    if ($friend->sender && $friend->sender->personal_info) {
        $friend->sender->personal_info->first_name = $this->safe_decrypt($friend->sender->personal_info->first_name);
        $friend->sender->personal_info->last_name  = $this->safe_decrypt($friend->sender->personal_info->last_name);
    }
    if ($friend->receiver && $friend->receiver->personal_info) {
        $friend->receiver->personal_info->first_name = $this->safe_decrypt($friend->receiver->personal_info->first_name);
        $friend->receiver->personal_info->last_name  = $this->safe_decrypt($friend->receiver->personal_info->last_name);
    }
}

//Decrypt each message
// Safe decrypt for messages


// Later when retrieving messages
foreach ($retrievedMessages as $message) {
    // Decrypt sender/receiver names
    if ($message->sender && $message->sender->personal_info) {
        $message->sender->personal_info->first_name = $this->safe_decrypt_string($message->sender->personal_info->first_name);
        $message->sender->personal_info->last_name  = $this->safe_decrypt_string($message->sender->personal_info->last_name);
    }
    if ($message->receiver && $message->receiver->personal_info) {
        $message->receiver->personal_info->first_name = $this->safe_decrypt_string($message->receiver->personal_info->first_name);
        $message->receiver->personal_info->last_name  = $this->safe_decrypt_string($message->receiver->personal_info->last_name);
    }

    // Decrypt the actual message
    if ($message->message) {
        $message->message = $this->safe_decrypt_string($message->message);
    }
}


//Decrypt sender names in friend requests
foreach ($friendRequests as $requestItem) {
    if ($requestItem->sender && $requestItem->sender->personal_info) {
        $requestItem->sender->personal_info->first_name = $this->safe_decrypt($requestItem->sender->personal_info->first_name);
        $requestItem->sender->personal_info->last_name  = $this->safe_decrypt($requestItem->sender->personal_info->last_name);
    }
}



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


private function safe_decrypt_string($value)
{
    try {
        return $value ? Crypt::decryptString($value) : null;
    } catch (\Exception $e) {
        return $value; // fallback to original if cannot decrypt
    }
}

}
