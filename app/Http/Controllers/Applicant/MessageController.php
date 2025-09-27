<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer\SendMessageModel as SendMessageToEmployer;
use App\Models\Employer\AccountInformationModel;

class MessageController extends Controller
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

    $attachmentPath = $request->hasFile('attachment') 
        ? $request->file('attachment')->store('attachments', 'public') 
        : null;

    SendMessageToEmployer::create([
        'applicant_id' => $applicantId,
        'employer_id' => $request->employer_id, // use only the ID
        'message' => $request->message,
        'attachment' => $attachmentPath,
        'sender_type' => 'applicant',
        'is_read' => false,
    ]);

    return redirect()->back()->with('success', 'Message sent successfully.');
}


}
