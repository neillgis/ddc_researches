<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\summary;
use App\member;
use App\depart;
use App\research;
use App\journal;
use Storage;
use File;


class SummaryController extends Controller
{


  public function summary(){
    return view('frontend.summary');
  }


    public function table_summary(){

// SUM BOX ------------------------------------------------------------------------>

      // โครงการวิจัยที่ทำเสร็จ db_research_project -> โดย count id (All Record)--------->
      $Total_research = DB::table('db_research_project')
                      -> select('db_research_project.id','pro_name_th','pro_name_en','pro_position',
                                'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                      ->get()->count();
// dd($Total_research);


      // โครงการวิจัยที่เป็นผู้วิจัยหลัก db_research_project -> โดย count id -> pro_position = 1 (เป็นผู้วิจัยหลัก)--------->
      $Total_master_pro = DB::table('db_research_project')
                        -> select('db_research_project.id','pro_name_th','pro_name_en','pro_position',
                                  'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                        -> whereIn ('pro_position', ['1'])
                        ->get()->count();
// dd($Total_master_pro);


      // โครงการวิจัยที่ตีพิมพ์ db_research_project -> โดย count id -> publish_status = 1 (ใช่ )--------->
      $Total_publish_pro = DB::table('db_research_project')
                        -> select('db_research_project.users_id','pro_name_th','pro_name_en','pro_position',
                                  'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                        -> whereIn ('publish_status', ['1'])
                        ->get()->count();
// dd($Total_publish_pro);


      // บทความผู้นิพนธ์หลัก db_published_journal -> โดย count id -> contribute = ผู้นิพนธ์หลัก (first-author) --------->
      $Total_master_journal = DB::table('db_published_journal')
                            -> select('db_published_journal.id','article_name_th','article_name_en','journal_name_th','journal_name_en',
                                      'publish_years','publish_no','publish_volume','publish_page','doi_number',
                                      'contribute','corres')
                            -> where ('contribute', '=', 'ผู้นิพนธ์หลัก (first-author)')
                            ->get()->count();
// dd($Total_master_journal);


      // บทความตีพิมพ์ db_published_journal โดย count id (All Record) --------->
      $Total_publish_journal = DB::table('db_published_journal')
                             -> select ('id','article_name_th','article_name_en','journal_name_th','journal_name_en',
                                       'publish_years','publish_no','publish_volume','publish_page','doi_number',
                                       'contribute','corres')
                             ->get()->count();
// dd($Total_publish_journal);


// END SUM BOX -------------------------------------------------------------------------->


// TABLE LIST ---------------------------------------------------------------------------->

      // ชื่อ-นามสกุล, หน่วยงาน - ระดับนักวิจัย researcher_level, ผู้ตรวจสอบข้อมูล data_auditor
      $data_table_1 = DB::table ('users')
               	 -> join ('depart', 'depart.id', '=', 'users.depart_id')
                 // -> join ('db_research_project', 'db_research_project.users_id', '=', 'users.card_id')

               	 -> select ('depart.id as dept_id',
                            'depart.depart_name',
                            'users.id as uid','users.card_id',
                            'users.orcid_id','users.prefix',
                            'users.fname_th','users.lname_th',
                            'users.researcher_level','users.data_auditor')

                 -> ORDERBY('uid','ASC')
                 ->get();
// dd($data_table_1);

      // จำนวน โครงการวิจัยทั้งหมด ------------------------------------------------------------>
      $data_table_2 = DB::table ('users')
                 -> join ('db_research_project', 'db_research_project.users_id', '=', 'users.card_id')
                 -> selectRaw ('users.id as uid, count(DISTINCT db_research_project.id) AS total_research_count')
                 -> GROUPBY ('uid')
                 -> ORDERBY('uid','ASC')
                 ->get();
// dd($data_table_2);

      // จำนวน โครงการวิจัยที่เป็นผู้วิจัยหลักทั้งหมด ------------------------------------------------>
      $data_table_2_1 = DB::table ('users')
                 -> join ('db_research_project', 'db_research_project.users_id', '=', 'users.card_id')
                 -> selectRaw ('users.id as uid, count(DISTINCT db_research_project.id) AS master_research_count')
                 -> whereIn ('pro_position', ['1'])
                 -> GROUPBY ('uid')
                 -> ORDERBY('uid','ASC')
                 ->get();
// dd($data_table_2_1);

      // จำนวน บทความที่ตีพิมพ์ทั้งหมด --------------------------------------------------------->
      $data_table_3 = DB::table ('users')
                  -> join ('db_published_journal', 'db_published_journal.users_id', '=', 'users.card_id')
                  -> selectRaw ('users.id as uid, count(DISTINCT db_published_journal.id) AS total_journal_count')
                  -> GROUPBY ('uid')
                  -> ORDERBY('uid','ASC')
                  ->get();
// dd($data_table_3);

      // จำนวน บทความที่นำไปใช้ประโยชน์เชิงวิชาการ ---------------------------------------------->
      $data_table_3_1 = DB::table ('users')
                  -> join ('db_utilization', 'db_utilization.users_id', '=', 'users.card_id')
                  -> selectRaw ('users.id as uid, count(DISTINCT db_utilization.id) AS total_util_count')
                  -> where ('util_type', '=', 'เชิงวิชาการ')
                  -> GROUPBY ('uid')
                  -> ORDERBY('uid','ASC')
                  ->get();
// dd($data_table_3_1);


      return view('frontend.summary',
      [
        // Sum Box
        'Total_research'        => $Total_research,
        'Total_master_pro'      => $Total_master_pro,
        'Total_publish_pro'     => $Total_publish_pro,
        'Total_master_journal'  => $Total_master_journal,
        'Total_publish_journal' => $Total_publish_journal,

        //  ชื่อ-สกุล users, ระดับนักวิจัย researcher_level, ผู้ตรวจสอบข้อมูล data_auditor
        'user_list'               => $data_table_1,

        // จำนวน โครงการวิจัยทั้งหมด
        'research_count'          => $data_table_2,

        // จำนวน โครงการวิจัยที่เป็นผู้วิจัยหลักทั้งหมด
        'master_pro_count'        => $data_table_2_1,

        // จำนวน บทความที่ตีพิมพ์ทั้งหมด
        'publish_journal_count'   => $data_table_3,

        // จำนวน บทความที่นำไปใช้ประโยชน์เชิงวิชาการ
        'journal_academic_count'  => $data_table_3_1,


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
