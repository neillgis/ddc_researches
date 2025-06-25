<?php

namespace App;

// use App\summary;
use DB;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class export_total implements FromCollection, WithHeadings
{
    // /**
    // * @return \Illuminate\Support\Collection
    // */

    public function collection()
    {

        $research = [
            "all" => 0,
            "verify" => 0,
            "pi" => 0,
            "users" => 0
        ];
        $journal = [
            "all" => 0,
            "verify" => 0,
            "tci1" => 0,
            "q1q3" => 0
        ];
        $util = [
            "all" => 0,
            "verify" => 0,
            "policy" => 0,
            "academic" => 0,
        ];
        $research_level = [
            "training_level" => 0,
            "beginner_level" => 0,
            "intermediate_level" => 0,
            "advanced_level" => 0,
        ];
        $verified_list = [
            1   => 'ระดับฝึกหัด',
            2   => 'ระดับต้น',
            3   => 'ระดับกลาง',
            4   => 'ระดับสูง'
        ];

        $tbbody = [];
        $tbtemp = [];

        function box($arr, $name, $id)
        {
            $temp = empty($arr[$name][$id]) ? 0 : $arr[$name][$id];
            // if ($temp == 0) {
            //     $temp = "<span class='text-danger'>" . $temp . "</span>";
            // }
            return $temp;
        }

        $arrlv = [];
        $query = DB::table("ref_research")->get();
        foreach ($query as $item) {
            $arrlv[$item->id] = $item->position_res;
        }

        //หาสมัครที่ยังอยู่ และ ออกไปแล้ว --------------------------------------------
        $data_users = DB::table('users')
            ->where('idCard', '!=', '00000000000')
            ->where('idCard', 'not like', 'u%')
            ->whereNull("deleted_users")
            ->get();
        $users_active = [];
        foreach ($data_users as $item) {

            $users_active[] = $item->idCard;
            //-------------------------------------------------
            if ($item->researcher_level == 1) {
                $tbtemp['relv'][$item->idCard] = $verified_list[$item->researcher_level];
                $research_level['training_level']++;
            } else if ($item->researcher_level == 2) {
                $tbtemp['relv'][$item->idCard] = $verified_list[$item->researcher_level];
                $research_level['beginner_level']++;
            } else if ($item->researcher_level == 3) {
                $tbtemp['relv'][$item->idCard] = $verified_list[$item->researcher_level];
                $research_level['intermediate_level']++;
            } else if ($item->researcher_level == 4) {
                $tbtemp['relv'][$item->idCard] = $verified_list[$item->researcher_level];
                $research_level['advanced_level']++;
            } else {
                $tbtemp['relv'][$item->idCard] = "";
            }
            //-------------------------------------------------
            if (is_null($item->idCard)) {
                $tbtemp['data_auditor'][$item->idCard] = "";
            } else {
                if (!empty($item->data_auditor)) {
                    $tbtemp['data_auditor'][$item->idCard] = $item->data_auditor;
                    $tbtemp['edit_date'][$item->idCard] = CmsHelper::DateThai($item->updated_at);
                }
            }
            $tbtemp['hindex'][$item->idCard] = $item->spIndex;
            //-------------------------------------------------

        }
        $users_active = array_unique($users_active);
        //count total researcher that have a research level.
        $research_level['total_researcher'] = array_sum($research_level);

        //ข้อมูลโครงการวิจัย-----------------------------------------------------------------------
        $data_research = DB::table('db_research_project')
            ->select("users_id", "verified", "pro_position")
            ->whereNull('deleted_at')
            // ->whereIn('users_id', $users_active)
            ->get();
        $temp = [];
        foreach ($data_research as $item) {
            if (empty($tbtemp['research'][$item->users_id])) {
                $tbtemp['research'][$item->users_id] = 0;
                $tbtemp['research_pi'][$item->users_id] = 0;
            }
            //............................................
            $research['all']++;
            if ($item->verified == 1) {
                $research['verify']++;
                $tbtemp['research'][$item->users_id]++;

                if ($item->pro_position <= 2) {
                    $research['pi']++;
                    $tbtemp['research_pi'][$item->users_id]++;
                }
                if (in_array($item->users_id, $users_active)) {
                    $temp[] = $item->users_id;
                }
            }
        }
        $research['users'] = count(array_unique($temp));
        //การตีพิมพ์วารสาร-----------------------------------------------------------------------
        $data_journal = DB::table('db_published_journal')
            ->select("users_id", "verified", "status")
            ->whereNull('deleted_at')
            // ->whereIn('users_id', $users_active)
            ->get();
        foreach ($data_journal as $item) {
            if (empty($tbtemp['journal_verify'][$item->users_id])) {
                $tbtemp['journal_verify'][$item->users_id] = 0;
                $tbtemp['journal_tci1'][$item->users_id] = 0;
                $tbtemp['journal_q1q3'][$item->users_id] = 0;
                $tbtemp['journal_co-author'][$item->users_id] = 0;
            }
            //............................................
            $journal['all']++;
            if ($item->verified == 1) {
                $journal['verify']++;
                $tbtemp['journal_verify'][$item->users_id]++;

                if ($item->status == 1) {
                    $journal['tci1']++;
                    $tbtemp['journal_tci1'][$item->users_id]++;
                } else if ($item->status == 4 || $item->status == 5 || $item->status == 6) {
                    $journal['q1q3']++;
                    $tbtemp['journal_q1q3'][$item->users_id]++;
                }
            } else if ($item->verified == 4) {
                $tbtemp['journal_co-author'][$item->users_id]++;
            }
        }
        //การนำไปใช้ประโยชน์-----------------------------------------------------------------------
        $data_util = DB::table('db_utilization')
            ->select("users_id", "verified", "util_type")
            ->whereNull('deleted_at')
            // ->whereIn('users_id', $users_active)
            ->get();
        foreach ($data_util as $item) {
            if (empty($tbtemp['util'][$item->users_id])) {
                $tbtemp['util'][$item->users_id] = 0;
            }
            //............................................
            $util['all']++;
            if ($item->verified == 1) {
                $util['verify']++;
                $tbtemp['util'][$item->users_id]++;
                if ($item->util_type == 'เชิงนโยบาย') {
                    $util['policy']++;
                }
                if ($item->util_type == 'เชิงวิชาการ') {
                    $util['academic']++;
                }
            }
        }

        foreach ($data_users as $item) {
            $cid = $item->idCard;


            // if ($status == 1) {
                $addrow = (!empty($tbtemp['research'][$cid]) || !empty($tbtemp['journal_verify'][$cid]) || !empty($tbtemp['journal_co-author'][$cid]));
            // } else {
            //     $addrow = (empty($tbtemp['research'][$cid]) && empty($tbtemp['journal_verify'][$cid]) && empty($tbtemp['journal_co-author'][$cid]));
            // }
            if ($addrow) {
                $temp = [
                    $cid,
                    $item->title . $item->fname . " " . $item->lname,
                    $item->position,
                    $item->deptName,
                    box($tbtemp, 'research', $cid),
                    box($tbtemp, 'research_pi', $cid),
                    box($tbtemp, 'journal_verify', $cid),
                    box($tbtemp, 'journal_tci1', $cid),
                    box($tbtemp, 'journal_q1q3', $cid),
                    box($tbtemp, 'journal_co-author', $cid),
                    box($tbtemp, 'util', $cid),
                    box($tbtemp, 'hindex', $cid),
                    box($tbtemp, 'relv', $cid),
                    box($tbtemp, 'data_auditor', $cid),
                    box($tbtemp, 'edit_date', $cid),

                ];
                $tbbody[] = $temp;
            }
        }

        return collect($tbbody);

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
