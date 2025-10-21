<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    
    //Report the employer job post

    public function reportEmployerJobPost(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'reported_id_job_id' => 'required|integer',
            'employer_id' => 'required|integer',
            'reason' => 'nullable|in:fraudulent,misleading,discriminatory,inappropriate,other',
            'other_reason' => 'nullable|string|max:255',
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_info' => 'nullable|string',
        ]);

        $applicantId = session('applicant_id'); 
        if (!$applicantId) {
            return redirect()->back()->with('error', 'Applicant not logged in.');
        }

        // Handle file upload if exists
        $attachmentPath = $request->hasFile('attachment') 
            ? $request->file('attachment')->store('report_attachments', 'public') 
            : null;

        // Create the report record
        \App\Models\Report\ReportModel::create([
            'reporter_id' => $applicantId,
            'reporter_type' => 'applicant',
            'reported_id' => $request->reported_id_job_id,
            'employer_id' => $request->employer_id,
            'reported_type' => 'employer',
            'reason' => $request->reason,
            'other_reason' => $request->other_reason,
            'attachment' => $attachmentPath,
            'additional_info' => $request->additional_info,
        ]);

        return redirect()->back()->with('success', 'Report submitted successfully.');
    }


    // End of Report the employer job post
    
    //For employer reports the applicant

    public function reportApplicant(Request $request)
{
    $request->validate([
        'reported_id' => 'required|integer',
        'reason' => 'nullable|in:fraudulent,misleading,discriminatory,inappropriate,other',
        'other_reason' => 'nullable|string|max:255',
        'attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'additional_info' => 'nullable|string',
    ]);

    // Get employer ID from auth guard
    $employerId = session('employer_id');
    if (!$employerId) {
        return redirect()->route('employer.login.display')->with('error', 'Please log in as an employer.');
    }

    // Handle file upload
    $attachmentPath = $request->hasFile('attachment')
        ? $request->file('attachment')->store('report_attachments', 'public')
        : null;

    // Create report
    \App\Models\Report\ReportModel::create([
        'reporter_id' => $employerId,
        'reporter_type' => 'employer',
        'reported_id' => $request->reported_id,
        'reported_type' => 'applicant',
        'reason' => $request->reason,
        'other_reason' => $request->other_reason,
        'attachment' => $attachmentPath,
        'additional_info' => $request->additional_info,
    ]);

    return redirect()->back()->with('success', 'Report submitted successfully.');
}


//remove the report of the employer
public function removeReportByEmployer($id)
{
    $employerId = session('employer_id');

    if (!$employerId) {
        return redirect()->route('employer.login.display')->with('error', 'Please log in as an employer.');
    }

    $deleted = \App\Models\Report\ReportModel::where('id', $id)
        ->where('reported_type', 'applicant')
        ->where('reporter_id', $employerId)
        ->where('reporter_type', 'employer')
        ->delete();

    if ($deleted) {
        return redirect()->back()->with('success', 'Report removed successfully.');
    }

    return redirect()->back()->with('error', 'Failed to remove report or report not found.');
}


}
