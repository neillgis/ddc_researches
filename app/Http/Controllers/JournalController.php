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


  //  -- Show Dropdown บทความนี้เป็นผลจากโครงการวิจัย --
  public function table_journal(){
    if(Auth::hasRole('manager')){
      $query  = DB::table('db_research_project')
                     ->select('db_research_project.id',
                              'db_research_project.pro_name_th',
                              'db_research_project.pro_name_en',
                              )
                     ->where('users_id', Auth::user()->preferred_username)
                     ->whereNull('deleted_at')
                     // ->whereNotNull('db_research_project.pro_name_en')
                     ->orderby('id', 'DESC')
                     ->get();

    }elseif(Auth::hasRole('departments')) {
      $query  = DB::table('db_research_project')
                     ->select('db_research_project.id',
                              'db_research_project.pro_name_th',
                              'db_research_project.pro_name_en',
                              )
                     ->where('users_id', Auth::user()->preferred_username)
                     ->whereNull('deleted_at')
                     // ->whereNotNull('db_research_project.pro_name_en')
                     ->orderby('id', 'DESC')
                     ->get();

     }else {
       $query  = DB::table('db_research_project')
                      ->select('db_research_project.id',
                               'db_research_project.pro_name_th',
                               'db_research_project.pro_name_en',
                               'db_research_project.pro_name_en',
                               )
                      ->where('users_id', Auth::user()->preferred_username)
                      ->whereNull('deleted_at')
                      // ->whereNotNull('db_research_project.pro_name_en')
                      ->orderby('id', 'DESC')
                      ->get();
     }



  //  -- SELECT DataTables PROJECT join JOURNAL --
    if(Auth::hasRole('manager')){

      $query2 = DB::table('db_published_journal')
                ->join('db_research_project', 'db_research_project.id', '=', 'db_published_journal.pro_id')
                ->join('users', 'db_published_journal.users_id', '=', 'users.idCard')
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
                         'db_published_journal.status',
                         'users.deptName',
                        )
                // ->where('db_published_journal.id', $request->id)
                ->whereNull('db_published_journal.deleted_at')
                ->orderby('id', 'DESC')
                ->get();
         // dd($query2);

    }elseif(Auth::hasRole('departments')){

      $query2 = DB::table('db_published_journal')
                ->leftjoin('users', 'db_published_journal.users_id', '=', 'users.idCard')
                ->select(
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
                         'db_published_journal.status',
                         'users.deptName',
                         'users.idCard',
                         'users.fname',
                         'users.lname',
                         )
                ->where('users.deptName', Auth::user()->family_name)
                ->orderby('id', 'DESC')
                ->get();
        // dd($query2);

    }else {
      $query2 = DB::table('db_published_journal')
                  ->select('id',
                           'pro_id',
                           'article_name_th',
                           'article_name_en',
                           'journal_name_th',
                           'journal_name_en',
                           'publish_years',
                            'corres',
                            'files',
                            'verified',
                            'status',
                            'deleted_at',
                            // \DB::raw('(CASE
                            //               WHEN verified = "1" THEN "ตรวจสอบแล้ว"
                            //               ELSE "รอตรวจสอบ"
                            //               END) AS verified'
                            // )
                            )
                  ->where('users_id', Auth::user()->preferred_username)
                  ->whereNull('deleted_at')
                  ->ORDERBY('id','DESC')
                  ->get();
              // dd($query2);
    }


      $query3 = [1=> 'ผู้นิพนธ์หลัก (first-author)',
                 2=> 'ผู้นิพนธ์ร่วม (co-author)'
                ];


      $query4 = [1=> 'ใช่',
                 2=> 'ไม่ใช่'
                ];


      $verified = [ 1 => 'ตรวจสอบแล้ว', //verify
                    2 => 'อยู่ระหว่างตรวจสอบ', //process_checked
                    3 => 'อยู่ระหว่างแก้ไข', //process_editing
                    9 => 'ไม่ตรงเงื่อนไข', //no_conditions
                  ];


      // -- DataTable Show -> not_from_project --
      $query5 = DB::table('db_published_journal')
                ->join('users', 'db_published_journal.users_id', '=', 'users.idCard')
                ->select('db_published_journal.id',
                         'db_published_journal.pro_id',
                         'db_published_journal.users_name',
                         'db_published_journal.article_name_th',
                         'db_published_journal.article_name_en',
                         'db_published_journal.journal_name_th',
                         'db_published_journal.journal_name_en',
                         'db_published_journal.publish_years',
                         'db_published_journal.files',
                         'db_published_journal.corres',
                         'db_published_journal.verified',
                         'db_published_journal.status',
                         'users.deptName'
                         )
                ->where('pro_id', null)
                ->whereNull('deleted_at')
                ->orderby('id', 'DESC')
                ->get();

      $query6 = DB::table('ref_journal_status')->get();


// --- COUNT 2 BOX on TOP ---

      // บทความตีพิมพ์ทั้งหมด COUNT = All Record
      if(Auth::hasRole('manager')){
        $Total_journal = journal::select('id', 'users_id')
                                  ->whereNull('deleted_at')
                                  ->get()
                                  ->count();

      }elseif(Auth::hasRole('departments')) {
        $Total_journal = DB::table('db_published_journal')
                          ->leftjoin('users', 'users.idCard', '=', 'db_published_journal.users_id')
                          ->select( 'db_published_journal.id',
                                    'db_published_journal.users_id',
                                    'users.idCard',
                                    'users.deptName',
                                  )
                          ->where('deptName', Auth::user()->family_name)
                          ->whereNull('deleted_at')
                          ->get()
                          ->count();
                  // dd($Total_journal);

      }else {
        $Total_journal = journal::select('id', 'users_id')
                                  ->where('users_id', Auth::user()->preferred_username)
                                  ->whereNull('deleted_at')
                                  ->get()
                                  ->count();
      }


      // บทความตีพิมพ์ ที่ตรวจสอบแล้ว COUNT = All Record -> 'verified', ['1']
      if(Auth::hasRole('manager')){
        $Total_journal_verify = journal::select('id', 'users_id')
                                      ->whereIn('verified', ['1'])
                                      ->whereNull('deleted_at')
                                      ->get()
                                      ->count();

      }elseif(Auth::hasRole('departments')) {
        $Total_journal_verify = DB::table('db_published_journal')
                                  ->leftjoin('users', 'users.idCard', '=', 'db_published_journal.users_id')
                                  ->select( 'db_published_journal.id',
                                            'db_published_journal.users_id',
                                            'db_published_journal.verified',
                                            'users.idCard',
                                            'users.deptName',
                                          )
                                  ->whereIn('verified', ['1'])
                                  ->where('deptName', Auth::user()->family_name)
                                  ->whereNull('deleted_at')
                                  ->get()
                                  ->count();

      }else {
        $Total_journal_verify = journal::select('id', 'users_id')
                                      -> whereIn ('verified', ['1'])
                                      ->where('users_id', Auth::user()->preferred_username)
                                      ->whereNull('deleted_at')
                                      ->get()
                                      ->count();
      }


      // บทความที่เป็นผู้นิพนธ์หลัก ที่ตรวจสอบแล้ว COUNT = contribute = 1 -> 'verified', ['1']
      if(Auth::hasRole('manager')){
        $Total_master_jour = journal::select('id', 'contribute')
                                    ->whereIn ('contribute', ['1'])
                                    -> whereIn ('verified', ['1'])
                                    ->whereNull('deleted_at')
                                    ->get()
                                    ->count();

      }elseif(Auth::hasRole('departments')) {
        $Total_master_jour = DB::table('db_published_journal')
                                  ->leftjoin('users', 'users.idCard', '=', 'db_published_journal.users_id')
                                  ->select( 'db_published_journal.id',
                                            'db_published_journal.users_id',
                                            'db_published_journal.verified',
                                            'db_published_journal.contribute',
                                            'users.idCard',
                                            'users.deptName',
                                          )
                                  ->whereIn('contribute', ['1'])
                                  ->whereIn('verified', ['1'])
                                  ->where('deptName', Auth::user()->family_name)
                                  ->whereNull('deleted_at')
                                  ->get()
                                  ->count();

      }else {
        $Total_master_jour = journal::select('id', 'contribute')
                                    ->whereIn ('contribute', ['1'])
                                    -> whereIn ('verified', ['1'])
                                    ->where('users_id', Auth::user()->preferred_username)
                                    ->whereNull('deleted_at')
                                    ->get()
                                    ->count();
      }
// --- END COUNT 2 BOX on TOP ---

    return view('frontend.journal',
      [
        'journal_res'              => $query,
        'journals'                 => $query2,
        'contribute'               => $query3,
        'corres_sl'                => $query4,
        'not_from_project'         => $query5,
        'status'                   => $query6,
        'Total_journal'            => $Total_journal,
        'Total_journal_verify'     => $Total_journal_verify,
        'Total_master_jour'        => $Total_master_jour,
        'verified_list'            => $verified,
     ]);
  }
  //  -- END SELECT --




  //  -- EDIT JOURNAL--
  public function edit_journal_form(Request $request){

    //แสดงข้อมูล Query EDIT
     $edit = DB::table('db_published_journal')
               ->join('db_research_project', 'db_research_project.id', '=', 'db_published_journal.pro_id')
               ->select('db_research_project.pro_name_en',
                        'db_research_project.pro_name_th',
                        'db_published_journal.id',
                        'db_published_journal.pro_id',
                        'article_name_th',
                        'article_name_en',
                        'journal_name_th',
                        'journal_name_en',
                        'publish_years',
                        'publish_no',
                        'publish_volume',
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



  //  -- EDIT 2 JOURNAL (** กรณี ไม่ได้มาจากโครงการวิจัย) --
  public function edit2_journal_form(Request $request){

    //แสดงข้อมูล Query EDIT 2
     $edit9 = DB::table('db_published_journal')
               ->select(
                        'db_published_journal.id', 'article_name_th', 'article_name_en', 'journal_name_th',
                        'journal_name_en', 'publish_years','publish_no', 'publish_volume', 'publish_firstpage',
                        'publish_lastpage', 'url_journal', 'doi_number', 'contribute', 'corres'
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

     return view('frontend.journal_edit2',
     [
        'data'  => $edit9,
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
      "users_name"        => Auth::user()->name,
      "article_name_th"   => $request->article_name_th,
      "article_name_en"   => $request->article_name_en,
      "journal_name_th"   => $request->journal_name_th,
      "journal_name_en"   => $request->journal_name_en,
      "publish_years"     => $request->publish_years,
      "publish_no"        => $request->publish_no,
      "publish_volume"    => $request->publish_volume,
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
                ->update([
                          'verified'    => $request->verified,
                          'status'      => $request->status,
                          'updated_at'  => date('Y-m-d H:i:s')
                        ]);

       // dd($verified);
       if($verified){
           session()->put('verify2', 'okkkkkayyyyy');
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
                ->update([
                          'verified' => NULL,
                          'updated_at'  => date('Y-m-d H:i:s')
                        ]);

       // dd($verified);
       if($verified){
           session()->put('Noverify', 'okkkkkayyyyy');
           return redirect()->route('page.journal');
       }else{
           return redirect()->back()->with('swl_err', 'บันทึกไม่สำเร็จ');
       }
     }
  //  -- END No VERIFIED --




  public function delete_journal(Request $request)
  {
    $delete = journal::where('id', $request->id)
                     ->update(["deleted_at"  =>  date('Y-m-d H:i:s')]);

    // dd($delete);

    if($delete){
      session()->put('deletejournal', 'okkkkkayyyyy');
      return redirect()->route('page.journal')->with('Okayyyyy');
    }else{
      return redirect()->back()->with('Errorrr');
    }

  }


  //  -- STATUS --
  public function status_journal(Request $request){
      //UPDATE db_published_journal = "STATUS"
      $status_journal = DB::table('db_published_journal')
                          ->where('id', $request->id)
                          ->update([
                                    'status'      => $request->status,
                                    'updated_at'  => date('Y-m-d H:i:s')
                                  ]);
       // dd($status_journal);

       if($status_journal){
           session()->put('statusjournal', 'okkkkkayyyyy');
           return redirect()->route('page.journal');
       }else{
           return redirect()->back()->with('swl_err', 'บันทึกไม่สำเร็จ');
       }
     }
  //  -- END STATUS --


}
