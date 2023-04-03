<?php

namespace App;

use journal;
use DB;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class export_journal implements FromCollection, WithHeadings
{
    // /**
    // * @return \Illuminate\Support\Collection
    // */

    public function collection()
    {
        // return journal::all();

        return DB::table('db_research_project')
                ->rightjoin('db_published_journal', 'db_research_project.id', '=', 'db_published_journal.pro_id')
                ->leftjoin('users', 'db_published_journal.users_id', '=', 'users.idCard')
                ->leftjoin('ref_contribute', 'db_published_journal.contribute', '=', 'ref_contribute.id')
                ->leftjoin('ref_yes_no', 'db_published_journal.verified', '=', 'ref_yes_no.id')
                ->leftjoin('ref_journal_status', 'db_published_journal.status', '=', 'ref_journal_status.id')
                ->leftjoin('ref_verified', 'db_published_journal.verified', '=', 'ref_verified.id')
                ->select('db_published_journal.pro_id',
                         'db_published_journal.users_id',
                         'db_published_journal.users_name',
                         'users.deptName',
                         'db_published_journal.article_name_en',
                         'db_published_journal.article_name_th',
                         'db_published_journal.journal_name_en',
                         'db_published_journal.journal_name_th',
                         'db_published_journal.publish_years',
                         'db_published_journal.publish_no',
                         'db_published_journal.publish_volume',
                         'db_published_journal.publish_firstpage',
                         'db_published_journal.publish_lastpage',
                         'db_published_journal.doi_number',
                         'ref_contribute.contributes',
                         'ref_yes_no.choice',
                         'db_published_journal.url_journal',
                         'ref_journal_status.journal_status',
                         'ref_verified.verify_name',
                         'db_published_journal.created_at'
                         )
                ->whereNull('db_published_journal.deleted_at')
                ->orderBy('db_published_journal.id', 'DESC')
                ->get();

    }


    public function headings(): array
    {
        return [
            'Project_ID',
            'เลขบัตรปชช.',
            'ชื่อ-สกุล',
            'หน่วยงาน',
            'ชื่อบทความ (ENG)',
            'ชื่อบทความ (TH)',
            'ชื่อวารสาร (ENG)',
            'ชื่อวารสาร (TH)',
            'ปีที่ตีพิมพ์',
            'ตีพิมพ์ฉบับที่ (Issue)',
            'ตีพิมพ์เล่มที่',
            'หน้าแรก (First_Page)',
            'หน้าสุดท้าย (Last_Page)',
            'เลข DOI',
            'การมีส่วนร่วมในบทความ',
            'การเป็นผู้รับผิดชอบบทความ (correspondent)',
            'URL',
            'สถานะของวารสาร',
            'การตรวจสอบ',
            'วันที่ลงข้อมูล'
        ];
    }

}
