@extends('layout.main')

<?php
  use App\CmsHelper as CmsHelper;
?>

@section('css-custom')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- DatePicker Style -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" /> -->

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>

<!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/> -->


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
            <li class="breadcrumb-item active"> ข้อมูลการตีพิมพ์วารสาร </li>
          </ol>
        </div>
      </div>
    </div>
  </div>
<!-- /.content-header -->

  <section class="content">
    <div class="container-fluid">

    <!-- START SUMMARY Total Box -->
      <div class="row">
        <div class="col-md-6 mx-auto">
          <div class="small-box bg-info mx-auto">
            <div class="inner">
              <h4> บทความที่เป็นผู้นิพนธ์หลัก </h4>
              <br>
              <h3> {{ empty($Total_master_jour)?'0': $Total_master_jour }} โครงการ </h3>
            </div>
            <div class="icon">
              <i class="ion ion-person"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
          </div>
        </div>

        <div class="col-md-6 mx-auto">
          <div class="small-box bg-danger mx-auto">
            <div class="inner">
              <h4> บทความตีพิมพ์ทั้งหมด </h4>
              <br>
              <h3> {{ empty($Total_journal)?'0': $Total_journal }} โครงการ </h3>
            </div>
            <div class="icon">
              <i class="ion ion-bookmark"></i>
            </div>
            <!-- <a class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
          </div>
        </div>

      </div>
      <br>
    <!-- END SUMMARY Total Box -->



    <!-- START From Input JOURNAL PROJECT -------------------------------------------------->
    @if(Auth::hasRole('user'))
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card shadow" style="background-color: #ff851b;">
            <div class="card-header">
              <h5><b> เพิ่มข้อมูลการตีพิมพ์วารสาร </b></h5>
            </div>
          </div>

            <!-- <form role="form"> -->
            <form method="POST" action="{{ route('journal.insert') }}" enctype="multipart/form-data">
             @csrf

              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInput1"> ชื่อบทความ (ENG) </label>
                      <input type="text" class="form-control" name="article_name_en" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInput1"> ชื่อบทความ (TH) </label>
                      <input type="text" class="form-control" name="article_name_th" >
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInput1"> ชื่อวารสาร (ENG) </label>
                      <input type="text" class="form-control" name="journal_name_en" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInput1"> ชื่อวารสาร (TH) </label>
                      <input type="text" class="form-control" name="journal_name_th" >
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="exampleInput1"> ปีที่พิมพ์ (year) </label>
                      <input type="text" class="form-control" placeholder="ปี ค.ศ." name="publish_years"
                             id="datepicker4" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="exampleInput1"> ฉบับที่ (issue) </label>
                      <input type="text" class="form-control" name="publish_no" maxlength="5"
                             onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลขเท่านั้น !'); this.value='';}" required>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="exampleInput1"> เล่มที่ (volume)  </label>
                      <input type="text" class="form-control" name="publish_volume" maxlength="4"
                             onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลขเท่านั้น !'); this.value='';}" required>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="exampleInput1"> หน้า (no) </label>
                      <input type="text" class="form-control" placeholder="xxxx" name="publish_page" maxlength="5"
                             onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลขเท่านั้น !'); this.value='';}">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="exampleInput1"> เลข DOI </label>
                      <input type="text" class="form-control" name="doi_number" maxlength="10" required>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="exampleSelect1"> การมีส่วนร่วมในบทความ </label>
                      <!-- SELECT option ดึงมาจาก ARRAY->contribute -->
                      <select class="form-control" name="contribute" required>
                        <option value="" disabled="true" selected="true" >กรุณาเลือก</option>
                        @foreach ($contribute as $key => $value)
                          <option value="{{ $key }}"> {{ $value }} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="exampleSelect1"> ท่านเป็นผู้รับผิดชอบบทความ </label>
                      <!-- SELECT option ดึงมาจาก ARRAY->corres -->
                      <select class="form-control" name="corres" required>
                        <option value="" disabled="true" selected="true" >กรุณาเลือก</option>
                        @foreach ($corres as $key => $value)
                          <option value="{{ $key }}"> {{ $value }} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="exampleSelect1"> บทความที่เป็นผลจากโครงการวิจัย </label>

                      <!-- SELECT Table -> db_research_project -->
                      <select class="form-control" name="pro_id">
                          <option value="" disabled="true" selected="true"> -- กรุณาเลือก -- </option>
                        @foreach ($journal_res as $value)
                          <option value = "{{ $value->id }}"> {{ $value->pro_name_en }} </option>
                        @endforeach
                      </select>

                    </div>
                  </div>
                </div>

                <div class="row" >
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="expInputFile"> อัพโหลดไฟล์ :<font color="red"> การตีพิมพ์วารสาร </font></label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" name="files" required>
                          <label class="custom-file-label" for="expInputFile"> Upload File ขนาดไม่เกิน 10 MB </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card-footer">
                <button type="submit" class="btn btn-success float-right" value="บันทึกข้อมูล">
                  <i class="fas fa-save"></i> &nbsp;บันทึกข้อมูล </button>
              </div>

            </form>

            <!-- Alert Notification -->
              <!-- @if(session()->has('success'))
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
              @endif -->
            <!-- END Alert Notification -->

          </div>
        </div>
      </div>
      <br>
  @endif
    <!-- END From Input JOURNAL PROJECT -------------------------------------------------->




    <!-- START TABLE -> JOURNAL PROJECT -------------------------------------------------->
      <section class="content">
        <div class="card">
          <div class="card card-secondary shadow">
            <div class="card-header">
              <h3 class="card-title"> ข้อมูลบทความที่ตีพิมพ์แล้ว </h3>
            </div>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover" id="example44">
                <thead>
                    <tr>
                      <th class="text-center"> Project ID </th>
                      <th class="text-center"> ชื่อบทความ (ENG) </th>
                      <th class="text-center"> ชื่อวารสาร (ENG) </th>
                      <th class="text-center"> ตีพิมพ์ </th>
                      <th class="text-center"> ผู้รับผิดชอบบทความ </th>
                      <th class="text-center"> การตรวจสอบ </th>
                      <th class="text-right"> ACTIONS </th>
                    </tr>
                </thead>

                <tbody>
                  @foreach ($journals as $value)
                  <tr>
                    <td class="text-center"> {{ $value->pro_id }} </td>
                    <td> {{ $value->article_name_en }} </td>
                    <td> {{ $value->journal_name_en }} </td>
                    <td class="text-center"> {{ $value->publish_years }} </td>
                    <td class="text-center"> {{ $corres [ $value->corres ] }} </td>

                    <td class="text-center">
                      @if($value->verified == "ตรวจสอบแล้ว")
                        <span class="badge bg-secondary badge-pill"> {{ $value->verified }} </span> <!-- null = รอการอนุมัติ -->
                      @else
                        <span class="badge bg-danger badge-pill"> {{ $value->verified }} </span> <!--  2 = ไม่อนุมัติ -->
                      @endif
                    </td>

                    <td class="td-actions text-right text-nowrap" href="#">
                    @if(Auth::hasRole('manager') || Auth::hasRole('user'))
                      <a href=" {{ route('DownloadFile.journal', ['id' => $value->id, 'files' => $value->files]) }} ">
                        <button type="button" class="btn btn-danger btn-md" data-toggle="tooltip" title="Download">
                          <i class="fas fa-arrow-alt-circle-down"></i>
                        </button>
                      </a>
                    @endif


                      <a href=" {{ route('journal.edit', ['id' => $value->id, 'pro_id' => $value->pro_id]) }} ">
                        <button type="button" class="btn btn-warning btn-md" data-toggle="tooltip" title="Edit">
                          <i class="fas fa-edit"></i>
                        </button>
                      </a>

                  @if(Auth::hasRole('manager'))
                      <a href=" {{ route('journal.verified', $value->id) }} ">
                        <button type="button" class="btn btn-md" data-toggle="tooltip" title="Verfied" style="background-color: #336699;">
                          <i class="fas fa-user-check"></i>
                        </button>
                      </a>
                  @endif
                    </td>

                  </tr>
                  @endforeach
                </tbody>



              </table>
            </div>
          </div>
        </div>

      </section>
    <!-- END TABLE -> JOURNAL PROJECT -------------------------------------------------->

      </div>
  </section>
@stop('contents')



@section('js-custom-script')

<!-- SweetAlert2 -->
<script src="{{ asset('bower_components/admin-lte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

  <!-- INSERT -->
    @if(session()->has('swl_add'))
      <script>
          Swal.fire({
              icon: 'success',
              title: 'บันทึกข้อมูลเรียบร้อยแล้ว',
              showConfirmButton: false,
              timer: 2800
          })
      </script>

    @elseif(session()->has('swl_del'))
      <script>
          Swal.fire({
              icon: 'error',
              title: 'บันทึกข้อมูลไม่สำเร็จ !!!',
              showConfirmButton: false,
              timer: 2800
          })
      </script>
    @endif

    <!-- UPDATE -->
    @if(session()->has('swl_update'))
      <script>
          Swal.fire({
              icon: 'success',
              title: 'บันทึกข้อมูลเรียบร้อยแล้ว',
              showConfirmButton: false,
              timer: 2800
          })
      </script>

    @elseif(session()->has('swl_errx'))
      <script>
          Swal.fire({
              icon: 'error',
              title: 'บันทึกข้อมูลไม่สำเร็จ !!!',
              showConfirmButton: false,
              timer: 2800
          })
      </script>
    @endif

<!-- END SweetAlert2 -->


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



<!-- DatePicker Style -->
<!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script> -->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
  $("#datepicker4").datepicker({
      format: "yyyy",
      viewMode: "years",
      minViewMode: "years",
      autoclose: true,
  });
</script>


<!-- <script>
    $('#datepicker4').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy',
        changeYear: true,
        changeMonth: false,
        autoclose: true,
        todayHighlight: true
    });
</script> -->
<!-- END DatePicker Style -->



<!-- FILE INPUT -->
<script type="text/javascript">
  $(document).ready(function () {
    bsCustomFileInput.init();
  });
</script>
<!-- END FILE INPUT -->


<script type="text/javascript" class="init">
  $(document).ready(function() {
    $('#example44').DataTable({
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
