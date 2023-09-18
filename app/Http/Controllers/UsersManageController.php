<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CmsHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;


class UsersManageController extends Controller
{

    // MANAGMENT Table "USERS" for ADMIN Only
    public function users_manage(Request $request){

      if(Gate::allows('manager') || Gate::allows('admin')){
        $users = DB::table('users')
                  ->whereNull('deleted_users')
                  ->orderBy('id', 'DESC')
                  ->get();
      }

      if(!isset($users)){
          return view('error-page.error405');
      }


      return view('frontend.users_manage', [
          "users"  =>  $users,
      ]);
    }


    public function users_manage_delete(Request $request){

        $delete_users = DB::table('users')
                          ->where('id', $request->users_id)
                          ->update([
                                      "deleted_users"  =>  Carbon::now(),
                                  ]);

      if($delete_users){
        session()->put('deleted_msg', 'okay');
          return redirect()->route('admin.users_manage');
      }else {
          return redirect()->back()->with('error', 'not_okay');
      }
    }


}
