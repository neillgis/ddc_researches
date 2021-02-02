<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Storage;
use App\CmsHelper;
use App\research;
use App\journal;
use Storage;
use File;
use Auth;
use app\Exceptions\Handler;
use Illuminate\Support\Facades\Route;
// use App\KeycloakUser;

class ResearchController extends Controller
{


  // public function research(){
  //   return view('frontend.research');
  // }


// -- SELECT DataTables RESEARCH --
  public function table_research(){
    if(Auth::hasRole('manager')) {
      $query = research::select('id','pro_name_th','pro_name_en','pro_position',
                                'pro_start_date','pro_end_date','publish_status',
                                'files', 'verified',
                                \DB::raw('(CASE
                                              WHEN verified = "1" THEN "ตรวจสอบแล้ว"
                                              ELSE "รอตรวจสอบ"
                                              END) AS verified'
                                ))
                       ->ORDERBY('id','DESC')
                       ->get();

    }elseif(Auth::hasRole('admin')) {
      $query = research::select('id','pro_name_th','pro_name_en','pro_position',
                                'pro_start_date','pro_end_date','publish_status',
                                'files', 'verified',
                                \DB::raw('(CASE
                                              WHEN verified = "1" THEN "ตรวจสอบแล้ว"
                                              ELSE "รอตรวจสอบ"
                                              END) AS verified'
                                ))
                       ->ORDERBY('id','DESC')
                       ->get();

     }else {
       $query = research::select('id','pro_name_th','pro_name_en','pro_position',
                                 'pro_start_date','pro_end_date','publish_status',
                                 'files', 'verified',
                                 \DB::raw('(CASE
                                               WHEN verified = "1" THEN "ตรวจสอบแล้ว"
                                               ELSE "รอตรวจสอบ"
                                               END) AS verified'
                                 ))
                        ->where('users_id', Auth::user()->preferred_username)
                        ->ORDERBY('id','DESC')
                        ->get();
     }


      $query2 = [1=> 'ผู้วิจัยหลัก',
                 2=> 'ผู้วิจัยหลัก-ร่วม',
                 3=> 'ผู้วิจัยร่วม',
                 4=> 'ผู้ช่วยวิจัย',
                 5=> 'ที่ปรึกษาโครงการ'
                ];

      $query3 = [1=> '1', 2=> '2', 3=> '3',
                 4=> '4', 5=> '5', 6=> '6',
                 7=> '7', 8=> '8', 9=> '9',
                 10=> '10'
                ];

       $query4 = [1=> 'ใช่',
                  2=> 'ไม่ใช่'
                 ];


// --- COUNT 3 BOX on TOP ---
      // COUNT = All Record
      if(Auth::hasRole('manager')){
            $Total_research = DB::table('db_research_project')
                            -> select('id','pro_name_th','pro_name_en','pro_position',
                                      'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                            ->get()
                            ->count();

      }elseif(Auth::hasRole('admin')) {
        $Total_research = DB::table('db_research_project')
                        -> select('id','pro_name_th','pro_name_en','pro_position',
                                  'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                        ->get()
                        ->count();

      }else {
        $Total_research = DB::table('db_research_project')
                        -> select('id','pro_name_th','pro_name_en','pro_position',
                                  'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                        ->where('users_id', Auth::user()->preferred_username)
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

      }elseif(Auth::hasRole('admin')) {
        $Total_master_pro = DB::table('db_research_project')
                          -> select('id','pro_name_th','pro_name_en','pro_position',
                                    'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                          -> whereIn ('pro_position', ['1'])
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


      // COUNT = publish_status = 1
      if(Auth::hasRole('manager')){
          $Total_publish_pro = DB::table('db_research_project')
                            -> select('id','pro_name_th','pro_name_en','pro_position',
                                      'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                            -> whereIn ('publish_status', ['1'])
                            ->get()
                            ->count();

      }elseif(Auth::hasRole('admin')) {
        $Total_publish_pro = DB::table('db_research_project')
                          -> select('id','pro_name_th','pro_name_en','pro_position',
                                    'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                          -> whereIn ('publish_status', ['1'])
                          ->get()
                          ->count();

      }else {
          $Total_publish_pro = DB::table('db_research_project')
                            -> select('id','pro_name_th','pro_name_en','pro_position',
                                      'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                            -> whereIn ('publish_status', ['1'])
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

    $edit3 = [1=> '1', 2=> '2', 3=> '3',
              4=> '4', 5=> '5', 6=> '6',
              7=> '7', 8=> '8', 9=> '9',
              10=> '10'
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
          // return redirect("/research_form")->with(["swl_add"=>"Success!"]);
          // return redirect('research_form')->with('swl_add', 'Profile updated!');
        return redirect()->route('page.research')->with('swl_add', 'บันทึกแล้ว');
    }else{
        return redirect()->back()->with('swl_err', 'บันทึกแล้ว');
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
                            'publish_status'  => $request->publish_status
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
                ->update(['verified' => "1"]);
                // ->get();

       // dd($verified);

      if(!$verified = '1'){
        return abort(404);
      }

      if($verified) {
          return redirect()->back()->with('swl_verified', '555ลบข้อมูลเรียบร้อยแล้ว');
      }else {
          return redirect()->back()->with('swl_del', 'ไม่สามารถลบข้อมูลได้');
      }

    }
      // else {
      //     return redirect()->back()->with('swl_verified', 'ลบข้อมูลเรียบร้อยแล้ว');
      // }

  // }
  //  -- END VERIFIED --


}
