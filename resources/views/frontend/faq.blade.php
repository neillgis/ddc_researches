@extends('layout.main')

<?php
  use App\CmsHelper as CmsHelper;
?>

@section('css-custom')

<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/sweetalert2-tdeme-bootstrap-4/bootstrap-4.min.css') }}">

  <!-- Fonts Style : Kanit -->
    <style>
    body {
      font-family: 'Kanit', sans-serif;
    }
    h1 {
      font-family: 'Kanit', sans-serif;
    }
    </style>
  <!-- END Fonts Style : Kanit -->

  <style>
       button {
        display: inline-block;
        position: relative;
        color: #1D9AF2;
        background-color: #292D3E;
        border: 1px solid #1D9AF2;
        border-radius: 4px;
        padding: 0 15px;
        cursor: pointer;
        height: 38px;
        font-size: 14px;

      }
      button:active {
        box-shadow: 0 3px 0 #1D9AF2;
        top: 3px;
      }
  </style>

  <style>
      #rcorners3 {
        border-radius: 20px;
        }
  </style>


  <style>
  table.center {
    margin-left: auto;
    margin-right: auto;
  }
  </style>



@stop('css-custom')


@section('contents')
<!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active"> FAQ (คำถามที่พบบ่อย) </li>
          </ol>
        </div>
      </div>
    </div>
  </div>
<!-- /.content-header -->


<!-- Main content -->
<section class="content">
  <div class="container">

<!-- Questions 1 ------------------------------------------------------------->
    <div class="row">
      <div class="col-md-10 mx-auto">
        <div class="card shadow collapsed-card" id="rcorners3">
          <div class="card-header" style="background-color: #54BEAE;">

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
              </button>
            </div>

            <!-- ใส่รายละเอียดคำถาม -------------------------------------------------------->
                <h4><i class="far fa-question-circle"></i>&nbsp; <b>Questions 1</b></h4>
                <h5>ใครบ้างที่สามารถจะเข้ามากรอกข้อมูลในระบบฐานข้อมูลนักวิจัยได้</h5>
          </div>

          <!-- ใส่ คำตอบ -------------------------------------------------------->
          <div class="card-body">
                <h5>บุคลากรกรมควบคุมโรคทุกตำแหน่งที่มีประสบการณ์ทำงานวิจัย ทั้งในฐานะ ผู้วิจัยหลัก ผู้วิจัยหลักร่วม ผู้ร่วมวิจัย ผู้ช่วยวิจัย และที่ปรึกษา</h5>
          </div>
        </div>
      </div>
    </div><br>

<!-- Questions 2 ------------------------------------------------------------->
    <div class="row">
      <div class="col-md-10 mx-auto">
        <div class="card shadow collapsed-card" id="rcorners3">
          <div class="card-header" style="background-color: #54BEAE;">

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
              </button>
            </div>

            <!-- ใส่รายละเอียดคำถาม -------------------------------------------------------->
                <h4><i class="far fa-question-circle"></i>&nbsp; <b>Questions 2</b></h4>
                <h5>โครงการวิจัยที่กรอกในระบบต้องเป็นโครงการจากแหล่งทุนใด และต้องเป็นโครงการวิจัยที่ผ่านการพิจารณารับรองจริยธรรมหรือไม่</h5>

          </div>

          <!-- ใส่ คำตอบ -------------------------------------------------------->
          <div class="card-body">
                <h5>เป็นโครงการวิจัยจากแหล่งทุนใดก็ได้ ทั้งจากในประเทศและต่างประเทศ หากเป็นการวิจัยในมนุษย์ โครงการวิจัยนั้นจะผ่านการพิจารณารับรองจริยธรรมจากที่ใดก็ได้</h5>
          </div>
        </div>
      </div>
    </div><br>

<!-- Questions 3 ------------------------------------------------------------->
    <div class="row">
      <div class="col-md-10 mx-auto">
        <div class="card shadow collapsed-card" id="rcorners3">
          <div class="card-header" style="background-color: #54BEAE;">

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
              </button>
            </div>

            <!-- ใส่รายละเอียดคำถาม -------------------------------------------------------->
                <h4><i class="far fa-question-circle"></i>&nbsp; <b>Questions 3</b></h4>
                <h5>รหัส ORCID คืออะไร แล้วเลขนี้มีจำนวนกี่หลัก ทำไมต้องกรอกรหัสนี้ด้วย</h5>

          </div>

          <!-- ใส่ คำตอบ -------------------------------------------------------->
          <div class="card-body">
                <h5>เป็น ORCID เปรียบเหมือนเลขบัตรประชาชนของนักวิจัย ใช้เป็นสากลสำหรับนักวิจัยทั่วโลก
          <br>
          </br>
                สามารถลงทะเบียนขอ ORCID ID ได้ด้วยตัวเองที่
          <br>
                <a href="https://orcid.org/register?fbclid=IwAR26_hEY1v4fP4h__9VH5MdWLWxEnQwRc255hK9596IM_qJTo69QUiTXuFQ">คลิก ORCID</a>
          <br>
                หน่วยงานที่ออกเลขให้คือ ORCID (Open Research and Contributor ID)
          </br>
          <br>
                เลขประจำตัวนักวิจัย ทำให้เชื่อมโยงกับระบบระบุตัวบุคคลของฐานข้อมูลออนไลน์ต่าง ๆ เช่น Scopus และสามารถเชื่อมโยงกับผลงานทุกชิ้นของนักวิจัย
                และช่วยให้ไม่เกิดความสับสน ในกรณีที่นักวิจัยมีชื่อเหมือนหรือคล้ายกัน เนื่องจาก ID ของนักวิจัยแต่ละคนจะได้หมายเลขไม่ซ้ำกันประกอบด้วยตัวเลขจำนวน 16 หลัก
                </h5>
          </div>
        </div>
      </div>
    </div><br>

<!-- Questions 4 ------------------------------------------------------------->
    <div class="row">
      <div class="col-md-10 mx-auto">
        <div class="card shadow collapsed-card" id="rcorners3">
          <div class="card-header" style="background-color: #54BEAE;">

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
              </button>
            </div>

            <!-- ใส่รายละเอียดคำถาม -------------------------------------------------------->
                <h4><i class="far fa-question-circle"></i>&nbsp; <b>Questions 4</b></h4>
                <h5>ฐานข้อมูลผลิตภัณฑ์เพื่อเฝ้าระวัง ป้องกันควบคุมโรคและภัยสุขภาพ ต่างจากฐานข้อมูลนักวิจัยนี้อย่างไร</h5>

          </div>

          <!-- ใส่ คำตอบ -------------------------------------------------------->
          <div class="card-body">
                <h5>ฐานข้อมูลนักวิจัยเป็นระบบที่ทำขึ้นเพื่อรวบรวมรายชื่อนักวิจัย และผลงานของนักวิจัยกรมควบคุมโรค เพื่อใช้ในการวาง <font color="red">แผนการพัฒนาศักยภาพนักวิจัย</font> ในอนาคต</h5>
          </div>
        </div>
      </div>
    </div><br>

<!-- Questions 5 ------------------------------------------------------------->
    <div class="row">
      <div class="col-md-10 mx-auto">
        <div class="card shadow collapsed-card" id="rcorners3">
          <div class="card-header" style="background-color: #54BEAE;">

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
              </button>
            </div>

            <!-- ใส่รายละเอียดคำถาม -------------------------------------------------------->
                <h4><i class="far fa-question-circle"></i>&nbsp; <b>Questions 5</b></h4>
                <h5>นักวิจัยจะทราบได้อย่างไรว่าข้อมูลที่กรอกเข้ามา ได้เข้าสู่ระบบและผ่านการตรวจสอบจากกองนวัตกรรมและวิจัยแล้ว</h5>
          </div>

          <!-- ใส่ คำตอบ -------------------------------------------------------->
          <div class="card-body">
          <br>
          <table class="center">
               <tr>
                  <td style="text-align:center"><p class="p-1 bg-danger text-white">รอตรวจสอบ</p></td>
                  <td><p>&nbsp;</p></td>
                  <td><p> = &nbsp; เมื่อนักวิจัยกรอกข้อมูลในระบบ</p></td>
               </tr>

               <tr>
                  <td style="text-align:center"><p class="p-1 bg-warning text-white">อยู่ระหว่างการตรวจสอบ</p></td>
                  <td><p>&nbsp;</p></td>
                  <td><p> = &nbsp; ผู้ดูแลระบบ (กนว.) กำลังตรวจสอบข้อมูล</p></td>
               </tr>

               <tr>
                  <td style="text-align:center"><p class="p-1 text-black" style="background-color: #ff851b;">อยู่ระหว่างแก้ไข</p></td>
                  <td><p>&nbsp;</p></td>
                  <td><p> = &nbsp; อยู่ระหว่างให้นักวิจัยแก้ไข/เพิ่มเติมข้อมูลในระบบ</p></td>
               </tr>

               <tr>
                  <td style="text-align:center"><p class="p-1 bg-secondary text-white">ตรวจสอบแล้ว&nbsp;<i class="far fa-check-square"></i></p></td>
                  <td><p>&nbsp;</p></td>
                  <td><p> = &nbsp; ผู้ดูแลระบบ (กนว.) ตรวจสอบข้อมูลแล้วเสร็จ</p></td>
               </tr>

               <tr>
                  <td style="text-align:center"><p class="p-1 bg-primary text-white">ไม่ตรงเงื่อนไข&nbsp;<i class="far fa-times-circle"></i></p></td>
                  <td><p>&nbsp;</p></td>
                  <td><p> = &nbsp; ข้อมูลที่แนบมาไม่ตรงเงื่อนไขที่กำหนด</p></td>
               </tr>
          </table>
                </h5>
          </div>
        </div>
      </div>
    </div><br>

<!-- Questions 6 ------------------------------------------------------------->
    <div class="row">
      <div class="col-md-10 mx-auto">
        <div class="card shadow collapsed-card" id="rcorners3">
          <div class="card-header" style="background-color: #54BEAE;">

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
              </button>
            </div>

            <!-- ใส่รายละเอียดคำถาม -------------------------------------------------------->
                <h4><i class="far fa-question-circle"></i>&nbsp; <b>Questions 6</b></h4>
                <h5>มีแนวทางอย่างไร หากเป็นบทความวิจัยที่ได้รับการตีพิมพ์ แต่ไม่ได้เป็นโครงการวิจัย
                    เช่น Document research หรือ Systematic Review and Meta-Analysis จะไม่สามารถใส่ในระบบได้ </h5>
          </div>

          <!-- ใส่ คำตอบ -------------------------------------------------------->
          <div class="card-body">
                <h5>สามารถเพิ่มผลงานวิจัยตีพิมพ์ประเภท Document research หรือ Systematic Review and Meta-Analysis ได้
                    แม้ว่างานวิจัยนั้นจะที่ไม่ได้มาจากโครงการวิจัย </h5>
              <picture>
                  <img src="{{ asset('/img/question_6.png') }}" class="rounded mx-auto d-block" width="500" >
              </picture>
          </div>
        </div>
      </div>
    </div><br>

<!-- Questions 7 ------------------------------------------------------------->
    <div class="row">
      <div class="col-md-10 mx-auto">
        <div class="card shadow collapsed-card" id="rcorners3">
          <div class="card-header" style="background-color: #54BEAE;">

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
              </button>
            </div>

            <!-- ใส่รายละเอียดคำถาม -------------------------------------------------------->
                <h4><i class="far fa-question-circle"></i>&nbsp; <b>Questions 7</b></h4>
                <h5>ผู้ที่ทำงานวิจัยที่ต้องลงข้อมูลในระบบงานวิจัยในที่นี้รวมถึงงานวิจัยจากงานประจำ (R2R) ด้วยหรือไม่</h5>
          </div>

          <!-- ใส่ คำตอบ -------------------------------------------------------->
          <div class="card-body">
               <h4 style="text-align:center">รวมงานวิจัยทุกประเภท ซึ่งรวมถึง</h4>
          <br>
          <h5>
          <table class="center">
               <tr>
                  <td><p><i class="far fa-dot-circle" style="font-size:15px"></i>&nbsp;</p></td>
                  <td><p>&nbsp; งานวิจัยจากงานประจำ (R2R)</p></td>
               </tr>

               <tr>
                 <td><p><i class="far fa-dot-circle" style="font-size:15px"></i>&nbsp;</p></td>
                 <td><p>&nbsp; Document research (R2R)</p></td>
               </tr>

               <tr>
                 <td><p><i class="far fa-dot-circle" style="font-size:15px"></i>&nbsp;</p></td>
                 <td><p>&nbsp; Systematic Review and Meta-Analysis (R2R)</p></td>
               </tr>
          </table>
          </h5>
          </div>
        </div>
      </div>
    </div><br>

<!-- Questions 8 ------------------------------------------------------------->
    <div class="row">
      <div class="col-md-10 mx-auto">
        <div class="card shadow collapsed-card" id="rcorners3">
          <div class="card-header" style="background-color: #54BEAE;">

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
            </button>
          </div>

          <!-- ใส่รายละเอียดคำถาม -------------------------------------------------------->
               <h4><i class="far fa-question-circle"></i>&nbsp; <b>Questions 8</b></h4>
               <h5>หากนักวิจัยกรอกข้อมูลผิดพลาด และต้องการแก้ไขข้อมูลหรือแนบไฟล์ใหม่ จะสามารถแก้ไขได้ไหม/หรือต้องทำการกรอกข้อมูลเข้ามาใหม่ </h5>
          </div>

          <!-- ใส่ คำตอบ -------------------------------------------------------->
          <div class="card-body">
          <h5>
          <table class="center">
               <tr>
                  <td><p><i class="far fa-dot-circle" style="font-size:15px"></i>&nbsp;</p></td>
                  <td><p>&nbsp; เมื่อนักวิจัยกรอกข้อมูลผิดพลาดและต้องการแก้ไข สามารถทำได้โดยคลิกที่แก้ไขข้อมูล</p></td> <br>
             </tr>

               <tr>
                 <td><p><i class="far fa-dot-circle" style="font-size:15px"></i>&nbsp;</p></td>
                 <td><p>&nbsp; เมื่อนักวิจัยต้องการแนบไฟล์ใหม่ สามารถทำได้โดยต้องทำการลบไฟล์เดิมก่อน เพื่ออัพโหลดไฟล์ใหม่ <br>
                        &nbsp; โดยคลิกที่ลบไฟล์ และอัพโหลดไฟล์ใหม่ ตามลำดับ</p></td>
               </tr>
          </table>
          </h5>

          </div>
        </div>
      </div>
    </div><br>

<!-- Questions 9 ------------------------------------------------------------->
    <div class="row">
      <div class="col-md-10 mx-auto">
        <div class="card shadow collapsed-card" id="rcorners3">
          <div class="card-header" style="background-color: #54BEAE;">

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
              </button>
            </div>

            <!-- ใส่รายละเอียดคำถาม -------------------------------------------------------->
                <h4><i class="far fa-question-circle"></i>&nbsp; <b>Questions 9</b></h4>
                <h5>หากไม่สามารถแนบไฟล์รายงานฉบับสมบูรณ์ในระบบได้ จะลงข้อมูลในระบบอย่างไร สามารถใช้เอกสารใดแทนได้</h5>

          </div>

          <!-- ใส่ คำตอบ -------------------------------------------------------->
          <div class="card-body">
                <h5>กรณีนักวิจัยไม่มีไฟล์รายงานฉบับสมบูรณ์
          <br>
          </br>
                สามารถเข้าไปสืบค้นได้ที่ระบบ
          <br>
                <a href="https://nriis.nrct.go.th">คลิก NRIIS</a>
          <br>
          </br>
                หรือใช้เอกสารสัญญารับทุนแทนได้
                </h5>
          </div>
        </div>
      </div>
    </div><br>


  </div>
</section>
@stop('contents')


@section('js-custom-script')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- <script src="{{ asset('bower_components/admin-lte/plugins/sweetalert2/sweetalert2.min.js') }}"></script> -->


@stop('js-custom-script')


@section('js-custom')

@stop('js-custom')
