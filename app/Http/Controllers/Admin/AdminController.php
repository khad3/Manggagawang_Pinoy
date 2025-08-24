<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin\AccountAdminModel as Admin;
use App\Models\Admin\AddTesdaOfficerModel as AddTesdaOfficer;
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
    if (!session()->has('id')) {
        return redirect()->route('admin.login.display');
    }

    $retrieveAdmin = Admin::where('id', session('id'))->first();

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
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    // Find the admin by email
    $admin = Admin::where('email', $request->email)->first();

    // Check if admin exists and password matches
    if (!$admin || !Hash::check($request->password, $admin->password)) {
        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->onlyInput('email');
    }

    //insert the login time
    $admin->last_login = Carbon::now();
    $admin->save();
    

    // Store admin session manually
    session([
        'id' => $admin->id,
        'name' => $admin->name, 
    ]);

    return redirect()->route('admin.homepage.display')->with('success', 'Welcome, Admin!');
}


public function logout()
{
    // If you want to update the last_login to null (or current timestamp)
    if (auth()->check()) {
        $admin = auth('admin'); // or use auth('admin')->user() if you use guards
        $admin->last_login = null; // or now() if you want to log the current time
        $admin->save();
    }

    // Clear all session data
    session()->flush();

    // Logout the admin from guard (optional if you're using guard)
    auth('admin')->logout(); // or auth('admin')->logout();

    // Redirect to login page
    return redirect()->route('admin.login.display');
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