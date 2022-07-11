<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class journalCommentMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $get_email = DB::table('db_published_journal')
        ->leftjoin('users', 'db_published_journal.users_id', '=', 'users.idCard')
        ->select('db_published_journal.id',
                 'users.email',
                )
        ->where('db_published_journal.id',$this->data['published_journal_id'])
        ->first();



        
        $details = [
            'text_header'    => 'เรียน นักวิจัยกรมควบคุมโรค',
            'detail_1'       => 'คุณได้รับการแจ้งเตือนจากระบบบันทึกข้อมูลนักวิจัยกรมควบคุมโรค (DDC Researcher Data Systems) กรุณาเข้าระบบเพื่อตรวจสอบและแก้ไขข้อมูล ได้ที่ลิงก์ ',
            'link1'          => 'https://dirrs-ddc.moph.go.th/',
            'detail_2'       => 'กรุณาแก้ไขข้อมูลในระบบภายใน 15 วัน หลังจากได้รับอีเมลนี้ หากไม่มีการแก้ไขตามระยะเวลาที่กำหนดถือว่าข้อมูลดังกล่าวมีสถานะ "ไม่ตรงเงื่อนไข" ',
            'detail_31'      => 'สามารถศึกษารายละเอียดได้ ดังนี้',
            'detail_32'      => '1. วิธีการแก้ไขข้อมูล ',
            'link32'         => 'https://youtube.com/watch?v=makbzXb-XHk',
            'detail_33'      => '2. วิธีการส่งข้อความสอบถาม admin กนว. ',
            'link33'         => 'https://youtu.be/nrLqUV6e6Ek',
            'text_footer'    => 'ขอแสดงความนับถือ',
            'text_footer1'   => 'นายอภิสิทธิ์ สนองค์',
            'text_footer2'   => 'Admin กองนวัตกรรมและวิจัย',
            'text_footer3'   => 'Tel:(Office) 662 590 3149',
            'text_footer4'   => 'E-mail: irem.hrd@ddc.mail.go.th'
        ];

        return $this
        ->to($get_email->email)
        ->view('emails.journalCommentMail')
        ->subject('การแจ้งเตือนจากระบบบันทึกข้อมูลนักวิจัย กรมควบคุมโรค')
        ->with([
            'details' => $details
        ]);

        // return $this->view('view.name');
    }
}
