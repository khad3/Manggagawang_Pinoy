<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employer\SendMessageModel;
use App\Models\Applicant\RegisterModel;
use Illuminate\Support\Facades\Crypt;

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

    if (!$receiver || !$receiver->personal_info) {
        return redirect()->back()->with('error', 'Receiver not found.');
    }

    if ($request->hasFile('photo')) {
        $attachmentPath = $request->file('photo')->store('attachments', 'public');
    }

    // 🔒 Encrypt message before saving
    $encryptedMessage = $request->message ? Crypt::encryptString($request->message) : null;

    // 💾 Save the message
    SendMessageModel::create([
        'is_read' => false,
        'message' => $encryptedMessage,
        'attachment' => $attachmentPath,
        'sender_type' => 'employer',
        'employer_id' => $request->sender_id,
        'applicant_id' => $request->receiver_id,
    ]);



   $firstName = $this->cleanDecrypt($receiver->personal_info->first_name ?? '');
$lastName  = $this->cleanDecrypt($receiver->personal_info->last_name ?? '');

return redirect()->back()->with(
    'success',
    "Message sent successfully to {$firstName} {$lastName}."
);

}


/**
 * ✅ Safe Decrypt Field
 * - Tries decrypting (for encrypted)
 * - If serialized → unserialize
 * - Otherwise returns as-is
 * - Keeps real semicolons (like 'Rofgelio;')
 */
private function cleanDecrypt($value)
{
    if (empty($value)) {
        return '';
    }

    try {
        // 1️⃣ Try decrypting
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            // Not encrypted → continue
        }

        // 2️⃣ If it contains multiple serialized strings, extract them
        preg_match_all('/s:\d+:"(.*?)";/', $value, $matches);
        if (!empty($matches[1])) {
            // Join all extracted parts with space
            return implode(' ', $matches[1]);
        }

        // 3️⃣ Extract readable letters (fallback)
        preg_match_all('/[a-zA-ZÀ-ÿ\-\']+/', $value, $matches);
        if (!empty($matches[0])) {
            return implode(' ', $matches[0]);
        }

        // 4️⃣ Otherwise return as-is
        return $value;

    } catch (\Exception $e) {
        return $value;
    }
}







}
