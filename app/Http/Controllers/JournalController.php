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


class JournalController extends Controller
{


  public function journal(){
    return view('frontend.journal');
  }



  //  -- SELECT SHOW DataTables--
  public function table_journal(){
    $query  = research::select('id','pro_name_en')->get();

    $query2 = journal::select(
                              'id',
                              'article_name_th',
                              'journal_name_th',
                              'publish_years',
                              'corres'
                              )
                        ->ORDERBY('id','DESC')
                        ->get();

    $query3 = [1=> 'ผู้นิพนธ์หลัก (first-author)',
               2=> 'ผู้นิพนธ์ร่วม (co-author)'
              ];

    $query4 = [1=> 'ใช่',
               2=> 'ไม่ใช่'
              ];

    return view('frontend.journal',
      [
        'journal_5'   => $query,
        'journals'    => $query2,
        'contribute'  => $query3,
        'corres'      => $query4

     ]);
  }
  //  -- END SELECT --




  //  -- EDIT JOURNAL--
  public function edit_journal_form(Request $request){
    //แสดงข้อมูล Query
    $edit = DB::table('db_published_journal')
              ->join('db_research_project', 'db_research_project.id', '=', 'db_published_journal.pro_id')
              ->select(
                        'db_research_project.id',
                        'db_research_project.pro_name_en',
                        'db_published_journal.pro_id',
                        'db_published_journal.article_name_th',
                        'db_published_journal.article_name_en',
                        'db_published_journal.journal_name_th',
                        'db_published_journal.journal_name_en',
                        'db_published_journal.publish_years',
                        'db_published_journal.publish_no',
                        'db_published_journal.publish_volume',
                        'db_published_journal.publish_page',
                        'db_published_journal.doi_number',
                        'db_published_journal.contribute',
                        'db_published_journal.corres'
                      )
              ->where('db_research_project.id', $request->id)
              ->first();

              // dd($edit);

    $edit2 = [1=> 'ผู้วิจัยหลัก',
              2=> 'ผู้วิจัยหลัก-ร่วม',
              3=> 'ผู้วิจัยร่วม',
              4=> 'ผู้ช่วยวิจัย',
              5=> 'ที่ปรึกษาโครงการ'
             ];

     $edit3 = [1=> 'ผู้นิพนธ์หลัก (first-author)',
               2=> 'ผู้นิพนธ์ร่วม (co-author)'
              ];

      $edit4 = [1=> 'ใช่',
                2=> 'ไม่ใช่'
               ];

     return view('frontend.journal_edit',
     [
        'data'  => $edit,
        'datax' => $edit2,
        'datay' => $edit3,
        'dataz' => $edit4
     ]);
  }
  //  -- END EDIT --




  //  INSERT
  public function insert(Request $request){
    // dd($data_post);
    $data_post = [
      "article_name_th"   => $request->article_name_th,
      "article_name_en"   => $request->article_name_en,
      "journal_name_th"   => $request->journal_name_th,
      "journal_name_en"   => $request->journal_name_en,
      "publish_years"     => $request->publish_years,
      "publish_no"        => $request->publish_no,
      "publish_volume"    => $request->publish_volume,
      "publish_page"      => $request->publish_page,
      "doi_number"        => $request->doi_number,
      "contribute"        => $request->contribute,
      "corres"            => $request->corres,
      "pro_id"            => $request->pro_id,
      "files"             => $request->files,
      "created_at"        => date('Y-m-d H:i:s')
    ];

    // dd($data_post);

      //  --  UPLOAD FILE journal_form  --
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

    $insert = journal::insert($data_post);

    if($insert){
      //return Sweet Alert
        return redirect()->route('page.journal')->with('swl_add', 'เพิ่มข้อมูลสำเร็จแล้ว');
    }else {
        return redirect()->back()->with('swl_err', 'บันทึกแล้ว');
    }
  }
  //  -- END INSERT --









  //  -- SAVE --
  public function save_journal_form(Request $request){
    // dd($request);
    $update = journal::where('id',$request->id)
                      ->update([
                                "pro_id"            => $request->pro_id,
                                "article_name_th"   => $request->article_name_th,
                                "article_name_en"   => $request->article_name_en,
                                "journal_name_th"   => $request->journal_name_th,
                                "journal_name_en"   => $request->journal_name_en,
                                "publish_years"     => $request->publish_years,
                                "publish_no"        => $request->publish_no,
                                "publish_volume"    => $request->publish_volume,
                                "publish_page"      => $request->publish_page,
                                "doi_number"        => $request->doi_number,
                                "contribute"        => $request->contribute,
                                "corres"            => $request->corres,
                              ]);

    if($update){
       return redirect()->back()->with('success','การบันทึกข้อมูลของคุณเสร็จสิ้นแล้ว');
    } else {
       return redirect()->back()->with('success','การบันทึกข้อมูลของคุณไม่สำเร็จ !!!');
    }
  }
  //  -- END SAVE --

}
