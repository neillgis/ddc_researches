<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CmsHelper;
use App\Http\Controllers\API\SSOController;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Gate;


class UsersManageController extends Controller
{

    // MANAGMENT Table "USERS" for ADMIN Only
    public function users_manage(Request $request){

      if(Gate::allows('manager') || Gate::allows('admin')){
        $users = DB::table('users')
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

    public function users_manage_backtomem($id){
      try {
          DB::table('users')
          ->where('id', $id)
          ->update([
            "deleted_users"  =>  NULL,
          ]);
          return redirect()->route('admin.users_manage');
      }catch (Exception $e) {
          return redirect()->back()->with(['error'=>'ลบไม่สำเร็จ']);
      } 
    }

    public function users_manage_outdb($id){
      // try {
      //   DB::table('users')
      //     ->where('id', $id)
      //     ->delete();
      //   return redirect()->route('admin.users_manage');
      // }catch (Exception $e) {
      //     return redirect()->back()->with(['error'=>'ลบไม่สำเร็จ']);
      // } 
    }

    public function users_manage_update($id){
      $query = DB::table('users')->select("idCard")->where('id', $id)->first();
      if( !empty($query) ) {
        $cid = $query->idCard;

        $sso = new SSOController;
        $data = $sso->ProfileData($cid);
        if( empty($data) ) {
          try {
            DB::table('users')
              ->where('id', $id)
              ->update([
                "deleted_users"  =>  Carbon::now()
              ]);
              return redirect()->route('admin.users_manage');
          }catch (Exception $e) {
              return redirect()->back()->with(['error'=>'ลบไม่สำเร็จ']);
          } 

        }else{

          $query =  DB::table('depart')->select("depart_name")->where("sso", $data['dep_id'])->first();
          $dep_name = empty( $query ) ? NULL : $query->depart_name;
          
          try {
            DB::table('users')
                ->where('id', $id)
                ->update([
                  "fname"  =>  $data['fname'],
                  "lname"  =>  $data['lname'],
                  "position"  =>  $data['position'],
                  "positionLevel"  =>  $data['positionLevel'],
                  "dept_id" => $data['dep_id'],
                  "deptName" => $dep_name,
                  "email" => $data['email']
                ]);
            return redirect()->route('admin.users_manage');
          }catch (Exception $e) {
              return redirect()->back()->with(['error'=>'ลบไม่สำเร็จ']);
          } 
        }

        
      }
    

    
    }
}
