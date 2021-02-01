<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Illuminate\Contracts\Auth\Guard;
use App\CmsHelper;
use App\summary;
use App\research;
use App\journal;
use Storage;
use File;
use Auth;
use app\Exceptions\Handler;
use Illuminate\Support\Facades\Route;


class SummaryController extends Controller
{


  // public function summary(){
  //   return view('frontend.summary');
  // }


    public function table_summary(){
    // SUM BOX --
      // โครงการวิจัยที่ทำเสร็จ db_research_project -> โดย count id (All Record)--------->
      if(Auth::hasRole('user')) {
        $Total_research = DB::table('db_research_project')
                        -> select('db_research_project.id','pro_name_th','pro_name_en','pro_position',
                                  'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                        ->where('users_id', Auth::user()->preferred_username)
                        ->get()
                        ->count();

      }else {
        $Total_research = DB::table('db_research_project')
                        -> select('db_research_project.id','pro_name_th','pro_name_en','pro_position',
                                  'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                        ->get()
                        ->count();
      }

      // โครงการวิจัยที่เป็นผู้วิจัยหลัก db_research_project -> โดย count id -> pro_position = 1 (เป็นผู้วิจัยหลัก)--------->
      $Total_master_pro = DB::table('db_research_project')
                        -> select('db_research_project.id','pro_name_th','pro_name_en','pro_position',
                                  'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                        -> whereIn ('pro_position', ['1'])
                        ->get()->count();

      // โครงการวิจัยที่ตีพิมพ์ db_research_project -> โดย count id -> publish_status = 1 (ใช่ )--------->
      $Total_publish_pro = DB::table('db_research_project')
                        -> select('db_research_project.users_id','pro_name_th','pro_name_en','pro_position',
                                  'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                        -> whereIn ('publish_status', ['1'])
                        ->get()->count();

      // บทความผู้นิพนธ์หลัก db_published_journal -> โดย count id -> contribute = ผู้นิพนธ์หลัก (first-author) --------->
      // $Total_master_journal = DB::table('db_published_journal')
      //                       -> select('db_published_journal.id','article_name_th','article_name_en','journal_name_th','journal_name_en',
      //                                 'publish_years','publish_no','publish_volume','publish_page','doi_number',
      //                                 'contribute','corres')
      //                       -> where ('contribute', ['1'])
      //                       ->get()->count();

      // บทความตีพิมพ์ db_published_journal โดย count id (All Record) --------->
      $Total_publish_journal = DB::table('db_published_journal')
                             -> select ('id','article_name_th','article_name_en','journal_name_th','journal_name_en',
                                       'publish_years','publish_no','publish_volume','publish_page','doi_number',
                                       'contribute','corres')
                             ->get()->count();

      // บทความที่นำไปใช้ประโยชน์เชิงวิชาการ db_utilization -> โดย count id -> util_type = เชิงวิชาการ --------->
      $Total_academic_util = DB::table('db_utilization')
                            -> select('pro_id','util_type')
                            -> where ('util_type', '=', 'เชิงวิชาการ')
                            ->get()->count();
      // END SUM BOX --


    // TABLE LIST --

      $data_table_count = DB::table('db_research_project')
          ->leftjoin ('db_published_journal', 'db_research_project.id', '=', 'db_published_journal.pro_id')
          ->leftjoin ('db_utilization', 'db_research_project.id', '=', 'db_utilization.pro_id')

          ->select('db_research_project.users_name')
          ->selectRaw("count(DISTINCT(db_research_project.id)) as count_pro")
          ->selectRaw("count(DISTINCT(case when db_research_project.pro_position = '1' then db_research_project.id end)) as count_master_pro")
          ->selectRaw("count(DISTINCT(case when db_research_project.publish_status = '1' then db_research_project.id end)) as count_publish_pro")
          ->selectRaw("count(DISTINCT(db_published_journal.id)) as count_journal_pro")
          ->selectRaw("count(DISTINCT(case when db_utilization.util_type = 'เชิงวิชาการ' then db_utilization.pro_id end)) as count_acdemic_util")

          ->GROUPBY ('db_research_project.users_name')
          ->get();





// dd($data_table_count);


      return view('frontend.summary',
      [
        'Total_research'          => $Total_research,
        'Total_master_pro'        => $Total_master_pro,
        'Total_publish_pro'       => $Total_publish_pro,
        // 'Total_master_journal'    => $Total_master_journal,
        'Total_publish_journal'   => $Total_publish_journal,
        'Total_academic_util'     => $Total_academic_util,

        'user_list'               => $data_table_count,

      ]);
    }
// END TABLE LIST ----------------------------------------------------------------->


    // EDIT ----------------------------------------------------------------->
    public function edit_summary(Request $request){

      // // users
      // $edit_0 = research::where('users_id' , $request->users_id)->first();

      $edit_0 = DB::table('db_research_project')
                  -> select ('db_research_project.id','db_research_project.users_id',
                             'db_research_project.users_name','db_research_project.researcher_level')
                  ->first();

      // ระดับนักวิจัย researcher_level
      $edit_2 = [1     => 'นักวิจัยฝึกหัด',
                 2     => 'นักวิจัยรุ่นใหม่',
                 3     => 'นักวิจัยรุ่นกลาง',
                 4     => 'นักวิจัยอาวุโส'
                 ];



      return view('frontend.summary_edit',
      [
         'edit_users'        => $edit_0,
         'edit_lev'          => $edit_2
      ]);
      }
      // END EDIT ----------------------------------------------------------------->


      // INSERT ------------------------------------------------------------->
          public function insert(Request $request){
            $data_post = [
              "users_id"              => Auth::user()->preferred_username,
              "users_name"            => Auth::user()->name,
              "researcher_level"      => $request->researcher_level,
              // "data_auditor"          => $request->data_auditor,
            ];
            $insert = research::insert($data_post);

            if($insert){
              return redirect()->route('page.summary')->with('swl_add', 'เพิ่มข้อมูลสำเร็จแล้ว');
          }else {
              return redirect()->back()->with('swl_err', 'บันทึกแล้ว');
            }
          }
      // END INSERT ----------------------------------------------------------->


      // SAVE ----------------------------------------------------------------->
      public function save_summary(Request $request){
      // dd($request);
      // $update = DB::table('db_summary')
      //               ->where('users_id', $request->users_id)
      //               ->update([
      //                       'users_name'        => Auth::user()->name,
      //                       'researcher_level'  => $request->researcher_level,
      //                       // 'data_auditor'      => $request->data_auditor
      //                       ]);


      $update = DB::table('db_research_project')
                      ->where('users_id', $request->users_id)
                      ->update([
                              'researcher_level'  => $request->researcher_level,
                              // 'data_auditor'      => $request->data_auditor
                              ]);


      if($update){
        //return Sweet Alert
         return redirect()->route('page.summary')->with('swl_update','แก้ไขข้อมูลสำเร็จแล้ว');
      } else {
         return redirect()->back()->with('swl_errs','บันทึกข้อมูลไม่สำเร็จ');
      }
      }
      // END SAVE ----------------------------------------------------------------->




}
