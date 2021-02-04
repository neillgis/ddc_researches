<?php

namespace App\Http\Controllers;

class ProfileController extends Controller

{
  public function index(){
    return view('frontend.profile');
  }

  // public function error(){
  //   return view('frontend.error404');
  // }

}
