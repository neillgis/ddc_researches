@extends('layout.main')


@section('css-custom')
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
            <li class="breadcrumb-item active"> แก้ไขข้อมูลโครงการวิจัย </li>
          </ol>
        </div>
      </div>
    </div>
  </div>
<!-- /.content-header -->

  <section class="content">
    <div class="container">

    <!-- START EDIT RESEARCH PROJECT ----------------->
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card shadow" style="background-color: #ff851b;">
              <div class="card-header">
                <h5><b> แก้ไข (ข้อมูลโครงการวิจัย) </b></h5>
              </div>
            </div>

            <!-- <form role="form"> -->
            <form action="{{ route('research.save') }}" method="POST" enctype="multipart/form-data" onsubmit="disableButton()">
              @csrf

              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="exampleInput1"> ชื่อโครงการ (TH) </label>
                      <input type="text" class="form-control" name="pro_name_th" value="{{ $data->pro_name_th }}">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="exampleInput1"> ชื่อโครงการ (ENG) </label>
                      <!-- HIDDEN ID -->
                      <input type="hidden" class="form-control" name="id" value="{{ $data->id }}">

                      <input type="text" class="form-control" name="pro_name_en" value="{{ $data->pro_name_en }}">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleSelect1"> ตำแหน่งในโครงการวิจัย </label>
                        <select class="form-control" name="pro_position">
                          @foreach ($data2 as $key => $value)
                            <option value="{{ $key }}"
                            {{ $data->pro_position == $key ? 'selected' : '' }}> {{ $value }}
                            </option>
                          @endforeach
                        </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleSelect1"> จำนวนผู้ร่วมวิจัย </label>
                        <select class="form-control" name="pro_co_researcher">
                          @foreach ($data3 as $key => $value)
                            <option value="{{ $key }}"
                            {{ $data->pro_co_researcher == $key ? 'selected' : '' }}> {{ $value }} </option>
                          @endforeach
                        </select>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleDatepicker1"> ปี พ.ศ. ที่เริ่มโครงการ </label>
                      <input type="text" class="form-control" id="datepicker1" placeholder="กรุณาเลือก ปี/เดือน/วัน"
                             name="pro_start_date" autocomplete="off" value="{{ $data->pro_start_date }}" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleDatepicker1"> ปี พ.ศ. ที่เสร็จสิ้นโครงการ </label>
                      <input type="text" class="form-control" id="datepicker2" placeholder="กรุณาเลือก ปี/เดือน/วัน"
                             name="pro_end_date" autocomplete="off" value="{{ $data->pro_end_date }}" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleSelect1"> โครงการได้ตีพิมพ์ </label>
                        <select class="form-control" name="publish_status">
                          @foreach ($data4 as $key => $value)
                            <option value="{{ $key }}" {{ $data->publish_status == $key ? 'selected' : '' }}> {{ $value }} </option>
                          @endforeach
                        </select>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="exampleInput1"> URL ที่อยู่ออนไลน์ของรายงานวิจัยฉบับสมบูรณ์ (ถ้ามี) </label>
                      <input type="text" class="form-control" name="url_research" value="{{ $data->url_research }}">
                    </div>
                  </div>
                </div>

              </div> <!-- END Card-body -->

          </div> <!-- END Card -->


          <div class="card">
            <div class="card-body">

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label><font color="red"> อัพโหลดไฟล์ **</font></label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="files">
                        <label class="custom-file-label"> Upload File ขนาดไม่เกิน 20 MB </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div> <!-- END Row -->

            </div> <!-- END Card-body -->

              <div class="card-footer">
                <a class="btn btn-secondary float-left" href="{{ route('page.research') }}">
                  <i class="fas fa-arrow-alt-circle-left"></i>
                    ย้อนกลับ
                </a>

                <button type="submit" class="btn btn-success float-right" value="แก้ไขข้อมูล" id="btn_disabled">
                  <i class="fas fa-save"></i>
                    &nbsp;แก้ไขข้อมูล
                </button>

              </div>
            </form>

          </div> <!-- END Card -->


        </div>
      </div>
      <!-- END EDIT RESEARCH PROJECT -------------------------------------------------->

    </div>
</section>
@stop('contents')



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

<!-- FILE INPUT -->
<script type="text/javascript">
  $(document).ready(function () {
    bsCustomFileInput.init();
  });

  //OnSubmit Disable Button
    function disableButton() {
        var btn = document.getElementById('btn_disabled');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Loading...'
    }
</script>


<!-- DatePicker Style -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<script>
  var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    $('#datepicker1').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy/mm/dd',
        maxDate: today,
        autoclose: true,
        todayHighlight: true
    });
</script>
<script>
    $('#datepicker2').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy/mm/dd',
        maxDate: today,
        autoclose: true,
        todayHighlight: true
    });
</script>
<!-- END DatePicker Style -->

@stop('js-custom-script')
