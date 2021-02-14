@extends('layout.main')

<?php
  use App\CmsHelper as CmsHelper;
?>

@section('css-custom')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>

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
        <div class="col-md-4 mx-auto">
          <div class="small-box bg-danger mx-auto">
            <div class="inner">
              <h3> {{ empty($Total_journal)?'0': $Total_journal }} บทความ </h3>
              <br>
              <p> บทความตีพิมพ์ทั้งหมด </p>
            </div>
            <div class="icon">
              <i class="fas fa-book-reader"></i>
            </div>
            <!-- <a class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
          </div>
        </div>

        <div class="col-md-4 mx-auto">
          <div class="small-box bg-green mx-auto">
            <div class="inner">
              <h3> {{ empty($Total_journal_verify)?'0': $Total_journal_verify }} บทความ </h3>
              <br>
              <p> บทความตีพิมพ์ที่ตรวจสอบแล้ว </p>
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
              <h3> {{ empty($Total_master_jour)?'0': $Total_master_jour }} บทความ </h3>
              <br>
              <p> บทความที่เป็นผู้นิพนธ์หลัก </p>
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



    <!-- START From Input JOURNAL PROJECT -------------------------------------------------->
    <!-- {{-- @if(Auth::hasRole('user')) --}} -->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card shadow" style="background-color: #ff851b;">
            <div class="card-header">
              <h5 class="card-title"><b> เพิ่มข้อมูลการตีพิมพ์วารสาร </b></h5>
            </div>
          </div>

            <!-- <form role="form"> -->
            <form method="POST" action="{{ route('journal.insert') }}" enctype="multipart/form-data">
             @csrf

              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInput1"> ชื่อบทความ (TH) </label>
                      <input type="text" class="form-control" name="article_name_th" >
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInput1"> ชื่อบทความ (ENG) </label>
                      <input type="text" class="form-control" name="article_name_en">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInput1"> ชื่อวารสาร (TH) </label>
                      <input type="text" class="form-control" name="journal_name_th" >
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInput1"> ชื่อวารสาร (ENG) </label>
                      <input type="text" class="form-control" name="journal_name_en">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInput1"> ปีที่พิมพ์ (Year) <font color="red"> * </font></label>
                      <input type="text" class="form-control" placeholder="ปี ค.ศ." name="publish_years"
                             id="datepicker4" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInput1"> ฉบับที่ (Issue) <font color="red"> * </font></label>
                      <input type="text" class="form-control" name="publish_no" maxlength="2"
                             onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลขเท่านั้น !'); this.value='';}" required>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInput1"> เล่มที่ (Volume) <font color="red"> * </font></label>
                      <input type="text" class="form-control" name="publish_volume" maxlength="2"
                             onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลขเท่านั้น !'); this.value='';}" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInput1"> หน้าแรก (First Page) <font color="red"> * </font></label>
                      <input type="text" class="form-control" placeholder="xxxx" name="publish_firstpage" maxlength="3"
                             onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลขเท่านั้น !'); this.value='';}" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInput1"> หน้าสุดท้าย (Last Page) <font color="red"> * </font></label>
                      <input type="text" class="form-control" placeholder="xxxx" name="publish_lastpage" maxlength="3"
                             onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลขเท่านั้น !'); this.value='';}" required>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInput1"> เลข DOI (ถ้ามี) </label>
                      <input type="text" class="form-control" name="doi_number">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleSelect1"> การมีส่วนร่วมในบทความ <font color="red"> * </font></label>
                      <!-- SELECT option ดึงมาจาก ARRAY->contribute -->
                      <select class="form-control" name="contribute" required>
                        <option value="" disabled="true" selected="true" >กรุณาเลือก</option>
                        @foreach ($contribute as $key => $value)
                          <option value="{{ $key }}"> {{ $value }} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleSelect1"> ท่านเป็นผู้รับผิดชอบบทความ (Correspondence) <font color="red"> * </font></label>
                      <!-- SELECT option ดึงมาจาก ARRAY->corres -->
                      <select class="form-control" name="corres" required>
                        <option value="" disabled="true" selected="true" >กรุณาเลือก</option>
                        @foreach ($corres_sl as $key => $value)
                          <option value="{{ $key }}"> {{ $value }} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleSelect1"> บทความนี้เป็นผลจากโครงการวิจัย <font color="red"> * </font></label>

                      <!-- SELECT Table -> db_research_project -->
                      <select class="form-control" name="pro_id" required>
                          <option value="" disabled="true" selected="true"> -- กรุณาเลือก -- </option>
                        @foreach ($journal_res as $value)
                          <option value = "{{ $value->id }}"> {{ $value->pro_name_en }} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <!-- URL ที่อยู่ออนไลน์ของบทความ -->
                <div class="row" >
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="exampleInput1"> URL ที่อยู่ออนไลน์ของบทความ (ถ้ามี) </label>
                      <input type="text" class="form-control" name="url_journal">
                    </div>
                  </div>
                </div>

                <div class="row" >
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="expInputFile"> อัพโหลดไฟล์ : บทคัดย่อ (Abstracts).pdf <font color="red"> * </font></label>
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
    <!-- {{-- @endif --}} -->
    <!-- END From Input JOURNAL PROJECT -------------------------------------------------->




    <!-- START TABLE -> JOURNAL PROJECT -------------------------------------------------->
      <section class="content">
        <div class="card">
          <div class="card card-secondary shadow">
            <div class="card-header">
              <h3 class="card-title"> บทความที่ตีพิมพ์แล้ว </h3>
            </div>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover" id="example44">
                <thead>
                    <tr>
                      <th class="text-center"> ลำดับ </th>
                      <th class="text-center"> Project ID </th>
                      <th class="text-center"> ชื่อบทความ (ENG) </th>
                      <th class="text-center"> ชื่อวารสาร (ENG) </th>
                      <th class="text-center"> ตีพิมพ์ </th>
                    @if(Auth::hasRole('manager'))
                      <th class="text-center"> ชื่อ/สกุล </th>
                    @endif
                      <th class="text-center"> ผู้รับผิดชอบบทความ </th>
                      <th class="text-center"> การตรวจสอบ </th>
                      <th class="text-right"> Actions </th>
                    </tr>
                </thead>

                <tbody>
                  @php
                      $i = 1;
                  @endphp
                  @foreach ($journals as $value)
                  <tr>
                    <td class="text-center"> {{ $i }} </td>
                    <td class="text-center"> {{ $value->pro_id }} </td>
                    <td> {{ $value->article_name_en }} </td>
                    <td> {{ $value->journal_name_en }} </td>
                    <td class="text-center"> {{ $value->publish_years }} </td>

                  @if(Auth::hasRole('manager'))
                    <td class="text-center"> {{ $value->users_name }} </td>
                  @endif

                    <td class="text-center"> {{ $value->corres }} </td>

                    <td class="text-center">
                      @if($value->verified == "ตรวจสอบแล้ว")
                        <span class="badge bg-secondary badge-pill"> {{ $value->verified }} </span> <!-- null = ตรวจสอบแล้ว -->
                      @else
                        <span class="badge bg-danger badge-pill"> {{ $value->verified }} </span> <!--  1 = รอตรวจสอบ -->
                      @endif
                    </td>

                    <td class="td-actions text-right text-nowrap" href="#">
                    <!-- {{-- @if(Auth::hasRole('manager') || Auth::hasRole('user')) --}} -->
                        @if($value->verified == "ตรวจสอบแล้ว")
                          <button type="button" class="btn btn-secondary btn-md" data-toggle="tooltip" title="Edit" disabled>
                            <i class="fas fa-arrow-alt-circle-down"></i>
                          </button>
                        @else
                          <a href=" {{ route('DownloadFile.journal', ['id' => $value->id, 'files' => $value->files]) }} ">
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
                          <a href=" {{ route('journal.edit', ['id' => $value->id, 'pro_id' => $value->pro_id]) }} ">
                            <button type="button" class="btn btn-warning btn-md" data-toggle="tooltip" title="Edit">
                              <i class="fas fa-edit"></i>
                            </button>
                          </a>
                        @endif


                      @if(Auth::hasRole('manager'))
                          @if($value->verified == "ตรวจสอบแล้ว")
                          <a href=" {{ route('journal.unverified', $value->id) }} ">
                            <button type="button" class="btn btn-secondary btn-md" data-toggle="tooltip" title="Verfied">
                              <i class="fas fa-user-check"></i>
                            </button>
                          </a>
                          @else
                            <a href=" {{ route('journal.verified', $value->id) }} ">
                              <button type="button" class="btn btn-md" data-toggle="tooltip" title="Verfied" style="background-color: #567fa8;">
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
    <!-- END TABLE -> JOURNAL PROJECT -------------------------------------------------->

      </div>
  </section>
@stop('contents')



@section('js-custom-script')

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- <script src="{{-- asset('bower_components/admin-lte/plugins/sweetalert2/sweetalert2.min.js') --}}"></script> -->

  <!-- INSERT -->
  @if(Session::get('message'))
   <?php Session::forget('message'); ?>
    <script>
      Swal.fire({
          icon: 'success',
          title: 'บันทึกข้อมูลเรียบร้อยแล้ว',
          showConfirmButton: false,
          timer: 2500
      })
    </script>
  @endif

  <!-- VERIFIED -->
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

  <!-- Un VERIFIED -->
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


<!-- DatePicker YEAR -->
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
<!-- END DatePicker YEAR -->



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

<!-- <script>
  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
  });
</script> -->
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
