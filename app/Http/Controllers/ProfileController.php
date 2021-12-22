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
            ->select('id', 'idCard', 'nriis_id', 'orcid_id')
            ->where('idCard', Auth::user()->preferred_username)
            ->get();

      $edit_profile = DB::table('users')
                    ->where('idCard', Auth::user()->preferred_username)
                    ->first();
                // dd($edit_profile);


      return view('frontend.profile',
        [
           'data'          => $data,
           'edit_profile'  => $edit_profile,
        ]);
    }

    public function save_update_profile(Request $request){

      $update_profile = DB::table('users')
                            ->where('idCard', Auth::user()->preferred_username)
                            ->update([
                                        'nriis_id'  =>  $request->nriis_id,
                                        'orcid_id'  =>  $request->orcid_id
                                    ]);
                  // dd($update_profile);

      if($update_profile){
          session()->put('messages', 'okkkkkayyyyy');
          return redirect()->route('page.profile');
      }else {
        return redirect()->back()->with('swl_err', 'บันทึกไม่สำเร็จ');
      }
    }



    //  -- INSERT  --
    public function insert(Request $request){

      $data_post = [
        "title"        => $request->title,
        "fname"         => $request->fname,
        "lname"         => $request->lname,
        "idCard"        => $request->idCard,
        "sex"           => $request->sex,
        "mobile"        => $request->mobile,
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
