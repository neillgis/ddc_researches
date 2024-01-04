<?php
namespace App;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Position;
use App\Roles;
use Cache;
use App\User;
use App\member;


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


        public static function DateEnglish($strDate){
          if($strDate=='0000-00-00' || $strDate=='' || $strDate==null) return '-';
              $strYear = date("Y",strtotime($strDate));
              $strMonth= date("n",strtotime($strDate));
              $strDay= date("j",strtotime($strDate));
              $strHour= date("H",strtotime($strDate));
              $strMinute= date("i",strtotime($strDate));
              $strSeconds= date("s",strtotime($strDate));
              $strMonthCut = Array("","Jan","Feb","Mar","Apr","May","Jun","July","Aug","Sep","Oct","Nov","Dec");
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
          return $strDay ." ". $strMonthThai ." ". $strYear;
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

        public static function toArray($tb, $index = 'id', $val = 'name', $orderBy = NULL)
        {
            //query table เป็น array
            //$arr = cms::toArray('ref_table');
            $arr = array();
            $query = DB::table($tb);
            if (!is_null($orderBy)) {
                $query->orderBy($orderBy);
            }
            $data = $query->get();
            foreach ($data as $item) {
                $arr[$item->$index] = $item->$val;
            }
            return $arr;
        }

        public static function Date_Format_BC_To_AD($strDate){
          if(empty($strDate)) return false;
            $bc_year = explode("-",$strDate);
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


        public static function Get_UserOrganize($orgs_id)
        {
          $query = member::where('idCard', $orgs_id)->first();
          $id = 0;
          $deptName = '';
          if (!empty($query)) {
            $id = $query->id;
            $deptName = $query->deptName;
          }
          //--------------------------
          return array(
            "id"      => $id,
            "deptName"  => $deptName,
          );
        }

        public static function Get_Status($status_id)
        {
          $query = Ref_Journal_Status::find($status_id);
          $id = 0;
          $journal_status = '';
          if (!empty($query)) {
            $id = $query->id;
            $journal_status = $query->journal_status;
          }
          //--------------------------
          return array(
            "id"      => $id,
            "status"  => $journal_status,
          );
        }


        public static function Get_Status_Util($statusx_id)
        {
          $query = Ref_Util_Status::find($statusx_id);
          $id = 0;
          $util_status = '';
          if (!empty($query)) {
            $id = $query->id;
            $util_status = $query->util_status;
          }
          //--------------------------
          return array(
            "id"      => $id,
            "status"  => $util_status,
          );
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


          // Get user profile [Individual] from SSO hr.ddc.moph.go.th
          public static function GetProfile($cid){
            $client = new \GuzzleHttp\Client();
            $response = $client->get('https://hr.ddc.moph.go.th/api/v2/employee/'.$cid,
            [
             'headers' => [
               'Authorization' => 'Bearer'.env('TOKEN_GET')
             ],
             'verify' => false
            ]);
            $decoded = json_decode($response->getBody(), true);
            return $decoded['fname'].' '.$decoded['lname'];
          }


          public static function fixid($cid, $lastshow=6){
            $num = 13-$lastshow;
            $last = substr($cid, $num);
            $txt = '';
            for( $i=0 ; $i<$num ; $i++ ) {
              $txt .= "X";
            }
            return $txt . $last;
          }



}
