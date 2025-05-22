<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\member;
use Exception;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller

{

    //  -- PROFILE --
    public function index(){

      $data = DB::table('users')
            ->select('id', 'idCard', 'nriis_id', 'orcid_id')
            ->selectRaw("COALESCE(researcher_level, '0') as researcher_level")
            ->where('idCard', Auth::user()->preferred_username)
            ->get();

      $edit_profile = DB::table('users')
                    ->where('idCard', Auth::user()->preferred_username)
                    ->first();

      // Mapping ระดับกับ Icon
        $levelIcons = [
            0 => ["icon" => "👤", "text" => "ยังไม่มีระดับ"], // ไม่มีระดับ
            1 => ["icon" => "🧑‍🏫", "text" => "นักวิจัยฝึกหัด"], // คนธรรมดา
            2 => ["icon" => "🧑‍🎓", "text" => "นักวิจัยระดับต้น"], // นักศึกษา
            3 => ["icon" => "🧑‍💼", "text" => "นักวิจัยระดับกลาง"], // คนทำงาน
            4 => ["icon" => "🧑‍🔬", "text" => "นักวิจัยระดับสูง"], // นักวิทยาศาสตร์
        ];

        $researcherLevel = [];

        if($data->isNotEmpty()){
            if($data[0]->researcher_level == 0){
                $researcherLevel = $levelIcons['0'];
            }elseif($data[0]->researcher_level == 1){
                $researcherLevel = $levelIcons['1'];
            }elseif($data[0]->researcher_level == 2){
                $researcherLevel = $levelIcons['2'];
            }elseif($data[0]->researcher_level == 3){
                $researcherLevel = $levelIcons['3'];
            }elseif($data[0]->researcher_level == 4){
                $researcherLevel = $levelIcons['4'];
            }
        }

      return view('frontend.profile',
        [
           'data'          => $data,
           'edit_profile'  => $edit_profile,
           'researcherLevel' => $researcherLevel,
        ]);
    }

    public function save_update_profile(Request $request){

      $update_profile = DB::table('users')
                            ->where('idCard', Auth::user()->preferred_username)
                            ->update([
                                        'nriis_id'  =>  $request->nriis_id,
                                        'orcid_id'  =>  $request->orcid_id
                                    ]);
                  // dd($update_profile);

      if($update_profile){
          session()->put('messages', 'okkkkkayyyyy');
          return redirect()->route('page.profile');
      }else {
        return redirect()->back()->with('swl_err', 'บันทึกไม่สำเร็จ');
      }
    }



    //  -- INSERT  --
    public function insert(Request $request){

      $data_post = [
        "title"        => $request->title,
        "fname"         => $request->fname,
        "lname"         => $request->lname,
        "idCard"        => $request->idCard,
        "sex"           => $request->sex,
        "mobile"        => $request->mobile,
        "email"         => $request->email,
        "educationLevel" => $request->educationLevel,
        "dept_id"       => $request->dept_id,
        "deptName"      => $request->deptName,
        "position"      => $request->position,
        "positionLevel" => $request->positionLevel,
        "nriis_id"      => $request->nriis_id,
        "orcid_id"      => $request->orcid_id,
        // "created_at"    => date('Y-m-d H:i:s')
      ];
      // dd($data_post);

      $output = member::insert($data_post);

      if($output){
          session()->put('messages', 'okkkkkayyyyy');
          return redirect()->route('page.profile');
      }else{
          return redirect()->back()->with('messagesx', 'not_okkkkkayyyyy');
      }
    }
    //  -- END INSERT --

    public function chk_update($obj){
      try {
          $data = json_decode($obj, true);
          $id=$data['id'];
          unset($data['id']);
          DB::table('users')->where("id", $id)->update($data);

          return response()->json(['msg'=>'ok']);
      }catch (Exception $e) {
          return response()->json(['msg'=>'error']);
      }
    }

}
