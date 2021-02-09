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
use Session;
use app\Exceptions\Handler;
use Illuminate\Support\Facades\Route;


class SummaryController extends Controller
{


  // public function summary(){
  //   return view('frontend.summary');
  // }


    public function table_summary(){
    // SUM BOX ------------------------------------------------------------------------>
      // โครงการวิจัยที่ทำเสร็จสิ้นทั้งหมด db_research_project -> โดย count id --------->
      if(Auth::hasRole('manager')){
        $Total_research = DB::table('db_research_project')
                        -> select('db_research_project.id','pro_name_th','pro_name_en','pro_position',
                                  'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                        ->get()
                        ->count();

      }elseif(Auth::hasRole('admin')) {
        $Total_research = DB::table('db_research_project')
                        -> select('db_research_project.id','pro_name_th','pro_name_en','pro_position',
                                  'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                        ->get()
                        ->count();

      }else {
        $Total_research = DB::table('db_research_project')
                        -> select('db_research_project.id','pro_name_th','pro_name_en','pro_position',
                                  'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                        -> where ('users_id', Auth::user()->preferred_username)
                        ->get()
                        ->count();
      }

      // โครงการวิจัยที่เป็นผู้วิจัยหลัก ที่ตรวจสอบแล้ว db_research_project -> โดย count id -> pro_position = 1 (เป็นผู้วิจัยหลัก)--------->
    if(Auth::hasRole('manager')){
      $Total_master_pro = DB::table('db_research_project')
                        -> select('db_research_project.id','pro_name_th','pro_name_en','pro_position',
                                  'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                        -> whereIn ('verified', ['1'])
                        -> whereIn ('pro_position', ['1'])
                        ->get()
                        ->count();

    }elseif(Auth::hasRole('admin')) {
      $Total_master_pro = DB::table('db_research_project')
                        -> select('db_research_project.id','pro_name_th','pro_name_en','pro_position',
                                  'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                        -> whereIn ('verified', ['1'])
                        -> whereIn ('pro_position', ['1'])
                        ->get()
                        ->count();

    }else {
      $Total_master_pro = DB::table('db_research_project')
                        -> select('db_research_project.id','pro_name_th','pro_name_en','pro_position',
                                  'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                        -> whereIn ('verified', ['1'])
                        -> whereIn ('pro_position', ['1'])
                        -> where ('users_id', Auth::user()->preferred_username)
                        ->get()->count();
    }

      // โครงการวิจัยที่ตีพิมพ์ ที่ตรวจสอบแล้ว db_research_project -> โดย count id -> publish_status = 1 (ใช่ )--------->
    if(Auth::hasRole('manager')){
      $Total_publish_pro = DB::table('db_research_project')
                        -> select('db_research_project.users_id','pro_name_th','pro_name_en','pro_position',
                                  'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                        -> whereIn ('verified', ['1'])
                        -> whereIn ('publish_status', ['1'])
                        ->get()
                        ->count();

    }elseif(Auth::hasRole('admin')) {
      $Total_publish_pro = DB::table('db_research_project')
                        -> select('db_research_project.users_id','pro_name_th','pro_name_en','pro_position',
                                  'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                        -> whereIn ('verified', ['1'])
                        -> whereIn ('publish_status', ['1'])
                        ->get()
                        ->count();

    }else {
      $Total_publish_pro = DB::table('db_research_project')
                        -> select('db_research_project.users_id','pro_name_th','pro_name_en','pro_position',
                                  'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                        -> whereIn ('verified', ['1'])
                        -> whereIn ('publish_status', ['1'])
                        -> where ('users_id', Auth::user()->preferred_username)
                        ->get()
                        ->count();
    }

      // บทความผู้นิพนธ์หลัก db_published_journal -> โดย count id -> contribute = ผู้นิพนธ์หลัก (first-author) --------->
      // $Total_master_journal = DB::table('db_published_journal')
      //                       -> select('db_published_journal.id','article_name_th','article_name_en','journal_name_th','journal_name_en',
      //                                 'publish_years','publish_no','publish_volume','publish_page','doi_number',
      //                                 'contribute','corres')
      //                       -> whereIn ('verified', ['1'])
      //                       -> where ('contribute', ['1'])
      //                       ->get()->count();

      // บทความตีพิมพ์ ที่ตรวจสอบแล้ว db_published_journal โดย count id -> verified = '1' (ตรวจสอบแล้ว) --------->
    if(Auth::hasRole('manager')){
      $Total_publish_journal = DB::table('db_published_journal')
                             -> select ('id','article_name_th','article_name_en','journal_name_th','journal_name_en',
                                       'publish_years','publish_no','publish_volume','publish_page','doi_number',
                                       'contribute','corres')
                             -> whereIn ('verified', ['1'])
                             ->get()
                             ->count();

     }elseif(Auth::hasRole('admin')) {
       $Total_publish_journal = DB::table('db_published_journal')
                              -> select ('id','article_name_th','article_name_en','journal_name_th','journal_name_en',
                                        'publish_years','publish_no','publish_volume','publish_page','doi_number',
                                        'contribute','corres')
                            -> whereIn ('verified', ['1'])
                            ->get()
                            ->count();

    }else {
      $Total_publish_journal = DB::table('db_published_journal')
                             -> select ('id','article_name_th','article_name_en','journal_name_th','journal_name_en',
                                       'publish_years','publish_no','publish_volume','publish_page','doi_number',
                                       'contribute','corres')
                             -> whereIn ('verified', ['1'])
                             -> where ('users_id', Auth::user()->preferred_username)
                             ->get()
                             ->count();
    }

      // บทความที่นำไปใช้ประโยชน์เชิงวิชาการ db_utilization -> โดย count id -> util_type = เชิงวิชาการ --------->
      // $Total_academic_util = DB::table('db_utilization')
      //                       -> select('pro_id','util_type')
      //                       -> where ('util_type', '=', 'เชิงวิชาการ')
      //                       ->get()->count();

      // บทความที่นำไปใช้ประโยชน์เชิงนโยบาย db_utilization -> โดย count id -> util_type = เชิงนโยบาย --------->
    if(Auth::hasRole('manager')){
      $Total_policy_util = DB::table('db_utilization')
                            -> select('pro_id','util_type')
                            -> where ('util_type', '=', 'เชิงนโยบาย')
                            -> whereIn ('verified', ['1'])
                            ->get()
                            ->count();

    }elseif(Auth::hasRole('admin')) {
      $Total_policy_util = DB::table('db_utilization')
                            -> select('pro_id','util_type')
                            -> where ('util_type', '=', 'เชิงนโยบาย')
                            -> whereIn ('verified', ['1'])
                            ->get()
                            ->count();

    }else {
      $Total_policy_util = DB::table('db_utilization')
                            -> select('pro_id','util_type')
                            -> where ('util_type', '=', 'เชิงนโยบาย')
                            -> whereIn ('verified', ['1'])
                            -> where ('users_id', Auth::user()->preferred_username)
                            ->get()
                            ->count();
    }
    // END SUM BOX ------------------------------------------------------------------------>


    // TABLE LIST ------------------------------------------------------------------------>

      $data_table_count = DB::table('db_research_project')
          ->leftjoin ('db_published_journal', 'db_research_project.id', '=', 'db_published_journal.pro_id')
          ->leftjoin ('db_utilization', 'db_research_project.id', '=', 'db_utilization.pro_id')
          ->leftjoin ('db_summary', 'db_research_project.users_id', '=', 'db_summary.users_id')

          ->select('db_research_project.users_name','db_research_project.researcher_level')
          // โครงการวิจัยที่เสร็จสิ้นทั้งหมด ที่ตรวจสอบแล้ว  // จำนวน count -> verified = '1'
          ->selectRaw("count(DISTINCT(case when db_research_project.verified = '1' then db_research_project.id end)) as count_verified_pro")
          // โครงการวิจัยที่เป็นผู้วิจัยหลัก ที่ตรวจสอบแล้ว  // จำนวน count -> pro_position = '1' -> verified = '1'
          ->selectRaw("count(DISTINCT(case when db_research_project.pro_position = '1' and db_research_project.verified = '1' then db_research_project.id end)) as count_master_pro")
          // บทความตีพิมพ์ ที่ตรวจสอบแล้ว  // จำนวน count -> verified = '1'
          ->selectRaw("count(DISTINCT(case when db_published_journal.verified = '1' then db_published_journal.id end)) as count_verified_journal")
          // โครงการที่นำไปใช้ประโยชน์ เชิงนโยบาย ที่ตรวจสอบแล้ว  // จำนวน count -> util_type = 'เชิงนโยบาย' -> verified = '1'
          ->selectRaw("count(DISTINCT(case when db_utilization.util_type = 'เชิงนโยบาย' and db_research_project.verified = '1' then db_utilization.pro_id end)) as count_policy_util")

          ->GROUPBY ('db_research_project.users_name','db_research_project.researcher_level')
          ->get();

// dd($data_table_count);

        $select_lev = [1      => 'นักวิจัยฝึกหัด',
                       2      => 'นักวิจัยรุ่นใหม่',
                       3      => 'นักวิจัยรุ่นกลาง',
                       4      => 'นักวิจัยอาวุโส'
                       ];


      return view('frontend.summary',
      [
        'Total_research'          => $Total_research,
        'Total_master_pro'        => $Total_master_pro,
        'Total_publish_pro'       => $Total_publish_pro,
        // 'Total_master_journal'    => $Total_master_journal,
        'Total_publish_journal'   => $Total_publish_journal,
        'Total_policy_util'       => $Total_policy_util,

        'user_list'               => $data_table_count,
        'user_lev'               => $select_lev,

      ]);
    }
// END TABLE LIST ----------------------------------------------------------------->


    // EDIT ----------------------------------------------------------------->
    public function edit_summary(Request $request){

      // // users
      // $edit_0 = research::where('id' , $request->id)->first();

      $edit_0 = DB::table('db_research_project')
                  -> leftjoin ('db_summary', 'db_research_project.users_id', '=', 'db_summary.users_id')
                  -> select ('db_research_project.id','db_research_project.users_id',
                             'db_research_project.users_name','db_summary.researcher_level','db_summary.data_auditor')
                  -> where ('db_research_project.users_name', $request->id)
                  ->first();


      // ระดับนักวิจัย researcher_level
      $edit_2 = [1      => 'นักวิจัยฝึกหัด',
                 2      => 'นักวิจัยรุ่นใหม่',
                 3      => 'นักวิจัยรุ่นกลาง',
                 4      => 'นักวิจัยอาวุโส'
                 ];
// dd($edit_2);


      return view('frontend.summary_edit',
      [
         'edit_users'        => $edit_0,
         'edit_lev'          => $edit_2
      ]);
      }
      // END EDIT ----------------------------------------------------------------->


      // INSERT ------------------------------------------------------------->
          // public function insert(Request $request){
          //   $data_post = [
          //     "users_id"              => Auth::user()->preferred_username,
          //     "users_name"            => Auth::user()->name,
          //     "researcher_level"      => $request->researcher_level,
          //     "data_auditor"          => $request->data_auditor,
          //     "created_at"            => date('Y-m-d H:i:s')
          //
          //   ];
          //   $insert = summary::insert($data_post);
          //
          //   if($insert){
          //     return redirect()->route('page.summary')->with('swl_add', 'เพิ่มข้อมูลสำเร็จแล้ว');
          // }else {
          //     return redirect()->back()->with('swl_err', 'บันทึกแล้ว');
          //   }
          // }
      // END INSERT ----------------------------------------------------------->


      // SAVE ----------------------------------------------------------------->
      public function save_summary(Request $request){

      // $update = DB::table('db_summary')
      //                 -> where ('users_name', $request->users_name)
      //                 ->where('id', $request->id)
      //
      //                 ->update([
      //                         'users_id'              => Auth::user()->preferred_username,
      //                         'users_name'            => Auth::user()->name,
      //                         'researcher_level'      => $request->researcher_level,
      //                         'data_auditor'          => $request->data_auditor
      //                         ]);


      $update = DB::table('db_research_project')
                      ->where('users_name', $request->users_name)
                      ->update([
                              'researcher_level'      => $request->researcher_level,
                              'updated_at'            => date('Y-m-d H:i:s')

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
