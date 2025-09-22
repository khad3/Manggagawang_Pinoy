<?php

namespace App\Http\Controllers\TermsAndCondition;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TermAnfConditionController extends Controller
{
    
      public function termsandconditions(){
        return view('terms&condition.terms_condition');
    }

    public function privacyPolicy(){
        return view('terms&condition.privacy_policy');
    }


    public function dataSharing(){
        return view('terms&condition.data_sharing');
    }

}
