<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\member;

class ProfileController extends Controller

{

  //  -- Profile --
  public function index(){
    return view('frontend.profile');
  }


  //  -- INSERT  --
  public function insert(Request $request){

    $data_post = [
      "title"        => $request->title,
      "fname"         => $request->fname,
      "lname"         => $request->lname,
      "idCard"        => $request->idCard,
      "sex"           => $request->sex,
      "email"         => $request->email,
      "educationLevel" => $request->educationLevel,
      "deptName"      => $request->deptName,
      "position"      => $request->position,
      "positionLevel" => $request->positionLevel,
      "nriis_id"      => $request->nriis_id,
      "orcid_id"      => $request->orcid_id,
      // "created_at"    => date('Y-m-d H:i:s')
    ];

    // dd($data_post);

    $output = member::insert($data_post);

    if($output){
        session()->put('messages', 'okkkkkayyyyy');
        return redirect()->route('page.profile');
    }else{
        return redirect()->back()->with('messagesx', 'not_okkkkkayyyyy');
    }
  }
  //  -- END INSERT --

}
