<?php

namespace App\Http\Controllers;

class KeycloakDemoController extends Controller

{
  public function index(){
    return view('layout.keycloak');
  }

  // public function error(){
  //   return view('frontend.error404');
  // }

  public function logout() {
    session()->forget('role');
    return redirect()->route('keycloak.logout');
  }

}
