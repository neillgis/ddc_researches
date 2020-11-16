@extends('layout.main')

@section('css-custom')
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

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

<!-- START CONTENT  BOX ------------------------------------------------------->
        <section class="content">
          <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
              <div class="col-md-4 col-4">
                <div class="small-box bg-yellow">
                  <div class="inner">
                    <h3>150</h3>
                    <p> หัวข้อ ??? </p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  <!-- <a class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                </div>
              </div>

              <div class="col-md-4 col-4">
                <div class="small-box bg-yellow">
                  <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3>
                    <p> หัวข้อ ??? </p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person"></i>
                  </div>
                  <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                </div>
              </div>

              <div class="col-md-4 col-4">
                <div class="small-box bg-yellow">
                  <div class="inner">
                    <h3>44</h3>
                    <p> หัวข้อ ??? </p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                </div>
              </div>
            </div>
            <br>
<!-- END CONTENT  BOX --------------------------------------------------------->

<!-- START FORM  INSERT ------------------------------------------------------->
          <!-- <div class="row">
            <div class="col-md-12">
              <div class="card card-gray">
                <div class="card-header">
                  <h3 class="card-title"> แบบฟอร์มการนำไปใช้ประโยชน์ </h3>
                </div>


                <form method="POST" action="{{ route('util.insert') }}">
                  @csrf

              <div class="card-body">
                <div class="row">
                  <div class="col-md-5">
                    <div class="form-group">
                      <b><lebel for="fname_th"> ชื่อโครงการ (th-en) </lebel></b>
                      <select class="form-control" id="fname_th" name="fname_th" required>
                        <option value="">กรุณาเลือก</option>
                        <option value="โครงการ A">โครงการ A</option>
                        <option value="โครงการ B">โครงการ B</option>
                        <option value="โครงการ C">โครงการ C</option>
                        <option value="โครงการ D">โครงการ D</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <b><lebel for="lname_th"> การนำไปใช้ประโยชน์ </lebel></b>
                      <select class="form-control" id="lname_th" name="lname_th" required>
                        <option value="">กรุณาเลือก</option>
                        <option value="เชิงวิชาการ">เชิงวิชาการ</option>
                        <option value="เชิงสังคม/ชุมชน">เชิงสังคม/ชุมชน</option>
                        <option value="เชิงนโยบาย">เชิงนโยบาย</option>
                        <option value="เชิงพาณิชย์">เชิงพาณิชย์</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <b><lebel for="files"> แนบไฟล์ </lebel></b>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="files">
                        <label class="custom-file-label" for="files">Choose file</label>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
              <br>

              <div class="card-footer">
                    <button type="submit" class="btn btn-success float-right" value="บันทึกข้อมูล"> บันทึกข้อมูล </button>
              </div>

              </form> -->

              <!-- Alert Notification -->
                <!-- @if(session()->has('success'))
                  <div class="alert alert-success">
                    {{ session()->get('success') }}
                  </div>
                @endif
                @if (Session::has('failure'))
                  <div class="alert alert-danger">
                     {{ Session::get('failure') }}
                  </div>
                @endif -->
              <!-- END Alert Notification -->

            <!-- </div>
            </div>
          </div>
          <br> -->
<!-- END FORM  INSERT --------------------------------------------------------->


<!-- START TABLE LIST --------------------------------------------------------->
          <section class="content">
            <div class="card">
                <div class="card card-gray">
                <div class="card-header">
                    <h3 class="card-title"> ตารางสรุปข้อมูลนักวิจัย </h3>
                </div>
                </div>

                <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="example1" style="width:100%">
                    <thead>
                        <tr>
                            <th style="text-align:center">ลำดับที่</th>
                            <th style="text-align:center">รหัสประจำตัวนักวิจัย</th>
                            <th style="text-align:center">ชื่อ-นามสกุล</th>
                            <th style="text-align:center">หน่วยงาน</th>
                            <th style="text-align:center">จำนวนโครงการวิจัยทั้งหมด</th>
                            <th style="text-align:center">จำนวนโครงการวิจัยที่เป็นผู้วิจัยหลักทั้งหมด</th>
                            <th style="text-align:center">จำนวนบทความที่ตีพิมพ์ทั้งหมด</th>
                            <th style="text-align:center">จำนวนบทความที่นำไปใช้ประโยชน์เชิงวิชาการ </th>
                            <th style="text-align:center">ระดับนักวิจัย</th>
                            <th style="text-align:center">ผู้ตรวจสอบข้อมูล</th>
                            <th class="text-right"> จัดการข้อมูล </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach( $datas as $value )
                        <tr>
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->orcid_id }}</td>
                            <td>{{ $value->prefix.$value->fname_th." ".$value->lname_th }}</td>
                            <td>{{ $value->dep_id }}</td>
                            <td>{{ $value->pro_end_total }}</td>
                            <td>{{ $value->pro_major_total }}</td>
                            <td>{{ $value->pro_publish_total }}</td>
                            <td>{{ $value->util_result_academic }}</td>
                            <td>{{ $value->researcher_level }}</td>
                            <td>{{ $value->data_auditor }}</td>

                            <td class="project-actions text-right">
                                <a class="btn btn-info btn-sm" href="#">
                                  <i class="fas fa-folder"></i>
                                    VIEW
                                </a>
                                <a class="btn btn-danger btn-sm" href="#">
                                  <i class="fas fa-edit"></i>
                                    EDIT
                                </a>
                                <a class="btn btn-success btn-sm" href="#">
                                  <i class="fas fa-paperclip"></i>
                                    VERIFIED
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
                </div>
              </div>
            </div>
          </section>
      </section>
<!-- END TABLE LIST ----------------------------------------------------------->



@stop('contents')

<!-- SCRIPT ------------------------------------------------------------------->
@section('js-custom-script')
<script type="text/javascript" class="init">
  $(document).ready(function() {
    $('#example1').DataTable({
      dom: 'Bfrtip',
      buttons: [
        'excel', 'print'
      ]
    });
  });
</script>

<script>
  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>

<!-- bs-custom-file-input -->
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>

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