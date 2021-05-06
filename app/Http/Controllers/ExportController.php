<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\export_research;
use App\export_journal;
use App\export_util;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{

    public function export_research()
    {
        return Excel::download(new export_research, 'research.xlsx');
    }
    // /**
    // * @return \Illuminate\Support\Collection
    // */


    public function export_journal()
    {
        return Excel::download(new export_journal, 'journal.xlsx');
    }
    // /**
    // * @return \Illuminate\Support\Collection
    // */


    public function export_util()
    {
        return Excel::download(new export_util, 'utilization.xlsx');
    }
    // /**
    // * @return \Illuminate\Support\Collection
    // */



}
