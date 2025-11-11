<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Employer\AccountInformationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Employer\SendMessageModel as SendMessageToEmployer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


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
        if (!$applicantId) {
            return redirect()->back()->with('error', 'Applicant not logged in.');
        }

        // Fetch employer
        $receiver = AccountInformationModel::with('personal_info')->find($request->employer_id);
        if (!$receiver) {
            return redirect()->back()->with('error', 'Employer not found.');
        }

        // Handle attachment upload
        $attachmentPath = $request->hasFile('attachment')
            ? $request->file('attachment')->store('attachments', 'public')
            : null;

        // Encrypt message if not null
        $encryptedMessage = $request->message ? Crypt::encryptString($request->message) : null;

        // Save message
        SendMessageToEmployer::create([
            'applicant_id' => $applicantId,
            'employer_id' => $receiver->id,
            'message' => $encryptedMessage,
            'attachment' => $attachmentPath,
            'sender_type' => 'applicant',
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Message sent successfully.');
    }

    public function fetchMessages($employerId)
    {
        $applicantId = session('applicant_id');
        if (!$applicantId) {
            return response()->json(['success' => false, 'error' => 'Applicant not authenticated'], 401);
        }

        $messages = DB::table('employer_messages_to_applicant')
            ->where('employer_id', $employerId)
            ->where('applicant_id', $applicantId)
            ->orderBy('created_at', 'asc')
            ->get();

        $messagesFormatted = $messages->map(function ($msg) {
            $decryptedMessage = $this->safeDecrypt($msg->message);

            return [
                'id' => $msg->id,
                'employer_id' => $msg->employer_id,
                'applicant_id' => $msg->applicant_id,
                'message' => $decryptedMessage,
                'attachment' => $msg->attachment,
                'sender_type' => $msg->sender_type,
                'is_read' => (bool) $msg->is_read,
                'is_typing' => (bool) $msg->is_typing,
                'created_at' => $msg->created_at,
                'time' => Carbon::parse($msg->created_at)->format('g:i A'),
            ];
        });

        return response()->json([
            'success' => true,
            'messages' => $messagesFormatted,
            'count' => $messagesFormatted->count(),
        ]);
    }

    public function setTypingStatus(Request $request, $employerId)
    {
        $applicantId = session('applicant_id');
        $isTyping = $request->input('is_typing', false);

        DB::table('employer_messages_to_applicant')
            ->where('employer_id', $employerId)
            ->where('applicant_id', $applicantId)
            ->update(['is_typing' => $isTyping]);

        return response()->json(['success' => true]);
    }

    private function safeDecrypt($value)
    {
        if (empty($value)) return null;
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return '[Cannot decrypt message]';
        }
    }
}


