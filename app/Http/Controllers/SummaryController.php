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
use app\Exceptions\Handler;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

// use Illuminate\Support\Arr;


class SummaryController extends Controller
{
  public function table_summary($status=1){
    if(Gate::allows('user')){
      return redirect()->route('page.profile');
    }

    $research = [
      "all" => 0,
      "verify" => 0,
      "pi" => 0,
      "users" => 0
    ];
    $journal = [
      "all" => 0,
      "verify" => 0,
      "tci1" => 0,
      "q1q3" => 0
    ];
    $util = [
      "all" => 0,
      "verify" => 0,
      "policy" => 0,
    ];
    // $verified_list = [
    //   1   => 'นักวิจัยฝึกหัด',
    //   2   => 'นักวิจัยรุ่นใหม่',
    //   3   => 'นักวิจัยรุ่นกลาง',
    //   4   => 'นักวิจัยอาวุโส'
    // ];
    $verified_list = [
      1   => 'ระดับฝึกหัด',
      2   => 'ระดับต้น',
      3   => 'ระดับกลาง',
      4   => 'ระดับอาวุโส'
    ];

    $tbheader = [];
    $tbbody = [];
    $tbtemp = [];

    function box($arr,$name,$id) {
      $temp = empty($arr[$name][$id])?0:$arr[$name][$id];
      if( $temp==0 ) {
        $temp = "<span class='text-danger'>".$temp."</span>";
      }
      return $temp;
    }

    $arrlv = [];
    $query = DB::table("ref_research")->get();
    foreach($query as $item) {
      $arrlv[$item->id] = $item->position_res;
    }

    if(Gate::allows('admin') || Gate::allows('manager')){
      //หาสมัครที่ยังอยู่ และ ออกไปแล้ว --------------------------------------------
      $data_users = DB::table('users')
              ->where('idCard','!=','00000000000')
              ->where('idCard','not like','u%')
              ->whereNull("deleted_users")
              ->get();
      $users_active = [];
      foreach($data_users as $item) {

          $users_active[] = $item->idCard;
          //-------------------------------------------------
          if($item->researcher_level == 1) {
            $tbtemp['relv'][$item->idCard] = "<span class='badge text-white' style='background-color:#5DADE2; font-size: 14px;'>".$verified_list[$item->researcher_level]."</span>";
          }
          else if($item->researcher_level == 2) {
            $tbtemp['relv'][$item->idCard] = "<span class='badge text-white' style='background-color:#45B39D; font-size: 14px;'>".$verified_list[$item->researcher_level]."</span>";
          }
          else if($item->researcher_level == 3) {
            $tbtemp['relv'][$item->idCard] = "<span class='badge text-white' style='background-color:#F5B041; font-size: 14px;'>".$verified_list[$item->researcher_level]."</span>";
          }
          else {
            $tbtemp['relv'][$item->idCard] = "<span class='badge bg-danger'> No results </span>";
          }
          //-------------------------------------------------
          if( is_null($item->idCard) ) {
            $tbtemp['data_auditor'][$item->idCard] = "<span class='badge bg-danger'> No results </span>";
          }else{
            if( !empty($item->data_auditor) ) {
              $tbtemp['data_auditor'][$item->idCard] =  $item->data_auditor.
              "<br><small><font color='red'>(".CmsHelper::DateThai($item->updated_at).")</font></small>";
            }

          }
          //-------------------------------------------------

      }
      $users_active = array_unique($users_active);

      //ข้อมูลโครงการวิจัย-----------------------------------------------------------------------
      $data_research = DB::table('db_research_project')
              ->select("users_id","verified", "pro_position")
              ->whereNull('deleted_at')
              // ->whereIn('users_id', $users_active)
              ->get();
      $temp = [];
      foreach($data_research as $item) {
        if( empty($tbtemp['research'][$item->users_id]) ) {
          $tbtemp['research'][$item->users_id] = 0;
          $tbtemp['research_pi'][$item->users_id] = 0;
        }
        //............................................
        $research['all']++;
        if($item->verified == 1) {
          $research['verify']++;
          $tbtemp['research'][$item->users_id]++;

          if($item->pro_position <= 2) {
            $research['pi']++;
            $tbtemp['research_pi'][$item->users_id]++;
          }
          if( in_array($item->users_id, $users_active) ) {
            $temp[] = $item->users_id;
          }
        }
      }
      $research['users'] = count(array_unique($temp));
      //การตีพิมพ์วารสาร-----------------------------------------------------------------------
      $data_journal = DB::table('db_published_journal')
              ->select("users_id","verified", "status")
              ->whereNull('deleted_at')
              // ->whereIn('users_id', $users_active)
              ->get();
      foreach($data_journal as $item) {
        if( empty($tbtemp['journal_verify'][$item->users_id]) ) {
          $tbtemp['journal_verify'][$item->users_id] = 0;
          $tbtemp['journal_tci1'][$item->users_id] = 0;
          $tbtemp['journal_q1q3'][$item->users_id] = 0;
          $tbtemp['journal_not'][$item->users_id] = 0;
        }
        //............................................
        $journal['all']++;
        if($item->verified == 1) {
          $journal['verify']++;
          $tbtemp['journal_verify'][$item->users_id]++;

          if($item->status == 1) {
            $journal['tci1']++;
            $tbtemp['journal_tci1'][$item->users_id]++;
          }
          else if($item->status == 4 || $item->status == 5 || $item->status == 6) {
            $journal['q1q3']++;
            $tbtemp['journal_q1q3'][$item->users_id]++;
          }
        }
        else if($item->verified == 9) {
          $tbtemp['journal_not'][$item->users_id]++;
        }
      }
      //การนำไปใช้ประโยชน์-----------------------------------------------------------------------
      $data_util = DB::table('db_utilization')
            ->select("users_id","verified", "util_type")
            ->whereNull('deleted_at')
            // ->whereIn('users_id', $users_active)
            ->get();
      foreach($data_util as $item) {
        if( empty($tbtemp['util'][$item->users_id]) ) {
          $tbtemp['util'][$item->users_id] = 0;
        }
        //............................................
        $util['all']++;
        if($item->verified == 1) {
          $util['verify']++;
          $tbtemp['util'][$item->users_id]++;
          if($item->util_type == 'เชิงนโยบาย') {
            $util['policy']++;
          }
        }
      }

      $tbheader[] = "ชื่อ-นามสกุล";
      $tbheader[] = "ตำแหน่ง";
      $tbheader[] = "หน่วยงาน";
      $tbheader[] = "โครงการวิจัย";
      $tbheader[] = "ตำแหน่ง PI & Co-PI";
      $tbheader[] = "วารสาร (ผู้นิพนธ์หลัก)";
      $tbheader[] = "วารสาร (TCI 1)";
      $tbheader[] = "วารสาร (Q1-Q3)";
      $tbheader[] = "วารสาร (ผู้นิพนธ์ร่วม)";
      $tbheader[] = "การนำไปใช้ประโยชน์";
      $tbheader[] = "ระดับนักวิจัย";
      $tbheader[] = "ผู้ตรวจสอบ";
      $tbheader[] = "Actions";

      foreach($data_users as $item) {
        $cid = $item->idCard;
        $btn = "<button type='button' class='btn btn-primary btn-md' title='Auditor'
                onclick=\"popup('$cid')\">
                <i class='fas fa-bars'></i>
                </button>";


        if( $status==1 ) {
          $addrow = (!empty($tbtemp['research'][$cid]) || !empty($tbtemp['journal_verify'][$cid]));
        }else{
          $addrow = !(!empty($tbtemp['research'][$cid]) || !empty($tbtemp['journal_verify'][$cid]));
        }
        if( $addrow ) {
          $temp = [
            "<div align='left'>".$item->title.$item->fname." ".$item->lname."</div>",
            "<div align='left'>".$item->position."</div>",
            "<div align='left'>".$item->deptName."</div>",
            box($tbtemp,'research',$cid),
            box($tbtemp,'research_pi',$cid),
            box($tbtemp,'journal_verify',$cid),
            box($tbtemp,'journal_tci1',$cid),
            box($tbtemp,'journal_q1q3',$cid),
            box($tbtemp,'journal_not',$cid),
            box($tbtemp,'util',$cid),
            empty($tbtemp['relv'][$cid])?"<span class='badge bg-danger'> No results </span>":$tbtemp['relv'][$cid],
            empty($tbtemp['data_auditor'][$cid])?"<span class='badge bg-danger'> No results </span>":$tbtemp['data_auditor'][$cid],
            $btn
          ];
          $tbbody[] = $temp;
        }
      }
    }








    else if(Gate::allows('departments')) {
      //หาสมัครที่ยังอยู่ และ ออกไปแล้ว --------------------------------------------
      $data_users = DB::table('users')
              ->where('idCard','!=','00000000000')
              ->where('idCard','not like','u%')
              ->whereNull("deleted_users")
              ->where('dept_id', Session::get('dep_id'))
              ->get();
      $users_active = [];
      foreach($data_users as $item) {
          $users_active[] = $item->idCard;
          //-------------------------------------------------
          if($item->researcher_level == 1) {
            $tbtemp['relv'][$item->idCard] = "<span class='badge' style='background-color:#5DADE2;'>".$verified_list[$item->researcher_level]."</span>";
          }
          else if($item->researcher_level == 2) {
            $tbtemp['relv'][$item->idCard] = "<span class='badge' style='background-color:#45B39D;'>".$verified_list[$item->researcher_level]."</span>";
          }
          else if($item->researcher_level == 3) {
            $tbtemp['relv'][$item->idCard] = "<span class='badge' style='background-color:#F5B041;'>".$verified_list[$item->researcher_level]."</span>";
          }
          else {
            $tbtemp['relv'][$item->idCard] = "<span class='badge bg-danger'> No results </span>";
          }
          //-------------------------------------------------
          if( is_null($item->idCard) ) {
            $tbtemp['data_auditor'][$item->idCard] = "<span class='badge bg-danger'> No results </span>";
          }else{
            $tbtemp['data_auditor'][$item->idCard] =  $item->data_auditor.
            "<br><small><font color='red'>(".CmsHelper::DateThai($item->updated_at).")</font></small>";
          }
          //-------------------------------------------------
      }
      //ข้อมูลโครงการวิจัย-----------------------------------------------------------------------
      $data_research = DB::table('db_research_project')
              ->select("users_id","verified", "pro_position")
              ->whereNull('deleted_at')
              ->whereIn('users_id', $users_active)
              ->get();

      $temp = [];
      foreach($data_research as $item) {
        if( empty($tbtemp['research'][$item->users_id]) ) {
          $tbtemp['research'][$item->users_id] = 0;
          $tbtemp['research_pi'][$item->users_id] = 0;
        }
        //............................................
        $research['all']++;
        if($item->verified == 1) {
          $research['verify']++;
          $tbtemp['research'][$item->users_id]++;

          if($item->pro_position <= 2) {
            $research['pi']++;
            $tbtemp['research_pi'][$item->users_id]++;
          }
          if( in_array($item->users_id, $users_active) ) {
            $temp[] = $item->users_id;
          }
        }
      }

      $research['users'] = count(array_unique($temp));
      //การตีพิมพ์วารสาร-----------------------------------------------------------------------
      $data_journal = DB::table('db_published_journal')
              ->select("users_id","verified", "status")
              ->whereNull('deleted_at')
              ->whereIn('users_id', $users_active)
              ->get();
      foreach($data_journal as $item) {
        if( empty($tbtemp['journal_verify'][$item->users_id]) ) {
          $tbtemp['journal_verify'][$item->users_id] = 0;
          $tbtemp['journal_tci1'][$item->users_id] = 0;
          $tbtemp['journal_q1q3'][$item->users_id] = 0;
          $tbtemp['journal_not'][$item->users_id] = 0;
        }
        //............................................
        $journal['all']++;
        if($item->verified == 1) {
          $journal['verify']++;
          $tbtemp['journal_verify'][$item->users_id]++;

          if($item->status == 1) {
            $journal['tci1']++;
            $tbtemp['journal_tci1'][$item->users_id]++;
          }
          else if($item->status == 4 || $item->status == 5 || $item->status == 6) {
            $journal['q1q3']++;
            $tbtemp['journal_q1q3'][$item->users_id]++;
          }
        }
        else if($item->verified == 9) {
          $tbtemp['journal_not'][$item->users_id]++;
        }
      }
      //การนำไปใช้ประโยชน์-----------------------------------------------------------------------
      $data_util = DB::table('db_utilization')
            ->select("users_id","verified", "util_type")
            ->whereNull('deleted_at')
            ->whereIn('users_id', $users_active)
            ->get();
      foreach($data_util as $item) {
        if( empty($tbtemp['util'][$item->users_id]) ) {
          $tbtemp['util'][$item->users_id] = 0;
        }
        //............................................
        $util['all']++;
        if($item->verified == 1) {
          $util['verify']++;
          $tbtemp['util'][$item->users_id]++;
          if($item->util_type == 'เชิงนโยบาย') {
            $util['policy']++;
          }
        }
      }

      $tbheader[] = "ชื่อ-นามสกุล";
      $tbheader[] = "ตำแหน่ง";
      $tbheader[] = "โครงการวิจัย";
      $tbheader[] = "ตำแหน่ง PI & Co-PI";
      $tbheader[] = "วารสาร (ตรวจสอบแล้ว)";
      $tbheader[] = "วารสาร (TCI 1)";
      $tbheader[] = "วารสาร (Q1-Q3)";
      $tbheader[] = "วารสาร (ไม่ตรงเงื่อนไข)";
      $tbheader[] = "การนำไปใช้ประโยชน์";
      $tbheader[] = "ระดับนักวิจัย";
      foreach($data_users as $item) {
        $cid = $item->idCard;

        if( $status==1 ) {
          $addrow = (!empty($tbtemp['research'][$cid]) || !empty($tbtemp['journal_verify'][$cid]));
        }else{
          $addrow = !(!empty($tbtemp['research'][$cid]) || !empty($tbtemp['journal_verify'][$cid]));
        }
        if( $addrow ) {
          $temp = [
            "<div align='left'>".$item->title.$item->fname." ".$item->lname."</div>",
            "<div align='left'>".$item->position."</div>",
            box($tbtemp,'research',$cid),
            box($tbtemp,'research_pi',$cid),
            box($tbtemp,'journal_verify',$cid),
            box($tbtemp,'journal_tci1',$cid),
            box($tbtemp,'journal_q1q3',$cid),
            box($tbtemp,'journal_not',$cid),
            box($tbtemp,'util',$cid),
            empty($tbtemp['relv'][$cid])?"<span class='badge bg-danger'> No results </span>":$tbtemp['relv'][$cid],
          ];
          $tbbody[] = $temp;
        }
      }
    }


    return view('frontend.summary',[
      "status" => $status,
      "research" => $research,
      "journal" => $journal,
      "util" => $util,
      "verified_list" => $verified_list,

      "tbheader" => $tbheader,
      "tbbody" => $tbbody,
      "data_users" => $data_users
    ]);
  }

/*
  public function table_summary_old(){
      //---------- SUM BOX ------------------------------------------------------------------------>

      // โครงการวิจัยที่ทำเสร็จสิ้นทั้งหมด db_research_project -> โดย count id --------->
      // For "MANAGER"

      if(Gate::allows('manager')){
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
    }
    elseif (Gate::allows('departments')) {
          $Total_research = DB::table('db_research_project')
                              ->join('users', 'users.idCard', '=', 'db_research_project.users_id')
                              ->select('db_research_project.id','pro_name_th','pro_name_en','pro_position',
                                        'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                              // ->where('users.deptName', Auth::user()->family_name)
                              ->where('users.dept_id', Session::get('dep_id'))
                              ->whereNull('db_research_project.deleted_at')
                              ->get()
                              ->count();

          $Total_research_verify = DB::table('db_research_project')
                                    ->join('users', 'users.idCard', '=', 'db_research_project.users_id')
                                    ->select('db_research_project.id','pro_name_th','pro_name_en','pro_position',
                                              'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                                    // ->where('users.deptName', Auth::user()->family_name)
                                    ->where('users.dept_id', Session::get('dep_id'))
                                    ->whereNull('deleted_at')
                                    ->whereIn('verified', ['1'])
                                    ->get()
                                    ->count();

          $Total_research_position_pi = DB::table('db_research_project')
                                          ->join('users', 'users.idCard', '=', 'db_research_project.users_id')
                                          ->selectRaw('sum(if(db_research_project.pro_position <= 2, 1, 0)) AS position')
                                          // ->where('users.deptName', Auth::user()->family_name)
                                          ->where('users.dept_id', Session::get('dep_id'))
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
                                      // ->where('users.deptName', Auth::user()->family_name)
                                      ->where('users.dept_id', Session::get('dep_id'))
                                      ->whereNull('db_research_project.deleted_at')
                                      ->where('db_research_project.verified', 1)
                                      ->get()
                                      ->count();

      }elseif(Gate::allows('admin')) {
          $Total_research = DB::table('db_research_project')
                          -> select('db_research_project.id','pro_name_th','pro_name_en','pro_position',
                                    'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                          ->whereNull('deleted_at')
                          ->get()
                          ->count();
      }


      // บทความตีพิมพ์ ที่ตรวจสอบแล้ว db_published_journal โดย count id  --------->
      // For "MANAGER"
      if(Gate::allows('manager')){
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
    }elseif (Gate::allows('departments')) {
          $Total_journal = DB::table('db_published_journal')
                             ->join('users', 'users.idCard', '=', 'db_published_journal.users_id')
                             ->select('article_name_th','article_name_en','journal_name_th',
                                      'journal_name_en','publish_years','publish_no','publish_volume','publish_page',
                                      'doi_number','contribute','corres')
                            //  ->where('users.deptName', Auth::user()->family_name)
                             ->where('users.dept_id', Session::get('dep_id'))
                             ->whereNull('deleted_at')
                             ->get()
                             ->count();

          $Total_journal_verify = DB::table('db_published_journal')
                                    ->join('users', 'users.idCard', '=', 'db_published_journal.users_id')
                                    ->select('article_name_th','article_name_en','journal_name_th','journal_name_en',
                                              'publish_years','publish_no','publish_volume','publish_page','doi_number',
                                              'contribute','corres')
                                    // ->where('users.deptName', Auth::user()->family_name)
                                    ->where('users.dept_id', Session::get('dep_id'))
                                    ->whereNull('deleted_at')
                                    ->whereIn('verified', ['1'])
                                    ->get()
                                    ->count();

          $Total_journal_tci_1 = DB::table('db_published_journal')
                                  ->join('users', 'users.deptName', '=', 'db_published_journal.users_id')
                                  ->select('article_name_th','article_name_en','journal_name_th','journal_name_en',
                                            'publish_years','publish_no','publish_volume','publish_page','doi_number',
                                            'contribute','corres')
                                  // ->where('users.deptName', Auth::user()->family_name)
                                  ->where('users.dept_id', Session::get('dep_id'))
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
                                  // ->where('users.deptName', Auth::user()->family_name)
                                  ->where('users.dept_id', Session::get('dep_id'))
                                  ->whereNull('deleted_at')
                                  ->whereIn('verified', ['1'])
                                  ->whereIn('status', ['4'])
                                  ->OrwhereIn('status', ['5'])
                                  ->OrwhereIn('status', ['6'])
                                  ->get()
                                  ->count();

       }elseif(Gate::allows('admin')) {
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
      if(Gate::allows('manager')){
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
      }elseif (Gate::allows('departments')) {
          $Total_util = DB::table('db_utilization')
                          ->join('users', 'users.idCard', '=', 'db_utilization.users_id')
                          ->select('pro_id','util_type')
                          // ->where('users.deptName', Auth::user()->family_name)
                          ->where('users.dept_id', Session::get('dep_id'))
                          ->whereNull('deleted_at')
                          ->get()
                          ->count();

          $Total_util_verify = DB::table('db_utilization')
                                ->join('users', 'users.idCard', '=', 'db_utilization.users_id')
                                ->select('pro_id','util_type')
                                // ->where('users.deptName', Auth::user()->family_name)
                                ->where('users.dept_id', Session::get('dep_id'))
                                ->whereNull('deleted_at')
                                ->whereIn('verified', ['1'])
                                ->get()
                                ->count();

          $Total_util_policies = DB::table('db_utilization')
                                  ->join('users', 'users.idCard', '=', 'db_utilization.users_id')
                                  ->select('pro_id','util_type')
                                  // ->where('users.deptName', Auth::user()->family_name)
                                  ->where('users.dept_id', Session::get('dep_id'))
                                  ->where('util_type', '=', 'เชิงนโยบาย')
                                  ->whereIn('verified', ['1'])
                                  ->whereNull('deleted_at')
                                  ->get()
                                  ->count();

      }elseif(Gate::allows('admin')) {
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
      if(Gate::allows('manager')){
          // DATA SUMMARY TOTAL Table ***IMPORTANT*** and Use Cache
          $summary_list = Cache::remember('summary_list_new', '30', function () {
                return DB::table('summary_list_new')->get();
                // dd($summary_list);
          });

      // For "DEPARTMEMT"
      }elseif (Gate::allows('departments')) {
          // DATA SUMMARY TOTAL Table ***IMPORTANT*** and Use Cache
          $summary_list = DB::table('summary_list_new')
                ->select('fullname', 'position', 'countPro', 'countPosition', 'countJour',
                         'countJour_tci_one', 'countJour_q_one2three', 'countJour_not',
                         'countUtil_depart', 'researcher_level')
                // ->where('deptName', Auth::user()->family_name)
                ->where('dept_id', Session::get('dep_id'))
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


      return view('frontend.summary2',[
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
*/


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
