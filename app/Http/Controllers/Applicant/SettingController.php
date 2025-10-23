<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Applicant\ApplicantFriendModel;
use App\Models\Applicant\ApplicantPortfolioModel;
use App\Models\Applicant\ApplicantPostCommentModel;
use App\Models\Applicant\ApplicantPostLikeModel;
use App\Models\Applicant\ApplicantPostModel;
use App\Models\Applicant\ApplicantUrlModel;
use App\Models\Applicant\ApplyJobModel;
use App\Models\Applicant\CommentModel;
use App\Models\Applicant\ExperienceModel;
use App\Models\Applicant\GroupCommentModel;
use App\Models\Applicant\GroupLikeModel;
use App\Models\Applicant\GroupModel;
use App\Models\Applicant\LikeModel;
use App\Models\Applicant\ParticipantModel;
use App\Models\Applicant\PersonalModel;
use App\Models\Applicant\PostModel;
use App\Models\Applicant\PostSpecificGroupModel;
use App\Models\Applicant\RegisterModel;
use App\Models\Applicant\ReplyModel;
use App\Models\Applicant\SavedJobModel;
use App\Models\Applicant\SendMessageModel;
use App\Models\Applicant\TemplateModel;
use App\Models\Applicant\TesdaUploadCertificationModel;
use App\Models\Report\ReportModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index()
    {
        return view('applicant.setting.setting');
    }


    public function updatePassword(Request $request)
{
    $applicantId = session('applicant_id');

    $request->validate([
        'current_password' => ['required'],
        'new_password' => [
            'required',
            'string',
            'min:8',
            'regex:/[a-z]/',      // must contain at least one lowercase letter
            'regex:/[A-Z]/',      // must contain at least one uppercase letter
            'regex:/[0-9]/',      // must contain at least one digit
            'regex:/[@$!%*?&]/',  // must contain a special character
            'confirmed'           // must match new_password_confirmation
        ],
    ], [
        'new_password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
    ]);

    $applicant = \App\Models\Applicant\RegisterModel::findOrFail($applicantId);

    if (!Hash::check($request->current_password, $applicant->password)) {
        return back()->withErrors(['current_password' => 'The provided current password is incorrect.']);
    }

    $applicant->password = Hash::make($request->new_password);
    $applicant->save();

    return back()->with('success', 'Password updated successfully.');
}


public function deleteAccount()
{
    $applicantId = session('applicant_id');

    // Find the applicant
    $applicant = \App\Models\Applicant\RegisterModel::findOrFail($applicantId);

    // Delete related data first (if relationships exist)
    // Adjust relationships as per your database design
    \App\Models\Applicant\ApplicantFriendModel::where('request_id', $applicantId)
                    ->orWhere('receiver_id', $applicantId)
                    ->delete();
    \App\Models\Applicant\ApplicantPortfolioModel::where('applicant_id', $applicantId)->delete();
    \App\Models\Applicant\ApplicantPostCommentModel::where('applicant_id', $applicantId)->delete();
    \App\Models\Applicant\ApplicantPostLikeModel::where('applicant_id', $applicantId)->delete();
    \App\Models\Applicant\ApplicantPostModel::where('applicant_id', $applicantId)->delete();
    \App\Models\Applicant\ApplicantUrlModel::where('applicant_id', $applicantId)->delete();
    \App\Models\Applicant\ApplyJobModel::where('applicant_id', $applicantId)->delete();
    \App\Models\Applicant\CommentModel::where('applicant_id', $applicantId)->delete();
    \App\Models\Applicant\ExperienceModel::where('applicant_id', $applicantId)->delete();
    \App\Models\Applicant\GroupCommentModel::where('applicant_id', $applicantId)->delete();
    \App\Models\Applicant\GroupLikeModel::where('applicant_id', $applicantId)->delete();
    \App\Models\Applicant\GroupModel::where('applicant_id', $applicantId)->delete();
    \App\Models\Applicant\LikeModel::where('applicant_id', $applicantId)->delete();
    \App\Models\Applicant\ParticipantModel::where('applicant_id', $applicantId)->delete();
    \App\Models\Applicant\PersonalModel::where('applicant_id', $applicantId)->delete();
    \App\Models\Applicant\PostModel::where('applicant_id', $applicantId)->delete();
    \App\Models\Applicant\PostSpecificGroupModel::where('applicant_id', $applicantId)->delete();
    \App\Models\Applicant\ReplyModel::where('applicant_id', $applicantId)->delete();
    \App\Models\Applicant\SavedJobModel::where('applicant_id', $applicantId)->delete();
    \App\Models\Applicant\SendMessageModel::where('sender_id', $applicantId)
                                          ->orWhere('receiver_id', $applicantId)->delete();
    \App\Models\Applicant\TemplateModel::where('applicant_id', $applicantId)->delete();
    \App\Models\Applicant\TesdaUploadCertificationModel::where('applicant_id', $applicantId)->delete();
   \App\Models\Report\ReportModel::where('reporter_id', $applicantId)
    ->where('reported_type', 'applicant')
    ->where('reported_id', $applicantId)
    ->delete();

    // Finally, delete the applicant account
    $applicant->delete();

    // Logout session
    session()->forget('applicant_id');

    return redirect()->route('applicant.login.display')->with('success', 'Account deleted successfully.');
}


        
}



