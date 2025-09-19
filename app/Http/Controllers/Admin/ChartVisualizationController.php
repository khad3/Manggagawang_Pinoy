<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChartVisualizationController extends Controller
{
    

   public function showChart()
{
    // Count applicants per date
    $applicantregistered = DB::table('applicants')
        ->select(DB::raw('DATE(created_at) as reg_date'), DB::raw('COUNT(*) as total'))
        ->groupBy('reg_date')
        ->orderBy('reg_date', 'asc')
        ->get();

    // Convert to Google Charts format
    $chartData = [];
    foreach ($applicantregistered as $row) {
        $chartData[] = "['{$row->reg_date}', {$row->total}]";
    }

    // Example colors
    $colors = ['#1E88E5', '#43A047', '#F4511E', '#FB8C00'];

    return view('admin.homepage.homepage', [
        'chartData' => $chartData,
        'colors' => $colors,
    ]);
}




}
