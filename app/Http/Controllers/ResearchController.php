<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CmsHelper;
use App\research;
use App\journal;
use Storage;
use File;
use Auth;
use Session;
use app\Exceptions\Handler;
use Illuminate\Support\Facades\Route;
// use App\KeycloakUser;

class ResearchController extends Controller
{


  // public function research(){
  //   return view('frontend.research');
  // }


// -- SELECT DataTables RESEARCH --
  public function table_research(Request $request){
    if(Auth::hasRole('manager')) {
      $query = DB::table('db_research_project')
                 ->join('users', 'db_research_project.users_id', '=', 'users.idCard')
                 ->select('db_research_project.id',
                          'db_research_project.pro_name_th',
                          'db_research_project.pro_name_en',
                          'db_research_project.pro_position',
                          'db_research_project.pro_start_date',
                          'db_research_project.pro_end_date',
                          'db_research_project.publish_status',
                          'db_research_project.files',
                          'db_research_project.verified',
                          'db_research_project.users_id',
                          'db_research_project.users_name',
                          'users.deptName',
                          // \DB::raw('(CASE
                          //               WHEN verified = "1" THEN "ตรวจสอบแล้ว"
                          //               WHEN verified = "2" THEN "เอกสารไม่สมบูรณ์"
                          //               WHEN verified = "3" THEN "ไม่อนุมัติ"
                          //               ELSE "รอตรวจสอบ"
                          //               END
                          //               ) AS verified'
                          // )
                          )
                       ->ORDERBY('id','DESC')
                       ->get();

                        // dd($query);

    }elseif(Auth::hasRole('departments')) {
      $query = DB::table('db_research_project')
                ->leftjoin('users', 'users.idCard', '=', 'db_research_project.users_id')
                ->select( 'db_research_project.id',
                          'db_research_project.users_id',
                          'db_research_project.pro_name_th',
                          'db_research_project.pro_name_en',
                          'db_research_project.pro_position',
                          'db_research_project.pro_start_date',
                          'db_research_project.pro_end_date',
                          'db_research_project.publish_status',
                          'db_research_project.files',
                          'db_research_project.verified',
                          'users_id',
                          'users.idCard',
                          'users.deptName',
                          'users_name'
                          // \DB::raw('(CASE
                          //               WHEN verified = "1" THEN "ตรวจสอบแล้ว"
                          //               ELSE "รอตรวจสอบ"
                          //               END) AS verified'
                          // )
                          )
                ->where('users.deptName', Auth::user()->family_name)
                ->ORDERBY('id','DESC')
                ->get();
              // dd($query);

      // $query = research::select('id','pro_name_th','pro_name_en','pro_position',
      //                           'pro_start_date','pro_end_date','publish_status',
      //                           'files', 'verified', 'users_id',
      //                           // \DB::raw('(CASE
      //                           //               WHEN verified = "1" THEN "ตรวจสอบแล้ว"
      //                           //               ELSE "รอตรวจสอบ"
      //                           //               END) AS verified'
      //                           // )
      //                           )
      //                  ->ORDERBY('id','DESC')
      //                  ->get();

     }else {
       $query = research::select('id','pro_name_th','pro_name_en','pro_position',
                                 'pro_start_date','pro_end_date','publish_status',
                                 'files', 'verified', 'users_id',
                                 )
                                 // \DB::raw('(CASE
                                 //               WHEN verified = "1" THEN "ตรวจสอบแล้ว"
                                 //               ELSE "รอตรวจสอบ"
                                 //               END) AS verified'
                                 // ))
                        ->where('users_id', Auth::user()->preferred_username)
                        ->whereNull('deleted_at')
                        ->ORDERBY('id','DESC')
                        ->get();
     }


      $query2 = [1=> 'ผู้วิจัยหลัก',
                 2=> 'ผู้วิจัยหลัก-ร่วม',
                 3=> 'ผู้วิจัยร่วม',
                 4=> 'ผู้ช่วยวิจัย',
                 5=> 'ที่ปรึกษาโครงการ'
                ];

      $query3 = [0=> '0',
                 1=> '1', 2=> '2', 3=> '3',
                 4=> '4', 5=> '5', 6=> '6',
                 7=> '7', 8=> '8', 9=> '9',
                 10=> '10',
                 11=> 'มากกว่า 10'
                ];

       $query4 = [1=> 'ใช่',
                  2=> 'ไม่ใช่'
                 ];

      $verified = [ 1 => 'ตรวจสอบแล้ว', //verify
                    2 => 'อยู่ระหว่างตรวจสอบ', //process_checked
                    3 => 'อยู่ระหว่างแก้ไข', //process_editing
                    9 => 'ไม่ตรงเงื่อนไข', //no_conditions
                  ];


// --- COUNT 3 BOX on TOP ---

    //For Departments ONLY
    $Total_departments = DB::table('db_research_project')
                      ->leftjoin('users', 'users.idCard', '=', 'db_research_project.users_id')
                      ->select( 'users.id',
                                'users.idCard',
                                'users.deptName',
                                'db_research_project.id',
                                'db_research_project.users_id',
                                'db_research_project.pro_name_en',
                                'db_research_project.publish_status'
                              )
                      // ->whereIn('publish_status', ['1'])
                      ->where('deptName', Auth::user()->family_name)
                      ->get()
                      ->count();


      // COUNT = publish_status = 1
      if(Auth::hasRole('manager')){
        $Total_publish_pro = DB::table('db_research_project')
                          -> select('id','pro_name_th','pro_name_en','pro_position',
                                    'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                          ->whereIn ('publish_status', ['1'])
                          ->get()
                          ->count();

      }elseif(Auth::hasRole('departments')) {
        $Total_publish_pro = DB::table('db_research_project')
                          ->leftjoin('users', 'users.idCard', '=', 'db_research_project.users_id')
                          ->select( 'users.id',
                                    'users.idCard',
                                    'users.deptName',
                                    'db_research_project.id',
                                    'db_research_project.users_id',
                                    'db_research_project.pro_name_en',
                                    'db_research_project.publish_status'
                                  )
                          ->whereIn('publish_status', ['1'])
                          ->where('deptName', Auth::user()->family_name)
                          ->get()
                          ->count();

      }else {
        $Total_publish_pro = DB::table('db_research_project')
                          -> select('id','pro_name_th','pro_name_en','pro_position',
                                    'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                          ->whereIn ('publish_status', ['1'])
                          ->where('users_id', Auth::user()->preferred_username)
                          ->get()
                          ->count();
      }



      // COUNT = All Record
      if(Auth::hasRole('manager')){
        $Total_research = DB::table('db_research_project')
                        -> select('id','pro_name_th','pro_name_en','pro_position',
                                  'pro_start_date','pro_end_date','pro_co_researcher','publish_status', 'verified')
                        ->where('verified', 1)
                        ->get()
                        ->count();

      }elseif(Auth::hasRole('departments')) {
        $Total_research = DB::table('db_research_project')
                          ->leftjoin('users', 'users.idCard', '=', 'db_research_project.users_id')
                          ->select( 'users.id',
                                    'users.idCard',
                                    'users.deptName',
                                    'db_research_project.id',
                                    'db_research_project.users_id',
                                    'db_research_project.verified',
                                  )
                          ->whereIn('verified', ['1'])
                          ->where('deptName', Auth::user()->family_name)
                          ->get()
                          ->count();

      }else {
        $Total_research = DB::table('db_research_project')
                        -> select('id','pro_name_th','pro_name_en','pro_position',
                                  'pro_start_date','pro_end_date','pro_co_researcher','publish_status', 'verified')
                        ->where('users_id', Auth::user()->preferred_username)
                        ->where('verified', 1)
                        ->get()
                        ->count();
      }



      // COUNT = pro_position = 1
      if(Auth::hasRole('manager')){
          $Total_master_pro = DB::table('db_research_project')
                            -> select('id','pro_name_th','pro_name_en','pro_position',
                                      'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                            -> whereIn ('pro_position', ['1'])
                            ->get()
                            ->count();

      }elseif(Auth::hasRole('departments')) {
        $Total_master_pro = DB::table('db_research_project')
                          ->leftjoin('users', 'users.idCard', '=', 'db_research_project.users_id')
                          ->select( 'users.id',
                                    'users.idCard',
                                    'users.deptName',
                                    'db_research_project.id',
                                    'db_research_project.users_id',
                                    'db_research_project.pro_position',
                                  )
                          ->whereIn('pro_position', ['1'])
                          ->where('deptName', Auth::user()->family_name)
                          ->get()
                          ->count();

      }else {
        $Total_master_pro = DB::table('db_research_project')
                          -> select('id','pro_name_th','pro_name_en','pro_position',
                                    'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                          -> whereIn ('pro_position', ['1'])
                          ->where('users_id', Auth::user()->preferred_username)
                          ->get()
                          ->count();
      }


// --- END COUNT 3 BOX on TOP ---

    return view('frontend.research',
      [
       'research'          => $query,
       'pro_position'      => $query2,
       'pro_co_researcher' => $query3,
       'publish_status'    => $query4,
       'Total_research'     => $Total_research,
       'Total_master_pro'   => $Total_master_pro,
       'Total_publish_pro'  => $Total_publish_pro,
       'verified_list'      => $verified,
       'Total_departments'  => $Total_departments
      ]);
  }
  //  -- END SELECT --




  //  -- Edit RESEARCH --
  public function edit_research_form(Request $request){
    //แสดงข้อมูล Query EDIT
    $edit = research::where('id' , $request->id)->first();

    $edit2 = [1=> 'ผู้วิจัยหลัก',
              2=> 'ผู้วิจัยหลัก-ร่วม',
              3=> 'ผู้วิจัยร่วม',
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




  //  -- INSERT  --
  public function insert(Request $request){

    $data_post = [
      "users_id"          => Auth::user()->preferred_username,
      "users_name"        => Auth::user()->name,
      "pro_name_th"       => $request->pro_name_th,
      "pro_name_en"       => $request->pro_name_en,
      "pro_position"      => $request->pro_position,
      "pro_co_researcher" => $request->pro_co_researcher,
      "pro_start_date"    => $request->pro_start_date,
      "pro_end_date"      => $request->pro_end_date,
      "publish_status"    => $request->publish_status,
      "url_research"      => $request->url_research,
      "files"             => $request->files,
      "created_at"        => date('Y-m-d H:i:s')
    ];

      //  --  UPLOAD FILE research_form  --
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




  //  -- SAVE --
  public function save_research_form(Request $request){
    // dd($request);
    $update = DB::table('db_research_project')
                  ->where('id', $request->id)
                  ->update([
                            'pro_name_en'     => $request->pro_name_en,
                            'pro_name_th'     => $request->pro_name_th,
                            'pro_position'    => $request->pro_position,
                            'pro_co_researcher' => $request->pro_co_researcher,
                            'pro_start_date'  => $request->pro_start_date,
                            'pro_end_date'    => $request->pro_end_date,
                            'publish_status'  => $request->publish_status,
                            'url_research'    => $request->url_research
                          ]);

    if($update){
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

    if(!$query){
      return view('error-page.error404');
    }

    $path = $query->files;

    // return Storage::disk('research')->download($path);

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




  public function delete_research(Request $request)
  {

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



}
