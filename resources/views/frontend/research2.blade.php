@extends('layout.main')

<?php
  use App\CmsHelper as CmsHelper;
?>

@section('css-custom')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

<!-- DatePicker Style -->
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css">
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
<!-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> -->

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
          <div class="small-box bg-danger mx-auto">
            <div class="inner">
              <h3> {{ empty($Total_publish_pro)?'0': $Total_publish_pro }} โครงการ</h3>
              <br>
              <p> โครงการวิจัยที่ตีพิมพ์ทั้งหมด </p>
            </div>
            <div class="icon">
              <i class="fas fa-dice-d20"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
          </div>
        </div>

        <div class="col-md-4 mx-auto">
          <div class="small-box bg-success mx-auto">
            <div class="inner">
              <h3> {{ empty($Total_research)?'0': $Total_research }} โครงการ</h3>
              <br>
              <p> โครงการวิจัยที่ตรวจสอบแล้ว </p>
            </div>
            <div class="icon">
              <i class="fas fa-microscope"></i>
            </div>
            <!-- <a class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
          </div>
        </div>

        <div class="col-md-4 mx-auto">
          <div class="small-box bg-info mx-auto">
            <div class="inner">
              <h3> {{ empty($Total_master_pro)?'0': $Total_master_pro }} โครงการ</h3>
              <br>
              <p> โครงการวิจัยที่เป็นผู้วิจัยหลัก</p>
            </div>
            <div class="icon">
              <i class="fas fa-user-graduate"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
          </div>
        </div>

      </div>
      <br>
    <!-- END SUMMARY Total Box -->



    <!-- START From Input RESEARCH PROJECT -------------------------------------------------->
    <!-- {{-- @if(Auth::hasRole('user')) --}} -->
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card shadow" style="background-color: #ff851b;">
              <div class="card-header">
                <h5 class="card-title"><b> เพิ่มข้อมูลโครงการวิจัย </b></h5>
              </div>
            </div>

            <!-- <form role="form"> -->
            <form method="POST" action="{{ route('research.insert') }}" enctype="multipart/form-data">
              @csrf

              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInput1"> ชื่อโครงการ (TH) </label>
                      <input type="text" class="form-control" name="pro_name_th">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInput1"> ชื่อโครงการ (ENG) </label>
                      <input type="text" class="form-control" name="pro_name_en">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleSelect1"> ตำแหน่งในโครงการวิจัย <font color="red"> * </font></label>
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
                      <label for="exampleSelect1"> จำนวนผู้ร่วมวิจัย : ไม่รวมผู้วิจัยหลักและที่ปรึกษาโครงการ <font color="red"> * </font></label>
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
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleDatepicker1"> ปีที่เริ่มโครงการ <font color="red"> * </font></label>
                        <a class="one form-group" href="#" id="modal"> <b> (คำอธิบายเพิ่มเติม) </b></a>
                        <input type="text" class="form-control" id="datepicker1" placeholder="กรุณาเลือก ปี/เดือน/วัน"
                               name="pro_start_date" autocomplete="off" data-date-language="th-th" required>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleDatepicker1"> ปีที่เสร็จสิ้นโครงการ <font color="red"> * </font></label>
                      <a class="two form-group" href="#" id="modal"> <b> (คำอธิบายเพิ่มเติม) </b></a>
                      <input type="text" class="form-control" id="datepicker2" placeholder="กรุณาเลือก ปี/เดือน/วัน"
                             name="pro_end_date" autocomplete="off" required>
                    </div>
                  </div>
                </div>


                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleSelect1"> โครงการได้รับการตีพิมพ์ในวารสารวิชาการ <font color="red"> * </font></label>
                      <!-- SELECT option ดึงมาจากฐานข้อมูล db_research_project -->
                      <select class="form-control" name="publish_status" required>
                        <option value="" disabled="true" selected="true" >กรุณาเลือก</option>
                        @foreach ($publish_status as $key => $value)
                          <option value="{{ $key }}"> {{ $value }} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="expInputFile"> อัพโหลดไฟล์ : รายงานวิจัยฉบับสมบูรณ์.pdf <font color="red"> * </font></label>

                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" name="files" required>
                          <label class="custom-file-label" for="expInputFile"> Upload File ขนาดไม่เกิน 20 MB </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- <br> -->

                <!-- <div class="label">
                  <h4><b>หมายเหตุ : </b></h4>
                  <label> * ปีที่เริ่มโครงการ : &nbsp;&nbsp; วันที่ทำสัญญากับแหล่งทุนหรือวันที่ได้รับอนุมัติจากผู้บริหารของหน่วยงาน <font color="red">กรณีจำวัน เดือน ไมได้ ให้แทนที่ด้วย 01/01</font></label>
                  <br>
                  <label> ** ปีที่เสร็จสิ้นโครงการ : &nbsp;&nbsp; วันที่ส่งรายงานฉบับสมบูรณ์กรณีไม่ทราบ <font color="red">กรณีจำวัน เดือน ไมได้ ให้แทนที่ด้วย 31/12</font></label>
                </div> -->
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
  <!-- {{-- @endif --}} -->

    <!-- END From Input RESEARCH PROJECT -------------------------------------------------->



    <!-- START TABLE -> RESEARCH PROJECT -------------------------------------------------->
      <section class="content">
        <div class="card">
          <div class="card card-gray">
            <div class="card-header">
              <h5 class="card-title"> โครงการวิจัยที่เสร็จสิ้นแล้ว </h5>
            </div>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover" id="example55">
                <thead>
                    <tr>
                      <th class="text-center"> ลำดับ </th>
                      <th class="text-center"> Project ID </th>
                      <th class="text-center"> ชื่อโครงการวิจัยที่เสร็จสิ้นแล้ว </th>
                      <th class="text-center"> เริ่มโครงการ </th>
                      <th class="text-center"> เสร็จสิ้นโครงการ </th>
                      <th class="text-center"> ตีพิมพ์ </th>
                      @if(Auth::hasRole('manager'))
                        <th class="text-center"> ชื่อ/สกุล </th>
                        <th class="text-center"> หน่วยงาน </th>
                      @endif
                      <th class="text-center"> การตรวจสอบ </th>
                      <th class="text-right"> Actions </th>
                    </tr>
                </thead>

                <tbody>
                  @php
                      $i = 1;
                  @endphp
                  @foreach ($research as $value)
                  <tr>
                    <td class="text-center"> {{ $i }} </td>
                    <td class="text-center"> {{ $value->id }} </td>
                    <td class="text-left"> {{ $value->pro_name_th." ".$value->pro_name_en}} </td>
                    <td class="text-center"> {{ CmsHelper::DateEnglish($value->pro_start_date) }} </td>
                    <td class="text-center"> {{ CmsHelper::DateEnglish($value->pro_end_date) }} </td>
                    <td class="text-center"> {{ $publish_status [ $value->publish_status ] }} </td>
                  @if(Auth::hasRole('manager'))
                    <td class="text-center"> {{ $value->users_name }} </td>
                    <td class="text-center"> {{ $value->deptName }} </td>
                  @endif

                    <td class="text-center">
                      @if($value->verified == "ตรวจสอบแล้ว")
                        <span class="badge bg-secondary badge-pill"> {{ $value->verified }} </span>
                      @elseif($value->verified == "เอกสารไม่สมบูรณ์")
                        <span class="badge bg-info badge-pill"> {{ $value->verified }} </span>
                      @elseif($value->verified == "ไม่อนุมัติ")
                        <span class="badge bg-danger badge-pill"> {{ $value->verified }} </span>
                      @else
                        <span class="badge bg-danger badge-pill"> {{ $value->verified }} </span>
                      @endif
                    </td>

                    <td class="td-actions text-right text-nowrap" href="#">
                    <!-- {{-- @if(Auth::hasRole('manager') || Auth::hasRole('user')) --}} -->
                        @if($value->verified == "ตรวจสอบแล้ว")
                          <button type="button" class="btn btn-secondary btn-md" data-toggle="tooltip" title="Download" disabled>
                            <i class="fas fa-arrow-alt-circle-down"></i>
                          </button>
                        @else
                          <a href=" {{ route('DownloadFile.research', ['id' => $value->id, 'files' => $value->files]) }} ">
                            <button type="button" class="btn btn-danger btn-md" data-toggle="tooltip" title="Download">
                              <i class="fas fa-arrow-alt-circle-down"></i>
                            </button>
                          </a>
                        @endif


                        @if($value->verified == "ตรวจสอบแล้ว")
                          <button type="button" class="btn btn-secondary btn-md" data-toggle="tooltip" title="Edit" disabled>
                            <i class="fas fa-edit"></i>
                          </button>
                        @else
                          <a href=" {{ route('research.edit', $value->id) }} ">
                            <button type="button" class="btn btn-warning btn-md" data-toggle="tooltip" title="Edit">
                              <i class="fas fa-edit"></i>
                            </button>
                          </a>
                        @endif


                      @if(Auth::hasRole('manager'))
                          @if($value->verified == "ตรวจสอบแล้ว")
                          <a href=" {{ route('research.waiting', $value->id) }} ">
                            <button type="button" class="btn btn-secondary btn-md" data-toggle="tooltip" title="Verfied">
                              <i class="fas fa-user-check"></i>
                            </button>
                          </a>
                          @elseif($value->verified == "ไม่อนุมัติ")
                          <a href=" {{ route('research.unverified', $value->id) }} ">
                            <button type="button" class="btn btn-danger btn-md" data-toggle="tooltip" title="Waiting">
                              <i class="fas fa-user-check"></i>
                            </button>
                          </a>
                          @elseif($value->verified == "เอกสารไม่สมบูรณ์")
                          <a href=" {{ route('research.incomplete', $value->id) }} ">
                            <button type="button" class="btn btn-info btn-md" data-toggle="tooltip" title="Verfied">
                              <i class="fas fa-user-check"></i>
                            </button>
                          </a>
                          @else
                            <a href=" {{ route('research.verified', $value->id) }} ">
                              <button type="button" class="verify btn btn-md" data-toggle="tooltip" title="Verfied" style="background-color: #567fa8;">
                                <i class="fas fa-user-check"></i>
                              </button>
                            </a>
                          @endif
                      @endif
                    </td>

                  </tr>
                  @php
                      $i++;
                  @endphp
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

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- <script src="{{-- asset('bower_components/admin-lte/plugins/sweetalert2/sweetalert2.min.js') --}}"></script> -->

  <!-- Alert คำอธิคำอธิบายเพิ่มเติม -->
  <script>
    document.querySelector(".one").addEventListener('click', function(){
      Swal.fire(
      "ปีที่เริ่มโครงการ",
      "วันที่ทำสัญญากับแหล่งทุนหรือวันที่ได้รับอนุมัติจากผู้บริหารของหน่วยงาน <br> กรณีจำวัน เดือน ไม่ได้ ให้แทนที่ด้วย 01/01",
      "warning"
      );
    });
  </script>
  <script>
    document.querySelector(".two").addEventListener('click', function(){
      Swal.fire(
      "ปีที่เสร็จสิ้นโครงการ",
      "วันที่ส่งรายงานฉบับสมบูรณ์ <br> กรณีจำวัน เดือน ไม่ได้ ให้แทนที่ด้วย 31/12",
      "warning"
      );
    });
  </script>
<!-- END Alert คำอธิคำอธิบายเพิ่มเติม -->


  <!-- INSERT success -->
    @if(Session::get('message'))
     <?php Session::forget('message'); ?>
      <script>
        Swal.fire({
            icon: 'success',
            title: 'บันทึกข้อมูลเรียบร้อยแล้ว',
            showConfirmButton: true,
            confirmButtonColor: '#2C6700',
            timer: 2500
        })
      </script>
    @endif
    <!-- END INSERT success -->


    @if(Session::get('verify'))
     <?php Session::forget('verify'); ?>
      <script>
        Swal.fire({
            icon: 'success',
            title: 'Verified Successfully',
            showConfirmButton: true,
            confirmButtonColor: '#2C6700',
            timer: 3800
        })
      </script>
    @endif


    @if(Session::get('Noverify'))
     <?php Session::forget('Noverify'); ?>
      <script>
        Swal.fire({
            icon: 'warning',
            title: 'Unverified Successfully',
            text: 'รายการนี้ยังไม่ได้ตรวจสอบ',
            showConfirmButton: true,
            confirmButtonColor: '#d33',
            timer: 6000
        })
      </script>
    @endif



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
  var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    $('#datepicker1').datepicker({
        uiLibrary: 'bootstrap4',
        // iconsLibrary: 'fontawesome',
        format: 'yyyy/mm/dd',
        maxDate: today,
        autoclose: true,
        todayHighlight: true,
        // thaiyear: true
    })
    $('#datepicker2').datepicker({
        uiLibrary: 'bootstrap4',
        // iconsLibrary: 'fontawesome',
        format: 'yyyy/mm/dd',
        maxDate: today,
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
