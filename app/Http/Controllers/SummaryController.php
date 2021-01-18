<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\summary;
use App\member;
use App\depart;
use App\research;
use App\journal;


use Illuminate\Support\Facades\Storage;
use File;


class SummaryController extends Controller
{


    public function summary(){
      return view('frontend.summary');
    }


    // public function insert(Request $request){
    //   // dd($data_post);
    //   $data_post = [
    //     "orcid_id"              => $request->orcid_id,
    //     "pro_end_total"         => $request->pro_end_total,
    //     "pro_major_total"       => $request->pro_major_total,
    //     "pro_publish_total"     => $request->pro_publish_total,
    //     "util_result_academic"  => $request->util_result_academic,
    //     "researcher_level"      => $request->researcher_level,
    //     "data_auditor"          => $request->data_auditor,
    //   ];
    //   $insert = summary::insert($data_post);
    //   // $insert = DB::table('person_ddc_table')->insert($data_post);  /*person_ddc_table คือ = ชื่อ table*/
    //
    //   if($insert){
    //     return redirect()->back()->with('success','Insert Succussfully');
    //   } else {
    //     return redirect()->back()->with('success','Insert Failed');
    //   }
    // }




    public function table_summary(){

// SUM BOX ------------------------------------------------------------------------>

      // โครงการวิจัยที่ทำเสร็จ db_research_project -> โดย count id (All Record)--------->
      $Total_research = DB::table('db_research_project')

                      -> select('id','pro_name_th','pro_name_en','pro_position',
                                'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                      ->get()->count();
// dd($Total_research);


      // โครงการวิจัยที่เป็นผู้วิจัยหลัก db_research_project -> โดย count id -> pro_position = 1 (เป็นผู้วิจัยหลัก)--------->
      $Total_master_pro = DB::table('db_research_project')

                        -> select('id','pro_name_th','pro_name_en','pro_position',
                                  'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                        -> whereIn ('pro_position', ['1'])
                        ->get()->count();
// dd($Total_master_pro);


      // โครงการวิจัยที่ตีพิมพ์ db_research_project -> โดย count id -> publish_status = 1 (ใช่ )--------->
      $Total_publish_pro = DB::table('db_research_project')
                        -> select('id','pro_name_th','pro_name_en','pro_position',
                                  'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                        -> whereIn ('publish_status', ['1'])
                        ->get()->count();
// dd($Total_publish_pro);


      // บทความผู้นิพนธ์หลัก db_published_journal -> โดย count id -> contribute = 0 , ผู้นิพนธ์หลัก (first-author) --------->
      $Total_master_journal = DB::table('db_published_journal')
                            -> select('id','article_name_th','article_name_en','journal_name_th','journal_name_en',
                                      'publish_years','publish_no','publish_volume','publish_page','doi_number',
                                      'contribute','corres')
                            -> where ('contribute', '=', 'ผู้นิพนธ์หลัก (first-author)')
                            ->get()->count();
// dd($Total_master_journal);


      // บทความตีพิมพ์ db_published_journal โดย count id (All Record) --------->
      $Total_publish_journal = DB::table('db_published_journal')
                             -> select('id','article_name_th','article_name_en','journal_name_th','journal_name_en',
                                       'publish_years','publish_no','publish_volume','publish_page','doi_number',
                                       'contribute','corres')
                             ->get()->count();
// dd($Total_publish_journal);

// END SUM BOX ------------------------------------------------------------------------>


// TABLE ------------------------------------------------------------------------------------------>

      // $sl_member = member::select ('orcid_id','prefix','fname_th','lname_th','dep_id')
      //            // -> ORDERBY ('orcid_id','ASC')
      //            -> get ();

      $sl_research = research::select ('id','pro_name_th','pro_name_en','pro_position',
                                       'pro_start_date','pro_end_date','pro_co_researcher','publish_status')
                   -> get ();

      $sl_journal = journal::select('id','article_name_th','article_name_en','journal_name_th','journal_name_en',
                                    'publish_years','publish_no','publish_volume','publish_page','doi_number',
                                    'contribute','corres')
                  -> get ();


      $users_dep = DB::table('users')
               	    -> join ('depart', 'depart.id', '=', 'users.dep_id')
               	    -> select ('depart.id','depart.depart_name',
                               'users.orcid_id','users.prefix','users.fname_th','users.lname_th',)
                    -> get ();
// dd($users_dep);
      $researcher_level = [1=> 'นักวิจัยฝึกหัด',
                           2=> 'นักวิจัยรุ่นใหม่',
                           3=> 'นักวิจัยรุ่นกลาง',
                           4=> 'นักวิจัยอวุโส'
                           ];

      $data_auditor = [1=> 'นางสาวนัยนา ประดิษฐ์สิทธิกร',
                       2=> 'นางสาวชลนที รอดสว่าง',
                       3=> 'นายอภิสิทธิ์ สนองค์'
                       ];


// END TABLE ------------------------------------------------------------------------------------------>


      return view('frontend.summary',
      [
        "Total_research"        => $Total_research,
        "Total_master_pro"      => $Total_master_pro,
        "Total_publish_pro"     => $Total_publish_pro,
        "Total_master_journal"  => $Total_master_journal,
        "Total_publish_journal" => $Total_publish_journal,

        "datas"    => $sl_research, $sl_journal,

        "users_dep"             => $users_dep,

        "researcher_level"      => $researcher_level,
        "data_auditor"          => $data_auditor

    ]);
}

}
