<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CmsHelper;
use App\research;
use App\journal;
use Storage;
use File;
use Auth;
use Session;
use app\Exceptions\Handler;
use Illuminate\Support\Facades\Route;


class JournalController extends Controller
{


  // public function journal(){
  //   return view('frontend.journal');
  // }


  //  -- SELECT DataTables JOURNAL --
  public function table_journal(){
    if(Auth::hasRole('manager')){
      $query  = DB::table('db_research_project')
                     ->select('db_research_project.id',
                              'db_research_project.pro_name_en',
                              )
                     ->where('users_id', Auth::user()->preferred_username)
                     ->orderby('id', 'DESC')
                     ->get();

    }elseif(Auth::hasRole('admin')) {
      $query  = DB::table('db_research_project')
                     ->select('db_research_project.id',
                              'db_research_project.pro_name_en',
                              )
                     ->where('users_id', Auth::user()->preferred_username)
                     ->orderby('id', 'DESC')
                     ->get();

     }else {
       $query  = DB::table('db_research_project')
                      ->select('db_research_project.id',
                               'db_research_project.pro_name_en',
                               )
                      ->where('users_id', Auth::user()->preferred_username)
                      ->orderby('id', 'DESC')
                      ->get();
     }

     //   return response(redirect(url('/keycloak/login')), 404);
     //   return abort(404);


    if(Auth::hasRole('manager')){

      $query2 = DB::table('db_published_journal')
                ->join('db_research_project', 'db_research_project.id', '=', 'db_published_journal.pro_id')
                ->select('db_research_project.users_name',
                         'db_published_journal.id',
                         'db_published_journal.pro_id',
                         'db_published_journal.article_name_th',
                         'db_published_journal.article_name_en',
                         'db_published_journal.journal_name_th',
                         'db_published_journal.journal_name_en',
                         'db_published_journal.publish_years',
                         'db_published_journal.files',
                         'db_published_journal.corres',
                         'db_published_journal.verified',
                         \DB::raw('(CASE
                                       WHEN db_published_journal.verified = "1" THEN "ตรวจสอบแล้ว"
                                       ELSE "รอตรวจสอบ"
                                       END) AS verified'
                         ))
                // ->where('db_published_journal.id', $request->id)
                ->orderby('id', 'DESC')
                ->get();


      // $query2 = journal::select('id', 'pro_id', 'article_name_th', 'article_name_en',
      //                           'journal_name_th', 'journal_name_en', 'publish_years',
      //                           'corres', 'files', 'verified',
      //                           \DB::raw('(CASE
      //                                         WHEN verified = "1" THEN "ตรวจสอบแล้ว"
      //                                         ELSE "รอตรวจสอบ"
      //                                         END) AS verified'
      //                           ))
      //                 ->ORDERBY('id','DESC')
      //                 ->get();

    }
    elseif(Auth::hasRole('admin')){
      $query2 = journal::select('id', 'pro_id', 'article_name_th', 'article_name_en',
                                'journal_name_th', 'journal_name_en', 'publish_years',
                                'corres', 'files', 'verified',
                                \DB::raw('(CASE
                                              WHEN verified = "1" THEN "ตรวจสอบแล้ว"
                                              ELSE "รอตรวจสอบ"
                                              END) AS verified'
                                ))
                      ->ORDERBY('id','DESC')
                      ->get();

    }else {
      $query2 = journal::select('id', 'pro_id', 'article_name_th', 'article_name_en',
                                'journal_name_th', 'journal_name_en', 'publish_years',
                                'corres', 'files', 'verified',
                                \DB::raw('(CASE
                                              WHEN verified = "1" THEN "ตรวจสอบแล้ว"
                                              ELSE "รอตรวจสอบ"
                                              END) AS verified'
                                ))
                      ->where('users_id', Auth::user()->preferred_username)
                      ->ORDERBY('id','DESC')
                      ->get();
    }



      $query3 = [1=> 'ผู้นิพนธ์หลัก (first-author)',
                 2=> 'ผู้นิพนธ์ร่วม (co-author)'
                ];


      $query4 = [1=> 'ใช่',
                 2=> 'ไม่ใช่'
                ];


// --- COUNT 2 BOX on TOP ---
      // COUNT = All Record
      if(Auth::hasRole('manager')){
        $Total_journal = journal::select('id', 'users_id')
                                  ->get()
                                  ->count();

      }elseif(Auth::hasRole('admin')) {
        $Total_journal = journal::select('id', 'users_id')
                                  ->where('users_id', Auth::user()->preferred_username)
                                  ->get()
                                  ->count();

      }else {
        $Total_journal = journal::select('id', 'users_id')
                                  ->where('users_id', Auth::user()->preferred_username)
                                  ->get()
                                  ->count();
      }

      // COUNT = contribute = 1
      if(Auth::hasRole('manager')){
        $Total_master_jour = journal::select('id', 'contribute')
                                    ->whereIn ('contribute', ['1'])
                                    ->get()
                                    ->count();

      }elseif(Auth::hasRole('admin')) {
        $Total_master_jour = journal::select('id', 'contribute')
                                    ->whereIn ('contribute', ['1'])
                                    ->get()
                                    ->count();

      }else {
        $Total_master_jour = journal::select('id', 'contribute')
                                    ->whereIn ('contribute', ['1'])
                                    ->where('users_id', Auth::user()->preferred_username)
                                    ->get()
                                    ->count();
      }
// --- END COUNT 2 BOX on TOP ---

    return view('frontend.journal',
      [
        'journal_res'     => $query,
        'journals'        => $query2,
        'contribute'      => $query3,
        'corres'          => $query4,
        'Total_journal'   => $Total_journal,
        'Total_master_jour'  => $Total_master_jour,

     ]);
  }
  //  -- END SELECT --




  //  -- EDIT JOURNAL--
  public function edit_journal_form(Request $request){
    //แสดงข้อมูล Query EDIT
     $edit = DB::table('db_published_journal')
               ->join('db_research_project', 'db_research_project.id', '=', 'db_published_journal.pro_id')
               ->select('db_research_project.pro_name_en',
                        'db_published_journal.id',
                        'db_published_journal.pro_id',
                        'article_name_th',
                        'article_name_en',
                        'journal_name_th',
                        'journal_name_en',
                        'publish_years',
                        'publish_no',
                        'publish_volume',
                        // 'publish_page',
                        'publish_firstpage',
                        'publish_lastpage',
                        'url_journal',
                        'doi_number',
                        'contribute',
                        'corres'
                        )
               ->where('db_published_journal.id', $request->id)
               ->orderby('id', 'DESC')
               ->first();


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

    $data_post = [
      "pro_id"            => $request->pro_id,
      "users_id"          => Auth::user()->preferred_username,
      "article_name_th"   => $request->article_name_th,
      "article_name_en"   => $request->article_name_en,
      "journal_name_th"   => $request->journal_name_th,
      "journal_name_en"   => $request->journal_name_en,
      "publish_years"     => $request->publish_years,
      "publish_no"        => $request->publish_no,
      "publish_volume"    => $request->publish_volume,
      // "publish_page"      => $request->publish_page,
      "publish_firstpage" => $request->publish_firstpage,
      "publish_lastpage"  => $request->publish_lastpage,
      "url_journal"       => $request->url_journal,
      "doi_number"        => $request->doi_number,
      "contribute"        => $request->contribute,
      "corres"            => $request->corres,
      "files"             => $request->files,
      "created_at"        => date('Y-m-d H:i:s')
    ];

      //  --  UPLOAD FILE journal_form  --
    if ($request->file('files')->isValid()) {
          //TAG input [type=file] ดึงมาพักไว้ในตัวแปรที่ชื่อ files
        $file=$request->file('files');
          //ตั้งชื่อตัวแปร $file_name เพื่อเปลี่ยนชื่อ + นามสกุลไฟล์
        $name='file_'.date('dmY_His');
        $file_name = $name.'.'.$file->getClientOriginalExtension();
          // upload file ไปที่ PATH : Storage/app/public/file_upload_journal
        $path = $file->storeAs('public/file_upload_journal',$file_name);
        $data_post['files'] = $file_name;
    }

    $output = journal::insert($data_post);

    if($output){
        session()->put('message', 'okkkkkayyyyy');
        return redirect()->route('page.journal');
    }else {
        return redirect()->back()->with('swl_err', 'บันทึกแล้ว');
    }
  }
  //  -- END INSERT --



  //  -- SAVE --
  public function save_journal_form(Request $request){
    // dd($request);
    $update = DB::table('db_published_journal')
                  ->where('id', $request->id)
                  ->update([
                            // "pro_id"            => $request->pro_id,
                            "article_name_th"   => $request->article_name_th,
                            "article_name_en"   => $request->article_name_en,
                            "journal_name_th"   => $request->journal_name_th,
                            "journal_name_en"   => $request->journal_name_en,
                            "publish_years"     => $request->publish_years,
                            "publish_no"        => $request->publish_no,
                            "publish_volume"    => $request->publish_volume,
                            "publish_page"      => $request->publish_page,
                            "publish_firstpage" => $request->publish_firstpage,
                            "publish_lastpage"  => $request->publish_lastpage,
                            "url_journal"       => $request->url_journal,
                            "doi_number"        => $request->doi_number,
                            "contribute"        => $request->contribute,
                            "corres"            => $request->corres,
                          ]);

    if($update){
      //return Sweet Alert
        return redirect()->route('page.journal')->with('swl_update', 'แก้ไขข้อมูลสำเร็จแล้ว');
    }else {
        return redirect()->back()->with('swl_errx', 'บันทึกแล้ว');
    }
  }
  //  -- END SAVE --




  //  -- DOWNLOAD --
  public function DownloadFile(Request $request){
    $query2 = DB::table('db_published_journal')
                  ->select('id', 'files')
                  ->where('id', $request->id)
                  ->first();

    if(!$query2) return abort(404);

    $path = $query2->files;

    // return Storage::disk('journal')->download($path);

    if(Storage::disk('journal')->exists($path)){
      return Storage::disk('journal')->download($path);
    }else {
      return view('error-page.error405');
    }
  }
  //  -- END DOWNLOAD --



  //  -- VERIFIED --
  public function action_verified(Request $request){
      //UPDATE db_published_journal
      $verified = DB::table('db_published_journal')
                ->where('id', $request->id)
                ->update(['verified'    => "1",
                          'updated_at'  => date('Y-m-d H:i:s')
                        ]);
                // ->get();

       // dd($verified);
       if($verified){
           session()->put('verify', 'okkkkkayyyyy');
           return redirect()->route('page.journal');
       }else{
           return redirect()->back()->with('swl_err', 'บันทึกไม่สำเร็จ');
       }
     }
  //  -- END VERIFIED --



  //  -- No VERIFIED --
  public function No_verified(Request $request){
      //UPDATE db_published_journal
      $verified = DB::table('db_published_journal')
                ->where('id', $request->id)
                ->update(['verified'    => NULL,
                          'updated_at'  => date('Y-m-d H:i:s')
                        ]);
                // ->get();

       // dd($verified);
       if($verified){
           session()->put('Noverify', 'okkkkkayyyyy');
           return redirect()->route('page.journal');
       }else{
           return redirect()->back()->with('swl_err', 'บันทึกไม่สำเร็จ');
       }
     }
  //  -- END No VERIFIED --


}
