<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\NotificationAlert;

class UpdateNotifyController extends Controller
{
    //

    public function notifications_all(){
      // Update "SEEN"
      NotificationAlert::where('receiver_id', Auth::user()->id)
                                ->update([
                                          'seen' => 1,
                                          'updated_at' => Carbon::now(),
                                        ]);

      // Data "SALE" Only
      if(Auth::user()->department == 1){
          $data_notify = NotificationAlert::where('receiver_id', Auth::user()->id)
                                          ->OrderBy('id','DESC')
                                          ->limit(30)
                                          ->get();
      }else {
          return view('error404');
      }

      return view('notify_all',[
        "data_notify" => $data_notify
      ]);
    }



    public function redirect_url(Request $request){

        if($request->url_redirect != NULL){
            return redirect($request->url_redirect);
        }else {
            return view('error404');
        }
    }


}
