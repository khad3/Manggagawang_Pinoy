<?php

use App\Http\Controllers\Applicant\CommunityForumController;
use App\Http\Controllers\Applicant\SettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Applicant\ApplicantController; 
use App\Http\Controllers\Employer\EmployerController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Applicant\ProfileController;
use App\Http\Controllers\Applicant\SendMessageEmployerController;
use App\Http\Controllers\Applicant\MessageController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\TesdaOfficer\TesdaOfficerController;
use App\Http\Controllers\Employer\SendMessageController;
use App\Http\Controllers\TermsAndCondition\TermAnfConditionController;
use App\Http\Controllers\Applicant\ReportController;
use App\Http\Controllers\Applicant\ReportEmployerController;
use App\Models\Employer\SendMessageModel;
use App\Models\User;
use Hamcrest\Core\Set;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Profiler\Profile;

//Terms and Condition and Privacy Policy and Data sharing
Route::get('terms-and-conditions', [TermAnfConditionController::class, 'termsandconditions'])->name('display.termsandconditions');
Route::get('privacy-policy', [TermAnfConditionController::class, 'privacypolicy'])->name('display.privacypolicy');
Route::get('data-sharing', [TermAnfConditionController::class, 'dataSharing'])->name('display.datasharing');

//Not found page
Route::get('not-found', [TermAnfConditionController::class, 'notFound'])->name('display.notfound');
//Index
Route::get('/index', [ApplicantController::class, 'index'])->name('display.index');

Route::get('/top-worker', [ApplicantController::class, 'topWorkers'])->name('display.topworker');

Route::get('/about-us', [ApplicantController::class, 'aboutUs'])->name('display.aboutus');

Route::get('/', function () {
    return view('welcome');
});



// Public routes 
Route::prefix('applicant')->group(function () {
    
    Route::get('register', [ApplicantController::class, 'ShowRegistrationForm'])->name('applicant.register.display');
    Route::post('register', [ApplicantController::class, 'Register'])->name('applicant.register.store');
    Route::get('register/verify', [ApplicantController::class, 'ShowVerifyForm'])->name('verification.display');
    Route::post('register/verify', [ApplicantController::class, 'Verify'])->name('applicant.verification.store');
    Route::post('/verification/resend', [ApplicantController::class, 'resend'])->name('verification.resend');
    Route::get('login', [ApplicantController::class, 'ShowLoginForm'])->name('applicant.login.display');
    Route::post('login', [ApplicantController::class, 'Login'])->name('applicant.login.store');
    //Forgotpassword applicant
    Route::get('forgot-password', [ApplicantController::class, 'forgotPassword'])->name('applicant.forgotpassword.display');
    Route::post('forgot-password', [ApplicantController::class, 'forgotPasswordStore'])->name('applicant.forgotpassword.store');
    Route::post('verify-code', [ApplicantController::class, 'verifyCode'])->name('applicant.verifycode.store');
    Route::post('reset-password', [ApplicantController::class, 'resetPassword'])->name('applicant.resetpassword.store');

});

//  Protected routes 
Route::middleware(['applicant.authenticate'])->prefix('applicant')->group(function () {
    //Report display file
    Route::get('messages/fetch/{employerId}', [SendMessageEmployerController::class, 'fetchMessages'])->name('applicant.messages.fetch');
    Route::post('typing/{employerId}', [SendMessageEmployerController::class, 'setTypingStatus']);
    Route::get('report-list', [ReportEmployerController::class, 'index'])->name('applicant.report.display');
    Route::delete('report-list/{id}', [ReportEmployerController::class, 'removeReport'])->name('applicant.report.delete');
    //Setting
    Route::get('setting', [SettingController::class, 'index'])->name('applicant.setting.display');
    Route::put('setting-update-password', [SettingController::class, 'updatePassword'])->name('applicant.setting.update.password.store');
    //Delete account 
    Route::delete('delete-account', [SettingController::class, 'deleteAccount'])->name('applicant.deleteaccount.destroy');
    //Read messages of the employer as read
    Route::put('read-message/{id}', [ApplicantController::class, 'ReadMessage'])->name('applicant.readmessage.store');
    
    Route::get('info', [ApplicantController::class, 'ShowPersonalInfoForm'])->name('info.personal');
    Route::post('info', [ApplicantController::class, 'PersonalInfo'])->name('applicant.info.personal.stores');
    Route::get('info/background', [ApplicantController::class, 'ShowWorkBackgroundForm'])->name('applicant.info.workbackground.display');
    Route::post('info/background', [ApplicantController::class, 'WorkBackground'])->name('applicant.info.workbackground.store');
    Route::get('info/template', [ApplicantController::class, 'ShowTemplateFormForm'])->name('applicant.info.template.display');
    Route::post('info/template', [ApplicantController::class, 'TemplateForm'])->name('applicant.info.template.store');
    Route::get('homepage', [ApplicantController::class, 'ShowHomepage'])->name('applicant.info.homepage.display');

    //Send rating
    Route::post('send-rating', [ApplicantController::class, 'sendRating'])->name('applicant.sendrating.store');
    //Report the employer job post
    Route::post('report/employer-job-post', [ReportController::class, 'reportEmployerJobPost'])->name('applicant.report.employerjobpost.store');
   // routes/web.php
    Route::post('notifications/{id}/read', [ApplicantController::class, 'ReadNotification']);
    Route::post('/notifications/mark-all-read', [ApplicantController::class, 'ReadlAllnotifications']);
    Route::delete('/notifications/delete/{id}', [ApplicantController::class, 'deleteNotification']);

    Route::post('notifications/retrieve/{id}/read', [ApplicantController::class, 'ReadNotifications']);
    Route::post('notifications/retrieve/mark-all-read', [ApplicantController::class, 'markAllAsRead']);
    //Community Forum
    Route::get('communityforum', [CommunityForumController::class, 'ShowForum'])->name('applicant.forum.display');
    Route::post('communityforum/create', [CommunityForumController::class, 'CreatePost'])->name('applicant.forum.store');
    Route::delete('communityforum/delete/{id}', [CommunityForumController::class, 'DeletePost'])->name('applicant.forum.delete');
    Route::get('communityforum/addcomment', [CommunityForumController::class, 'ShowPost'])->name('applicant.forum.comments.display');
    Route::post('communityforum/addcomment', [CommunityForumController::class, 'AddComments'])->name('applicant.forum.comments.store');
    Route::delete('communityforum/deletecomment/{id}', [CommunityForumController::class, 'DeleteComment'])->name('applicant.forum.comments.delete');
    Route::post('communityforum/replycomment', [CommunityForumController::class, 'ReplyComments'])->name('applicant.forum.replycomments.store');
    Route::delete('communityforum/replycomment/delete/{id}', [CommunityForumController::class, 'DeleteReplyComment'])->name('applicant.forum.replycomments.delete');
    Route::post('communityforum/like{id}', [CommunityForumController::class, 'LikePost'])->name('applicant.forum.likes.store');
    Route::get('communityforum/viewpost', [CommunityForumController::class, 'ViewMyPost'])->name('applicant.forum.viewpost.display');
    // roup foru
    Route::get('communityforum/create-group', [CommunityForumController::class, 'ShowGroupForum'])->name('applicant.forum.group.display');
    Route::post('communityforum/create-group', [CommunityForumController::class, 'AddGroupForum'])->name('applicant.forum.group.store');
    Route::get('communityforum/group-community', [CommunityForumController::class, 'DisplayGroupForum'])->name('applicant.forum.groupcommunity.display');
    Route::post('communityforum/join-group', [CommunityForumController::class, 'RequestAndJoinGroup'])->name('applicant.forum.joingroup.store');
    // Group-specific posts/comments/likes
    Route::post('communityforum/view-specific-group/{groupId}', [CommunityForumController::class, 'AddPostGroupCommunity'])->name('applicant.forum.addpostgroupcommunity.store');
    Route::get('communityforum/view-specific-group/{id}', [CommunityForumController::class, 'ViewSpecificGroup'])->name('applicant.forum.joinedgroup.display');
    // Accept or reject join request
    Route::post('communityforum/groupmembers/{groupId}/accept/{applicantId}', [CommunityForumController::class, 'AcceptJoinRequest'])->name('applicant.forum.groupmembers.accept');
    Route::delete('communityforum/groupmembers/{groupId}/reject/{applicantId}', [CommunityForumController::class, 'RejectJoinRequest'])->name('applicant.forum.groupmembers.reject');
    Route::get('communityforum/view-group-creator', [CommunityForumController::class, 'ViewGroupByCreator'])->name('applicant.forum.viewgroupcreator.display');
    Route::delete('communityforum/{id}/view-group-creator', [CommunityForumController::class, 'DeleteGroupByCreator'])->name('applicant.forum.deletegroupcreator.delete');
    Route::delete('communityforum/group/{groupId}/kick/{memberId}', [CommunityForumController::class, 'KickGroup'])->name('group.kickMember');
    Route::get('communityforum/view-specific-creator/view-group/{groupId}', [CommunityForumController::class, 'ViewGroupByCreatorPage'])->name('applicant.forum.creatorviewpage.display');
    Route::post('communityforum/view-specific-creator/view-group/{groupId}', [CommunityForumController::class, 'AddPostGroupSpecific'])->name('applicant.forum.addpostgroup.store');
    Route::post('communityforum/view-specific-creator/view-group/{groupId}/comment', [CommunityForumController::class, 'AddCommentGroupSpecific'])->name('applicant.forum.groupcomments.store');
    Route::delete('communityforum/view-specific-creator/view-group/{groupId}/comment/{commentId}', [CommunityForumController::class, 'DeleteCommentGroup'])->name('applicant.forum.groupcomments.delete');
    Route::post('communityforum/view-specific-creator/view-group/{groupId}/like/{postId}', [CommunityForumController::class, 'AddLikeGroup'])->name('applicant.forum.groupaddlike.store');
    // Post editing
    Route::get('communityforum/{id}/edit-post', [CommunityForumController::class, 'ShowPostPage'])->name('applicant.forum.editpost.display');
    Route::put('communityforum/{id}/update', [CommunityForumController::class, 'EditPost'])->name('applicant.forum.update');
    // Friend
    Route::post('communityforum/add-friend/{id}', [CommunityForumController::class, 'AddFriend'])->name('applicant.forum.addfriend.store');
    Route::delete('communityforum/cancel-friend-request/{id}', [CommunityForumController::class, 'CancelFriendRequest'])->name('applicant.forum.friend.cancel');
    Route::put('communityforum/accept-friend-request/{id}', [CommunityForumController::class, 'AcceptFriendRequest'])->name('applicant.forum.friend.accept');
    Route::get('communityforum/view-friend-list', [CommunityForumController::class, 'ViewFriendlistPage'])->name('applicant.forum.viewfriendlist.display');
    // Profile
    Route::get('profile', [ProfileController::class, 'ViewProfilePage'])->name('applicant.profile.display');
    Route::post('add-cover-photo', [ProfileController::class, 'AddCoverPhoto'])->name('applicant.coverphoto.store');
    Route::delete('delete-cover-photo', [ProfileController::class, 'DeleteCoverPhoto'])->name('applicant.coverphoto.delete');
    Route::put('profile/edit-update/{id}', [ProfileController::class, 'EditProfile'])->name('applicant.profile.info.update');
    Route::post('profile/add-post', [ProfileController::class, 'ApplicantPost'])->name('applicant.applicantposts.store');
    Route::put('profile/update-post/{id}', [ProfileController::class, 'ApplicantEditPost'])->name('applicant.applicantposts.update');
    Route::delete('profile/delete-post/{id}', [ProfileController::class, 'ApplicantDeletePost'])->name('applicant.applicantposts.delete');
    Route::post('profile/add-portfolio', [ProfileController::class, 'AddPortfolio'])->name('applicant.portfolio.store');
    Route::delete('profile/delete-portfolio/{id}', [ProfileController::class, 'DeletePortfolio'])->name('applicant.portfolio.delete');
    Route::post('profile/add-youtube-video', [ProfileController::class, 'AddYoutubeVideo'])->name('applicant.youtubevideo.store');
    Route::delete('profile/delete-youtube-video/{id}', [ProfileController::class, 'DeleteYoutubeVideo'])->name('applicant.youtubevideo.delete');
    Route::get('profile/{id}', [ProfileController::class, 'getApplicantProfile'])->name('applicant.getprofile.display');
    Route::put('profile/update/{id}', [ProfileController::class, 'updateProfile'])->name('applicant.editprofile');
    Route::post('profile/like-post/{id}', [ProfileController::class, 'toggleLike'])->name('applicant.likepost.store');
    Route::post('profile/comment-post/{id}', [ProfileController::class, 'ApplicantAddComments'])->name('applicantaddcomments.store');
    Route::delete('profile/delete-comment/{id}', [ProfileController::class, 'ApplicantDeleteComments'])->name('applicant.comment.delete');
    //Tesda certification
    Route::post('add-certification', [ProfileController::class, 'addTesdaCertificate'])->name('applicant.certification.store');
    Route::delete('delete-certification/{id}', [ProfileController::class, 'deleteTesdaCertificate'])->name('applicant.certification.delete');
    //Applicant messages the employer
    Route::post('send-message/employer', [MessageController::class, 'sendMessage'])->name('applicant.sendmessageemployer.store');
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
    Route::post('apply-job', [ApplicantController::class, 'applyJob'])->name('jobs.apply.store');
    Route::delete('cancel-job', [ApplicantController::class, 'cancelApplication'])->name('jobs.cancel.delete');

});

//Public routes for employer
Route::group(['prefix' => 'employer'], function () {
    
    //View registration form step 1 
    Route::get('register', [EmployerController::class, 'ShowRegistrationForm'])->name('employer.register.display');
    Route::post('register', [EmployerController::class, 'addJobDetails'])->name('employer.jobdetails.store');
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
    //View contact form  2
   
    
    //Display the login form
    Route::get('login', [EmployerController::class, 'ShowLoginForm'])->name('employer.login.display');
    Route::post('login', [EmployerController::class, 'login'])->name('employer.login.store');


     //Forgot password employer
    Route::get('forgot-password', [EmployerController::class, 'forgotPassword'])->name('employer.forgotpassword.display');
    Route::post('forgot-password', [EmployerController::class, 'forgotPasswordStore'])->name('employer.forgotpassword.store');
    Route::post('verify-code', [EmployerController::class, 'verifyCode'])->name('employer.verifycode.store');
    Route::post('reset-password', [EmployerController::class, 'resetPassword'])->name('employer.resetpassword.store');

});

//Protected routes for employer
Route::middleware(['employer.authenticate'])->prefix('employer')->group(function () {

    Route::get('messages/fetch/{applicantId}', [SendMessageController::class, 'fetchMessages'])->name('applicant.messages.fetch');
    Route::post('typing/{applicantId}', [SendMessageController::class, 'setTypingStatus']);
    //insert loho
    route::post('insert-company-logo', [EmployerController::class, 'insertCompanyLogo'])->name('employer.companylogo.store');

    //Schedule interview
    Route::post('schedule-interview/{id}', [EmployerController::class, 'setScheduleInterviewByEmployer'])->name('employer.scheduleinterview.store');
    // Employer Notifications Routes
    Route::post('notifications/{id}/read', [EmployerController::class, 'markAsRead']);
    Route::post('announcements/{id}/read', [EmployerController::class, 'markAnnouncementAsRead']);
    Route::post('notifications/mark-all-read', [EmployerController::class, 'markAllAsRead']);
    Route::delete('/notifications/delete/{id}', [EmployerController::class, 'deleteNotification']);
    // Employer Announcements Routes
    Route::post('messages/mark-as-read/{applicantId}', [EmployerController::class, 'viewMessageAsRead'])->name('employer.messages.markAsRead');
    //delete account
    Route::delete('delete-account/{id}', [EmployerController::class, 'deleteAccount'])->name('employer.deleteaccount.destroy');
       //Homepage display
    Route::get('homepage', [EmployerController::class, 'ShowHomepage'])->name('employer.info.homepage.display');
    //Report the applicant
    Route::post('report/applicant', [ReportController::class, 'reportApplicant'])->name('employer.report.applicant.store');
    //Remove the applicant report
    Route::delete('remove/report/applicant/{id}', [ReportController::class, 'removeReportByEmployer'])->name('employer.remove.report.applicant.store');
    //Update the company name of the employer
    Route::put('update-company-name', [EmployerController::class, 'updateCompanyName'])->name('employer.updatecompanyname.store');
    Route::put('update-company-password', [EmployerController::class, 'updateCompanyPassword'])->name('employer.updatecompanypassword.store');
    //Logout
    Route::post('logout', [EmployerController::class, 'logout'])->name('employer.logout.store');
    //show the applicants profile modal
    Route::get('applicant/{id}/profile', [EmployerController::class, 'viewApplicantProfile'])->name('employer.applicantsprofile.display');
    //Add job post
    Route::post('add-job-post', [EmployerController::class, 'addJobPost'])->name('employer.jobsposts.store');
    Route::put('job-post/{id}/update', [EmployerController::class, 'updateJobStatus'])->name('employer.updatejobpost.store');
    Route::delete('job-post/{id}/delete', [EmployerController::class, 'deleteJobPost'])->name('employer.deletejobpost.store');
    //Pending applicants
    Route::put('approve-applicant{id}', [EmployerController::class, 'approveApplicant'])->name('employer.approveapplicant.store');
    Route::put('reject-applicant/{id}', [EmployerController::class, 'rejectApplicant'])->name('employer.rejectapplicant.store');
    Route::put('schedule-interview/{id}', [EmployerController::class, 'scheduleInterview'])->name('employer.scheduleinterview.store');
    //Send rating 
    Route::post('send-rating', [EmployerController::class, 'sendReview'])->name('employer.sendrating.store');
    //Send message to applicant
    Route::post('send-message', [SendMessageController::class, 'sendMessage'])->name('employer.sendmessage.store');
    Route::get('conversation/{employerId}/{applicantId}', [SendMessageController::class, 'getConversation'])
     ->name('conversation.get');

});

Route::prefix('admin')->group(function () {
    
    Route::get('login', [AdminController::class, 'loginDisplay'])->name('admin.login.display');
    Route::post('login', [AdminController::class, 'login'])->name('admin.login.store');
    
});

Route::middleware(['admin.authenticate'])->prefix('admin')->group(function () {
Route::delete('/delete-account/{id}', [AdminController::class, 'deleteApplicantOrEmployer'])->name('admin.deleteaccount.destroy');

    Route::get('homepage', [AdminController::class, 'homepageDisplay'])->name('admin.homepage.display');
    Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout.store');
    //Officer
    Route::post('add-officer', [AdminController::class, 'addTesdaOfficer'])->name('admin.addofficer.store');
    Route::put('officer/{id}/update', [AdminController::class, 'updateTesdaOfficer'])->name('admin.updateofficer');
    Route::delete('officer/{id}/delete', [AdminController::class, 'deleteTesdaOfficer'])->name('admin.deleteofficer');
    //Announcement
    Route::post('create-announcement', [AnnouncementController::class, 'createAnnouncement'])->name('admin.create-announcement');
    Route::delete('delete-announcement/{id}', [AnnouncementController::class, 'deleteAnnouncement'])->name('admin.delete-announcement.destroy');
    Route::put('update-announcement/{id}', [AnnouncementController::class, 'updateAnnouncement'])->name('admin.update-announcement');
    //Suspension
    Route::post('suspend-employer', [UserManagementController::class, 'suspendUser'])->name('admin.suspend-user.store');
    Route::put('users/{id}/ban', [UserManagementController::class, 'banUser'])->name('admin.ban-user.store');
    Route::put('users/{id}/unban', [UserManagementController::class, 'unbanUser'])->name('admin.unban-user.store');
    Route::delete('users/{id}/delete', [UserManagementController::class, 'deleteUser'])->name('admin.delete-user.destroy');
    //Excel
    Route::get('export', [UserManagementController::class, 'exportData'])->name('admin.export');

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

