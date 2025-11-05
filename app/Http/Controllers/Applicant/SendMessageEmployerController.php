<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Employer\AccountInformationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
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




public function fetchMessages(Request $request)
{
    try {
        // Get the currently authenticated applicant
        $applicantId = session('applicant_id');

        if (!$applicantId) {
            return response()->json([
                'success' => false,
                'error' => 'Applicant not authenticated',
            ], 401);
        }

        // Fetch all messages for this applicant
        $messages = DB::table('employer_messages_to_applicant')
            ->where('applicant_id', $applicantId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) {
                // Fetch employer record
                $employer = DB::table('employer_account')->where('id', $message->employer_id)->first();

                if (!$employer) {
                    return null; // Skip messages with missing employer
                }

                // Fetch related employer personal info
                $personalInfo = DB::table('employer_personal_info')
                    ->where('employer_id', $employer->id)
                    ->first();

                // Fetch related company info
                $companyInfo = DB::table('employer_info_address')
                    ->where('employer_id', $employer->id)
                    ->first();

                // Return message with employer details
                return [
                    'id' => $message->id,
                    'employer_id' => $message->employer_id,
                    'applicant_id' => $message->applicant_id,
                    'message' => $message->message,
                    'attachment' => $message->attachment,
                    'sender_type' => $message->sender_type,
                    'is_read' => (bool) $message->is_read,
                    'is_typing' => (bool) $message->is_typing,
                    'created_at' => $message->created_at,
                    'employer' => [
                        'id' => $employer->id,
                        'personal_info' => [
                            'first_name' => $personalInfo->first_name ?? 'N/A',
                            'last_name' => $personalInfo->last_name ?? '',
                        ],
                        'company' => [
                            'company_name' => $companyInfo->company_name ?? 'Company',
                            'company_logo' => $companyInfo->company_logo ?? null,
                        ]
                    ]
                ];
            })
            ->filter(); // removes any null values if employer not found

        return response()->json([
            'success' => true,
            'messages' => $messages->values(), // reindex array after filtering
            'count' => $messages->count(),
        ]);

    } catch (\Exception $e) {
        \Log::error('Error fetching messages: ' . $e->getMessage());
        \Log::error($e->getTraceAsString());

        return response()->json([
            'success' => false,
            'error' => 'Failed to fetch messages',
            'message' => config('app.debug') ? $e->getMessage() : null,
        ], 500);
    }
}






}
