@extends('layout.main')

<?php
  use App\CmsHelper as CmsHelper;
?>


@section('css-custom')
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!-- <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml"> -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" /> -->


<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">


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


@stop('css-custom')

@section('contents')

<!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active"> สรุปข้อมูลสำหรับ (กนว.) </li>
          </ol>
        </div>
      </div>
    </div>
  </div>
<!-- /.content-header -->

      <section class="content">
        <div class="container-fluid">

<!-- START SUM  BOX ------------------------------------------------------->
            <div class="row">
              <div class="col-md-3">
                <div class="small-box bg-red">
                  <div class="inner">
                    <!-- เรียกจาก db_research_project -> โดย count id -> verified = 1 ( ตรวจสอบแล้ว ) ------------>
                    <h3> {{ empty($Total_research)?'0': $Total_research }} โครงการ </h3>
                    <br>
                    <p> โครงการวิจัยที่ทำเสร็จสิ้นทั้งหมด </p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-chart-line"></i>
                  </div>
                  <!-- <a class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3 mx-auto">
                <div class="small-box bg-info">
                  <div class="inner">
                    <!-- เรียกจาก db_research_project -> โดย count id -> pro_position = 1 ( เป็นผู้วิจัยหลัก ) ------------>
                    <h3> {{ empty($Total_master_pro)?'0': $Total_master_pro }} โครงการ </h3>
                    <br>
                    <p> โครงการวิจัยที่เป็นผู้วิจัยหลัก </p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                  </div>
                </div>
              </div>

              <div class="col-md-3 mx-auto">
                <div class="small-box bg-info">
                  <div class="inner">
                    <!-- เรียกจาก db_research_project -> โดย count id -> publish_status = 1 (ใช่ ) ------------>
                    <h3> {{ empty($Total_publish_pro)?'0': $Total_publish_pro }} โครงการ </h3>
                    <br>
                    <p> โครงการวิจัยตีพิมพ์ </p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-dice-d20"></i>
                  </div>
                </div>
              </div>

              <div class="col-md-3 mx-auto">
                <div class="small-box bg-info">
                  <div class="inner">
                    <!-- เรียกจาก db_published_journal โดย count id -> verified = 1 ( ตรวจสอบแล้ว ) ------------>
                    <h3> {{ empty($Total_publish_journal)?'0': $Total_publish_journal }} บทความ </h3>
                    <br>
                    <p> บทความตีพิมพ์ </p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-book-reader"></i>
                  </div>
                </div>
              </div>

              <div class="col-md-3 mx-auto">
                <div class="small-box bg-info">
                  <div class="inner">
                    <!-- เรียกจาก db_utilization -> โดย count id -> util_type = เชิงนโยบาย ------------>
                    <h3> {{ empty($Total_policy_util)?'0': $Total_policy_util }} บทความ </h3>
                    <br>
                    <p> บทความเชิงนโยบาย </p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-cubes"></i>
                  </div>
                </div>
              </div>
            </div>
            <br>
<!-- END SUM  BOX --------------------------------------------------------->


<!-- START TABLE LIST --------------------------------------------------------->
          <section class="content">
            <div class="card">
              <div class="card card-gray">
                <div class="card-header">
                    <h3 class="card-title"><b> สรุปข้อมูลนักวิจัย </b></h3>
                </div>
              </div>

              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover nowrap" style="width:100%" id="example1" >
                  <thead>
                    <tr>
                      <th class="text-center"> ชื่อ-นามสกุล </th>
                      <th class="text-center"> โครงการวิจัย </th>
                      <th class="text-center"> หน่วยงาน </th>
                      <th class="text-center"> โครงการวิจัย </th>
                      <th class="text-center"> บทความที่ตีพิมพ์ </th>
                      <th class="text-center"> บทความใช้ประโยชน์เชิงนโยบาย </th>
                      <th class="text-center"> ระดับนักวิจัย </th>
                      <th class="text-center"> ผู้ตรวจสอบ </th>
                      <th class="text-center"> วันที่ตรวจสอบ </th>
                      <th class="text-right"> Actions </th>
                    </tr>
                  </thead>

                  <tbody>
                      @foreach($users_total_research as $value)
                      <tr>
                        <td class="text-center"> {{ $value->fname." ".$value->lname }} </td>
                        <td class="text-center"> {{ $value->count_verified_pro }} </td>
                        <td class="text-center"> {{ $value->count_verified_pro }} </td>

                        <td class="text-center"> {{ $value->count_master_pro }} </td>
                        <td class="text-center"> {{ $value->count_verified_journal }} </td>
                        <td class="text-center"> {{ $value->count_policy_util }} </td>
                        <td class="text-center">
                            @if( !empty($value->researcher_level))
                                  {{$user_lev[$value->researcher_level]}}
                            @endif
                        </td>
                        <td class="text-center"></td>
                        <td class="text-center"></td>

                        <!-- จัดการข้อมูล -->
                        <td class="td-actions text-right text-nowrap" href="#">
                          <a href=" {{ route('summary.edit', $value->users_name) }} ">
                            <button type="button" class="btn btn-warning btn-md" data-toggle="tooltip" title="Edit">
                              <i class="fas fa-edit"></i>
                            </button>
                          </a>
                        </td>
                      </tr>
                  @endforeach
                  </tbody>
                  </table>
                </div>
              </div>
            </div>
          </section>
        </div>

      </section>
<!-- END TABLE LIST ----------------------------------------------------------->

@stop('contents')

<!-- SCRIPT ------------------------------------------------------------------->
@section('js-custom-script')

<!-- START ALERT บันทึกข้อมูลสำเร็จ  -->
    @if(session()->has('swl_add'))
      <script>
          Swal.fire({
              icon: 'success',
              title: 'บันทึกข้อมูลเรียบร้อยแล้ว',
              showConfirmButton: false,
              timer: 2800
          })
      </script>
    @endif
<!-- END ALERT บันทึกข้อมูลสำเร็จ  -->

<!-- REPORT FILE -->
  <script type="text/javascript" class="init">
    $(document).ready(function() {
      $('#example1').DataTable({
        dom: 'Bfrtip',
        buttons: [
          // 'excel', 'print'
        ]
      });
    });
  </script>
<!-- END REPORT FILE -->
@stop('js-custom-script')


@section('js-custom')
<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>

@stop('js-custom')
