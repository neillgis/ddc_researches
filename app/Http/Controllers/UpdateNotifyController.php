<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NotificationAlert;
use Carbon\Carbon;
use Storage;
use File;
use Auth;
use app\Exceptions\Handler;
use Illuminate\Support\Facades\Route;

class UpdateNotifyController extends Controller
{
    //

    public function notifications_all(){
      // Update "SEEN"
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
                                          ->orderBy('id','DESC')
                                          ->limit(30)
                                          ->get();

          $category = [ 1 => "โครงการวิจัย",
                        2 => "การตีพิมพ์วารสาร",
                        3 => "การนำไปใช้ประโยชน์",
                      ];


      // For "USER" Only
      }else {

            $data_notify = NotificationAlert::where('receiver_id', Auth::user()->preferred_username)
                                            ->OrderBy('id','DESC')
                                            ->limit(30)
                                            ->get();

            $category = [ 1 => "โครงการวิจัย",
                          2 => "การตีพิมพ์วารสาร",
                          3 => "การนำไปใช้ประโยชน์",
                        ];
      }

        if(!isset($data_notify)){
            return view('error-page.error405');
        }

      return view('notify_all',[
        "data_notify" =>  $data_notify,
        "category"    =>  $category,
      ]);
    }



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

        $path = $query_download->files;

      if(Storage::disk('research')->exists($path)) {
        return Storage::disk('research')->download($path);
      }else {
        return view('error-page.error405');
      }

    }



}
