<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Illuminate\Contracts\Auth\Guard;
use App\CmsHelper;
use App\summary;
use App\member;
use App\depart;
use App\research;
use App\journal;
use Storage;
use File;
use Auth;
// use Illuminate\Support\Facades\Route;
// use Illuminate\Routing\Controller;
// use App\KeycloakUser;
// use GuzzleHttp\Client;
// use GuzzleHttp\Exception\RequestException;


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
      $Total_master_journal = DB::table('db_published_journal')
                            -> select('db_published_journal.id','article_name_th','article_name_en','journal_name_th','journal_name_en',
                                      'publish_years','publish_no','publish_volume','publish_page','doi_number',
                                      'contribute','corres')
                            -> where ('contribute', ['1'])
                            ->get()->count();

      // บทความตีพิมพ์ db_published_journal โดย count id (All Record) --------->
      $Total_publish_journal = DB::table('db_published_journal')
                             -> select ('id','article_name_th','article_name_en','journal_name_th','journal_name_en',
                                       'publish_years','publish_no','publish_volume','publish_page','doi_number',
                                       'contribute','corres')
                             ->get()->count();
      // END SUM BOX --




    // TABLE LIST --

      $data_table_1 = DB::table('db_research_project')
          ->leftjoin('db_published_journal', 'db_research_project.id', '=', 'db_published_journal.pro_id')
          ->leftjoin('db_utilization', 'db_research_project.id', '=', 'db_utilization.pro_id')
          ->select("db_research_project.users_name")
          ->selectRaw("count(db_research_project.id) as totals")
          ->selectRaw("count(case when db_research_project.pro_position = '1' then 1 end) as position")
          ->selectRaw("count(db_published_journal.id) as public")
          ->selectRaw("count(case when db_utilization.util_type = 'เชิงวิชาการ' then 1 end) as util")
          ->GROUPBY ('db_research_project.users_name')
          ->get();
        // dd($query);


        //Query ค่าบทความที่นำไปใช้ แยกออกมา เพื่อนำไปหยอดใน foreach ข้างล่าง
        // $abc
        // ->count();
        //
        // //ใส่ในนี้
        // $arr = [];
        // foreach ($variable as $value) {
        //
        //   $arr[$value->users_id] = $value->countNO;
        // }

      return view('frontend.summary',
      [
        'Total_research'          => $Total_research,
        'Total_master_pro'        => $Total_master_pro,
        'Total_publish_pro'       => $Total_publish_pro,
        'Total_master_journal'    => $Total_master_journal,
        'Total_publish_journal'   => $Total_publish_journal,
        'user_list'               => $data_table_1,
      ]);
    }
// END TABLE LIST ----------------------------------------------------------------->




    // EDIT ----------------------------------------------------------------->
    public function edit_summary(Request $request){

      // // users
      $edit_0 = member::where ('id', $request->id)
                      ->first();
      //
      // depart
      $edit_1 = DB::table ('users')
               	 -> join ('depart', 'depart.id', '=', 'users.depart_id')
               	 -> select ('depart.id','depart.depart_name')
                 ->first();

      // ระดับนักวิจัย researcher_level
      $edit_2 = ['นักวิจัยฝึกหัด'     => 'นักวิจัยฝึกหัด',
                 'นักวิจัยรุ่นใหม่'     => 'นักวิจัยรุ่นใหม่',
                 'นักวิจัยรุ่นกลาง'    => 'นักวิจัยรุ่นกลาง',
                 'นักวิจัยอาวุโส'     => 'นักวิจัยอาวุโส'
                 ];

      // ผู้ตรวจสอบข้อมูล data_auditor
      $edit_3 = ['นางสาวนัยนา ประดิษฐ์สิทธิกร'  => 'นางสาวนัยนา ประดิษฐ์สิทธิกร',
                 'นางสาวชลนที รอดสว่าง'      => 'นางสาวชลนที รอดสว่าง',
                 'นายอภิสิทธิ์ สนองค์'         => 'นายอภิสิทธิ์ สนองค์'
                ];


      return view('frontend.summary_edit',
      [
         'edit_users'        => $edit_0,
         'edit_depart'       => $edit_1,
         'edit_researchlev'  => $edit_2,
         'edit_auditorchk'   => $edit_3
      ]);
      }
      // END EDIT ----------------------------------------------------------------->


      // INSERT ------------------------------------------------------------->
          public function insert(Request $request){
            $data_post = [
              // "users_id"          => Auth::user()->id,
              "researcher_level"      => $request->researcher_level,
              "data_auditor"          => $request->data_auditor,
              "updated_at"            => date('Y-m-d H:i:s')
            ];
            $insert = summary::insert($data_post);

            if($insert){
              return redirect()->route('page.summary')->with('success', 'เพิ่มข้อมูลสำเร็จแล้ว');
          }else {
              return redirect()->back()->with('success', 'บันทึกแล้ว');
            }
          }
      // END INSERT ----------------------------------------------------------->


      // SAVE ----------------------------------------------------------------->
      public function save_summary(Request $request){
      // dd($request);
      $update = member::where('id',$request->id)
                      ->update([
                              'researcher_level'  => $request->researcher_level,
                              'data_auditor'      => $request->data_auditor
                              ]);

      if($update){
        //return Sweet Alert
         return redirect()->route('page.summary')->with('success','บันทึกข้อมูลสำเร็จ');
      } else {
         return redirect()->back()->with('failure','บันทึกข้อมูลไม่สำเร็จ !!');
      }
      }
      // END SAVE ----------------------------------------------------------------->


      //  -- DOWNLOAD --
      // public function DownloadFile(Request $request){
      //   $query = DB::table('db_research_project')
      //                 ->select('id', 'files')
      //                 ->where('id', $request->id)
      //                 ->first();
      //
      //   if(!$query) return abort(404);
      //
      //   $path = $query->files;
      //
      //   return Storage::disk('research')->download($path);

      //  -- END DOWNLOAD --


}
