<?php

namespace App\Http\Controllers\TesdaOfficer;

use App\Http\Controllers\Controller;
use App\Models\Admin\AddTesdaOfficerModel;
use App\Models\Applicant\RegisterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use App\Models\Applicant\TesdaUploadCertificationModel;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class TesdaOfficerController extends Controller
{

   private function safety_decrypt($value) {
    try {
        return decrypt($value);
    } catch (\Exception $e) {
        Log::error('Decryption error: ' . $e->getMessage());
        return null; // fallback if decryption fails
    }
}

    
    public function homepage()
{
    $tesdaOfficerId = auth()->guard('tesda_officer')->id();

    // Retrieve all applicant certificates
    $applicantCertificates = TesdaUploadCertificationModel::with('personal_info')->get();

    //decrypt applicant names
   foreach ($applicantCertificates as $certificate) {
    $info = $certificate->personal_info;
    if ($info) {
        $info->first_name = $info->first_name ? $this->safety_decrypt($info->first_name) : 'N/A';
        $info->last_name  = $info->last_name ? $this->safety_decrypt($info->last_name) : '';
    }
}


    

    // Generate applicant ID
    $lastId = (RegisterModel::latest('id')->first()->id ?? 0) + 1;
    $applicant_id = 'APP-' . date('Y') . '-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);

    // Pending applications today & yesterday for this officer
    $todayPending = TesdaUploadCertificationModel::where('status', 'pending')
        ->count();

    $yesterdayPending = TesdaUploadCertificationModel::where('status', 'pending')
        ->whereDate('created_at', today()->subDay())
        ->count();

    $pendingChange = $todayPending - $yesterdayPending;
    $pendingPercentage = $yesterdayPending > 0
        ? round(($pendingChange / $yesterdayPending) * 100, 1)
        : ($todayPending > 0 ? 100 : 0);

    // Approved applications today & yesterday for this officer
    $approvedToday = TesdaUploadCertificationModel::where('status', 'approved')
        ->where('approved_by', $tesdaOfficerId)
        ->whereDate('created_at', today())
        ->count();

    $approvedYesterday = TesdaUploadCertificationModel::where('status', 'approved')
        ->where('approved_by', $tesdaOfficerId)
        ->whereDate('created_at', today()->subDay())
        ->count();

    $approvedChange = $approvedYesterday > 0
        ? round((($approvedToday - $approvedYesterday) / $approvedYesterday) * 100)
        : ($approvedToday > 0 ? 100 : 0);

    $approvedSign = $approvedChange >= 0 ? '+' : '';

    // Total processed by this officer
    $totalProcessed = TesdaUploadCertificationModel::where('approved_by', $tesdaOfficerId)->count();

    return view('tesdaofficer.homepage.homepage', compact(
        'applicantCertificates',
        'applicant_id',
        'todayPending',
        'yesterdayPending',
        'pendingChange',
        'pendingPercentage',
        'approvedToday',
        'approvedYesterday',
        'approvedChange',
        'approvedSign',
        'totalProcessed'
    ));
}


public function approvedOfficer(Request $request)
{
    $tesda_officer_id = Auth::guard('tesda_officer')->id();

    if (!$tesda_officer_id) {
        return redirect()->route('tesda-officer.login')->with('error', 'Please login first.');
    }

    $request->validate([
        'status' => 'required|string|in:approved,rejected,request_revision',
        'officer_comment' => 'nullable|string', // Made required since form has required
        'application_id' => 'required|integer|exists:tesda_upload_certification,id', 
    ]);

    try {
        $certification = TesdaUploadCertificationModel::findOrFail($request->application_id);

        // Use fill() method or update() to ensure fillable attributes are respected
        $certification->fill([
            'status' => $request->status,
            'officer_comment' => $request->officer_comment,
            'approved_by' => $tesda_officer_id,
        ]);
        
        $certification->save();

        // Alternative approach using update()
        // $certification->update([
        //     'status' => $request->status,
        //     'officer_comment' => $request->officer_comment,
        //     'approved_by' => $tesda_officer_id,
        // ]);

        return redirect()->back()->with('success', 'Review sent successfully.');

    } catch (\Exception $e) {
        \Log::error('Error updating certification: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to save review. Please try again.');
    }
}


public function deleteOfficerReview(Request $request)
{
    $tesda_officer_id = Auth::guard('tesda_officer')->id();

    if (!$tesda_officer_id) {
        return redirect()->route('tesda-officer.login')->with('error', 'Please login first.');
    }

    // Only remove officer data for this officer
    TesdaUploadCertificationModel::where('approved_by', $tesda_officer_id)
        ->update([
            'approved_by' => null,
            'officer_comment' => null,
            'status' => 'pending' // optional: reset status to pending
        ]);

    return redirect()->back()->with('success', 'Your review data has been cleared without affecting applicant certificates.');
}



    public function loginDisplay(){
        return view('tesdaofficer.auth.login');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('tesda_officer')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('homepage.display')
                ->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->onlyInput('email');
    }


    //logout
    public function logout(Request $request)
    {
        Auth::guard('tesda_officer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('tesda-officer.login.display');
    }

}
