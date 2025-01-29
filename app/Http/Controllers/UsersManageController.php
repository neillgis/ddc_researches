<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CmsHelper;
use App\Http\Controllers\API\SSOController;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class UsersManageController extends Controller
{

    // MANAGMENT Table "USERS" for ADMIN Only
    public function users_manage($status=1){

      if(Gate::allows('manager') || Gate::allows('admin')){
        if( $status == 1 ) {
          $users = DB::table('users')
                ->whereNull('deleted_users')
                ->orderBy('edit_date', 'ASC')
                ->orderBy('id', 'DESC')
                ->get();
        }else{
          $users = DB::table('users')
                ->whereNotNull('deleted_users')
                ->orderBy('edit_date', 'ASC')
                ->orderBy('id', 'DESC')
                ->get();
        }
      }

      if(!isset($users)){
          return view('error-page.error405');
      }

      $dep = DB::table('depart')
      ->orderBy('depart_type')
      ->orderByRaw(" CONVERT( depart_name USING tis620 ) ASC ")
      ->get();

      return view('frontend.users_manage', [
          "status" => $status,
          "users"  =>  $users,
          "dep" => $dep
      ]);
    }


    public function users_manage_delete($users_id){

        $delete_users = DB::table('users')
                          ->where('id', $users_id)
                          ->update([
                                      "deleted_users"  =>  Carbon::now(),
                                      "edit_date"  =>  Carbon::now(),
                                      "edit_user"  =>  Auth::user()->preferred_username,
                                  ]);

      if($delete_users){
        session()->put('deleted_msg', 'okay');
          return redirect()->route('admin.users_manage');
      }else {
          return redirect()->back()->with('error', 'not_okay');
      }
    }

    public function ajax_users_manage_delete($user_id) {
      try {
          DB::table('users')
          ->where('id', $user_id)
          ->update([
            "deleted_users"  =>  Carbon::now(),
            "edit_date"  =>  Carbon::now(),
            "edit_user"  =>  Auth::user()->preferred_username,
          ]);
          return response()->json(['msg'=>'ok', 'data'=>CmsHelper::DateThai(date('Y-m-d'))]);
      }catch (Exception $e) {
          return response()->json(['msg'=>'err']);
      }
    }

    public function users_manage_backtomem($id){
      try {
          DB::table('users')
          ->where('id', $id)
          ->update([
            "deleted_users"  =>  NULL,
            "edit_date"  =>  Carbon::now(),
            "edit_user"  =>  Auth::user()->preferred_username,
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

    public function users_manage_update(Request $request, $user_id){
        try {
          $data = [];
          $data['title'] = $request->title;
          $data['fname'] = $request->fname;
          $data['lname'] = $request->lname;
          $data['dept_id'] = $request->dep_id;
          $data['deptName'] = $request->dep_name;
          $data['position'] = $request->position;
          $data['edit_date'] = Carbon::now();
          $data['edit_user'] = Auth::user()->preferred_username;

          DB::table('users')
              ->where('id', $user_id)
              ->update($data);
          return redirect()->route('admin.users_manage');
        }catch (Exception $e) {
            return redirect()->back()->with(['error'=>'ลบไม่สำเร็จ']);
        }
    }

    public function ajax_users_manage_update($user_id){
      $request = json_decode($_GET['obj']);
      $request = json_decode($request);

      try {
        $data = [];
        $data['title'] = $request->title;
        $data['fname'] = $request->fname;
        $data['lname'] = $request->lname;
        $data['dept_id'] = $request->dep_id;
        $query = DB::table("depart")->select("depart_name")->where("sso", $request->dep_id)->first();
        $data['deptName'] = empty($query)?"":$query->depart_name;
        $data['position'] = $request->position;
        $data['edit_date'] = Carbon::now();
        $data['edit_user'] = Auth::user()->preferred_username;

        DB::table('users')
            ->where('id', $user_id)
            ->update($data);

        return response()->json([
          "user_id" => $user_id,
          'msg'=>'ok',
          'data'=>CmsHelper::DateThai(date('Y-m-d'))
        ]);
      }catch (Exception $e) {
        return response()->json(['msg'=>'err']);
      }
  }
}
