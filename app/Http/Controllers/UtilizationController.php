<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\util;
use App\research;
use App\NotificationAlert;
use Storage;
use File;
use Carbon\Carbon;
use app\Exceptions\Handler;
use Illuminate\Support\Facades\Route;
use App\Mail\utilizationCommentMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use DateTime;


class UtilizationController extends Controller
{


  // public function util(){
  //   return view('frontend.util');
  // }


  public function table_util(){

    // ----------- SUM BOX ------------>

    // โครงการที่นำไปใช้ประโยชน์ทั้งหมด db_utilization -> โดย count id (All Record) --------->
      if(Gate::allows('manager')){
        $Total_util = DB::table('db_utilization')
                        ->select('pro_id','util_type')
                        ->whereNull('deleted_at')
                        ->get()
                        ->count();

      }elseif(Gate::allows('departments')) {
        $Total_util = DB::table('db_utilization')
                        ->leftjoin('users', 'db_utilization.users_id', '=', 'users.idCard')
                        ->select( 'db_utilization.pro_id',
                                  'db_utilization.util_type',
                                  'users.idCard',
                                  'users.deptName',
                                )
                        ->where('users.dept_id', Session::get('dep_id'))
                        ->whereNull('deleted_at')
                        ->get()
                        ->count();
      }else {
        $Total_util = DB::table('db_utilization')
                        ->select('pro_id','util_type')
                        ->where('users_id', Auth::user()->preferred_username)
                        ->whereNull('deleted_at')
                        ->get()
                        ->count();
      }




    // โครงการที่นำไปใช้ประโยชน์ทั้งหมด ที่ผ่านการตรวจสอบแล้ว db_utilization -> โดย count id (All Record) -> 'verified', ['1'] --------->
    if(Gate::allows('manager')){
      $Total_util_verify = DB::table('db_utilization')
                            ->select('pro_id','util_type')
                            ->whereIn('verified', ['1'])
                            ->whereNull('deleted_at')
                            ->get()
                            ->count();

    }elseif(Gate::allows('departments')) {
      $Total_util_verify = DB::table('db_utilization')
                            ->leftjoin('users', 'db_utilization.users_id', '=', 'users.idCard')
                            ->select( 'db_utilization.pro_id',
                                      'db_utilization.util_type',
                                      'db_utilization.verified',
                                      'users.idCard',
                                      'users.deptName',
                                    )
                            ->whereIn('verified', ['1'])
                            ->where('users.dept_id', Session::get('dep_id'))
                            ->whereNull('deleted_at')
                            ->get()
                            ->count();

    }else {
      $Total_util_verify = DB::table('db_utilization')
                            ->select('pro_id','util_type')
                            ->whereIn('verified', ['1'])
                            ->where('users_id', Auth::user()->preferred_username)
                            ->whereNull('deleted_at')
                            ->get()
                            ->count();
    }



    // โครงการที่นำไปใช้ประโยชน์เชิงนโยบาย db_utilization -> โดย count id -> util_type = เชิงนโยบาย --------->
    if(Gate::allows('manager')){
      $Total_policy_util = DB::table('db_utilization')
                            -> select('pro_id','util_type')
                            ->where('util_type', '=', 'เชิงนโยบาย')
                            ->whereIn('verified', ['1'])
                            ->whereNull('deleted_at')
                            ->get()
                            ->count();

    }elseif(Gate::allows('departments')) {
      $Total_policy_util = DB::table('db_utilization')
                            ->leftjoin('users', 'db_utilization.users_id', '=', 'users.idCard')
                            ->select( 'db_utilization.pro_id',
                                      'db_utilization.util_type',
                                      'db_utilization.verified',
                                      'users.idCard',
                                      'users.deptName',
                                    )
                            ->where('util_type', '=', 'เชิงนโยบาย')
                            ->whereIn('verified', ['1'])
                            ->where('users.dept_id', Session::get('dep_id'))
                            ->whereNull('deleted_at')
                            ->get()
                            ->count();

    }else {
      $Total_policy_util = DB::table('db_utilization')
                            ->select('pro_id','util_type')
                            ->where('util_type', '=', 'เชิงนโยบาย')
                            ->whereIn('verified', ['1'])
                            ->where('users_id', Auth::user()->preferred_username)
                            ->whereNull('deleted_at')
                            ->get()
                            ->count();
    }




    // โครงการที่นำไปใช้ประโยชน์เชิงวิชาการ db_utilization -> โดย count id -> util_type = เชิงวิชาการ --------->
      if(Gate::allows('manager')){
        $Total_academic_util = DB::table('db_utilization')
                              -> select('pro_id','util_type')
                              -> where ('util_type', '=', 'เชิงวิชาการ')
                              -> whereIn ('verified', ['1'])
                              ->whereNull('deleted_at')
                              ->get()
                              ->count();

      }elseif(Gate::allows('departments')) {
        $Total_academic_util = DB::table('db_utilization')
                                  ->leftjoin('users', 'db_utilization.users_id', '=', 'users.idCard')
                                  ->select( 'db_utilization.pro_id',
                                            'db_utilization.util_type',
                                            'db_utilization.verified',
                                            'users.idCard',
                                            'users.deptName',
                                          )
                                  ->where('util_type', '=', 'เชิงวิชาการ')
                                  ->whereIn('verified', ['1'])
                                  ->where('users.dept_id', Session::get('dep_id'))
                                  ->whereNull('deleted_at')
                                  ->get()
                                  ->count();

      }else {
        $Total_academic_util = DB::table('db_utilization')
                              -> select('pro_id','util_type')
                              -> where ('util_type', '=', 'เชิงวิชาการ')
                              -> whereIn ('verified', ['1'])
                              -> where ('users_id', Auth::user()->preferred_username)
                              ->whereNull('deleted_at')
                              ->get()
                              ->count();
      }



      // โครงการที่นำไปใช้ประโยชน์เชิงสังคม/ชุมชน db_utilization -> โดย count id -> util_type = เชิงสังคม/ชุมชน --------->
      if(Gate::allows('manager')){
        $Total_social_util = DB::table('db_utilization')
                              -> select('pro_id','util_type')
                              -> where ('util_type', '=', 'เชิงสังคม/ชุมชน')
                              -> whereIn ('verified', ['1'])
                              ->whereNull('deleted_at')
                              ->get()
                              ->count();

      }elseif(Gate::allows('departments')) {
        $Total_social_util = DB::table('db_utilization')
                              ->leftjoin('users', 'db_utilization.users_id', '=', 'users.idCard')
                              ->select( 'db_utilization.pro_id',
                                        'db_utilization.util_type',
                                        'db_utilization.verified',
                                        'users.idCard',
                                        'users.deptName',
                                      )
                              ->where('util_type', '=', 'เชิงสังคม/ชุมชน')
                              ->whereIn('verified', ['1'])
                              ->where('users.dept_id', Session::get('dep_id'))
                              ->whereNull('deleted_at')
                              ->get()
                              ->count();

      }else {
        $Total_social_util = DB::table('db_utilization')
                              -> select('pro_id','util_type')
                              -> where ('util_type', '=', 'เชิงสังคม/ชุมชน')
                              -> whereIn ('verified', ['1'])
                              -> where ('users_id', Auth::user()->preferred_username)
                              ->whereNull('deleted_at')
                              ->get()
                              ->count();
      }



      // โครงการที่นำไปใช้ประโยชน์เชิงนโยบาย db_utilization -> โดย count id -> util_type = เชิงพาณิชย์ --------->
      if(Gate::allows('manager')){
        $Total_commercial_util = DB::table('db_utilization')
                              -> select('pro_id','util_type')
                              -> where ('util_type', '=', 'เชิงพาณิชย์')
                              -> whereIn ('verified', ['1'])
                              ->whereNull('deleted_at')
                              ->get()
                              ->count();

      }elseif(Gate::allows('departments')) {
        $Total_commercial_util = DB::table('db_utilization')
                                  ->leftjoin('users', 'db_utilization.users_id', '=', 'users.idCard')
                                  ->select( 'db_utilization.pro_id',
                                            'db_utilization.util_type',
                                            'db_utilization.verified',
                                            'users.idCard',
                                            'users.deptName',
                                          )
                                  ->where('util_type', '=', 'เชิงพาณิชย์')
                                  ->whereIn('verified', ['1'])
                                  ->where('users.dept_id', Session::get('dep_id'))
                                  ->whereNull('deleted_at')
                                  ->get()
                                  ->count();

      }else {
        $Total_commercial_util = DB::table('db_utilization')
                              ->select('pro_id','util_type')
                              ->where('util_type', '=', 'เชิงพาณิชย์')
                              ->whereIn('verified', ['1'])
                              ->where('users_id', Auth::user()->preferred_username)
                              ->whereNull('deleted_at')
                              ->get()
                              ->count();
      }

// ---------------- END SUM BOX ---------------->




// ---------------- TABLE LIST ---------------->
      if(Gate::allows('manager')) {
        $query_research   = research::select('id','pro_name_th','pro_name_en','users_id','users_name')
                                    ->where('users_id', Auth::user()->preferred_username)
                                    ->whereNull('deleted_at')
                                    ->get();

      }elseif(Gate::allows('admin')) {
        $query_research   = research::select('id','pro_name_th','pro_name_en','users_id','users_name')
                                    ->whereNull('deleted_at')
                                    ->get();

      }else {
        $query_research   = research::select('id','pro_name_th','pro_name_en','users_id','users_name')
                                    ->where('users_id', Auth::user()->preferred_username)
                                    ->whereNull('deleted_at')
                                    ->get();
      }

      $util_year = [];

      // Create a DateTime object for the current date/time
      $currentDate = new DateTime();

      // Get the current Gregorian year
      $currentGregorianYear = (int)$currentDate->format('Y');

      // Convert to Thai year by adding 543
      $currentThaiYear = $currentGregorianYear + 543;

      // Define a range: for example, 10 years back to 10 years ahead
      $startThaiYear = $currentThaiYear - 30;
      $endThaiYear   = $currentThaiYear;

      for ($year = $startThaiYear; $year <= $endThaiYear; $year++){
        $util_year[] = $year;
      };

      $query_util_type = ['เชิงนโยบาย'      => 'เชิงนโยบาย',
                          'เชิงวิชาการ'      => 'เชิงวิชาการ',
                          'เชิงสังคม/ชุมชน'   => 'เชิงสังคม/ชุมชน',
                          'เชิงพาณิชย์'      => 'เชิงพาณิชย์'
                 ];

       $verified = [ 1 => 'ตรวจสอบแล้ว', //verify
                     2 => 'อยู่ระหว่างตรวจสอบ', //process_checked
                     3 => 'อยู่ระหว่างแก้ไข', //process_editing
                     9 => 'ไม่ตรงเงื่อนไข', //no_conditions
                   ];

       $verified_departments = [ 2 => 'อยู่ระหว่างตรวจสอบ', //process_checked
                                 3 => 'อยู่ระหว่างแก้ไข', //process_editing
                               ];



  // ---------------- SELECT TABLE ---------------->
    if(Gate::allows('manager')){
        $query_util = DB::table('db_utilization')
                        ->join ('db_research_project', 'db_utilization.pro_id', '=', 'db_research_project.id')
                        ->leftjoin('users', 'db_utilization.users_id', '=', 'users.idCard')
                        ->select ( 'db_utilization.id',
                                   'db_utilization.users_id',
                                   'db_utilization.util_type',
                                   'db_utilization.files',
                                   'db_utilization.verified',
                                   'db_utilization.status',
                                   'db_utilization.util_year',
                                   'db_research_project.pro_name_th',
                                   'db_research_project.pro_name_en',
                                   'db_research_project.users_name',
                                   'db_research_project.pro_end_date',
                                   'users.deptName',
                                   // \DB::raw('(CASE
                                   //               WHEN db_utilization.verified = "1" THEN "ตรวจสอบแล้ว"
                                   //               ELSE "รอการตรวจสอบ"
                                   //               END) AS verified'
                                   // )
                                )
                        // ->whereNull('db_research_project.deleted_at')
                        ->whereNull('db_utilization.deleted_at')
                        ->orderBy('id', 'DESC')
                        ->get();

    }elseif(Gate::allows('departments')){
        $query_util = DB::table('db_utilization')
                        ->join ('db_research_project', 'db_utilization.pro_id', '=', 'db_research_project.id')
                        ->leftjoin('users', 'db_utilization.users_id', '=', 'users.idCard')
                        ->select ( 'db_utilization.id',
                                   'db_utilization.users_id',
                                   'db_utilization.util_type',
                                   'db_utilization.files',
                                   'db_utilization.verified',
                                   'db_utilization.status',
                                   'db_utilization.util_year',
                                   'db_research_project.pro_name_th',
                                   'db_research_project.pro_name_en',
                                   'db_research_project.users_name',
                                   'db_research_project.pro_end_date',
                                   'users.idCard',
                                   'users.deptName',
                                   'users.fname',
                                   'users.lname',
                                   // \DB::raw('(CASE
                                   //               WHEN db_utilization.verified = "1" THEN "ตรวจสอบแล้ว"
                                   //               ELSE "รอการตรวจสอบ"
                                   //               END) AS verified'
                                   // )
                                )
                        ->where('users.dept_id', Session::get('dep_id'))
                        // ->whereNull('db_research_project.deleted_at')
                        ->whereNull('db_utilization.deleted_at')
                        ->orderBy('id', 'DESC')
                        ->get();

    }else {
        $query_util = DB::table('db_utilization')
                        ->join ('db_research_project', 'db_utilization.pro_id', '=', 'db_research_project.id')
                        ->select ( 'db_utilization.id',
                                   'db_utilization.util_type',
                                   'db_utilization.files',
                                   'db_utilization.verified',
                                   'db_utilization.status',
                                   'db_utilization.util_year',
                                   'db_research_project.pro_name_th',
                                   'db_research_project.pro_name_en',
                                   'db_research_project.users_name',
                                   'db_research_project.pro_end_date',
                                   // \DB::raw('(CASE
                                   //               WHEN db_utilization.verified = "1" THEN "ตรวจสอบแล้ว"
                                   //               ELSE "รอการตรวจสอบ"
                                   //               END) AS verified'
                                   // )
                                   )
                        ->where('db_utilization.users_id', Auth::user()->preferred_username)
                        // ->whereNull('db_research_project.deleted_at')
                        ->whereNull('db_utilization.deleted_at')
                        ->orderBy('id', 'DESC')
                        ->get();
    }


        $query9 = DB::table('ref_util_status')->get();


      return view('frontend.util',
      [
        'Total_util'             => $Total_util,
        'Total_util_verify'      => $Total_util_verify,
        'Total_academic_util'    => $Total_academic_util,
        'Total_social_util'      => $Total_social_util,
        'Total_policy_util'      => $Total_policy_util,
        'Total_commercial_util'  => $Total_commercial_util,
        // --- SELECT FORM ---
        'form_research'          => $query_research,
        'form_util_type'         => $query_util_type,
        'form_year_util'         => $util_year,
        // --- SELECT TABLE ---
        'table_util'             => $query_util,
        'verified_list'          => $verified,
        'verified_departments'   => $verified_departments,
        'status'                 => $query9,
      ]);
 }



   // ------------------ INSERT ------------------>
   public function insert(Request $request){

       $data_post = [
         "users_id"          => Auth::user()->preferred_username,
         "pro_id"            => $request->pro_id,
         "util_year"         => $request->util_year - 543,
         "util_type"         => $request->util_type,
         "util_descrip"      => $request->util_descrip,
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


     if($insert){
       session()->put('message', 'บันทึกแล้ว');
       return redirect()->route('page.util');
     }else{
       return redirect()->back()->with('swl_err', 'บันทึกไม่สำเร็จ');
     }
  }




  // ------------------ EDIT --------------------->
  public function edit_util(Request $request){

      $edit = util::where('id' , $request->id)->first();

      $edit_1 = DB::table('db_utilization')
                  ->join('db_research_project', 'db_utilization.pro_id', '=', 'db_research_project.id')
                  ->select('db_utilization.id',
                           'db_utilization.util_type',
                           'db_utilization.files',
                           'db_utilization.verified',
                           'db_utilization.util_descrip',
                           'db_utilization.util_year',
                           'db_research_project.pro_name_th',
                           'db_research_project.pro_name_en',
                           'db_research_project.users_id',
                           'db_research_project.users_name',
                          )
                  ->where ('db_utilization.id' , $request->id)
                  ->first();


        $edit_2 = ['เชิงนโยบาย'       => 'เชิงนโยบาย',
                    'เชิงวิชาการ'        => 'เชิงวิชาการ',
                    'เชิงสังคม/ชุมชน'    => 'เชิงสังคม/ชุมชน',
                    'เชิงพาณิชย์'        => 'เชิงพาณิชย์'
                    ];

        $edit_util_year = [];

        // Create a DateTime object for the current date/time
        $currentDate = new DateTime();

        // Get the current Gregorian year
        $currentGregorianYear = (int)$currentDate->format('Y');

        // Convert to Thai year by adding 543
        $currentThaiYear = $currentGregorianYear + 543;

        // Define a range: for example, 10 years back to 10 years ahead
        $startThaiYear = $currentThaiYear - 30;
        $endThaiYear   = $currentThaiYear;

        for ($year = $startThaiYear; $year <= $endThaiYear; $year++){
        $edit_util_year[] = $year;
        };

     return view('frontend.util_edit',
       [
        'edit_util'       => $edit,
        'edit_data'       => $edit_1,
        'edit_utiltype'   => $edit_2,
        'edit_util_year'  => $edit_util_year
       ]);
  }



  // ------------------ SAVE ------------------>
  public function save_util(Request $request){

    // UPDATE Files ==> "db_research_project" **กรณี "มี" ไฟล์ที่แก้ไข Upload**

    if ($request->file('files') != NULL) {

       $file = $request->file('files');
       $name='file_'.date('dmY_His');
       $clientName = $name.'.'.$file->getClientOriginalExtension();
       $path = $file->storeAs('public/file_upload_util', $clientName);

        $update_util = DB::table('db_utilization')
                        ->where('id', $request->id)
                        ->update([
                                    "util_type"    => $request->util_type,
                                    "util_descrip" => $request->util_descrip,
                                    "util_year"    => $request->util_year - 543,
                                    "files"        => $clientName,
                                  ]);

    }else {

        // **กรณี "ไม่มี" ไฟล์ที่แก้ไข Upload**
        $update_util = DB::table('db_utilization')
                        ->where('id', $request->id)
                        ->update([
                                    "util_type"    => $request->util_type,
                                    "util_descrip" => $request->util_descrip,
                                    "util_year"    => $request->util_year - 543,
                                  ]);

    }

    if($update_util){
       return redirect()->route('page.util')->with('swl_update','แก้ไขข้อมูลสำเร็จแล้ว');
    } else {
       return redirect()->back()->with('swl_errs','ไม่สามารถแก้ไขได้');
    }
  }



    //  -- DOWNLOAD --
    public function DownloadFile(Request $request){
      $query = DB::table('db_utilization')
                  ->select('id', 'files')
                  ->where('id', $request->id)
                  ->first();

      if(!isset($query)){
        return view('error-page.error405');
      }

      $path = $query->files;


      if(Storage::disk('util')->exists($path)) {
        return Storage::disk('util')->download($path);
      }else {
        return view('error-page.error405');
      }
    }



    //  -- VERIFIED --
    public function action_verified(Request $request){

        //UPDATE db_research_project
        $verified = DB::table('db_utilization')
                  ->where('id', $request->id)
                  ->update([
                            'verified'    => $request->verified,
                            'status'      => $request->status,
                            'updated_at'  => date('Y-m-d H:i:s')
                          ]);
         // dd($verified);

         if($verified){
             session()->put('verify', 'okkkkkayyyyy');
             return redirect()->route('page.util');
         }else{
             return redirect()->back()->with('swl_err', 'บันทึกไม่สำเร็จ');
         }
       }



    // -- No VERIFIED --
    public function No_verified(Request $request){
        //UPDATE db_research_project
        $verified = DB::table('db_utilization')
                      ->where('id', $request->id)
                      ->update(['verified'    => NULL,
                                'updated_at'  => date('Y-m-d H:i:s')
                              ]);

         // dd($verified);
         if($verified){
             session()->put('Noverify', 'okkkkkayyyyy');
             return redirect()->route('page.util');
         }else{
             return redirect()->back()->with('swl_err', 'บันทึกไม่สำเร็จ');
         }
       }



    //  -- DELETE --
    public function delete_util(Request $request)
    {

        $delete = util::where('id', $request->id)
                      ->update(["deleted_at"  =>  date('Y-m-d H:i:s')]);
        // dd($delete);

      if($delete){
        session()->put('delete_util', 'okkkkkayyyyy');
        return redirect()->route('page.util')->with('Okayyyyy');
      }else{
        return redirect()->back()->with('Errorrr');
      }

    }



    //  -- STATUS --
    public function status_util(Request $request){
        //UPDATE db_utilization = "STATUS"
        $status_util = DB::table('db_utilization')
                         ->where('id', $request->id)
                         ->update([
                                  'status'      => $request->status,
                                  'updated_at'  => date('Y-m-d H:i:s')
                                ]);
     // dd($status_util);

       if($status_util){
           session()->put('status_util', 'okkkkkayyyyy');
           return redirect()->route('page.util');
       }else{
           return redirect()->back()->with('swl_err', 'บันทึกไม่สำเร็จ');
       }
    }



    //  -- COMMENTS "MANAGER"--
    public function action_comments_manager(Request $request){

          $insert_comments = [
              "send_date"     =>  Carbon::today(),
              "category"      =>  "3",
              "projects_id"   =>  $request->projects_id,
              "subject"       =>  $request->subject,
              "sender_id"     =>  Auth::user()->preferred_username,
              "sender_name"   =>  Auth::user()->name,
              "receiver_id"   =>  $request->receiver_id,
              "receiver_name" =>  $request->receiver_name,
              "description"   =>  $request->description,
              "files_upload"  =>  $request->files_upload,
              "url_redirect"  =>  "util_edit/".$request->projects_id,
          ];


          // UPLOAD Files "Notifications_messages"

          // if ($request->file('files_upload')->isValid()) {
          if ($request->file('files_upload') != NULL) {
              $file=$request->file('files_upload');
              $name='file_'.date('dmY_His');
              $file_name = $name.'.'.$file->getClientOriginalExtension();
              $path = $file->storeAs('public/file_upload_notify',$file_name);
              $insert_comments['files_upload'] = $file_name;
          }

            // -- INSERT --
            $notify = NotificationAlert::insertGetId($insert_comments);


         if($notify){
             session()->put('notify_send', 'okayy');
             //ส่ง email
             $data = ['utilization_id' => $request->projects_id];
             Mail::send(new utilizationCommentMail($data));
             return redirect()->route('page.util');
         }else{
             return redirect()->back()->with('swl_err', 'บันทึกไม่สำเร็จ');
         }
       }



    //  -- COMMENTS "USER"--
    public function action_comments_users(Request $request){

          $insert_comments = [
              "send_date"     =>  Carbon::today(),
              "category"      =>  "3",
              "projects_id"   =>  $request->projects_id,
              "subject"       =>  $request->subject,
              "sender_id"     =>  Auth::user()->preferred_username,
              "sender_name"   =>  Auth::user()->name,
              "receiver_id"   =>  "1709700158952",
              "receiver_name" =>  "อภิสิทธิ์ สนองค์",
              "description"   =>  $request->description,
              "url_redirect"  =>  "util_edit/".$request->projects_id,
              // "files_upload" =>  $request->files_upload,
          ];



          // UPLOAD Files Table "Notifications_messages"
          // if ($request->file('files_upload')->isValid()) {
          //     $file=$request->file('files_upload');
          //     $name='file_'.date('dmY_His');
          //     $file_name = $name.'.'.$file->getClientOriginalExtension();
          //     $path = $file->storeAs('public/file_upload_notify',$file_name);
          //     $insert_comments['files_upload'] = $file_name;
          // }

          // -- INSERT --
          $notify_users = NotificationAlert::insertGetId($insert_comments);


         if($notify_users){
             session()->put('notify_send', 'okayy');
             return redirect()->route('page.util');
         }else{
             return redirect()->back()->with('swl_err', 'บันทึกไม่สำเร็จ');
         }
       }




}
