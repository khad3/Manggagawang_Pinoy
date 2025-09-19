<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin\SuspensionModel as SuspendedModel;
use App\Models\Applicant\RegisterModel;
use App\Models\Employer\AccountInformationModel;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class UserManagementController extends Controller
{
    

    //Add the suspension and ban functionality here

  public function suspendUser(Request $request)
{
    $request->validate([
        'type' => 'required|string|in:applicant,employer',
        'user_id' => 'required|integer',
        'reason' => 'required|string|in:pending_investigation,multiple_user_reports,suspicious_activity,other',
        'other_reason' => 'nullable|string|max:255',
        'additional_notes' => 'nullable|string',
        'suspension_duration' => 'required|integer|in:1,3,7,14,30',
    ]);

    $userId = $request->user_id;
    $type   = $request->type;

    $suspendedUser = new SuspendedModel();

    if ($type === 'applicant') {
        $suspendedUser->applicant_id = $userId;

        // update applicant status
        RegisterModel::where('id', $userId)->update(['status' => 'suspended']);
    } elseif ($type === 'employer') {
        $suspendedUser->employer_id = $userId;

        // update employer status
        AccountInformationModel::where('id', $userId)->update(['status' => 'suspended']);
    }

    // fill in suspension details
    $suspendedUser->reason = $request->reason;
    $suspendedUser->other_reason = $request->other_reason;
    $suspendedUser->additional_info = $request->additional_notes;
    $suspendedUser->suspension_duration = $request->suspension_duration;
    $suspendedUser->save();

    return redirect()->back()->with('success', 'User suspended successfully!');
}




//Bann the user
public function banUser(Request $request, $id)
{
    $type = $request->query('type', 'applicant'); // default to applicant

    if ($type === 'employer') {
        $user = AccountInformationModel::findOrFail($id);
    } else {
        $user = RegisterModel::findOrFail($id); // applicant
    }

    $user->status = 'banned';
    $user->save();

    return redirect()->back()->with('success', 'User has been banned successfully.');
}



//unbanned the user
public function unbanUser(Request $request, $id)
{
    $type = $request->query('type', 'applicant'); // default to applicant

    if ($type === 'employer') {
        $user = AccountInformationModel::findOrFail($id);
    } else {
        $user = RegisterModel::findOrFail($id); // applicant
    }

    $user->status = 'active';
    $user->save();

    return redirect()->back()->with('success', 'User has been unbanned successfully.');

}


public function deleteUser(Request $request, $id) {

    $type = $request->query('type', 'applicant'); // default to applicant

    if ($type === 'employer') {
        $user = AccountInformationModel::findOrFail($id);
    } else {
        $user = RegisterModel::findOrFail($id); // applicant
    }

    $user->delete();

    return redirect()->back()->with('success', 'User has been deleted successfully.');

}


//export excel
public function exportData() {
    return Excel::download(new UsersExport, 'users.xlsx');
}



}
