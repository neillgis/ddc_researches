<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
use Illuminate\Support\Facades\Cache;

// use Illuminate\Support\Arr;


class SummaryController extends Controller
{


  // public function summary(){
  //   return view('frontend.summary');
  // }


    public function table_summary(){
//---------- SUM BOX ------------------------------------------------------------------------>

      // โครงการวิจัยที่ทำเสร็จสิ้นทั้งหมด db_research_project -> โดย count id --------->
      // For "MANAGER"
      if(Auth::hasRole('manager')){
          $Total_research = DB::table('db_research_project')
                              ->select('db_research_project.id','pro_name_th','pro_name_en','pro_position',
                                        'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                              ->whereNull('deleted_at')
                              ->get()
                              ->count();

          $Total_research_verify = DB::table('db_research_project')
                                    ->select('db_research_project.id','pro_name_th','pro_name_en','pro_position',
                                              'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                                    ->whereNull('deleted_at')
                                    ->whereIn('verified', ['1'])
                                    ->get()
                                    ->count();

          // $Total_research_position_pi = DB::table('db_research_project')
          //                                 ->select('db_research_project.id','pro_name_th','pro_name_en','pro_position',
          //                                           'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
          //                                 ->whereNull('deleted_at')
          //                                 ->whereIn('verified', ['1'])
          //                                 ->whereIn('pro_position', ['1'])
          //                                 ->OrwhereIn('pro_position', ['2'])
          //                                 ->get()
          //                                 ->count();
          $Total_research_position_pi = DB::table('db_research_project')
                                          ->selectRaw('sum(if(db_research_project.pro_position <= 2, 1, 0)) AS position')
                                          ->whereNull('deleted_at')
                                          ->whereIn('verified', ['1'])
                                          ->get();
          // Convert "String" to "Int"
          $num = $Total_research_position_pi[0]->position;
          $int_position_pi = (int)$num;
          // dd($int_position_pi);

          $Total_research_users = DB::table('db_research_project')
                                      ->rightjoin('users', 'db_research_project.users_id', '=', 'users.idCard')
                                      ->select('users_id')
                                      ->groupBy('db_research_project.users_id')
                                      ->whereNull('db_research_project.deleted_at')
                                      ->where('db_research_project.verified', 1)
                                      ->get()
                                      ->count();

      // For "DEPARTMENT"
    }elseif (Auth::hasRole('departments')) {
          $Total_research = DB::table('db_research_project')
                              ->join('users', 'users.idCard', '=', 'db_research_project.users_id')
                              ->select('db_research_project.id','pro_name_th','pro_name_en','pro_position',
                                        'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                              ->where('users.deptName', Auth::user()->family_name)
                              ->whereNull('db_research_project.deleted_at')
                              ->get()
                              ->count();

          $Total_research_verify = DB::table('db_research_project')
                                    ->join('users', 'users.idCard', '=', 'db_research_project.users_id')
                                    ->select('db_research_project.id','pro_name_th','pro_name_en','pro_position',
                                              'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                                    ->where('users.deptName', Auth::user()->family_name)
                                    ->whereNull('deleted_at')
                                    ->whereIn('verified', ['1'])
                                    ->get()
                                    ->count();

          $Total_research_position_pi = DB::table('db_research_project')
                                          ->join('users', 'users.idCard', '=', 'db_research_project.users_id')
                                          ->selectRaw('sum(if(db_research_project.pro_position <= 2, 1, 0)) AS position')
                                          ->where('users.deptName', Auth::user()->family_name)
                                          ->whereNull('deleted_at')
                                          ->whereIn('verified', ['1'])
                                          ->get();
          // Convert "String" to "int"
          $num = $Total_research_position_pi[0]->position;
          $int_position_pi = (int)$num;
          // dd($int_position_pi);


          $Total_research_users = DB::table('db_research_project')
                                      ->rightjoin('users', 'db_research_project.users_id', '=', 'users.idCard')
                                      ->select('users_id')
                                      ->groupBy('db_research_project.users_id')
                                      ->where('users.deptName', Auth::user()->family_name)
                                      ->whereNull('db_research_project.deleted_at')
                                      ->where('db_research_project.verified', 1)
                                      ->get()
                                      ->count();

      }elseif(Auth::hasRole('admin')) {
          $Total_research = DB::table('db_research_project')
                          -> select('db_research_project.id','pro_name_th','pro_name_en','pro_position',
                                    'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                          ->whereNull('deleted_at')
                          ->get()
                          ->count();
      }


      // บทความตีพิมพ์ ที่ตรวจสอบแล้ว db_published_journal โดย count id  --------->
      // For "MANAGER"
      if(Auth::hasRole('manager')){
          $Total_journal = DB::table('db_published_journal')
                             ->select('id','article_name_th','article_name_en','journal_name_th','journal_name_en',
                                       'publish_years','publish_no','publish_volume','publish_page','doi_number',
                                       'contribute','corres')
                             ->whereNull('deleted_at')
                             ->get()
                             ->count();

          $Total_journal_verify = DB::table('db_published_journal')
                                    ->select('id','article_name_th','article_name_en','journal_name_th','journal_name_en',
                                              'publish_years','publish_no','publish_volume','publish_page','doi_number',
                                              'contribute','corres')
                                    ->whereNull('deleted_at')
                                    ->whereIn('verified', ['1'])
                                    ->get()
                                    ->count();

          $Total_journal_tci_1 = DB::table('db_published_journal')
                                  ->select('id','article_name_th','article_name_en','journal_name_th','journal_name_en',
                                            'publish_years','publish_no','publish_volume','publish_page','doi_number',
                                            'contribute','corres')
                                  ->whereNull('deleted_at')
                                  ->whereIn('verified', ['1'])
                                  ->whereIn('status', ['1'])
                                  ->get()
                                  ->count();

          $Total_journal_q1_3 = DB::table('db_published_journal')
                                  ->select('id','article_name_th','article_name_en','journal_name_th','journal_name_en',
                                            'publish_years','publish_no','publish_volume','publish_page','doi_number',
                                            'contribute','corres')
                                  ->whereNull('deleted_at')
                                  ->whereIn('verified', ['1'])
                                  ->whereIn('status', ['4'])
                                  ->OrwhereIn('status', ['5'])
                                  ->OrwhereIn('status', ['6'])
                                  ->get()
                                  ->count();

      // For "DEPARTMEMT"
    }elseif (Auth::hasRole('departments')) {
          $Total_journal = DB::table('db_published_journal')
                             ->join('users', 'users.idCard', '=', 'db_published_journal.users_id')
                             ->select('article_name_th','article_name_en','journal_name_th',
                                      'journal_name_en','publish_years','publish_no','publish_volume','publish_page',
                                      'doi_number','contribute','corres')
                             ->where('users.deptName', Auth::user()->family_name)
                             ->whereNull('deleted_at')
                             ->get()
                             ->count();

          $Total_journal_verify = DB::table('db_published_journal')
                                    ->join('users', 'users.idCard', '=', 'db_published_journal.users_id')
                                    ->select('article_name_th','article_name_en','journal_name_th','journal_name_en',
                                              'publish_years','publish_no','publish_volume','publish_page','doi_number',
                                              'contribute','corres')
                                    ->where('users.deptName', Auth::user()->family_name)
                                    ->whereNull('deleted_at')
                                    ->whereIn('verified', ['1'])
                                    ->get()
                                    ->count();

          $Total_journal_tci_1 = DB::table('db_published_journal')
                                  ->join('users', 'users.deptName', '=', 'db_published_journal.users_id')
                                  ->select('article_name_th','article_name_en','journal_name_th','journal_name_en',
                                            'publish_years','publish_no','publish_volume','publish_page','doi_number',
                                            'contribute','corres')
                                  ->where('users.deptName', Auth::user()->family_name)
                                  ->whereNull('deleted_at')
                                  ->whereIn('verified', ['1'])
                                  ->whereIn('status', ['1'])
                                  ->get()
                                  ->count();

          $Total_journal_q1_3 = DB::table('db_published_journal')
                                  ->join('users', 'users.deptName', '=', 'db_published_journal.users_id')
                                  ->select('article_name_th','article_name_en','journal_name_th','journal_name_en',
                                            'publish_years','publish_no','publish_volume','publish_page','doi_number',
                                            'contribute','corres')
                                  ->where('users.deptName', Auth::user()->family_name)
                                  ->whereNull('deleted_at')
                                  ->whereIn('verified', ['1'])
                                  ->whereIn('status', ['4'])
                                  ->OrwhereIn('status', ['5'])
                                  ->OrwhereIn('status', ['6'])
                                  ->get()
                                  ->count();

       }elseif(Auth::hasRole('admin')) {
         $Total_journal = DB::table('db_published_journal')
                            ->select('db_research_project.id','article_name_th','article_name_en','journal_name_th','journal_name_en',
                                      'publish_years','publish_no','publish_volume','publish_page','doi_number',
                                      'contribute','corres')
                            ->whereNull('deleted_at')
                            ->whereIn('verified', ['1'])
                            ->get()
                            ->count();
      }


      // บทความที่นำไปใช้ประโยชน์เชิงนโยบาย db_utilization -> โดย count id --------->
      // For "MANAGER"
      if(Auth::hasRole('manager')){
          $Total_util = DB::table('db_utilization')
                          ->select('pro_id','util_type')
                          ->whereNull('deleted_at')
                          ->get()
                          ->count();

          $Total_util_verify = DB::table('db_utilization')
                                ->select('pro_id','util_type')
                                ->whereNull('deleted_at')
                                ->whereIn('verified', ['1'])
                                ->get()
                                ->count();

          $Total_util_policies = DB::table('db_utilization')
                                  ->select('pro_id','util_type')
                                  ->where('util_type', '=', 'เชิงนโยบาย')
                                  ->whereIn('verified', ['1'])
                                  ->whereNull('deleted_at')
                                  ->get()
                                  ->count();

      // For "DEPARTMEMT"
      }elseif (Auth::hasRole('departments')) {
          $Total_util = DB::table('db_utilization')
                          ->join('users', 'users.idCard', '=', 'db_utilization.users_id')
                          ->select('pro_id','util_type')
                          ->where('users.deptName', Auth::user()->family_name)
                          ->whereNull('deleted_at')
                          ->get()
                          ->count();

          $Total_util_verify = DB::table('db_utilization')
                                ->join('users', 'users.idCard', '=', 'db_utilization.users_id')
                                ->select('pro_id','util_type')
                                ->where('users.deptName', Auth::user()->family_name)
                                ->whereNull('deleted_at')
                                ->whereIn('verified', ['1'])
                                ->get()
                                ->count();

          $Total_util_policies = DB::table('db_utilization')
                                  ->join('users', 'users.idCard', '=', 'db_utilization.users_id')
                                  ->select('pro_id','util_type')
                                  ->where('users.deptName', Auth::user()->family_name)
                                  ->where('util_type', '=', 'เชิงนโยบาย')
                                  ->whereIn('verified', ['1'])
                                  ->whereNull('deleted_at')
                                  ->get()
                                  ->count();

      }elseif(Auth::hasRole('admin')) {
        $Total_policy_util = DB::table('db_utilization')
                              ->select('pro_id','util_type')
                              ->where('util_type', '=', 'เชิงนโยบาย')
                              ->whereIn('verified', ['1'])
                              ->whereNull('deleted_at')
                              ->get()
                              ->count();
      }
// --------------- END SUM BOX ------------------------------------------------------------------------>



// --------------- TABLE LIST ------------------------------------------------------------------------>

      $data_table_total = DB::table('db_research_project')

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


      // For "MANAGER"
      if(Auth::hasRole('manager')){
          // DATA SUMMARY TOTAL Table ***IMPORTANT*** and Use Cache
          $summary_list = Cache::remember('summary_list', '30', function () {
                return DB::table('summary_list')->get();
                // dd($summary_list);
          });

      // For "DEPARTMEMT"
      }elseif (Auth::hasRole('departments')) {
          // DATA SUMMARY TOTAL Table ***IMPORTANT*** and Use Cache
          $summary_list = DB::table('summary_list')
                ->select('fullname', 'countPro', 'countPosition', 'countJour',
                         'countJour_tci_one', 'countJour_q_one2three', 
                         'countUtil', 'researcher_level')
                ->where('deptName', Auth::user()->family_name)
                ->get();
      }



      // ก้อนที่ 1 RESEARCH  = 76 users
      // $users_total_research = DB::table('users')
      //                         ->join('db_research_project', 'users.idCard', '=', 'db_research_project.users_id')
      //                         ->selectRaw('count(db_research_project.users_id) AS count_research,
      //                                      sum(if(db_research_project.pro_position <= 2, 1, 0)) AS position,
      //                                      idCard,
      //                                      title,
      //                                      fname,
      //                                      lname,
      //                                      deptName
      //                                    ')
      //                         ->whereNull('db_research_project.deleted_at')
      //                         ->whereIn('db_research_project.verified', ['1'])
      //                         ->groupBy('db_research_project.users_id')
      //                         ->orderBy('users.id', 'ASC')
      //                         ->get();
                          // dd($users_total_research);

          // ก้อนที่ 2 JOURNAL  = 43 users
          // $users_total_journal = DB::table('users')
          //                         ->leftjoin('db_published_journal', 'users.idCard', '=', 'db_published_journal.users_id')
          //                         ->selectRaw('count(db_published_journal.users_id) AS count_journal,
          //                                      sum(if(status = 1, 1, 0)) AS tci_one,
          //                                      users_id,
          //                                      title,
          //                                      fname,
          //                                      lname
          //                                    ')
          //                               ->where('db_published_journal.users_id', 3609900892134)
          //                         ->whereNull('db_published_journal.deleted_at')
          //                         ->where('db_published_journal.verified', ['1'])
          //                         ->groupBy('db_published_journal.users_id')
          //                         ->orderBy('users.id', 'ASC')
          //                         ->get();
                              // dd($users_total_journal);


// -------------------------------------------------------------------------------------
        // TOTAL 190 users
        $users = DB::table('users')
                    ->select('idCard')
                    ->groupBy('idCard')
                    ->get();

        // TOTAL 102 users หาก Where ตามจำนวนนี้  ==> จะได้ทั้งหมด 76 users
        $research = DB::table('db_research_project')
                    // ->rightjoin('users', 'db_research_project.users_id', '=', 'users.idCard')
                    ->select('users_id')
                    ->groupBy('db_research_project.users_id')
                    ->whereNull('db_research_project.deleted_at')
                    ->where('db_research_project.verified', 1)
                    ->get()
                    ->count();

        // TOTAL 71 users
        $journal = DB::table('db_published_journal')
                    ->join('users', 'db_published_journal.users_id', '=', 'users.idCard')
                    ->select('users_id')
                    ->groupBy('users_id')
                    ->whereNull('db_published_journal.deleted_at')
                    ->get();

        // TOTAL 21 users
        $util = DB::table('db_utilization')
                    ->select('users_id')
                    ->groupBy('users_id')
                    ->orderBy('id')
                    ->get();
// -------------------------------------------------------------------------------------

        $verified_list = [  1   => 'นักวิจัยฝึกหัด',
                            2   => 'นักวิจัยรุ่นใหม่',
                            3   => 'นักวิจัยรุ่นกลาง',
                            4   => 'นักวิจัยอาวุโส'
                          ];


      return view('frontend.summary',[
        'Total_research'          => $Total_research,
        'Total_research_verify'   => $Total_research_verify,
        'int_position_pi'         => $int_position_pi, //Convert "String" to "Int"
        'Total_research_users'    => $Total_research_users,
        // -----------------------------------------------
        'Total_journal'           => $Total_journal,
        'Total_journal_verify'    => $Total_journal_verify,
        'Total_journal_tci_1'     => $Total_journal_tci_1,
        'Total_journal_q1_3'      => $Total_journal_q1_3,
        // -----------------------------------------------
        'Total_util'              => $Total_util,
        'Total_util_verify'       => $Total_util_verify,
        'Total_util_policies'     => $Total_util_policies,
        // -----------------------------------------------
        'data_table_total'        => $data_table_total,
        // 'users_total_research'    => $users_total_research,
        // 'users_total_journal'     => $users_total_journal,
        // -----------------------------------------------
        'summary_list'            => $summary_list,
        'verified_list'           => $verified_list,
      ]);

    }
// ------ END TABLE LIST ----------------------------------------------------------------->



    //  -- VERIFIED --
    public function auditor_verified(Request $request){
        //UPDATE Table users
        $verified = DB::table('users')
                      ->where('idCard', $request->idCard)
                      ->update([
                                'researcher_level'  => $request->researcher_level,
                                'data_auditor'      => $request->data_auditor,
                                'updated_at'        => date('Y-m-d H:i:s')
                              ]);

         // dd($verified);
         if($verified){
             session()->put('auditor', 'okkkkkayyyyy');
             return redirect()->route('page.summary');
         }else{
             return redirect()->back()->with('swl_err', 'บันทึกไม่สำเร็จ');
         }
       }
    //  -- END VERIFIED --


}
