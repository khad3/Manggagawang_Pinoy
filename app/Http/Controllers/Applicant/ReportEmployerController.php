<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportEmployerController extends Controller
{
     public function index()
    {
        $applicantId = session('applicant_id');

        // Get all employers reported by the applicant
        $jobPostReported = \App\Models\Report\ReportModel::with(['job', 'employer'])
            ->where('reporter_id', $applicantId)
            ->where('reported_type', 'employer')
            ->where('reporter_type', 'applicant')
            ->whereNotNull('employer_id') // cleaner than '!=', ensures employer exists
            ->orderBy('created_at', 'desc') // optional: latest reports first
            ->get();

        return view('applicant.report_employer.report', compact('jobPostReported'));
    }


    public function removeReport($reportId)
    {
        $report = \App\Models\Report\ReportModel::find($reportId);
        $report->delete();
        return redirect()->back()->with('success', 'Report removed successfully.');
    }

    
}
