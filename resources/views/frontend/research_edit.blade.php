@extends('layout.main')


@section('css-custom')
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

    <!-- START EDIT RESEARCH PROJECT -------------------------------------------------->
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card card-warning shadow">
              <div class="card-header">
                <h5><b> แก้ไขข้อมูลโครงการวิจัย </b></h5>
              </div>
            </div>

            <!-- <form role="form"> -->
            <form action="{{ route('research.save') }}" method="POST">
              @csrf

              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInput1"> ชื่อโครงการ (ENG) </label>
                      <!-- hidden = id -->
                      <input type="hidden" class="form-control" name="id" value="{{ $data->id }}">

                      <input type="text" class="form-control" name="pro_name_en" value="{{ $data->pro_name_en }}">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInput1"> ชื่อโครงการ (TH) </label>
                      <input type="text" class="form-control" name="pro_name_th" value="{{ $data->pro_name_th }}">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleSelect1"> ตำแหน่งในโครงการวิจัย </label>
                      <!-- <input type="text" class="form-control" name="pro_position" value="{{-- $data2 [$data->pro_position] --}}"> **กรณี CONVERT Array to String** -->

                      <!-- Query มาจากฐานข้อมูล db_research_project เพื่อมา UPDATE -->
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
                      <!-- <input type="text" class="form-control" name="pro_position" value="{{-- $data2 [$data->pro_co_researcher] --}}"> **กรณี CONVERT Array to String** -->

                      <!-- Query มาจากฐานข้อมูล db_research_project เพื่อมา UPDATE -->
                      <select class="form-control" name="pro_co_researcher">
                        @foreach ($data3 as $key => $value)
                          <option value="{{ $key }}"
                          {{ $data->pro_co_researcher == $key ? 'selected' : '' }}> {{ $value }} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleDatepicker1"> ปี พ.ศ. ที่เริ่มโครงการ </label>
                      <input type="text" class="form-control" name="pro_start_date" value="{{ $data->pro_start_date }}">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleDatepicker1"> ปี พ.ศ. ที่เสร็จสิ้นครงการ </label>
                      <input type="text" class="form-control" name="pro_end_date" value="{{ $data->pro_end_date }}">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleSelect1"> โครงการได้ตีพิมพ์ </label>
                      <!-- <input type="text" class="form-control" name="pro_position" value="{{-- $data2 [$data->publish_status] --}}"> **กรณี CONVERT Array to String** -->

                      <!-- Query มาจากฐานข้อมูล db_research_project เพื่อมา UPDATE -->
                      <select class="form-control" name="publish_status">
                        @foreach ($data4 as $key => $value)
                          <option value="{{ $key }}"
                          {{ $data->publish_status == $key ? 'selected' : '' }}> {{ $value }} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
              </div>


              <div class="card-footer">
                <a class="btn btn-danger float-left" href="{{ route('page.research') }}">
                  <i class="fas fa-arrow-alt-circle-left"></i>
                    ย้อนกลับ
                </a>

                <button type="submit" class="btn btn-success float-right" value="บันทึกข้อมูล">
                  <i class="fas fa-save"></i>
                    &nbsp;บันทึกข้อมูล
                </button>
              </div>

            </form>


          </div>
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
<!-- END ALERT บันทึกข้อมูลสำเร็จ  -->


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

@stop('js-custom-script')
