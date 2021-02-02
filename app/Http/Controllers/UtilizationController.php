<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\util;
use App\research;
use Storage;
use File;
use Auth;
use app\Exceptions\Handler;
use Illuminate\Support\Facades\Route;


class UtilizationController extends Controller
{


  // public function util(){
  //   return view('frontend.util');
  // }


  public function table_util(){
// SUM BOX ------------------------------------------------------------------------>
  if(Auth::hasRole('manager')){
    // โครงการที่นำไปใช้ประโยชน์ทั้งหมด db_utilization -> โดย count id (All Record) --------->
    $Total_util = DB::table('db_utilization')
                    -> select('pro_id','util_type')
                    ->get()->count();

  }elseif(Auth::hasRole('admin')) {
    $Total_util = DB::table('db_utilization')
                    -> select('pro_id','util_type')
                    ->get()->count();
  }else {
    $Total_util = DB::table('db_utilization')
                    -> select('pro_id','util_type')
                    -> where ('users_id', Auth::user()->preferred_username)
                    ->get()->count();
  }
// dd($Total_util);


  if(Auth::hasRole('manager')){
    // โครงการที่นำไปใช้ประโยชน์เชิงวิชาการ db_utilization -> โดย count id -> util_type = เชิงวิชาการ --------->
    $Total_academic_util = DB::table('db_utilization')
                          -> select('pro_id','util_type')
                          -> where ('util_type', '=', 'เชิงวิชาการ')
                          ->get()->count();

  }elseif(Auth::hasRole('admin')) {
    $Total_academic_util = DB::table('db_utilization')
                          -> select('pro_id','util_type')
                          -> where ('util_type', '=', 'เชิงวิชาการ')
                          ->get()->count();

  }else {
    $Total_academic_util = DB::table('db_utilization')
                          -> select('pro_id','util_type')
                          -> where ('util_type', '=', 'เชิงวิชาการ')
                          -> where ('users_id', Auth::user()->preferred_username)
                          ->get()->count();
  }
// dd($Total_academic_util);


  if(Auth::hasRole('manager')){
    // โครงการที่นำไปใช้ประโยชน์เชิงสังคม/ชุมชน db_utilization -> โดย count id -> util_type = เชิงสังคม/ชุมชน --------->
    $Total_social_util = DB::table('db_utilization')
                          -> select('pro_id','util_type')
                          -> where ('util_type', '=', 'เชิงสังคม/ชุมชน')
                          ->get()->count();

  }elseif(Auth::hasRole('admin')) {
    $Total_social_util = DB::table('db_utilization')
                          -> select('pro_id','util_type')
                          -> where ('util_type', '=', 'เชิงสังคม/ชุมชน')
                          ->get()->count();

  }else {
    $Total_social_util = DB::table('db_utilization')
                          -> select('pro_id','util_type')
                          -> where ('util_type', '=', 'เชิงสังคม/ชุมชน')
                          -> where ('users_id', Auth::user()->preferred_username)
                          ->get()->count();
  }
// dd($Total_social_util);


  if(Auth::hasRole('manager')){
    // โครงการที่นำไปใช้ประโยชน์เชิงนโยบาย db_utilization -> โดย count id -> util_type = เชิงนโยบาย --------->
    $Total_policy_util = DB::table('db_utilization')
                          -> select('pro_id','util_type')
                          -> where ('util_type', '=', 'เชิงนโยบาย')
                          ->get()->count();

  }elseif(Auth::hasRole('admin')) {
    $Total_policy_util = DB::table('db_utilization')
                          -> select('pro_id','util_type')
                          -> where ('util_type', '=', 'เชิงนโยบาย')
                          ->get()->count();

  }else {
    $Total_policy_util = DB::table('db_utilization')
                          -> select('pro_id','util_type')
                          -> where ('util_type', '=', 'เชิงนโยบาย')
                          -> where ('users_id', Auth::user()->preferred_username)
                          ->get()->count();
  }
// dd($Total_policy_util);


  if(Auth::hasRole('manager')){
    // โครงการที่นำไปใช้ประโยชน์เชิงนโยบาย db_utilization -> โดย count id -> util_type = เชิงพาณิชย์ --------->
    $Total_commercial_util = DB::table('db_utilization')
                          -> select('pro_id','util_type')
                          -> where ('util_type', '=', 'เชิงพาณิชย์')
                          ->get()->count();

  }elseif(Auth::hasRole('admin')) {
    $Total_commercial_util = DB::table('db_utilization')
                          -> select('pro_id','util_type')
                          -> where ('util_type', '=', 'เชิงพาณิชย์')
                          ->get()->count();

  }else {
    $Total_commercial_util = DB::table('db_utilization')
                          -> select('pro_id','util_type')
                          -> where ('util_type', '=', 'เชิงพาณิชย์')
                          -> where ('users_id', Auth::user()->preferred_username)
                          ->get()->count();
  }
// dd($Total_commercial_util);

// END SUM BOX ------------------------------------------------------------------------>


// TABLE LIST--------------------------------------------------------------------------->

  // SELECT FORM --------------------------------------------------------------------->
  if(Auth::hasRole('manager')) {
    $query_research   = research::select ('id','pro_name_th','pro_name_en','users_id','users_name')
                                ->get();

  }elseif(Auth::hasRole('admin')) {
    $query_research   = research::select ('id','pro_name_th','pro_name_en','users_id','users_name')
                                ->get();

  }else {
    $query_research   = research::select ('id','pro_name_th','pro_name_en','users_id','users_name')
                                -> where ('users_id', Auth::user()->preferred_username)
                                ->get();
  }


    $query_util_type = ['เชิงวิชาการ'      => 'เชิงวิชาการ',
                       'เชิงสังคม/ชุมชน'   => 'เชิงสังคม/ชุมชน',
                       'เชิงนโยบาย'      => 'เชิงนโยบาย',
                       'เชิงพาณิชย์'      => 'เชิงพาณิชย์'
               ];


  // SELECT TABLE ----------------------------------------------------------------------->
  if(Auth::hasRole('manager')){
    $query_util = DB::table('db_utilization')
                    -> join ('db_research_project', 'db_utilization.pro_id', '=', 'db_research_project.id')
                    -> select ('db_utilization.id','db_utilization.util_type','db_utilization.files',
                               'db_utilization.verified',
                               'db_research_project.pro_name_th','db_research_project.pro_name_en',
                               \DB::raw('(CASE
                                             WHEN db_utilization.verified = "1" THEN "ตรวจสอบแล้ว"
                                             ELSE "รอการตรวจสอบ"
                                             END) AS verified'
                               ))
                    ->get();
// dd($query_util);
  }elseif(Auth::hasRole('admin')){
    $query_util = DB::table('db_utilization')
                    -> join ('db_research_project', 'db_utilization.pro_id', '=', 'db_research_project.id')
                    -> select ('db_utilization.id','db_utilization.util_type','db_utilization.files',
                                'db_utilization.verified',
                                'db_research_project.pro_name_th','db_research_project.pro_name_en',
                               \DB::raw('(CASE
                                             WHEN db_utilization.verified = "1" THEN "ตรวจสอบแล้ว"
                                             ELSE "รอการตรวจสอบ"
                                             END) AS verified'
                               ))
                    ->get();

  }else {
    $query_util = DB::table('db_utilization')
                    -> join ('db_research_project', 'db_utilization.pro_id', '=', 'db_research_project.id')
                    -> select ('db_utilization.id','db_utilization.util_type','db_utilization.files',
                                'db_utilization.verified',
                                'db_research_project.pro_name_th','db_research_project.pro_name_en',
                               \DB::raw('(CASE
                                             WHEN db_utilization.verified = "1" THEN "ตรวจสอบแล้ว"
                                             ELSE "รอการตรวจสอบ"
                                             END) AS verified'
                               ))
                    -> where ('db_utilization.users_id', Auth::user()->preferred_username)
                    ->get();
  }
  // dd($query_util);



    return view('frontend.util',
    [
      'Total_util'             => $Total_util,
      'Total_academic_util'    => $Total_academic_util,
      'Total_social_util'      => $Total_social_util,
      'Total_policy_util'      => $Total_policy_util,
      'Total_commercial_util'  => $Total_commercial_util,
      // SELECT FORM
      'form_research'          => $query_research,
      'form_util_type'         => $query_util_type,
      // SELECT TABLE
      'table_util'             => $query_util,


    ]);
}


    // EDIT ---------------------------------------------------------------->
  public function edit_util(Request $request){

    $edit = util::where('id' , $request->id)
                ->first();

    $edit_1 = DB::table('db_utilization')
                -> join ('db_research_project', 'db_utilization.pro_id', '=', 'db_research_project.id')
                -> select ('db_utilization.id','db_utilization.util_type','db_utilization.files',
                           'db_utilization.verified',
                           'db_research_project.pro_name_th','db_research_project.pro_name_en',
                           'db_research_project.users_id','db_research_project.users_name')
                -> where ('db_utilization.id' , $request->id)
                ->first();

    $edit_2 = ['เชิงวิชาการ'        => 'เชิงวิชาการ',
               'เชิงสังคม/ชุมชน'    => 'เชิงสังคม/ชุมชน',
               'เชิงนโยบาย'        => 'เชิงนโยบาย',
               'เชิงพาณิชย์'        => 'เชิงพาณิชย์'
               ];

     return view('frontend.util_edit',
       [
        'edit_util'       => $edit,
        'edit_data'       => $edit_1,
        'edit_utiltype'   => $edit_2
       ]);
  }
    // END EDIT ------------------------------------------------------------>


    // INSERT ------------------------------------------------------------->
      public function insert(Request $request){

        $data_post = [
          "users_id"          => Auth::user()->preferred_username,
          "pro_id"            => $request->pro_id,
          "util_type"         => $request->util_type,
          "files"             => $request->files,
          "created_at"        => date('Y-m-d H:i:s')
        ];

        if ($request->file('files')->isValid()) {
              //TAG input [type=file] ดึงมาพักไว้ในตัวแปรที่ชื่อ files
            $file=$request->file('files');
              //ตั้งชื่อตัวแปร $file_name เพื่อเปลี่ยนชื่อ + นามสกุลไฟล์
            $name='file_'.date('dmY_His');
            $file_name = $name.'.'.$file->getClientOriginalExtension();
              // upload file ไปที่ PATH : public/file_upload
            $path = $file->storeAs('public/file_upload_util',$file_name);
            $data_post['files'] = $file_name;
        }

        $insert = util::insert($data_post);
        // $insert = DB::table('person_ddc_table')->insert($data_post);  /*person_ddc_table คือ = ชื่อ table*/

        if($insert){
          //return Sweet Alert
          return redirect()->route('page.util')->with('swl_add', 'บันทึกแล้ว');
      }else{
          return redirect()->back()->with('swl_err', 'บันทึกแล้ว');
      }
    }

    // END INSERT ----------------------------------------------------------->


    // SAVE ----------------------------------------------------------------->
  public function save_util(Request $request){
    // dd($request);
    $update = DB::table('db_utilization')
                  -> where ('id',$request->id)
                  -> update ([
                            'util_type'       => $request->util_type
                            ]);


    if($update){
       return redirect()->route('page.util')->with('swl_update','แก้ไขข้อมูลสำเร็จ');
    } else {
       return redirect()->back()->with('swl_errs','แก้ไขข้อมูลไม่สำเร็จ');
    }
  }
    // END SAVE ------------------------------------------------------------>


    //  -- DOWNLOAD --
    public function DownloadFile(Request $request){
      $query = DB::table('db_utilization')
                    ->select('id', 'files')
                    ->where('id', $request->id)
                    ->first();

      if(!$query) return abort(404);

      $path = $query->files;

      if($path){
        return Storage::disk('util')->download($path);
      }else {
        return view('error-page.error404');
      }

    }
    //  -- END DOWNLOAD --


    //  -- VERIFIED --
    public function action_verified(Request $request){

        //UPDATE db_research_project
        $verified = DB::table('db_utilization')
                  ->where('id', $request->id)
                  ->update(['verified' => "1"]);
                  // ->get();

         // dd($verified);

        if(!$verified = '1'){
          return abort(404);
        }

        if($verified) {
            return redirect()->back()->with('swl_verified', 'ลบข้อมูลเรียบร้อยแล้ว');
        }else {
            return redirect()->back()->with('swl_del', 'ไม่สามารถลบข้อมูลได้');
        }

      }
      //  -- END VERIFIED --


// END TABLE LIST------------------------------------------------------------------>

}
