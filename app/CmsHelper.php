<?php
namespace App;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Position;
use App\Roles;
use Cache;
use App\User;

    class CmsHelper{
        function __construct()
        {
            //echo 'test';
        }

        public static function DateThai($strDate){
          if($strDate=='0000-00-00' || $strDate=='' || $strDate==null) return '-';
              $strYear = date("Y",strtotime($strDate))+543;
              $strMonth= date("n",strtotime($strDate));
              $strDay= date("j",strtotime($strDate));
              $strHour= date("H",strtotime($strDate));
              $strMinute= date("i",strtotime($strDate));
              $strSeconds= date("s",strtotime($strDate));
              $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
              $strMonthThai=$strMonthCut[$strMonth];
          return "$strDay $strMonthThai $strYear";
        }

        public static function DateThaiFull($strDate){
          if($strDate=='0000-00-00' || $strDate=='' || $strDate==null) return '-';
              $strYear = date("Y",strtotime($strDate))+543;
              $strMonth= date("n",strtotime($strDate));
              $strDay= date("j",strtotime($strDate));

              $strWeek= date("w",strtotime($strDate));
              $strHour= date("H",strtotime($strDate));
              $strMinute= date("i",strtotime($strDate));
              $strSeconds= date("s",strtotime($strDate));
              $strMonthWeek = Array("","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์","อาทิตย์");
              $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
              $strWeekThai=$strMonthWeek[$strWeek];
              $strMonthThai=$strMonthCut[$strMonth];
          return "ประจำวัน".$strWeekThai ."ที่ ". $strDay ." ". $strMonthThai ." ". $strYear;
        }

        public static function TimeThai($strTime){
          if($strTime=='00:00:00' || $strTime=='' || $strTime==null) return '-';
              $strHour= date("H",strtotime($strTime));
              $strMinute= date("i",strtotime($strTime));
          return $strHour.":".$strMinute;
        }

        public static function Numth($younum) {
          $temp = str_replace("0","๐",$younum);
          $temp = str_replace("1","๑",$temp);
          $temp = str_replace("2","๒",$temp);
          $temp = str_replace("3","๓",$temp);
          $temp = str_replace("4","๔",$temp);
          $temp = str_replace("5","๕",$temp);
          $temp = str_replace("6","๖",$temp);
          $temp = str_replace("7","๗",$temp);
          $temp = str_replace("8","๘",$temp);
          $temp = str_replace("9","๙",$temp);
          return $temp;
        }

        public static function MonthThai($strDate){
          if($strDate=='0000-00-00' || $strDate=='' || $strDate==null) return '-';
              $strYear = date("Y",strtotime($strDate))+543;
              $strMonth= date("n",strtotime($strDate));
              $strDay= date("j",strtotime($strDate));
              $strHour= date("H",strtotime($strDate));
              $strMinute= date("i",strtotime($strDate));
              $strSeconds= date("s",strtotime($strDate));
              $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
              $strMonthThai=$strMonthCut[$strMonth];
          return "$strMonthThai $strYear";
        }

        public static function formatDateThai($strDate)
        {
            $strYear = date("Y",strtotime($strDate))+543;
            $strMonth= date("n",strtotime($strDate));
            $strDay= date("j",strtotime($strDate));
            $strHour= date("H",strtotime($strDate));
            $strMinute= date("i",strtotime($strDate));
            $strSeconds= date("s",strtotime($strDate));
            $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
            $strMonthThai=$strMonthCut[$strMonth];
            return "$strDay $strMonthThai $strYear เวลา $strHour:$strMinute";
        }

        public static function Date_Format_BC_To_AD($strDate){
          if(empty($strDate)) return false;
            $bc_year = explode("/",$strDate);
            $day = $bc_year['0'];
            $month = $bc_year['1'];
            $year = $bc_year['2']-543;
          return $year.'-'.$month.'-'.$day;
        }

        public static function Date_Format_ฺAD_To_BC($strDate){
          if(empty($strDate)) return false;
          $ad_year = explode("-",$strDate);
          $day = $ad_year['2'];
          $month = $ad_year['1'];
          $year = $ad_year['0']+543;
          return $day.'/'.$month.'/'.$year;
        }
        public static function Date_Format_Custom($strDate){
          if(empty($strDate)) return false;
            $bc_year = explode("-",($strDate));
            $day = $bc_year['2'];
            $month = $bc_year['1'];
            $year = $bc_year['0'];
          return $year.'-'.$month.'-'.$day;
        }

        public static function RemoveDash($str){
          if(empty($str)) return false;
          return trim(str_replace("-", "", $str));
        }

        public static function generateRandomString($length = 10) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return trim($randomString);
        }
        public static function Get_UserID_In_Role($role_id){
          if(empty($role_id)) return false;

          $users_lists = DB::table('users')
                  ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                  ->select('users.id as id','model_has_roles.role_id as role_id')
                  ->where('model_has_roles.role_id',$role_id)
                  ->get();

          if(count($users_lists)<1) return false;

          foreach($users_lists as $value){
            $arr[] = $value->id;
          }

          return $arr;

        }


        public static function Get_Talent_language(){
          $lists_talent = Talent::all();
          foreach($lists_talent as $talent_language){
            $arr[$talent_language->id] = $talent_language->talent_name;
          }
          return $arr;
        }

        public static function Get_Talent_Drive(){
          $lists_drive = TalentDrive::all();
          foreach($lists_drive as $talent_drive){
            $arr[$talent_drive->id] = $talent_drive->drive;
          }
          return $arr;
        }

        public static function Get_Talent_Course(){
          $lists_course = TalentCourse::all();
          foreach($lists_course as $talent_course){
            $arr[$talent_course->id] = $talent_course->course;
          }
          return $arr;
        }

        public static function Get_List_User_TH(){
          $users_lists = User::select('id','name_th','lname_th')->get();
          foreach($users_lists as $users){
            $arr[$users->id] = trim($users->name_th).' '.trim($users->lname_th);
          }
          return $arr;
        }

        public static function Get_Organization_TH(){
          $lists_organization = Organization::all();
          foreach($lists_organization as $organization_th){
            $arr[$organization_th->organization_id] = $organization_th->organization_name;
          }
          return $arr;
        }

        public static function Get_Position_TH(){
          $lists_position = Position::all();
          foreach($lists_position as $position_th){
            $arr[$position_th->position_id] = $position_th->position_name;
          }
          return $arr;
        }

        public static function Get_Prefix_TH(){
          $list_prefix_th = RefPrefix::all();
          foreach($list_prefix_th as $prefix_th){
            $arr[$prefix_th->id] = trim($prefix_th->name_th);
          }
          return $arr;
        }

        public static function Get_Prefix_EN(){
          $list_prefix_en = RefPrefix::all();
          foreach($list_prefix_en as $prefix_en){
            $arr[$prefix_en->id] = trim($prefix_en->name_en);
          }
          return $arr;
        }

        public static function Get_Current_Role_Group($id){
          $model_has_row = DB::table('model_has_roles')->select('role_id')->where('model_id',$id)->first();
          if(empty($model_has_row)) return array();
          return $model_has_row->role_id;
        }

        public static function Get_Roles_TH2(){
          $lists_roles = Roles::all();
          foreach($lists_roles as $roles_th){
            $arr[$roles_th->id] = $roles_th->name;
          }
          return $arr;
        }

        public static function Get_Roles_EN(){
          $lists_roles = Roles::all();
          foreach($lists_roles as $roles_en){
            $arr[$roles_en->id] = $roles_en->name_eng;
          }
          return $arr;
        }

        public static function Get_UserID($user_id){
          $query = User::find($user_id);
          return array(
            "username" => $query->username,
            "user_id" => $query->id,
            "fname" => $query->name_th,
            "lname" => $query->lname_th
          );
        }
        public static function Get_Icon_Notify($module_name){
          switch ($module_name) {
            case "task":
              $icon = "fa-tasks";
              break;
            case "meeting":
              $icon = "fa-handshake";
              break;
            case "assign":
              $icon = "fa-tasks";
              break;
            case "ddcdrive":
              $icon = "fa-hdd";
              break;
            default:
              $icon = "fa-globe-asia";
          }
          return $icon;
        }

          // add comma to array data
        	public static function add_comma($data){
              $prefix = '';
          	  $split_word = "";
          	  foreach ($data as $val){
          	            $split_word .= $prefix . "" . $val . "";
          	            $prefix = ',';
          	  }
          	  return $split_word;
        	}

}
