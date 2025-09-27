<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Employer\AccountInformationModel;
use Illuminate\Http\Request;
use App\Models\Employer\SendMessageModel as SendMessageToEmployer;

class SendMessageEmployerController extends Controller
{
    

public function sendMessage(Request $request)
{
    $request->validate([
        'message' => 'nullable|string',
        'employer_id' => 'required|integer',
        'attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

    ]);

    $applicantId = session('applicant_id'); 
    if (!$applicantId) return redirect()->back()->with('error', 'Applicant not logged in.');


    $receiverid = AccountInformationModel::with('personal_info')->find($request->employer_id);

    $attachmentPath = $request->hasFile('attachment') 
        ? $request->file('attachment')->store('attachments', 'public') 
        : null;

    SendMessageToEmployer::create([
        'applicant_id' => $applicantId,
        'employer_id' =>  $receiverid,
        'message' => $request->message,
        'attachment' => $attachmentPath,
        'sender_type' => 'applicant',
        'is_read' => false,
    ]);

    return redirect()->back()->with('success', 'Message sent successfully.');
}






}
