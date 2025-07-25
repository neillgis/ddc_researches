<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CmsHelper;
use App\research;
use App\journal;
use App\NotificationAlert;
use Storage;
use File;
use Carbon\Carbon;
use app\Exceptions\Handler;
use Illuminate\Support\Facades\Route;
use App\Mail\researcheCommentMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class ResearchController extends Controller
{
  public function table_research(){
    $users_active = [];
    $user_dep_name = [];
    $research = [
      "all" => 0,
      "publish" => 0,
      "verify" => 0,
      "pi" => 0
    ];
    $pro_position = [
      1=> 'ผู้วิจัยหลัก',
      2=> 'ผู้วิจัยหลัก-ร่วม',
      3=> 'ผู้ร่วมวิจัย',
      4=> 'ผู้ช่วยวิจัย',
      5=> 'ที่ปรึกษาโครงการ'
    ];
    $pro_co_researcher = [];
    for( $i=0 ; $i<=10 ; $i++ ) {
      $pro_co_researcher[$i] = $i;
    }
    $pro_co_researcher[11] = 'มากกว่า 10';

    $publish_status = [1=> 'ใช่',2=> 'ไม่ใช่'];

    $verified = [
      1 => 'ตรวจสอบแล้ว', //verify
      2 => 'อยู่ระหว่างตรวจสอบ', //process_checked
      3 => 'อยู่ระหว่างแก้ไข', //process_editing
      4 => 'ผ่านการตรวจสอบแล้ว',
      9 => 'ไม่ตรงเงื่อนไข', //no_conditions
    ];
    $verified_departments = [3 =>'อยู่ระหว่างแก้ไข',4 =>'ผ่านการตรวจสอบแล้ว'];
    $ref_verified = DB::table('ref_verified')->get();
    //==========================================================

    if(Gate::allows('admin') || Gate::allows('manager')){
      $data_users = DB::table('users')
            ->where('idCard','!=','00000000000')
            ->where('idCard','not like','u%')
            // ->whereNull("deleted_users")
            ->get();
      foreach($data_users as $item) {
        $users_active[] = $item->idCard;
        $user_dep_name[$item->idCard] = $item->deptName;
      }
      //---------------------------------------
    }elseif(Gate::allows('departments')) {
      $data_users = DB::table('users')
            ->where('idCard','!=','00000000000')
            ->where('idCard','not like','u%')
            ->whereNull("deleted_users")
            ->where('dept_id', Session::get('dep_id'))
            ->get();
      foreach($data_users as $item) {
        $users_active[] = $item->idCard;
        $user_dep_name[$item->idCard] = $item->deptName;
      }
      //---------------------------------------
    }else {
      $users_active[] = Auth::user()->preferred_username;
      $user_dep_name[Auth::user()->preferred_username] = Session::get('dep_name');
      //---------------------------------------
    }
    $users_active = array_unique($users_active);


    //====================================================
    $data_research = DB::table('db_research_project')
                  ->whereNull('deleted_at')
                  ->whereIn('users_id', $users_active)
                  ->orderBy('id','DESC')
                  ->paginate(3000);
                //   ->get();

    if(Gate::allows('admin') || Gate::allows('manager')){
      $query = DB::table('db_research_project')
            ->select("users_id","verified","pro_position","publish_status")
            ->whereNull('deleted_at')
            ->get();
    }else{
      $query = DB::table('db_research_project')
            ->select("users_id","verified","pro_position","publish_status")
            ->whereNull('deleted_at')
            ->whereIn('users_id', $users_active)
            ->get();
    }


    foreach($query as $item) {
      $research['all']++;
      if($item->verified == 1) {
        $research['verify']++;
        if($item->pro_position==1) {
          $research['pi']++;
        }
        if( $item->publish_status ==1 ) {
          $research['publish']++;
        }
      }
    }
    //====================================================
    return view('frontend.research',
      [
       'pro_position'      => $pro_position,
       'pro_co_researcher' => $pro_co_researcher,
       'publish_status'    => $publish_status,
       'verified_list'      => $verified,
       'verified_departments' => $verified_departments,
       'ref_verified'       => $ref_verified,
       'research'          => $research,

       'data_research' => $data_research,
       'user_dep_name' => $user_dep_name,
      ]);

  }

  //  -- INSERT  --
  public function insert(Request $request){

    $data_post = [
      "users_id"          => Auth::user()->preferred_username,
      "users_name"        => Auth::user()->name,
      "pro_name_th"       => $request->pro_name_th,
      "pro_name_en"       => $request->pro_name_en,
      "pro_position"      => $request->pro_position,
      "pro_co_researcher" => $request->pro_co_researcher,
      // "pro_start_date"    => $request->pro_start_date,
      // "pro_end_date"      => $request->pro_end_date,
      "pro_start_date"    => CmsHelper::Date_Format_BC_To_AD($request->pro_start_date),
      "pro_end_date"      => CmsHelper::Date_Format_BC_To_AD($request->pro_end_date),
      "publish_status"    => $request->publish_status,
      "url_research"      => $request->url_research,
      "files"             => $request->files,
      "created_at"        => date('Y-m-d H:i:s')
    ];

    // UPLOAD FILE research_form
    if ($request->file('files')->isValid()) {
          //TAG input [type=file] ดึงมาพักไว้ในตัวแปรที่ชื่อ files
        $file=$request->file('files');
          //ตั้งชื่อตัวแปร $file_name เพื่อเปลี่ยนชื่อ + นามสกุลไฟล์
        $name='file_'.date('dmY_His');
        $file_name = $name.'.'.$file->getClientOriginalExtension();
          // upload file ไปที่ PATH : public/file_upload
        $path = $file->storeAs('public/file_upload',$file_name);
        $data_post['files'] = $file_name;
    }

        $output = research::insert($data_post);

    if($output){

        session()->put('message', 'okkkkkayyyyy');
        return redirect()->route('page.research');
    }else{
        return redirect()->back()->with('swl_err', 'บันทึกไม่สำเร็จ');
    }
  }
  //  -- END INSERT --




  //  -- Edit RESEARCH --
  public function edit_research_form(Request $request){

    //แสดงข้อมูล Query EDIT
    $edit = research::where('id' , $request->id)->first();

    $edit2 = [1=> 'ผู้วิจัยหลัก',
              2=> 'ผู้วิจัยหลัก-ร่วม',
              3=> 'ผู้ร่วมวิจัย',
              4=> 'ผู้ช่วยวิจัย',
              5=> 'ที่ปรึกษาโครงการ'
             ];

    $edit3 = [0=> '0',
              1=> '1', 2=> '2', 3=> '3',
              4=> '4', 5=> '5', 6=> '6',
              7=> '7', 8=> '8', 9=> '9',
              10=> '10',
              11=> 'มากกว่า 10'
             ];


     $edit4 = [1=> 'ใช่',
               2=> 'ไม่ใช่'
              ];


     return view('frontend.research_edit',
       ['data'    => $edit,
        'data2'   => $edit2,
        'data3'   => $edit3,
        'data4'   => $edit4,
       ]);
  }
  //  -- END Edit RESEARCH --



  //  -- SAVE --
  public function save_research_form(Request $request){

    // UPDATE Files ==> "db_research_project" **กรณี "มี" ไฟล์ที่แก้ไข Upload**

    if ($request->file('files') != NULL) {

       $file = $request->file('files');
       $name='file_'.date('dmY_His');
       $clientName = $name.'.'.$file->getClientOriginalExtension();
       $path = $file->storeAs('public/file_upload', $clientName);

        $update_data = DB::table('db_research_project')
                          ->where('id', $request->id)
                          ->update([
                                    'pro_name_en'       => $request->pro_name_en,
                                    'pro_name_th'       => $request->pro_name_th,
                                    'pro_position'      => $request->pro_position,
                                    'pro_co_researcher' => $request->pro_co_researcher,
                                    'pro_start_date'    => $request->pro_start_date,
                                    'pro_end_date'      => $request->pro_end_date,
                                    'publish_status'    => $request->publish_status,
                                    'url_research'      => $request->url_research,
                                    "files"             => $clientName,
                                  ]);

    }else {

        // **กรณี "ไม่มี" ไฟล์ที่แก้ไข Upload**
        $update_data = DB::table('db_research_project')
                          ->where('id', $request->id)
                          ->update([
                                    'pro_name_en'       => $request->pro_name_en,
                                    'pro_name_th'       => $request->pro_name_th,
                                    'pro_position'      => $request->pro_position,
                                    'pro_co_researcher' => $request->pro_co_researcher,
                                    'pro_start_date'    => $request->pro_start_date,
                                    'pro_end_date'      => $request->pro_end_date,
                                    'publish_status'    => $request->publish_status,
                                    'url_research'      => $request->url_research,
                                  ]);

    }


    if($update_data){
      //return Sweet Alert
        return redirect()->route('page.research')->with('swl_update', 'แก้ไขข้อมูลสำเร็จแล้ว');
    }else {
        return redirect()->back()->with('swl_errs', 'บันทึกแล้ว');
    }
  }
  //  -- END SAVE --



  //  -- DOWNLOAD --
  public function DownloadFile(Request $request){

      $query = DB::table('db_research_project')
                  ->select('id', 'files')
                  ->where('id', $request->id)
                  ->first();

      if(!isset($query)){
        return view('error-page.error405');
      }

      $path = $query->files;


      if(Storage::disk('research')->exists($path)) {
        return Storage::disk('research')->download($path);
      }else {
        return view('error-page.error405');
      }
  }
  //  -- END DOWNLOAD --



  //  -- VERIFIED --
  public function action_verified(Request $request){
      //UPDATE db_research_project
        $verified = DB::table('db_research_project')
                  ->where('id', $request->id)
                  ->update([
                            'verified'  => $request->verified
                            // 'updated_at'  => date('Y-m-d H:i:s')
                          ]);

       if($verified){
         //return Sweet Alert
           session()->put('verify', 'okkkkkayyyyy');
           return redirect()->route('page.research');
       }else{
           return redirect()->back()->with('swl_err', 'บันทึกไม่สำเร็จ');
       }

     }
  //  -- END VERIFIED --



  //  -- No VERIFIED --
  public function No_verified(Request $request){
      //UPDATE db_research_project
      $verified = DB::table('db_research_project')
                ->where('id', $request->id)
                ->update([
                          'verified' => NULL,
                          // 'updated_at'  => date('Y-m-d H:i:s')
                        ]);

       if($verified){
         //return Sweet Alert
           session()->put('Noverify', 'okkkkkayyyyy');
           return redirect()->route('page.research');
       }else{
           return redirect()->back()->with('swl_err', 'บันทึกไม่สำเร็จ');
       }
     }
  //  -- END No VERIFIED --


  //  --- DELETE ---
  public function delete_research(Request $request) {

      $delete = research::where('id', $request->id)
                        ->update(["deleted_at"  =>  date('Y-m-d H:i:s')]);
      // dd($delete);

    if($delete){
      session()->put('delete_research', 'okkkkkayyyyy');
      return redirect()->route('page.research')->with('Okayyyyy');
    }else{
      return redirect()->back()->with('Errorrr');
    }
  }



  //  -- COMMENTS "MANAGER"--
  public function action_comments_manager(Request $request){

        // -- VALIDATIONS --
        $request->validate([
            'files_upload'  => 'mimes:jpg,jpeg,png,doc,docx,xls,xlsx,pdf|max:10240',
        ]);

        $insert_comments = [
            "send_date"     =>  Carbon::today(),
            "category"      =>  "1",
            "projects_id"   =>  $request->projects_id,
            "subject"       =>  $request->subject,
            "sender_id"     =>  Auth::user()->preferred_username,
            "sender_name"   =>  Auth::user()->name,
            "receiver_id"   =>  $request->receiver_id,
            "receiver_name" =>  $request->receiver_name,
            "description"   =>  $request->description,
            "files_upload"  =>  $request->files_upload,
            "url_redirect"  =>  "research_edit/".$request->projects_id,
        ];


      // ======== UPLOAD Files "Notifications_messages" ========
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
           $data = ['research_project_id' => $request->projects_id];
           Mail::send(new researcheCommentMail($data));

           return redirect()->route('page.research');
       }else{
           return redirect()->back()->with('swl_err', 'บันทึกไม่สำเร็จ');
       }
     }




  //  -- COMMENTS "USER"--
  public function action_comments_users(Request $request){

        $insert_comments = [
            "send_date"     =>  Carbon::today(),
            "category"      =>  "1",
            "projects_id"   =>  $request->projects_id,
            "subject"       =>  $request->subject,
            "sender_id"     =>  Auth::user()->preferred_username,
            "sender_name"   =>  Auth::user()->name,
            "receiver_id"   =>  "1709700158952",
            "receiver_name" =>  "อภิสิทธิ์ สนองค์",
            "description"   =>  $request->description,
            "url_redirect"  =>  "research_edit/".$request->projects_id,
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


        // UPDATE Files ===> "db_research_project"
         // $file = $request->file('files_upload');
         // $name='file_'.date('dmY_His');
         // $clientName = $name.'.'.$file->getClientOriginalExtension();
         // $path = $file->storeAs('public/file_upload', $clientName);
         //
         // $aa = DB::table('db_research_project')
         //         ->where('id', $request->projects_id)
         //         ->update([ "files"  =>  $clientName ]);


       if($notify_users){
           session()->put('notify_send', 'okayy');
           return redirect()->route('page.research');
       }else{
           return redirect()->back()->with('swl_err', 'บันทึกไม่สำเร็จ');
       }
  }





}
