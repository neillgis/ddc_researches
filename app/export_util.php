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
        $queryUtilExport = DB::table('db_utilization')
            ->leftJoin('db_research_project', 'db_utilization.pro_id', '=', 'db_research_project.id')
            ->leftJoin('db_published_journal', 'db_utilization.journal_id', '=', 'db_published_journal.id')
            ->leftjoin('users', 'db_utilization.users_id', '=', 'users.idCard')
            ->leftjoin('ref_util_status', 'db_utilization.status', '=', 'ref_util_status.id')
            ->leftjoin('ref_verified', 'db_utilization.verified', '=', 'ref_verified.id')
            ->select(
                DB::raw("
                    CASE
                        WHEN db_utilization.pro_id IS NULL THEN db_utilization.journal_id
                        ELSE db_utilization.pro_id
                    END AS project_id
                "),
                'db_utilization.users_id',
                DB::raw("concat(users.title, ' ', users.fname, ' ', users.lname) as users_name"),
                'users.deptName',
                DB::raw("
                    CASE
                        WHEN db_utilization.pro_id IS NULL THEN db_published_journal.article_name_en
                        ELSE db_research_project.pro_name_en
                    END AS pro_name_en
                "),
                DB::raw("
                    CASE
                        WHEN db_utilization.pro_id IS NULL THEN db_published_journal.article_name_th
                        ELSE db_research_project.pro_name_th
                    END AS pro_name_th
                "),
                DB::raw("
                    CASE
                        WHEN db_utilization.pro_id IS NULL THEN db_published_journal.publish_years
                        ELSE db_research_project.pro_end_date
                    END AS pro_end_date
                "),
                'util_year',
                DB::raw("
                    CASE
                        WHEN db_published_journal.contribute = 1 THEN 6
                        WHEN db_published_journal.contribute = 2 THEN 7
                        ELSE db_research_project.pro_position
                    END AS combined_position
                "),
                'util_type',
                'util_descrip',
                'ref_util_status.util_status',
                'ref_verified.verify_name',
                'db_utilization.created_at'
            )
            ->whereNull('db_utilization.deleted_at')
            ->orderBy('db_utilization.id', 'DESC')
            ->get();

        $positionMap = [
            1 => 'ผู้วิจัยหลัก',
            2 => 'ผู้วิจัยหลัก-ร่วม',
            3 => 'ผู้วิจัยร่วม',
            4 => 'ผู้ช่วยวิจัย',
            5 => 'ที่ปรึกษาโครงการ',
            6 => 'ผู้นิพนธ์หลัก',
            7 => 'ผู้นิพนธ์ร่วม',
        ];

        $prepUtilTable = $queryUtilExport->map(function ($item) use ($positionMap) {
            return [
                "project_id" => $item->project_id,
                "users_id" => $item->users_id,
                "users_name" => $item->users_name,
                "deptName" => $item->deptName,
                "pro_name_en" => $item->pro_name_en,
                "pro_name_th" => $item->pro_name_th,
                "pro_end_date" => $item->pro_end_date,
                "util_year" => $item->util_year,
                "pro_position" => $positionMap[$item->combined_position] ?? 'ไม่ทราบตำแหน่ง',
                "util_type" => $item->util_type,
                "util_descrip" => $item->util_descrip,
                "util_status" => $item->util_status,
                "verify_name" => $item->verify_name,
                "created_at" => $item->created_at,
            ];
        });
        return $prepUtilTable;
    }


    public function headings(): array
    {
        return [
            'project_id',
            'เลขบัตรปชช.',
            'ชื่อ-สกุล',
            'หน่วยงาน',
            'ชื่อโครงการ (ENG)',
            'ชื่อโครงการ (TH)',
            'ปีที่เผยแพร่',
            'ปีที่เสร็จสิ้น',
            'ปีที่นำไปใช้ประโยชน์',
            'ตำแหน่งในโครงการวิจัย',
            'ประเภท',
            'คำอธิบาย',
            'สถานะของการนำไปใช้ประโยชน์',
            'การตรวจสอบ',
            'วันที่ลงข้อมูล'
        ];
    }
}
