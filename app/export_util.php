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
                ->rightjoin('db_utilization', 'db_research_project.id', '=', 'db_utilization.pro_id')
                ->leftjoin('users', 'db_research_project.users_id', '=', 'users.idCard')

                ->leftjoin('ref_util_status', 'db_utilization.status', '=', 'ref_util_status.id')
                ->leftjoin('ref_verified', 'db_utilization.verified', '=', 'ref_verified.id')
                ->select('db_utilization.pro_id',
                         'db_utilization.users_id',
                         'db_research_project.users_name',
                         'users.deptName',
                         'util_type',
                         'util_descrip',
                         'ref_util_status.util_status',
                         'ref_verified.verify'
                         )
                ->whereNull('db_utilization.deleted_at')
                ->orderBy('db_utilization.id', 'ASC')
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
            'สถานะของการนำไปใช้ประโยชน์',
            'การตรวจสอบ'
        ];
    }

}
