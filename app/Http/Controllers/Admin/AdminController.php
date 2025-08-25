<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin\AccountAdminModel as Admin;
use App\Models\Admin\AddTesdaOfficerModel as AddTesdaOfficer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


//Employer Model
use App\Models\Employer\AccountInformationModel as Employer;
//Applicants Model
use App\Models\Applicant\RegisterModel;
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
    ));
}

//update the credentials of the tesda officer
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


}