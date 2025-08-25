<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Applicant\ApplicantController; 
use App\Http\Controllers\Employer\EmployerController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TesdaOfficer\TesdaOfficerController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\DB;

//Index
Route::get('/index', [ApplicantController::class, 'index'])->name('display.index');

Route::get('/top-worker', [ApplicantController::class, 'topWorkers'])->name('display.topworker');

Route::get('/', function () {
    return view('welcome');
});


// Public routes 
Route::prefix('applicant')->group(function () {
    Route::get('register', [ApplicantController::class, 'ShowRegistrationForm'])->name('applicant.register.display');
    Route::post('register', [ApplicantController::class, 'Register'])->name('applicant.register.store');

    Route::get('register/verify', [ApplicantController::class, 'ShowVerifyForm'])->name('verification.display');
    Route::post('register/verify', [ApplicantController::class, 'Verify'])->name('applicant.verification.store');

    Route::get('login', [ApplicantController::class, 'ShowLoginForm'])->name('applicant.login.display');
    Route::post('login', [ApplicantController::class, 'Login'])->name('applicant.login.store');
});

//  Protected routes 
Route::middleware(['applicant.authenticate'])->prefix('applicant')->group(function () {
    Route::get('info', [ApplicantController::class, 'ShowPersonalInfoForm'])->name('info.personal');
    Route::post('info', [ApplicantController::class, 'PersonalInfo'])->name('applicant.info.personal.stores');

    Route::get('info/background', [ApplicantController::class, 'ShowWorkBackgroundForm'])->name('applicant.info.workbackground.display');
    Route::post('info/background', [ApplicantController::class, 'WorkBackground'])->name('applicant.info.workbackground.store');

    Route::get('info/template', [ApplicantController::class, 'ShowTemplateFormForm'])->name('applicant.info.template.display');
    Route::post('info/template', [ApplicantController::class, 'TemplateForm'])->name('applicant.info.template.store');

    Route::get('homepage', [ApplicantController::class, 'ShowHomepage'])->name('applicant.info.homepage.display');

    Route::get('communityforum', [ApplicantController::class, 'ShowForum'])->name('applicant.forum.display');
    Route::post('communityforum/create', [ApplicantController::class, 'CreatePost'])->name('applicant.forum.store');
    Route::delete('communityforum/delete/{id}', [ApplicantController::class, 'DeletePost'])->name('applicant.forum.delete');

    Route::get('communityforum/addcomment', [ApplicantController::class, 'ShowPost'])->name('applicant.forum.comments.display');
    Route::post('communityforum/addcomment', [ApplicantController::class, 'AddComments'])->name('applicant.forum.comments.store');
    Route::delete('communityforum/deletecomment/{id}', [ApplicantController::class, 'DeleteComment'])->name('applicant.forum.comments.delete');
    Route::post('communityforum/replycomment', [ApplicantController::class, 'ReplyComments'])->name('applicant.forum.replycomments.store');
    Route::delete('communityforum/replycomment/delete/{id}', [ApplicantController::class, 'DeleteReplyComment'])->name('applicant.forum.replycomments.delete');

    Route::post('communityforum/like{id}', [ApplicantController::class, 'LikePost'])->name('applicant.forum.likes.store');
    Route::get('communityforum/viewpost', [ApplicantController::class, 'ViewMyPost'])->name('applicant.forum.viewpost.display');

    // Group forum
    Route::get('communityforum/create-group', [ApplicantController::class, 'ShowGroupForum'])->name('applicant.forum.group.display');
    Route::post('communityforum/create-group', [ApplicantController::class, 'AddGroupForum'])->name('applicant.forum.group.store');
    Route::get('communityforum/group-community', [ApplicantController::class, 'DisplayGroupForum'])->name('applicant.forum.groupcommunity.display');
    Route::post('communityforum/join-group', [ApplicantController::class, 'RequestAndJoinGroup'])->name('applicant.forum.joingroup.store');

    // Group-specific posts/comments/likes
    Route::post('communityforum/view-specific-group/{groupId}', [ApplicantController::class, 'AddPostGroupCommunity'])->name('applicant.forum.addpostgroupcommunity.store');
    Route::get('communityforum/view-specific-group/{id}', [ApplicantController::class, 'ViewSpecificGroup'])->name('applicant.forum.joinedgroup.display');

    Route::get('communityforum/view-group-creator', [ApplicantController::class, 'ViewGroupByCreator'])->name('applicant.forum.viewgroupcreator.display');
    Route::delete('communityforum/{id}/view-group-creator', [ApplicantController::class, 'DeleteGroupByCreator'])->name('applicant.forum.deletegroupcreator.delete');

    Route::get('communityforum/view-specific-creator/view-group/{groupId}', [ApplicantController::class, 'ViewGroupByCreatorPage'])->name('applicant.forum.creatorviewpage.display');
    Route::post('communityforum/view-specific-creator/view-group/{groupId}', [ApplicantController::class, 'AddPostGroupSpecific'])->name('applicant.forum.addpostgroup.store');
    Route::post('communityforum/view-specific-creator/view-group/{groupId}/comment', [ApplicantController::class, 'AddCommentGroupSpecific'])->name('applicant.forum.groupcomments.store');
    Route::delete('communityforum/view-specific-creator/view-group/{groupId}/comment/{commentId}', [ApplicantController::class, 'DeleteCommentGroup'])->name('applicant.forum.groupcomments.delete');
    Route::post('communityforum/view-specific-creator/view-group/{groupId}/like/{postId}', [ApplicantController::class, 'AddLikeGroup'])->name('applicant.forum.groupaddlike.store');

    // Post editing
    Route::get('communityforum/{id}/edit-post', [ApplicantController::class, 'ShowPostPage'])->name('applicant.forum.editpost.display');
    Route::put('communityforum/{id}/update', [ApplicantController::class, 'EditPost'])->name('applicant.forum.update');

    // Friend
    Route::post('communityforum/add-friend/{id}', [ApplicantController::class, 'AddFriend'])->name('applicant.forum.addfriend.store');
    Route::delete('communityforum/cancel-friend-request/{id}', [ApplicantController::class, 'CancelFriendRequest'])->name('applicant.forum.friend.cancel');
    Route::put('communityforum/accept-friend-request/{id}', [ApplicantController::class, 'AcceptFriendRequest'])->name('applicant.forum.friend.accept');
    Route::get('communityforum/view-friend-list', [ApplicantController::class, 'ViewFriendlistPage'])->name('applicant.forum.viewfriendlist.display');

    // Profile
    Route::get('profile', [ApplicantController::class, 'ViewProfilePage'])->name('applicant.profile.display');
    Route::post('profile/add-post', [ApplicantController::class, 'ApplicantPost'])->name('applicant.applicantposts.store');
    Route::post('profile/add-portfolio', [ApplicantController::class, 'AddPortfolio'])->name('applicant.portfolio.store');
    Route::delete('profile/delete-portfolio/{id}', [ApplicantController::class, 'DeletePortfolio'])->name('applicant.portfolio.delete');
    Route::post('profile/add-youtube-video', [ApplicantController::class, 'AddYoutubeVideo'])->name('applicant.youtubevideo.store');
    Route::delete('profile/delete-youtube-video/{id}', [ApplicantController::class, 'DeleteYoutubeVideo'])->name('applicant.youtubevideo.delete');
    Route::get('profile/{id}', [ApplicantController::class, 'getApplicantProfile'])->name('applicant.getprofile.display');
    Route::put('profile/update', [ApplicantController::class, 'updateProfile'])->name('applicant.editprofile');

    //Tesda certification
    Route::post('add-certification', [ApplicantController::class, 'addTesdaCertificate'])->name('applicant.certification.store');
    Route::delete('delete-certification/{id}', [ApplicantController::class, 'deleteTesdaCertificate'])->name('applicant.certification.delete');

    // Calling card
    Route::get('callingcard', [ApplicantController::class, 'ViewCallingCard'])->name('applicant.callingcard.display');

    //Resume builder
    Route::get('resume', [ApplicantController::class, 'ViewResume'])->name('applicant.resume.display');

    // Logout
    Route::post('logout', [ApplicantController::class, 'logout'])->name('applicant.logout.store');

    // Chat/messaging
    Route::delete('unfriend/{id}', [ApplicantController::class, 'unFriend'])->name('applicant.unfriend.store');
    Route::post('send-message', [ApplicantController::class, 'sendMessage'])->name('applicant.sendmessage.store');
    Route::post('/friend-request/send/{id}', [ApplicantController::class, 'sendFriendRequest'])->name('applicant.friend.send');
    Route::post('update-lastseen', [ApplicantController::class, 'updateLastSeen'])->name('applicant.updatelastseen.store');
    Route::get('messages/{friend_id}', [ApplicantController::class, 'viewMessages'])->name('applicant.messages.view');

    // Typing indicators
    Route::get('/fetch-messages/{id}', [ApplicantController::class, 'fetchMessages']);
    Route::post('/mark-read/{id}', [ApplicantController::class, 'markAsRead']);
    Route::post('/start-typing', [ApplicantController::class, 'startTyping'])->name('applicant.typing.start');
    Route::post('/stop-typing', [ApplicantController::class, 'stopTyping'])->name('applicant.typing.stop');
    Route::get('/check-typing/{receiver_id}', [ApplicantController::class, 'checkTyping'])->name('applicant.check.typing');
    Route::get('/get-unread-counts', [ApplicantController::class, 'getUnreadCounts'])->name('applicant.get.unread.counts');


    //Application status and page
    Route::get('application-status', [ApplicantController::class, 'ViewApplicationStatus'])->name('applicant.application.status.display');
    Route::post('/jobs/{job}/toggle-save', [ApplicantController::class, 'toggleSaveJob'])->name('jobs.toggleSave');
    Route::delete('/jobs/unsave/{id}', [ApplicantController::class, 'unSavedJob'])->name('jobs.unsave');



    // Portfolio / YouTube
    Route::get('/applicant-portfolio/{applicant_id}', function($applicant_id) {
        return DB::table('applicants_portfolio')
            ->where('applicant_id', $applicant_id)
            ->get();
    });

    Route::get('/applicant-youtube/{applicant_id}', function($applicant_id) {
        return DB::table('applicants_sample_work_url')
            ->where('applicant_id', $applicant_id)
            ->get();
    });

    Route::post('/save-qr-data', function(Request $request) {
        DB::table('ar_qr_logs')->insert([
            'applicant_id' => $request->applicant_id,
            'generated_at' => now()
        ]);
        return response()->json(['success' => true]);
    });

    // AR page
    Route::get('/mobile-ar', function(Request $request) {
        $data = json_decode($request->get('data'), true);
        return view('mobile-ar', compact('data'));
    });
});

//Public routes for employer
Route::group(['prefix' => 'employer'], function () {
    
    //View registration form step 1 
    Route::get('register', [EmployerController::class, 'ShowRegistrationForm'])->name('employer.register.display');
    Route::post('register', [EmployerController::class, 'addJobDetails'])->name('employer.jobdetails.store');
    //View contact form  2
   
    
    //Display the login form
    Route::get('login', [EmployerController::class, 'ShowLoginForm'])->name('employer.login.display');
    Route::post('login', [EmployerController::class, 'login'])->name('employer.login.store');

});

//Protected routes for employer
Route::middleware(['employer.authenticate'])->prefix('employer')->group(function () {
     Route::get('contact', [EmployerController::class, 'ShowContactForm'])->name('employer.contact.display');
    Route::post('contact', [EmployerController::class, 'addContactDetails'])->name('employer.contact.store');
    //View hiring preference form 3
    Route::get('hiring-preference', [EmployerController::class, 'ShowHiringPreferenceForm'])->name('employer.hiringpreference.display');
    Route::post('hiring-preference', [EmployerController::class, 'AddHiringPreference'])->name('employer.hiringpreference.store');
    //View the review registration form 4
    Route::get('review-registration', [EmployerController::class, 'ShowReviewRegistrationForm'])->name('employer.reviewregistration.display');
    //View the successfull registration form 5
    Route::get('success-registration', [EmployerController::class, 'ShowSuccessForm'])->name('employer.successregistration.display');

    //Send and display email
    Route::post('/employer/send-verification-email', [EmployerController::class, 'sendVerificationEmail'])->name('employer.sendVerificationEmail');
    Route::get('/employer/verify/{email}', [EmployerController::class, 'verifyEmail'])->name('employer.verify');

       //Homepage display
    Route::get('homepage', [EmployerController::class, 'ShowHomepage'])->name('employer.info.homepage.display');

    //Logout
    Route::post('logout', [EmployerController::class, 'logout'])->name('employer.logout.store');

    //show the applicants profile modal
    Route::get('employer/applicant/{id}/profile', [EmployerController::class, 'viewApplicantProfile'])->name('employer.applicantsprofile.display');

    //Add job post
    Route::post('employer/add-job-post', [EmployerController::class, 'addJobPost'])->name('employer.jobsposts.store');
    Route::put('employer/job-post/{id}/update', [EmployerController::class, 'updateJobStatus'])->name('employer.updatejobpost.store');
    Route::delete('employer/job-post/{id}/delete', [EmployerController::class, 'deleteJobPost'])->name('employer.deletejobpost.store');

    //Send rating 
    Route::post('employer/send-rating', [EmployerController::class, 'sendReview'])->name('employer.sendrating.store');

    
});



Route::prefix('admin')->group(function () {
    
    
    Route::get('login', [AdminController::class, 'loginDisplay'])->name('admin.login.display');
    Route::post('login', [AdminController::class, 'login'])->name('admin.login.store');
    


  
});

Route::middleware(['admin.authenticate'])->prefix('admin')->group(function () {
     Route::get('homepage', [AdminController::class, 'homepageDisplay'])->name('admin.homepage.display');

      Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout.store');


    //Officer
    Route::post('admin/add-officer', [AdminController::class, 'addTesdaOfficer'])->name('admin.addofficer.store');
    Route::put('admin/officer/{id}/update', [AdminController::class, 'updateTesdaOfficer'])->name('admin.updateofficer');
});


//Public routes for tesda officer
Route::prefix('tesda-officer')->group(function () {
    
    Route::get('login', [TesdaOfficerController::class, 'loginDisplay'])->name('tesda-officer.login.display');
    Route::post('login', [TesdaOfficerController::class, 'login'])->name('tesda-officer.login.store');
    
});

//Protected routes for tesda officer
 Route::middleware(['tesda-officer.authenticate'])->prefix('tesda-officer')->group(function () {

    Route::get('homepage' , [TesdaOfficerController::class, 'homepage'])->name('homepage.display');

    Route::post('sent-review', [TesdaOfficerController::class, 'approvedOfficer'])->name('tesda-officer.approved.store');
    Route::delete('delete-review', [TesdaOfficerController::class, 'deleteOfficerReview'])->name('tesda-officer.delete');

    Route::post('logout', [TesdaOfficerController::class, 'logout'])->name('tesda-officer.logout.store');

});

