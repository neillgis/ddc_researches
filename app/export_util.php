<?php

namespace App;

use util;
use DB;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class export_util implements FromCollection, WithHeadings
{
    // /**
    // * @return \Illuminate\Support\Collection
    // */

    public function collection()
    {
        // return research::all();

        return DB::table('db_research_project')
                ->join('db_utilization', 'db_research_project.id', '=', 'db_utilization.pro_id')
                ->join('users', 'db_research_project.users_id', '=', 'users.idCard')
                ->select('db_utilization.pro_id',
                         'db_utilization.users_id',
                         'db_research_project.users_name',
                         'users.deptName',
                         'util_type',
                         'util_descrip',
                         'db_utilization.verified'
                         )
                ->get();
    }


    public function headings(): array
    {
        return [
            'Project_ID',
            'เลขบัตรปชช.',
            'ชื่อ-สกุล',
            'หน่วยงาน',
            'ประเภท',
            'คำอธิบาย',
            'การตรวจสอบ'
        ];
    }

}
