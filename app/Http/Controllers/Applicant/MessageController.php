<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer\SendMessageModel as SendMessageToEmployer;
use App\Models\Employer\AccountInformationModel;
use Illuminate\Support\Facades\Crypt;

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

    // Encrypt the message using AES
    $encryptedMessage = $request->message ? Crypt::encryptString($request->message) : null;

    SendMessageToEmployer::create([
        'applicant_id' => $applicantId,
        'employer_id' => $request->employer_id,
        'message' => $encryptedMessage, // store encrypted
        'attachment' => $attachmentPath,
        'sender_type' => 'applicant',
        'is_read' => false,
    ]);

    return redirect()->back()->with('success', 'Message sent successfully.');
}


}
