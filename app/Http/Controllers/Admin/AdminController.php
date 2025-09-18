<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin\AccountAdminModel as Admin;
use App\Models\Admin\AddTesdaOfficerModel as AddTesdaOfficer;
use App\Models\Applicant\TesdaUploadCertificationModel as TesdaCertification;
use App\Models\Admin\UserManagmentModel;
use App\Models\Admin\AnnouncementModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


//Employer Model
use App\Models\Employer\AccountInformationModel as Employer;
//Applicants Model
use App\Models\Applicant\RegisterModel;
use App\Models\User;
use Illuminate\Auth\Events\Logout;

class AdminController extends Controller
{
    //Homepage 

   public function homepageDisplay()
{
       if (!Auth::guard('admin')->check()) {
        return redirect()->route('admin.login.display');
    }

    $retrieveAdmin = Auth::guard('admin')->user();

    // Total counts
    $employerCount = Employer::count();
    $applicantsCount = RegisterModel::count();

    // Monthly count comparison
    $now = Carbon::now();
    $currentMonth = $now->month;
    $currentYear = $now->year;

    $lastMonth = $now->copy()->subMonth()->month;
    $lastMonthYear = $now->copy()->subMonth()->year;

    $applicantsThisMonth = RegisterModel::whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->count();

    $applicantsLastMonth = RegisterModel::whereMonth('created_at', $lastMonth)
        ->whereYear('created_at', $lastMonthYear)
        ->count();

        

    // Calculate trend percentage
    $change = 0;
    $isTrendingUp = true;

    if ($applicantsLastMonth > 0) {
        $change = (($applicantsThisMonth - $applicantsLastMonth) / $applicantsLastMonth) * 100;
        $isTrendingUp = $change >= 0;
    } elseif ($applicantsThisMonth > 0) {
        $change = 100;
    }

    //Employer
    // Employers trend
    $employersThisMonth = Employer::whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->count();

    $employersLastMonth = Employer::whereMonth('created_at', $lastMonth)
        ->whereYear('created_at', $lastMonthYear)
        ->count();

    $employerChange = 0;
    $employersTrendingUp = true;

    if ($employersLastMonth > 0) {
        $employerChange = (($employersThisMonth - $employersLastMonth) / $employersLastMonth) * 100;
        $employersTrendingUp = $employerChange >= 0;
    } elseif ($employersThisMonth > 0) {
        $employerChange = 100;
    }


     // Total users
    $totalUsers = $applicantsCount + $employerCount;
    $totalUsersThisMonth = $applicantsThisMonth + $employersThisMonth;
    $totalUsersLastMonth = $applicantsLastMonth + $employersLastMonth;


     // Percentage growth
    $percentageGrowth = 0;
    if ($totalUsersLastMonth > 0) {
        $percentageGrowth = (($totalUsersThisMonth - $totalUsersLastMonth) / $totalUsersLastMonth) * 100;
    }



    //retrive the last login
    $last_login = $retrieveAdmin->last_login;


    //Retrieve the Tesda Officers
    $retrieveTesdaOfficers = AddTesdaOfficer::all();


    //retrieved the annoucements count
    $retrieveAnnouncementsTotal = AnnouncementModel::count();

    $retrieveAnnouncements = AnnouncementModel::orderBy('created_at', 'desc')->get();

    $weeklyAnnouncements = AnnouncementModel::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();

    //retrieve the publisjhed announcements
    $publishedAnnouncementTotal = AnnouncementModel::where('status', 'published')->count();

    //Retrieve the tesda officers count
    $tesdaOfficersCount = AddTesdaOfficer::count();

    // New officers added this month
    $newTesdaOfficers = AddTesdaOfficer::whereMonth('created_at', Carbon::now()->month)
    ->whereYear('created_at', Carbon::now()->year)
    ->count();

    //user trends
     $applicantStats = RegisterModel::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->whereYear('created_at', Carbon::now()->year)
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

    $employerStats = Employer::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->whereYear('created_at', Carbon::now()->year)
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total', 'month');

    $chartData = [];
    $chartData[] = "['Month', 'Applicants', 'Employers']"; // Add both series

    for ($m = 1; $m <= 12; $m++) {
        $monthName = Carbon::create()->month($m)->format('F');
        $applicants = $applicantStats[$m] ?? 0;
        $employers  = $employerStats[$m] ?? 0;
        $chartData[] = "['{$monthName}', {$applicants}, {$employers}]";
    }

    $colors = ['#1E88E5', '#43A047']; // Blue = applicants, Green = employers


    // //retrieved the user data to display in the homepage
    // $retrievedApplicants = RegisterModel::where('type_user', 'applicant')->get();

    $applicantUser = RegisterModel::with('personal_info')
        ->get()
        ->map(fn($a) => ['type' => 'applicant', 'data' => $a]);

    $employerUser = Employer::with('personal_info' , 'addressCompany')
        ->get()
        ->map(fn($e) => ['type' => 'employer', 'data' => $e]);

    // Merge both collections
    $users = $applicantUser->concat($employerUser);

    $applicantsCount = RegisterModel::count();
    $employerCount = Employer::count();

    $totalUsers = $applicantsCount + $employerCount;


    //retrieve the account ban to make a reports
   // Count bans
    $retrieveAccountBanApplicant = RegisterModel::where('status', 'banned')->count();
    $retrieveAccountBanEmployer = Employer::where('status', 'banned')->count();

    // Prepare chart data for Google Charts
    $banChartData = [];
    $banChartData[] = "['Account Type', 'Banned Count']"; 
    $banChartData[] = "['Applicants', {$retrieveAccountBanApplicant}]";
    $banChartData[] = "['Employers', {$retrieveAccountBanEmployer}]";

    $banColors = ['#E53935', '#FB8C00']; // Red for Applicants, Orange for Employers



    //Suspended Chart data
    $retrievedSuspendedApplicants = RegisterModel::where('status', 'suspended')->count();
    $retrievedSuspendedEmployers = Employer::where('status', 'suspended')->count();


    $suspendedChartData = [];
    $suspendedChartData[] = "['Account Type', 'Suspended Count']"; 
    $suspendedChartData[] = "['Applicants', {$retrievedSuspendedApplicants}]";
    $suspendedChartData[] = "['Employers', {$retrievedSuspendedEmployers}]";

    $suspendedColors = ['#E53935', '#FB8C00']; // Red for Applicants, Orange for Employers


        //retrieve the certifications accecpted
    // Group certifications by month (accepted ones)

    $retrievedCertificationCount = TesdaCertification::where('status', 'approved')->count();
    // Certifications grouped by month and status
    $certifications = TesdaCertification::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, status, COUNT(*) as total")
        ->groupBy('month', 'status')
        ->orderBy('month')
        ->get();

    $statuses = ['approved', 'pending', 'rejected', 'request_revision'];
    $months = $certifications->pluck('month')->unique()->values();

    $certificationsChartData = [];
    $certificationsChartData[] = "['Month', 'Approved', 'Pending', 'Rejected', 'Request Revision']";

    foreach ($months as $month) {
        // Convert YYYY-MM to "Mon YYYY"
        $monthLabel = \Carbon\Carbon::createFromFormat('Y-m', $month)->format('M Y');

        $row = ["'{$monthLabel}'"];
        foreach ($statuses as $status) {
            $count = $certifications
                ->where('month', $month)
                ->where('status', $status)
                ->sum('total');
            $row[] = $count;
        }
        $certificationsChartData[] = "[" . implode(',', $row) . "]";
    }   

    $certificationsColors = ['#43A047', '#FB8C00', '#E53935', '#1E88E5']; 
    // Green = Approved, Orange = Pending, Red = Rejected, Blue = Request Revision
    
$activityLogs = collect();

/**
 * Suspended Applicants
 */
$applicantSuspensions = RegisterModel::with('suspension')
    ->where('status', 'suspended')
    ->latest()
    ->get()
    ->map(function ($a) {
        $duration = $a->suspension->duration ?? 'N/A';
        return [
            'action' => 'suspended',
            'email' => $a->email,
            'description' => "{$a->email} suspended for {$duration} days due to multiple reports",
            'created_at' => $a->updated_at,
        ];
    });

/**
 * Suspended Employers
 */
$employerSuspensions = Employer::with('suspension')
    ->where('status', 'suspended')
    ->latest()
    ->get()
    ->map(function ($e) {
        $duration = $e->suspension->duration ?? 'N/A';
        return [
            'action' => 'suspended',
            'email' => $e->email,
            'description' => "{$e->email} suspended for {$duration} days due to multiple reports",
            'created_at' => $e->updated_at,
        ];
    });

/**
 * Banned Applicants
 */
$applicantBanned = RegisterModel::where('status', 'banned')
    ->latest()
    ->get()
    ->map(function ($a) {
        return [
            'action' => 'banned',
            'email' => $a->email,
            'description' => "{$a->email} was banned by admin",
            'created_at' => $a->updated_at,
        ];
    });

/**
 * Banned Employers
 */
$employerBanned = Employer::where('status', 'banned')
    ->latest()
    ->get()
    ->map(function ($e) {
        return [
            'action' => 'banned',
            'email' => $e->email,
            'description' => "{$e->email} was banned by admin",
            'created_at' => $e->updated_at,
        ];
    });

/**
 * Unbanned Applicants
 */
// Unbanned Applicants
$applicantUnbans = RegisterModel::where('status', 'active')
    ->latest()
    ->get()
    ->map(function ($a) {
        return [
            'action' => 'unbanned',
            'email' => $a->email,
            'description' => "{$a->email} ban was lifted by admin",
            'created_at' => $a->updated_at,
        ];
    });

// Unbanned Employers
$employerUnbans = Employer::where('status', 'active')
    ->latest()
    ->get()
    ->map(function ($e) {
        return [
            'action' => 'unbanned',
            'email' => $e->email,
            'description' => "{$e->email} ban was lifted by admin",
            'created_at' => $e->updated_at,
        ];
    });


/**
 * Merge ALL logs together
 */
$activityLogs = collect()
    ->merge($applicantSuspensions)
    ->merge($employerSuspensions)
    ->merge($applicantBanned)
    ->merge($employerBanned)
    ->merge($applicantUnbans)
    ->merge($employerUnbans)
    ->sortByDesc('created_at')
    ->values();













    return view('admin.homepage.homepage', compact(
        'employerCount',
        'applicantsCount',
        'applicantsThisMonth',
        'change',
        'isTrendingUp',
        'employersTrendingUp',
        'employerChange',
        'totalUsers',
        'percentageGrowth',
        'retrieveAdmin',
        'last_login',
        'retrieveTesdaOfficers',
        'retrieveAnnouncements',
        'weeklyAnnouncements',
        'retrieveAnnouncementsTotal',
        'publishedAnnouncementTotal',
        'tesdaOfficersCount',
        'newTesdaOfficers',
        'chartData',
        'colors',
        'users',
        'totalUsers',
        'banChartData',
        'banColors',
        'retrieveAccountBanApplicant',
        'retrieveAccountBanEmployer',
        'suspendedChartData',
        'suspendedColors',
        'retrievedSuspendedApplicants',
        'retrievedSuspendedEmployers',
        'certificationsChartData',
        'certificationsColors',
        'retrievedCertificationCount',
        'activityLogs',
        

    ));
}

//update the credentials of the tesda officer


    //login page
    public function loginDisplay(){
        return view('admin.auth.login');
    }

public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    // Attempt login using 'admin' guard
    if (Auth::guard('admin')->attempt($credentials)) {
        // Regenerate session
        $request->session()->regenerate();

        // Update last login
        $admin = Auth::guard('admin')->user();
        $admin->last_login = Carbon::now();
        $admin->save();

         // Try direct URL instead of named route
        return redirect('/admin/homepage')
            ->with('success', 'Welcome, Admin!');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
}





public function logout(Request $request)
{
    Auth::guard('admin')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('admin.login.display')
        ->with('success', 'You have been logged out successfully.');
}


//add tesda officer
public function addTesdaOfficer(Request $request) {
    $request->validate([
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|email|unique:tesda_officers,email',
        'temporary_password' => 'required|string|min:8',
        'status' => 'required|string|in:active,inactive',
    ]);

    $tesdaOfficer = new AddTesdaOfficer();
    $tesdaOfficer->first_name = $request->first_name;
    $tesdaOfficer->last_name = $request->last_name;
    $tesdaOfficer->email = $request->email;
    $tesdaOfficer->password = Hash::make($request->temporary_password);
    $tesdaOfficer->status = $request->status;
    $tesdaOfficer->save();

    return redirect()->route('admin.homepage.display')->with('success', 'Tesda Officer added successfully!');

}

public function updateTesdaOfficer(Request $request , $officer_id) {

    $request->validate([
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'email' => 'required|email',
        'password' => 'required|string',
        'status' => 'required|string|in:active,inactive',
    ]);


    $tesdaOfficer = AddTesdaOfficer::find($officer_id);
    $tesdaOfficer->first_name = $request->first_name;
    $tesdaOfficer->last_name = $request->last_name;
    $tesdaOfficer->email = $request->email;
    $tesdaOfficer->password = Hash::make($request->password);
    $tesdaOfficer->status = $request->status;
    $tesdaOfficer->save();

    return redirect()->route('admin.homepage.display')->with('success', 'Tesda Officer updated successfully!');


}


//delete tesda officer
public function deleteTesdaOfficer($officer_id) {
    $tesdaOfficer = AddTesdaOfficer::find($officer_id);
    if ($tesdaOfficer) {
        $tesdaOfficer->delete();
        return redirect()->back()->with('success', 'Tesda Officer deleted successfully.');
    } else {
        return redirect()->back()->with('error', 'Tesda Officer not found.');
    }

}



}