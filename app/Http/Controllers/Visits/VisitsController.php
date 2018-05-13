<?php

namespace App\Http\Controllers\Visits;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VisitsController extends Controller
{
    public function checkin(Request $request){
      return view('visits.checkin');
    }
}
