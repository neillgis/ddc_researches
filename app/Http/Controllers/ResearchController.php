<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
// use Storage;
use App\CmsHelper;
use App\research;
use App\journal;
use File;
use Auth;


class ResearchController extends Controller
{


  public function research(){
    return view('frontend.research');
  }




  //  -- SELECT DataTables RESEARCH --
  public function table_research(){

      $query = research::select('id','pro_name_th','pro_name_en','pro_position',
                                'pro_start_date','pro_end_date','publish_status')
                       ->ORDERBY('id','DESC')
                       ->get();

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


      // if(Auth::user()->roles_type == 1){
          // count (All Record)
            $Total_research = DB::table('db_research_project')
                            -> select('id','pro_name_th','pro_name_en','pro_position',
                                      'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                            ->get()
                            ->count();
      // }else {
      //       $Total_research = DB::table('db_research_project')
      //                       -> select('id','pro_name_th','pro_name_en','pro_position',
      //                                 'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
      //                       // ->where('db_research_project.users_id', Auth::user()->id)
      //                       ->get()
      //                       ->count();
      // }


      // if(Auth::user()->roles_type == 1){
          // count (pro_position) = 1
          $Total_master_pro = DB::table('db_research_project')
                            -> select('id','pro_name_th','pro_name_en','pro_position',
                                      'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                            -> whereIn ('pro_position', ['1'])
                            ->get()
                            ->count();
      // }else {
      //     $Total_master_pro = DB::table('db_research_project')
      //                       -> select('id','pro_name_th','pro_name_en','pro_position',
      //                                 'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
      //                       -> whereIn ('pro_position', ['1'])
      //                       // ->where('db_research_project.users_id', Auth::user()->id
      //                       ->get()
      //                       ->count();
      // }


      // if(Auth::user()->roles_type == 1){
          // count (publish_status) = 1
          $Total_publish_pro = DB::table('db_research_project')
                            -> select('id','pro_name_th','pro_name_en','pro_position',
                                      'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                            -> whereIn ('publish_status', ['1'])
                            ->get()
                            ->count();
      // }else {
      //     $Total_publish_pro = DB::table('db_research_project')
      //                       -> select('id','pro_name_th','pro_name_en','pro_position',
      //                                 'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
      //                       -> whereIn ('publish_status', ['1'])
      //                       // ->where('db_research_project.users_id', Auth::user()->id)
      //                       ->get()
      //                       ->count();
      // }


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
       ]  /*นำตัวแปร data ไปใส่ใน research_edit.blade.php  คือ  value = "{{ $data->id }}"*/
    );
  }
  //  -- END Edit RESEARCH --




  //  -- INSERT  --
  public function insert(Request $request){

    $data_post = [
      // "id"          => $request->id,
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

    $insert = research::insert($data_post);

    if($insert){
      //return Sweet Alert
        return redirect()->route('page.research')->with('swl_add', 'เพิ่มข้อมูลสำเร็จแล้ว');
    }else {
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

          // dd($request->id);

    if($update){
      //return Sweet Alert
        return redirect()->route('page.research')->with('swl_add', 'แก้ไขข้อมูลสำเร็จแล้ว');
    }else {
        return redirect()->back()->with('swl_err', 'บันทึกแล้ว');
    }
  }
  //  -- END SAVE --



  public function download_file(Request $request){
    $pathToFile = DB::table('db_research_project')
                  ->select('files')
                  ->where('files', $request->files)
                  ->first();



    return response()->download($pathToFile);

    // $path = $file->storeAs('public/file_upload', $file_name);
    //
    //
    // return Storage::download($path);



        // if(!asset($file_name)){
        //   return abort(404);
        // }
        // //
        // // $path = $download->files;
        // // DD($path);
        //

        // return Storage::download($download);
      }
    }


// }
