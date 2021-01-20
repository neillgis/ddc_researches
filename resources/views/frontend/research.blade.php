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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

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
            <li class="breadcrumb-item active"> ข้อมูลโครงการวิจัย </li>
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
        <div class="col-md-4 mx-auto">
          <div class="small-box bg-success">
            <div class="inner">
              <h3> {{ empty($Total_research)?'0': $Total_research }} </h3>
              <p> โครงการวิจัยทั้งหมด </p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <!-- <a class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
          </div>
        </div>

        <div class="col-md-4 mx-auto">
          <div class="small-box bg-info mx-auto">
            <div class="inner">
              <h3> {{ empty($Total_master_pro)?'0': $Total_master_pro }} </h3>
              <p> โครงการวิจัยที่เป็นผู้วิจัยหลัก </p>
            </div>
            <div class="icon">
              <i class="ion ion-person"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
          </div>
        </div>

        <div class="col-md-4 mx-auto">
          <div class="small-box bg-danger mx-auto">
            <div class="inner">
              <h3> {{ empty($Total_publish_pro)?'0': $Total_publish_pro }} </h3>
              <p> โครงการวิจัยที่ตีพิมพ์ทั้งหมด </p>
            </div>
            <div class="icon">
              <i class="ion ion-bookmark"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
      </div>
      <br>
    <!-- END SUMMARY Total Box -->



    <!-- START From Input RESEARCH PROJECT -------------------------------------------------->
  {{-- @if(Auth::user()->roles_type != '1') --}}
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card shadow" style="background-color: #ff851b;">
              <div class="card-header">
                <h5><b> เพิ่มข้อมูลโครงการวิจัย </b></h5>
              </div>
            </div>

            <!-- <form role="form"> -->
            <form method="POST" action="{{ route('research.insert') }}" enctype="multipart/form-data">
              @csrf

              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInput1"> ชื่อโครงการ (ENG) </label>
                      <input type="text" class="form-control" name="pro_name_en" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInput1"> ชื่อโครงการ (TH) </label>
                      <input type="text" class="form-control" name="pro_name_th">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleSelect1"> ตำแหน่งในโครงการวิจัย </label>
                      <!-- SELECT option ดึงมาจากฐานข้อมูล db_research_project -->
                      <select class="form-control" name="pro_position" required>
                        <option value="" disabled="true" selected="true" >กรุณาเลือก</option>
                        @foreach ($pro_position as $key => $value)
                          <option value="{{ $key }}"> {{ $value }} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleSelect1"> จำนวนผู้ร่วมวิจัย </label>
                      <!-- SELECT option ดึงมาจากฐานข้อมูล db_research_project -->
                      <select class="form-control" name="pro_co_researcher" required>
                        <option value="" disabled="true" selected="true" >กรุณาเลือก</option>
                        @foreach ($pro_co_researcher as $key => $value)
                          <option value="{{ $key }}"> {{ $value }} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleDatepicker1"> ปี พ.ศ. ที่เริ่มโครงการ </label>
                      <input type="text" class="form-control" id="datepicker1" placeholder="กรุณาเลือก ปี/เดือน/วัน"
                             name="pro_start_date" autocomplete="off" required>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleDatepicker1"> ปี พ.ศ. ที่เสร็จสิ้นครงการ </label>
                      <input type="text" class="form-control" id="datepicker2" placeholder="กรุณาเลือก ปี/เดือน/วัน"
                             name="pro_end_date" autocomplete="off" required>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleSelect1"> โครงการได้ตีพิมพ์ </label>
                      <!-- SELECT option ดึงมาจากฐานข้อมูล db_research_project -->
                      <select class="form-control" name="publish_status" required>
                        <option value="" disabled="true" selected="true" >กรุณาเลือก</option>
                        @foreach ($publish_status as $key => $value)
                          <option value="{{ $key }}"> {{ $value }} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row" >
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="expInputFile"> อัพโหลดไฟล์ : <font color="red"> โครงการวิจัย </font></label>

                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" name="files">
                          <label class="custom-file-label" for="expInputFile"> Upload File ขนาดไม่เกิน 20 MB </label>
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

          </div>
        </div>
      </div>
    <br>
    {{-- @endif --}}

    <!-- END From Input RESEARCH PROJECT -------------------------------------------------->



    <!-- START TABLE -> RESEARCH PROJECT -------------------------------------------------->
      <section class="content">
        <div class="card">
          <div class="card card-secondary shadow">
            <div class="card-header">
              <h3 class="card-title"> โครงการวิจัยที่เสร็จสิ้นแล้ว </h3>
            </div>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover" id="example55">
                <thead>
                    <tr>
                      <th> ลำดับ </th>
                      <th> ชื่อโครงการ (ENG) </th>
                      <th> เริ่มโครงการ </th>
                      <th> เสร็จสิ้นโครงการ </th>
                      <th> ตีพิมพ์ </th>
                      <th> การตรวจสอบ </th>
                      <th class="text-right"> ACTIONS </th>
                    </tr>
                </thead>

                <tbody>
                  @foreach ($research as $value)
                  <tr>
                    <td> {{ $value->id }} </td>
                    <td> {{ $value->pro_name_en }} </td>
                    <td> {{ CmsHelper::DateThai($value->pro_start_date) }} </td>
                    <td> {{ CmsHelper::DateThai($value->pro_end_date) }} </td>
                    <td> {{ $publish_status [ $value->publish_status ] }} </td>

                    <td>
                      @if($value->verified == "อนุมัติแล้ว")
                        <span class="badge bg-secondary badge-pill"> {{ $value->verified }} </span> <!-- null = รอการอนุมัติ -->
                      @else
                        <span class="badge bg-danger badge-pill"> {{ $value->verified }} </span> <!--  2 = ไม่อนุมัติ -->
                      @endif
                    </td>

                    <td class="td-actions text-right text-nowrap" href="#">
                      <a href=" {{ route('DownloadFile.research', ['id' => $value->id, 'files' => $value->files]) }} ">
                        <button type="button" class="btn btn-danger btn-md" data-toggle="tooltip" title="Download">
                          <i class="fas fa-arrow-alt-circle-down"></i>
                        </button>
                      </a>

                      <a href=" {{ route('research.edit', $value->id) }} ">
                        <button type="button" class="btn btn-warning btn-md" data-toggle="tooltip" title="Edit">
                          <i class="fas fa-edit"></i>
                        </button>
                      </a>

                  {{-- @if(Auth::user()->roles_type != '1') --}}
                      <a href=" {{ route('research.verified', $value->id) }} ">
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
      </section>
    <!-- END TABLE -> RESEARCH PROJECT -------------------------------------------------->

      </div>
  </section>

@stop('contents')



@section('js-custom-script')

<!-- SweetAlert2 INSERT -->
<script src="{{ asset('bower_components/admin-lte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

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
<!-- END SweetAlert2 -->


<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

  @if(session()->has('swl_verified'))
    <script>
      // $.ajaxSetup({
      //   headers: {
      //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      //   }
      // });

        Swal.fire({
          title: 'Are you sure?',
          text: "รายการนี้ถูกตรวจสอบแล้วใช่ไหม",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: '#208a17',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Confirm',
          cancelButtonText: "No Cancel",
          reverseButtons: !0,
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire(
              'Verfied Success',
              'Your data has been verfied.',
              'success'
              // icon: 'success',
              // title: 'รายการนี้ถูกตรวจสอบเรียบร้อยแล้ว',
              // showConfirmButton: true,
              // timer: 1000

            )
          }
        })
          // reverseButtons: !0
        // }).then(function (e) {
        //
        //     if (e.value === true) {
        //         var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        //
        //         $.ajax({
        //             type: 'GET',
        //             url: "{{ route('research.verified', $value->id) }}",
        //             data: {_token: CSRF_TOKEN},
        //             dataType: 'JSON',
        //             success: function (results) {
        //
        //                 if (results.success === true) {
        //                     swal("Done!", results.message, "success");
        //                     setTimeout(function(){
        //                       location.reload();
        //                       }, 1000);
        //                 } else {
        //                     swal("Error!", results.message, "error");
        //                 }
        //             }
        //         });
        //
        //     } else {
        //         e.dismiss;
        //     }
        //
        // }, function (dismiss) {
        //     return false;
        // });


        // }).then((result) => {
        //   if (result.isConfirmed) {
        //     window.location.href = "{{ route('research.verified', $value->id) }}";
            // $.ajax({
            //   url: "{{ route('research.verified', $value->id) }}",
            //   type: "get",
            //   data: {
            //     'id': id,
            //   },
            //   success: function(data) {
            //     if (data.verified != 'ok') {
            //       Swal.fire({
            //         icon: 'success',
            //         title: 'รายการนี้ถูกตรวจสอบเรียบร้อยแล้ว',
            //         showConfirmButton: true,
            //         timer: 1000
            //       }).then((result) => {
            //         if (result) {
            //           location.reload();
            //         }
            //       })
            //     }
            //   }
            // })
        //   }
        // });
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


<!-- FILE INPUT -->
<script type="text/javascript">
  $(document).ready(function () {
    bsCustomFileInput.init();
  });
</script>
<!-- END FILE INPUT -->


<!-- DatePicker Style -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<script>
    $('#datepicker1').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy/mm/dd',
        autoclose: true,
        todayHighlight: true
    });
</script>
<script>
    $('#datepicker2').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy/mm/dd',
        autoclose: true,
        todayHighlight: true
    });
</script>
<!-- END DatePicker Style -->



<script type="text/javascript" class="init">
  $(document).ready(function() {
    $('#example55').DataTable({
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
