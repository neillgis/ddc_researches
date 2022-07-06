<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class journalCommentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $get_email = DB::table('db_research_project')
        ->leftjoin('users', 'db_research_project.users_id', '=', 'users.idCard')
        ->select('db_research_project.id',
                 'db_research_project.users_id',
                 'db_research_project.users_name',
                 'users.email',
                )
        ->where('db_research_project.id',$this->data['research_project_id'])
        ->first();
        
        $details = [
            'text_header'    => 'เรียน นักวิจัยกรมควบคุมโรค',
            'detail_1'       => '(ทดสอบส่ง)คุณได้รับการแจ้งเตือนจากระบบบันทึกข้อมูลนักวิจัยกรมควบคุมโรค (DDC Researcher Data System) กรุณาเข้าระบบเพื่อตรวจสอบและแก้ไขข้อมูล ได้ที่ลิงก์ https://dirrs-ddc.moph.go.th',
            'detail_2'       => 'กรุณาแก้ไขข้อมูลในระบบภายใน 15 วัน หลังจากได้รับอีเมลนี้ หากไม่มีการแก้ไขตามระยะเวลาที่กำหนดถือว่าข้อมูลดังกล่าวมีสถานะ "ไม่ตรงเงื่อนไข" ',
            'detail_31'      => 'สามารถศึกษารายละเอียดได้ ดังนี้',
            'detail_32'      => '1. วิธีการแก้ไขข้อมูล https://youtube.com/watch?v=makbzXb-XHk',
            'detail_33'      => '2. วิธีการส่งข้อความสอบถาม admin กนว. https://youtu.be/nrLqUV6e6Ek',
            'text_footer'    => 'ขอบแสดงความนับถือ',
            'text_footer1'   => 'นายอภิสิทธ์ สนองค์',
            'text_footer2'   => 'Admin กองนวัตกรรมและวิจัย',
            'text_footer3'   => 'Tel:(Office) 662 590 3149',
            'text_footer4'   => 'E-mail: irem.hrd@ddc.mail.go.th'
        ];

        return $this
        ->to($email_recipients)
        ->view('emails.journalCommentMail')
        ->subject('การแจ้งเตือนจากระบบบันทึกข้อมูลนักวิจัย กรมควบคุมโรค')
        ->with([
            'details' => $details
        ]);

        // return $this->view('view.name');
    }
}
