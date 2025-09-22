<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer\SendMessageModel;
use App\Models\Applicant\RegisterModel;

class SendMessageController extends Controller
{
    //send message

  public function sendMessage(Request $request)
{
    $request->validate([
        'message' => 'nullable|string',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'sender_id' => 'required|integer',
        'receiver_id' => 'required|integer',
    ]);

    $attachmentPath = null;

    $receiver = RegisterModel::with('personal_info')->find($request->receiver_id);

    if ($request->hasFile('photo')) {
        $attachmentPath = $request->file('photo')->store('attachments', 'public');
    }

    $message = SendMessageModel::create([
        'is_read' => false,
        'message' => $request->message,
        'attachment' => $attachmentPath,
        'employer_id' => $request->sender_id,
        'applicant_id' => $request->receiver_id,
    ]);

   return redirect()->back()->with('success', "Message sent successfully to {$receiver->personal_info->first_name} {$receiver->personal_info->last_name}.");

       
}




}
