<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\SSOController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UsersManageRoleController extends Controller
{
    public function home(){
       
        if(Gate::allows('admin')){
            $users = DB::table("user_role")->get();
        }
    
        if(!isset($users)){
            return view('error-page.error405');
        }
        //---------------------------------------
        $dep = [];
        $query = DB::table("depart")->get();
        foreach($query as $item) {
            $dep[$item->sso] = $item->depart_name;
        }

        $role = [];
        $query = DB::table("ref_role")->get();
        foreach($query as $item) {
            $role[$item->id] = $item->name;
        }
        //---------------------------------------
        return view('manuser.home', [
            "dep" => $dep,
            "role" => $role,
            "users"  =>  $users,
        ]);
    }

    public function insert(Request $request){
        try {
            $data = [];
            $data['cid'] = $request->cid;
            $data['name'] = $request->name;
            $data['dep_id'] = $request->dep_id;
            $data['role'] = $request->role;
            DB::table("user_role")->insert($data);
            return redirect()->route('manuser.home',['Success'=>"บันทึกสำเร็จ"]);
        }catch (Exception $e) {
            return redirect()->back()->with(['Error'=>'บันทึกไม่สำเร็จ']);
        }  
    }

    public function update(Request $request, $id){
        try {
            $data = [];
            $data['role'] = $request->role;
            DB::table("user_role")->where('id', $id)->update($data);
            return redirect()->route('manuser.home',['Success'=>"บันทึกสำเร็จ"]);
        }catch (Exception $e) {
            return redirect()->back()->with(['Error'=>'อัพเดทไม่สำเร็จ']);
        } 
    }

    public function delete($id){
        try {
            DB::table("user_role")->where('id', $id)->delete();
            return redirect()->route('manuser.home',['Success'=>"ลบสำเร็จ"]);
        }catch (Exception $e) {
            return redirect()->back()->with(['Error'=>'ลบไม่สำเร็จ']);
        } 
    }

    //ajax
    public function user_detail($cid) {
        $sso = new SSOController;
        $data = $sso->ProfileData($cid);
        return response()->json(['data'=>json_encode($data, JSON_UNESCAPED_UNICODE)]);
    }

    public function user_switch($id) {
        session()->put('curr_role', $id);
        return response()->json(['massage'=>'success']);
    }
}
