<?php

namespace App\Http\Controllers\TesdaOfficer;

use App\Http\Controllers\Controller;
use App\Models\Admin\AddTesdaOfficerModel;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

class TesdaOfficerController extends Controller
{
    
    public function homepage()
    {
        return view('tesdaofficer.homepage.homepage');
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
