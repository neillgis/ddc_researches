<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\util;
use App\research;
use App\member;
use Illuminate\Support\Facades\Storage;
use File;
use DB;

class UtilizationController extends Controller
{


  public function util(){
    return view('frontend.util');
  }


// INSERT ------------------------------------------------------------->
  public function insert(Request $request){
     //dd($request->pro_id);
    $data_post = [
      "pro_id"        => $request->pro_id,
      "util_type"            => $request->util_type,
      "review_status"        => $request->review_status,
      "date_entry"           => date('Y-m-d H:i:s')
    ];


    $insert = util::insert($data_post);
    // $insert = DB::table('person_ddc_table')->insert($data_post);  /*person_ddc_table คือ = ชื่อ table*/

    if($insert){
      return redirect()->back()->with('success','การบันทึกข้อมูลสำเร็จ');
    } else {
      return redirect()->back()->with('failure','การบันทึกข้อมูลไม่สำเร็จ !!');
    }
  }
// END INSERT ----------------------------------------------------------->


  public function table_util(){

// SUM BOX ------------------------------------------------------------------------>

    // โครงการที่นำไปใช้ประโยชน์ทั้งหมด db_utilization -> โดย count id (All Record) --------->
    $Total_util = DB::table('db_utilization')
                    -> select('db_utilization.id','pro_id','util_type')
                    ->get()->count();
// dd($Total_util);


    // โครงการที่นำไปใช้ประโยชน์เชิงวิชาการ db_utilization -> โดย count id -> util_type = เชิงวิชาการ --------->
    $Total_academic_util = DB::table('db_utilization')
                          -> select('db_utilization.id','pro_id','util_type')
                          -> where ('util_type', '=', 'เชิงวิชาการ')
                          ->get()->count();
// dd($Total_academic_util);


    // โครงการที่นำไปใช้ประโยชน์เชิงสังคม/ชุมชน db_utilization -> โดย count id -> util_type = เชิงสังคม/ชุมชน --------->
    $Total_social_util = DB::table('db_utilization')
                          -> select('db_utilization.id','pro_id','util_type')
                          -> where ('util_type', '=', 'เชิงสังคม/ชุมชน')
                          ->get()->count();
// dd($Total_social_util);


    // โครงการที่นำไปใช้ประโยชน์เชิงนโยบาย db_utilization -> โดย count id -> util_type = เชิงนโยบาย --------->
    $Total_policy_util = DB::table('db_utilization')
                          -> select('db_utilization.id','pro_id','util_type')
                          -> where ('util_type', '=', 'เชิงนโยบาย')
                          ->get()->count();
// dd($Total_policy_util);


    // โครงการที่นำไปใช้ประโยชน์เชิงนโยบาย db_utilization -> โดย count id -> util_type = เชิงพาณิชย์ --------->
    $Total_commercial_util = DB::table('db_utilization')
                          -> select('db_utilization.id','pro_id','util_type')
                          -> where ('util_type', '=', 'เชิงพาณิชย์')
                          ->get()->count();
// dd($Total_commercial_util);

// END SUM BOX ------------------------------------------------------------------------>


// TABLE LIST------------------------------------------------------------->

    // FORM ----------------------------------------------------------------->
    $query_research   = research::select('id','pro_name_th','pro_name_en')
                                ->ORDERBY('id','DESC')
                                ->get();


    $query_util  = DB::table('db_utilization')
                    ->join('db_research_project', 'db_utilization.pro_id', '=', 'db_research_project.id')
                    ->selectRaw('db_utilization.id,db_research_project.pro_name_th,db_research_project.pro_name_en,
                                db_utilization.util_type,db_utilization.review_status')
                    ->ORDERBY('id','ASC')
                    ->get();

    $query_util_type = [1 => 'เชิงวิชาการ',
                        2 => 'เชิงสังคม/ชุมชน',
                        3 => 'เชิงนโยบาย',
                        4 => 'เชิงพาณิชย์'
                        ];
    // END FORM ----------------------------------------------------------------->

    return view('frontend.util',
    [
      "Total_util"             => $Total_util,
      "Total_academic_util"    => $Total_academic_util,
      "Total_social_util"      => $Total_social_util,
      "Total_policy_util"      => $Total_policy_util,
      "Total_commercial_util"  => $Total_commercial_util,

      'sl_research'  => $query_research,
      'sl_util'      => $query_util,
      'util_type'    => $query_util_type

    ]);
}

    // EDIT ---------------------------------------------------------------->
  // public function edit_util_form(Request $request){
  //
  //   $edit = util::where('id' , $request->id)->first();
  //
  //
  //   $edit2 = [1 => 'เชิงวิชาการ',
  //             2 => 'เชิงสังคม/ชุมชน',
  //             3 => 'เชิงนโยบาย',
  //             4 => 'เชิงพาณิชย์'
  //             ];
  //
  //    return view('frontend.util_edit',
  //      ['data'      => $edit,
  //       'data2'     => $edit2
  //      ]   /*นำตัวแปร data ไปใส่ใน research_edit.blade.php  คือ  value = "{{ $data->id }}"*/
  //   );
  // }
    // END EDIT ------------------------------------------------------------>


    // SAVE ----------------------------------------------------------------->
  public function save_util_form(Request $request){
    // dd($request);
    $update = util::where('id',$request->id)
                  ->update(['pro_id'        => $request->pro_id,
                            'util_type'            => $request->util_type,
                            'review_status'        => $request->review_status,
                            ]);

    if($update){
       return redirect()->back()->with('success','การบันทึกข้อมูลสำเร็จ');
    } else {
       return redirect()->back()->with('failure','การบันทึกข้อมูลไม่สำเร็จ !!');
    }
  }
    // END SAVE ------------------------------------------------------------>

// END TABLE LIST------------------------------------------------------------------>

}
