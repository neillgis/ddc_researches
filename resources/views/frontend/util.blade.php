@extends('layout.main')


@section('css-custom')
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!-- <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="http://www.datatables.net/rss.xml"> -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">


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
                    <h3> {{ empty($Total_util)?'0': $Total_util }} โครงการ </h3>
                    <br>
                    <p> โครงการที่นำไปใช้ประโยชน์ทั้งหมด </p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-share-square"> </i>
                  </div>
                </div>
              </div>

              <div class="col-md-3 mx-auto">
                <div class="small-box bg-green">
                  <div class="inner">
                    <!-- เรียกจาก db_utilization -> โดย count id -> util_type = เชิงนโยบาย --------->
                    <h3> {{ empty($Total_policy_util)?'0': $Total_policy_util }} โครงการ </h3>
                    <br>
                    <p> เชิงนโยบาย </p>
                  </div>
                  <div class="icon">
                    <i class="ion fas fa-chalkboard-teacher"></i>
                  </div>
                    <a class="one small-box-footer" href="#" id="modal">
                      คำอธิบายรายละเอียด
                      <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
              </div>


              <div class="col-md-3 mx-auto">
                <div class="small-box bg-green">
                  <div class="inner">
                    <!-- เรียกจาก db_utilization -> โดย count id -> util_type = เชิงวิชาการ --------->
                    <h3> {{ empty($Total_academic_util)?'0': $Total_academic_util }} โครงการ </h3>
                    <br>
                    <p> เชิงวิชาการ </p>
                  </div>
                  <div class="icon">
                    <i class="fa fa-university"></i>
                  </div>
                    <a class="two small-box-footer" href="#" id="modal">
                      คำอธิบายรายละเอียด
                      <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
              </div>

              <div class="col-md-3 mx-auto">
                <div class="small-box bg-green">
                  <div class="inner">
                    <!-- เรียกจาก db_utilization -> โดย count id -> util_type = เชิงสังคม/ชุมชน --------->
                    <h3> {{ empty($Total_social_util)?'0': $Total_social_util }} โครงการ </h3>
                    <br>
                    <p> เชิงสังคม/ชุมชน </p>
                  </div>
                  <div class="icon">
                    <i class="ion fas fa-users"></i>
                  </div>
                    <a class="three small-box-footer" href="#" id="modal">
                      คำอธิบายรายละเอียด
                      <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
              </div>

              <div class="col-md-3 mx-auto">
                <div class="small-box bg-green">
                  <div class="inner">
                    <!-- เรียกจาก db_utilization -> โดย count id -> util_type = เชิงพาณิชย์ --------->
                    <h3> {{ empty($Total_commercial_util)?'0': $Total_commercial_util }} โครงการ </h3>
                    <br>
                    <p> เชิงพาณิชย์ </p>
                  </div>
                  <div class="icon">
                    <i class="ion fas fa-donate"></i>
                  </div>
                    <a class="four small-box-footer" href="#" id="modal">
                      คำอธิบายรายละเอียด
                      <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
              </div>
            </div>
            <br>
<!-- END CONTENT  BOX --------------------------------------------------------->

<!-- START FORM  INSERT ------------------------------------------------------->
      <!-- {{-- @if(Auth::hasRole('user')) --}} -->
          <div class="row">
            <div class="col-md-12 mx-auto">
              <div class="card">
               <div class="card shadow" style="background-color: #ff851b;">
                <div class="card-header">
                  <h5 class="card-title"><b> เพิ่มข้อมูลการนำไปใช้ประโยชน์ </b></h5>
                </div>
              </div>

                <form method="POST" action="{{ route('util.insert') }}" enctype="multipart/form-data">
                  @csrf

              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <b><lebel for="exampleSelect1"> ชื่อโครงการ (TH-ENG) <font color="red"> * </font></lebel></b>
                      <!-- SELECT ดึงข้อมูลชื่อโครงการมาจาก -> db_research_project Table -->
                      <select class="form-control" name="pro_id" required>
                          <option value="" disabled="true" selected="true"> กรุณาเลือก </option>
                        @foreach ($form_research as $value)
                          <option value = "{{ $value->id }}"> {{ $value->pro_name_th." ".$value->pro_name_en }} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <b><lebel for="util_type"> ประเภทการนำไปใช้ประโยชน์ <font color="red"> * </font></lebel></b>
                      <select class="form-control" name="util_type" required>
                        <option value="" disabled="true" selected="true" > กรุณาเลือก </option>
                        @foreach ($form_util_type as $key => $value)
                          <option value="{{ $value }}"> {{ $value }} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="exampleInput1"> คำอธิบายการนำไปใช้ประโยชน์ </label>
                      <textarea class="form-control" name="util_descrip" rows="3" cols="30" placeholder="ข้อความไม่เกิน 200 ตัวอักษร"></textarea>
                    </div>
                  </div>
                </div>

                <div class="row" >
                  <div class="col-md-12">
                    <b><lebel for="expInputFile"> อัพโหลดไฟล์ : การนำไปใช้ประโยชน์.pdf <font color="red"> * </font></lebel></b>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="files" required>
                        <label class="custom-file-label" for="expInputFile"> Upload File ขนาดไม่เกิน 20 MB </label>
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
      <!-- {{-- @endif --}} -->
<!-- END FORM  INSERT --------------------------------------------------------->

<!-- START TABLE LIST --------------------------------------------------------->
          <section class="content">
            <div class="card">
              <div class="card card-gray">
                <div class="card-header">
                  <h5 class="card-title"><b> โครงการที่นำไปใช้ประโยชน์ </b></h5>
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
                            <th class="text-center">การตรวจสอบ</th>
                            <th class="text-right"> จัดการข้อมูล </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($table_util as $value)
                        <tr>
                          <td class="text-center"> {{ $value->id }} </td>
                          <td class="text-left"> {{ $value->pro_name_th." ".$value->pro_name_en }} </td>
                          <td class="text-center"> {{ $value->util_type }} </td>

                          <td class="text-center">
                            @if($value->verified == "ตรวจสอบแล้ว")
                              <span class="badge bg-secondary badge-pill"> {{ $value->verified }} </span> <!-- null = รอการตรวจสอบ -->
                            @else
                              <span class="badge bg-danger badge-pill"> {{ $value->verified }} </span> <!--  2 = ไม่อนุมัติ -->
                            @endif
                          </td>

                          <!-- จัดการข้อมูล -->
                          <td class="td-actions text-right text-nowrap" href="#">
                            <!-- {{-- @if(Auth::hasRole('manager') || Auth::hasRole('user')) --}} -->
                            @if($value->verified == "ตรวจสอบแล้ว")
                              <button type="button" class="btn btn-secondary btn-md" data-toggle="tooltip" title="Download" disabled>
                                <i class="fas fa-arrow-alt-circle-down"></i>
                              </button>
                            @else
                            <a href=" {{ route('DownloadFile.util', ['id' => $value->id, 'files' => $value->files]) }} ">
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
                            <a href=" {{ route('util.edit', $value->id) }} ">
                              <button type="button" class="btn btn-warning btn-md" data-toggle="tooltip" title="Edit">
                                <i class="fas fa-edit"></i>
                              </button>
                            </a>
                            @endif

                            <!-- {{-- @endif --}} -->

                            <!-- FOR Admin ONLY -->
                            <!-- {{-- @if(Auth::hasRole('admin')) --}}
                            <a href=" {{ route('util.edit', $value->id) }} ">
                              <button type="button" class="btn btn-warning btn-md" data-toggle="tooltip" title="Views">
                                <i class="fas fa-eye"></i>
                              </button>
                            </a>
                            {{-- @endif --}} -->

                            @if(Auth::hasRole('manager'))
                                @if($value->verified == "ตรวจสอบแล้ว")
                                <button type="button" class="btn btn-secondary btn-md" data-toggle="tooltip" title="Verfied" disabled>
                                  <i class="fas fa-user-check"></i>
                                </button>
                                @else
                                <a href=" {{ route('util.verified', $value->id) }} ">
                                  <button type="button" class="btn btn-md"
                                          data-toggle="tooltip" title="Verfied" style="background-color: #336699;">
                                    <i class="fas fa-user-check"></i>
                                  </button>
                                </a>
                            @endif
                          @endif
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

<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> -->
<script src="{{ asset('bower_components/admin-lte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

<script type="text/javascript">
  document.querySelector(".one").addEventListener('click', function(){
    Swal.fire("การนำไปใช้ประโยชน์เชิงนโยบาย",
    "มิตินโยบาย หมายถึง การนำข้อมูลผลงานวิจัย มาใช้ประกอบการตัดสินใจเชิงนโยบาย หรือ เป็นแนวทางในการแก้ไขประเด็นพัฒนาสำคัญและปัญหาเร่งด่วน ในเชิงนโยบายระดับประเทศ ระดับภูมิภาค ระดับจังหวัดระดับท้องถิ่นหรือระดับหน่วยงาน"
    );
  });
</script>

<script type="text/javascript">
  document.querySelector(".two").addEventListener('click', function(){
    Swal.fire("มิติเชิงวิชาการ",
    "มิติวิชาการ หมายถึง การถูกอ้างอิง (citation) บทความวิจัยซึ่งได้รับการตีพิมพ์ในวารสารวิชาการระดับนานาชาติ ซึ่งมี peer review"
    );
  });
</script>

<script type="text/javascript">
  document.querySelector(".three").addEventListener('click', function(){
    Swal.fire("มิติเชิงสังคม/ชุมชน",
    "มิติเชิงสังคม/ชุมชน หมายถึง การถ่ายทอดความรู้ให้ชุมชน ท้องถิ่น องค์กร (ซึ่งมิใช่หน่วยงานต้นสังกัดของนักวิจัย/หน่วยงานให้ทุน) หรือการจัดกิจกรรม ที่แสดงให้เห็นถึงการใช้ประโยชน์และสามารถแสดงผลการเปลี่ยนแปลงที่เกิดขึ้นต่อชุมชน ท้องถิ่นหรือองค์กร"
    );
  });
</script>

<script type="text/javascript">
  document.querySelector(".four").addEventListener('click', function(){
    Swal.fire("มิติเชิงพาณิชย์",
    "มิติเชิงพาณิชย์ หมายถึง การนำผลงานวิจัยไปพัฒนาหรือปรับปรุงกระบวนการ หรือผลิตและจำหน่าย ในภาคการผลิตและอุตสาหกรรม"
    );
  });
</script>


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
<!-- END ALERT บันทึกข้อมูลสำเร็จ  -->


<!-- FILE INPUT -->
<script type="text/javascript">
  $(document).ready(function () {
    bsCustomFileInput.init();
  });
</script>
<!-- END FILE INPUT -->


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
