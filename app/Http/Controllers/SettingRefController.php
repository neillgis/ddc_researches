<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class SettingRefController extends Controller
{
    public function setdep_home(){
       
        if(Gate::allows('admin')){
            $dep = DB::table("depart")->get();
        }
    
        if(!isset($dep)){
            return view('error-page.error405');
        }  //---------------------------------------
        return view('setting.setdep', [
            "dep" => $dep
        ]);
    }

    public function setdep_insert(Request $request){
        try {
            $data = [];
            $data['sso'] = $request->sso_id;
            $data['depart_name'] = $request->depart_name;
            $data['depart_type'] = $request->depart_type;
            DB::table("depart")->insert($data);
            return redirect()->back()->with(['Success'=>"บันทึกสำเร็จ"]);
        }catch (Exception $e) {
            return redirect()->back()->with(['Error'=>'บันทึกไม่สำเร็จ']);
        }  
    }

    public function setdep_update(Request $request, $id){
        try {
            $data = [];
            $data['sso'] = $request->sso_id;
            $data['depart_name'] = $request->depart_name;
            $data['depart_type'] = $request->depart_type;
            DB::table("depart")->where('id', $id)->update($data);
            return redirect()->back()->with(['Success'=>"อัพเดทสำเร็จ"]);
        }catch (Exception $e) {
            return redirect()->back()->with(['Error'=>'อัพเดทไม่สำเร็จ']);
        } 
    }
}