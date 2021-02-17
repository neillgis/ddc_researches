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
                ->select('id', 'users_id', 'users_name', 'pro_name_en', 'pro_name_th', 'pro_position',
                         'pro_co_researcher', 'pro_start_date', 'pro_end_date', 'publish_status', 'verified')
                ->get();
    }


    public function headings(): array
    {
        return [
            'Project_ID',
            'เลขบัตรปชช.',
            'ชื่อ-สกุล',
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
