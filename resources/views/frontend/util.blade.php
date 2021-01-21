@extends('layout.main')


@section('css-custom')
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!-- <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml"> -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- DatePicker Style -->
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
            <li class="breadcrumb-item active"> การนำไปใช้ประโยชน์ </li>
          </ol>
        </div>
      </div>
    </div>
  </div>
<!-- /.content-header -->

<!-- START CONTENT  BOX ------------------------------------------------------->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12 mx-auto">
                <div class="small-box bg-red">
                  <div class="inner">
                    <!-- เรียกจาก db_utilization -> โดย count id (All Record) --------->
                    <h4> โครงการที่นำไปใช้ประโยชน์ทั้งหมด </h4>
                    <br>
                    <h3> {{ empty($Total_util)?'0': $Total_util }} โครงการ </h3>
                  </div>
                  <div class="icon">
                    <i class="fas fa-chart-line" style="font-size:100px"> </i>
                  </div>
                </div>
              </div>

              <div class="col-md-3 mx-auto">
                <div class="small-box bg-green">
                  <div class="inner">
                    <!-- เรียกจาก db_utilization -> โดย count id -> util_type = เชิงวิชาการ --------->
                    <h4> โครงการที่นำไปใช้ประโยชน์เชิงวิชาการ </h4>
                    <br>
                    <h3> {{ empty($Total_academic_util)?'0': $Total_academic_util }} โครงการ </h3>
                  </div>
                  <div class="icon">
                    <i class="ion fas fa-brain"></i>
                  </div>
                </div>
              </div>

              <div class="col-md-3 mx-auto">
                <div class="small-box bg-green">
                  <div class="inner">
                    <!-- เรียกจาก db_utilization -> โดย count id -> util_type = เชิงสังคม/ชุมชน --------->
                    <h4> โครงการที่นำไปใช้ประโยชน์เชิงสังคม/ชุมชน </h4>
                    <br>
                    <h3> {{ empty($Total_social_util)?'0': $Total_social_util }} โครงการ </h3>
                  </div>
                  <div class="icon">
                    <i class="ion fas fa-users"></i>
                  </div>
                </div>
              </div>

              <div class="col-md-3 mx-auto">
                <div class="small-box bg-green">
                  <div class="inner">
                    <!-- เรียกจาก db_utilization -> โดย count id -> util_type = เชิงนโยบาย --------->
                    <h4> โครงการที่นำไปใช้ประโยชน์เชิงนโยบาย </h4>
                    <br>
                    <h3> {{ empty($Total_policy_util)?'0': $Total_policy_util }} โครงการ </h3>
                  </div>
                  <div class="icon">
                    <i class="ion fas fa-chalkboard-teacher"></i>
                  </div>
                </div>
              </div>

              <div class="col-md-3 mx-auto">
                <div class="small-box bg-green">
                  <div class="inner">
                    <!-- เรียกจาก db_utilization -> โดย count id -> util_type = เชิงพาณิชย์ --------->
                    <h4> โครงการที่นำไปใช้ประโยชน์เชิงพาณิชย์ </h4>
                    <br>
                    <h3> {{ empty($Total_commercial_util)?'0': $Total_commercial_util }} โครงการ </h3>
                  </div>
                  <div class="icon">
                    <i class="ion fas fa-donate"></i>
                  </div>
                </div>
              </div>
            </div>
            <br>
<!-- END CONTENT  BOX --------------------------------------------------------->

<!-- START FORM  INSERT ------------------------------------------------------->
          <div class="row">
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
                      <b><lebel for="exampleSelect1"> ชื่อโครงการ (th-en) </lebel></b>
                      <!-- SELECT ดึงข้อมูลชื่อโครงการมาจาก -> db_research_project Table -->
                      <select class="form-control" name="result_pro_id" required>
                          <option value="" disabled="true" selected="true"> กรุณาเลือก </option>
                        @foreach ($sl_research as $value)
                          <option value = "{{ $value->id }}"> {{ $value->pro_name_th." ".$value->pro_name_en }} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <b><lebel for="util_type"> ประเภทการนำไปใช้ประโยชน์ </lebel></b>
                      <select class="form-control" name="util_type" required>
                        <option value="" disabled="true" selected="true" > กรุณาเลือก </option>
                        @foreach ($util_type as $key => $value)
                          <option value="{{ $value }}"> {{ $value }} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <b><lebel for="files"> อัพโหลดไฟล์ : <font color="red"> การนำไปใช้ประโยชน์ </font></lebel></b>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="files">
                        <label class="custom-file-label" for="files"> Upload File ขนาดไม่เกิน 20 MB </label>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
              <br>

              <div class="card-footer">
                    <button type="submit" class="btn btn-success float-right" value="บันทึกข้อมูล">
                      <i class="fas fa-save"></i> &nbsp;บันทึกข้อมูล </button>
              </div>

              </form>

              <!-- Alert Notification -->
                @if(session()->has('success'))
                  <div class="alert alert-success" id="success-alert">
                    <strong> {{ session()->get('success') }} </strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
                @if (Session::has('failure'))
                  <div class="alert alert-danger">
                    <strong> {{ Session::get('failure') }} </strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
              <!-- END Alert Notification -->

            </div>
            </div>
          </div>
          <br>
<!-- END FORM  INSERT --------------------------------------------------------->

<!-- START TABLE LIST --------------------------------------------------------->
          <section class="content">
            <div class="card">
              <div class="card card-gray">
                <div class="card-header">
                  <h3 class="card-title"> โครงการที่นำไปใช้ประโยชน์ </h3>
                </div>
              </div>

              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover" style="width:100%" id="example1">
                    <thead>
                        <tr>
                            <th class="text-center">ลำดับที่</th>
                            <th class="text-center">ชื่อโครงการ</th>
                            <th class="text-center">การนำไปใช้ประโยชน์</th>
                            <th class="text-center">สถานะการตรวจสอบ</th>
                            <th class="text-right"> จัดการข้อมูล </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($sl_util as $value)
                        <tr>
                          <td class="text-center"> {{ $value->id }} </td>
                          <td class="text-left"> {{ $value->pro_name_th." ".$value->pro_name_en }} </td>
                          <td class="text-center"> {{ $value->util_type }} </td>
                          <td class="text-center"> {{ $value->review_status }} </td>

                          <!-- จัดการข้อมูล -->
                          <td class="td-actions text-right text-nowrap" href="#">
                            <a href="#">
                              <button type="button" class="btn btn-danger btn-md" data-toggle="tooltip" title="Download">
                                <i class="fas fa-arrow-alt-circle-down"></i>
                              </button>
                            </a>

                            <a href="#">
                              <button type="button" class="btn btn-warning btn-md" data-toggle="tooltip" title="Edit">
                                <i class="fas fa-edit"></i>
                              </button>
                            </a>

                        {{-- @if(Auth::user()->roles_type != '1') --}}
                            <a href="#">
                              <button type="button" class="btn btn-md"
                                      data-toggle="tooltip" title="Verfied" style="background-color: #336699;">
                                <i class="fas fa-user-check"></i>
                              </button>
                            </a>
                        {{-- @endif --}}
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


<!-- START ALERT บันทึกข้อมูลสำเร็จ  -->
<script type="text/javascript">
  $(document).ready(function () {
    window.setTimeout(function() {
      $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
          $(this).remove();
      });
    }, 2000);
  });
</script>
<!-- END ALERT บันทึกข้อมูลสำเร็จ  -->


<!-- REPORT FILE -->
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
<!-- END REPORT FILE -->

<script>
  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script>

<!-- FILE INPUT -->
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
<!-- END FILE INPUT -->

@stop('js-custom-script')


@section('js-custom')

<!-- DataTables -->
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
