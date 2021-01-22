<?php

namespace App\Http\Controllers;

class KeycloakDemoController extends Controller
{
  public function index(){
    return view('layout.keycloak');
  }
}
