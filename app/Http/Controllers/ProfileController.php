<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\member;
use Auth;

class ProfileController extends Controller

{

    //  -- PROFILE --
    public function index(){

      $data = DB::table('users')
            ->select('id', 'idCard', 'nriis_id', 'orcid_id',
                    // \DB::raw('(CASE
                    //               WHEN verified = "1" THEN "ตรวจสอบแล้ว"
                    //               ELSE "รอตรวจสอบ"
                    //               END) AS verified'
                    // )
                    )
            ->where('idCard', Auth::user()->preferred_username)
            ->get();
// dd($data);

      return view('frontend.profile',
        [
         'data'          => $data,
        ]);
    }


  //   //  -- SELECT --
  //   public function profiles(Request $request){
  //     $data = member::select('id', 'nriis_id', 'orcid_id')
  //           // ->where('id', Auth::user()->preferred_username)
  //           ->get();
  //
  //   dd($data);
  //
  //   return view('frontend.profile',
  //     [
  //      'data'          => $data,
  //     ]);
  // }


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
