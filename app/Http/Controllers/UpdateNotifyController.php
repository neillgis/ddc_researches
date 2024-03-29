<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NotificationAlert;
use Carbon\Carbon;
use Storage;
use File;
use Illuminate\Support\Facades\Auth;
use app\Exceptions\Handler;
use Illuminate\Support\Facades\Route;


class UpdateNotifyController extends Controller
{
    //

    public function notifications_all(){
      // Update "SEEN" if you Read Messages
      NotificationAlert::where('receiver_id', Auth::user()->preferred_username)
                        ->update([
                                  'seen' => 1,
                                  'updated_at' => Carbon::now(),
                                ]);


      // For "MANAGER" Only
      if(Auth::hasRole('manager')){
          $data_notify = NotificationAlert::where('receiver_id', Auth::user()->preferred_username)
                                          // ->where('send_date', Carbon::today())
                                          // ->Orwhere('send_date', Carbon::yesterday())
                                          ->whereNull('manager_verify')
                                          ->orderBy('id','DESC')
                                          ->limit(100)
                                          ->get();

          $category = [ 1 => "โครงการวิจัย",
                        2 => "การตีพิมพ์วารสาร",
                        3 => "การนำไปใช้ประโยชน์",
                      ];


      // For "USER" Only
      }else {

            $data_notify = NotificationAlert::where('receiver_id', Auth::user()->preferred_username)
                                            // ->whereNull('manager_verify')
                                            ->OrderBy('id','DESC')
                                            ->limit(30)
                                            ->get();
                                      // dd($data_notify);

            $category = [ 1 => "โครงการวิจัย",
                          2 => "การตีพิมพ์วารสาร",
                          3 => "การนำไปใช้ประโยชน์",
                        ];
      }

        if(!isset($data_notify)){
            return view('error-page.error405');
        }


      // USE in Research "VERIFIED"
      $verified = [ 1 => 'ตรวจสอบแล้ว',
                    2 => 'อยู่ระหว่างตรวจสอบ',
                    3 => 'อยู่ระหว่างแก้ไข',
                    4 => 'ผ่านการตรวจสอบแล้ว',
                    9 => 'ไม่ตรงเงื่อนไข',
                  ];


      return view('notify_all',[
        "data_notify"   =>  $data_notify,
        "category"      =>  $category,
        "verified"      =>  $verified,
      ]);
    }



    // -- REDIRECT --
    public function redirect_url(Request $request){

        if($request->url_redirect != NULL){
            return redirect($request->url_redirect);
        }else {
            return view('error-page.error405');
        }
    }



    //  -- DOWNLOAD --
    public function DownloadFile_Notify(Request $request){

        $query_download = NotificationAlert::where('id', $request->id)->first();


        if(!isset($query_download)){
          return view('error-page.error405');
        }

        $path = $query_download->files_upload;


      if(Storage::disk('notify_alert')->exists($path)) {
        return Storage::disk('notify_alert')->download($path);
      }else {
        return view('error-page.error405');
      }

    }



    public function manager_verfiry(Request $request){
      // dd($request);

      $manager_verify = NotificationAlert::where('id', $request->id)
                                         ->update([ 'manager_verify' => 1 ]);

      if($manager_verify){
          return redirect()->route('all.notify');
      }else {
          return view('error-page.error405');
      }
    }



}
