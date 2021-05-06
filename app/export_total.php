<?php

namespace App;

// use App\summary;
use DB;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class export_totals implements FromCollection, WithHeadings
{
    // /**
    // * @return \Illuminate\Support\Collection
    // */

    public function collection()
    {
        // return research::all();

        return DB::table('db_research_project')
                ->leftjoin ('db_published_journal', 'db_research_project.id', '=', 'db_published_journal.pro_id')
                ->leftjoin ('db_utilization', 'db_research_project.id', '=', 'db_utilization.pro_id')
                ->leftjoin ('users', 'db_research_project.users_id', '=', 'users.idCard')

                ->select('db_research_project.users_name','db_research_project.researcher_level')
                // // โครงการวิจัยที่เสร็จสิ้นทั้งหมด ที่ตรวจสอบแล้ว  // จำนวน count -> verified = '1'
                ->selectRaw("count(DISTINCT(case when db_research_project.verified = '1' then db_research_project.id end)) as count_verified_pro")
                // // โครงการวิจัยที่เป็นผู้วิจัยหลัก ที่ตรวจสอบแล้ว  // จำนวน count -> pro_position = '1' -> verified = '1'
                ->selectRaw("count(DISTINCT(case when db_research_project.pro_position = '1' and db_research_project.verified = '1' then db_research_project.id end)) as count_master_pro")
                // // บทความตีพิมพ์ ที่ตรวจสอบแล้ว  // จำนวน count -> verified = '1'
                ->selectRaw("count(DISTINCT(case when db_published_journal.verified = '1' then db_published_journal.id end)) as count_verified_journal")
                // // โครงการที่นำไปใช้ประโยชน์ เชิงนโยบาย ที่ตรวจสอบแล้ว  // จำนวน count -> util_type = 'เชิงนโยบาย' -> verified = '1'
                ->selectRaw("count(DISTINCT(case when db_utilization.util_type = 'เชิงนโยบาย' and db_research_project.verified = '1' then db_utilization.pro_id end)) as count_policy_util")
                //
                ->GROUPBY ('db_research_project.users_name','db_research_project.researcher_level')
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
