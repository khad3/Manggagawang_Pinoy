<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer\SendMessageModel;
use App\Models\Applicant\RegisterModel;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

        $receiver = RegisterModel::with('personal_info')->find($request->receiver_id);
        if (!$receiver || !$receiver->personal_info) {
            return redirect()->back()->with('error', 'Receiver not found.');
        }

        // Upload photo if any
        $attachmentPath = $request->hasFile('photo')
            ? $request->file('photo')->store('attachments', 'public')
            : null;

        // Encrypt message if exists
        $encryptedMessage = $request->message ? Crypt::encryptString($request->message) : null;

        // Save to DB
        SendMessageModel::create([
            'is_read' => false,
            'message' => $encryptedMessage,
            'attachment' => $attachmentPath,
            'sender_type' => 'employer',
            'employer_id' => $request->sender_id,
            'applicant_id' => $request->receiver_id,
        ]);

        $firstName = $this->cleanDecrypt($receiver->personal_info->first_name ?? '');
        $lastName = $this->cleanDecrypt($receiver->personal_info->last_name ?? '');

        return redirect()->back()->with('success', "Message sent successfully to {$firstName} {$lastName}.");
    }

    public function fetchMessages($applicantId)
    {
        $employerId = session('employer_id');
        if (!$employerId) {
            return response()->json(['success' => false, 'error' => 'Employer not authenticated'], 401);
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

        $applicantTyping = DB::table('employer_messages_to_applicant')
            ->where('employer_id', $employerId)
            ->where('applicant_id', $applicantId)
            ->where('sender_type', 'applicant')
            ->orderByDesc('updated_at')
            ->value('is_typing');

        return response()->json([
            'success' => true,
            'messages' => $messagesFormatted,
            'is_typing' => (bool) $applicantTyping,
            'count' => $messagesFormatted->count(),
        ]);
    }

    public function setTypingStatus(Request $request, $applicantId)
    {
        $employerId = session('employer_id');
        $isTyping = $request->input('is_typing', false);

        if (!$employerId) {
            return response()->json(['success' => false, 'error' => 'Not authenticated'], 401);
        }

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

    private function cleanDecrypt($value)
    {
        if (empty($value)) return '';
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return preg_replace('/[^a-zA-Z\s]/', '', $value);
        }
    }
}







