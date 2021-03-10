<?php

namespace App;

use research;
use DB;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class export_research implements FromCollection, WithHeadings
{
    // /**
    // * @return \Illuminate\Support\Collection
    // */

    public function collection()
    {
        // return research::all();

        return DB::table('db_research_project')
                ->join('users', 'db_research_project.users_id', '=', 'users.idCard')
                ->select('db_research_project.id',
                         'db_research_project.users_id',
                         'db_research_project.users_name',
                         'users.deptName',
                         'db_research_project.pro_name_en',
                         'db_research_project.pro_name_th',
                         'db_research_project.pro_position',
                         'db_research_project.pro_co_researcher',
                         'db_research_project.pro_start_date',
                         'db_research_project.pro_end_date',
                         'db_research_project.publish_status',
                         'db_research_project.verified'
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
            'ชื่อโครงการ (ENG)',
            'ชื่อโครงการ (TH)',
            'ตำแหน่งในโครงการวิจัย',
            'จำนวนผู้ร่วมวิจัย',
            'ปีที่เริ่มโครงการ',
            'ปีที่สิ้นสุดโครงการ',
            'การตีพิมพ์',
            'การตรวจสอบ',
        ];
    }

}
