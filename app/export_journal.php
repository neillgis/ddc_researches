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
                ->join('db_published_journal', 'db_research_project.id', '=', 'db_published_journal.pro_id')
                ->select('db_published_journal.pro_id',
                         'db_published_journal.users_id',
                         'db_research_project.users_name',
                         'article_name_en',
                         'article_name_th',
                         'journal_name_en',
                         'journal_name_th',
                         'publish_years',
                         'publish_no',
                         'publish_volume',
                         'publish_firstpage',
                         'publish_lastpage',
                         'doi_number',
                         'contribute',
                         'corres',
                         'url_journal',
                         'db_published_journal.verified'
                         )
                ->get();
    }


    public function headings(): array
    {
        return [
            'Project_ID',
            'เลขบัตรปชช.',
            'ชื่อ-สกุล',
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
            'การตรวจสอบ'
        ];
    }

}
