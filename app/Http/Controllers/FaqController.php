<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CmsHelper;
use Auth;
use Session;


class FaqController extends Controller
{
  public function faq_index()
  {
   return view('frontend.faq');
  }


}
