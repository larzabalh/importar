<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;


class SiteController extends Controller
{
    public function index(){
    	return  redirect()->route('admin');
    	//return view('layouts.template');

    }


}
