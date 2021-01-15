@extends('layout.main')


@section('css-custom')
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- DatePicker Style -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css">

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
          <div class="card card-success shadow">
            <div class="card-header">
              <h3 class="card-title"><b> แก้ไขข้อมูลโครงการวิจัย </b></h3>
            </div>

            <!-- <form role="form"> -->
            <form action="{{ route('journal.save') }}" method="POST">
              @csrf

              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInput1"> ชื่อบทความ (ENG) </label>
                      <input type="text" class="form-control" name="article_name_en" value="{{ $data->article_name_en }}">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInput1"> ชื่อบทความ (TH) </label>
                      <input type="text" class="form-control" name="article_name_th" value="{{ $data->article_name_th }}">
                    </div>
                  </div>
                </div>


                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInput1"> ชื่อวารสาร (ENG) </label>
                      <input type="text" class="form-control" name="journal_name_en" value="{{ $data->journal_name_en }}">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInput1"> ชื่อวารสาร (TH) </label>
                      <input type="text" class="form-control" name="journal_name_th" value="{{ $data->journal_name_th }}">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="exampleDatepicker1"> ปีที่พิมพ์ (year) </label>
                      <input type="text" class="form-control" name="publish_years" value="{{ $data->publish_years }}">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="exampleDatepicker1"> ฉบับที่ (issue) </label>
                      <input type="text" class="form-control" name="publish_no" value="{{ $data->publish_no }}">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="exampleDatepicker1"> เล่มที่ (volume) </label>
                      <input type="text" class="form-control" name="publish_volume" value="{{ $data->publish_volume }}">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="exampleDatepicker1"> หน้า (no) </label>
                      <input type="text" class="form-control" name="publish_page" value="{{ $data->publish_page }}">
                    </div>
                  </div>
                </div>


                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="exampleInput1"> เลข DOI </label>
                      <input type="text" class="form-control" name="doi_number" value="{{ $data->doi_number }}">
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="exampleSelect1"> การมีส่วนร่วมในบทความ </label>
                      <input type="text" class="form-control" name="contribute" value="{{ $data->contribute }}">
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="exampleSelect1"> ท่านเป็นผู้รับผิดชอบบทความ </label>
                      <input type="text" class="form-control" name="corres" value="{{ $data->corres }}">
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="exampleSelect1"> บทความที่เป็นผลจากโครงการวิจัย </label>
                      <input type="text" class="form-control" name="result_pro_id" value="{{ $data->pro_name_en }}">
                    </div>
                  </div>
                </div>

              </div>
            </div>


            <div class="card-footer">
                <button type="button" class="btn bg-gradient-red" onclick="window.history.back();">
                  <i class="fas fa-arrow-alt-circle-left"></i>
                  ย้อนกลับ
                </button>

              <button type="submit" class="btn btn-success float-right" value="บันทึกข้อมูล">
                <i class="fas fa-save"></i> &nbsp;บันทึกข้อมูล </button>
            </div>

          </form>
          <br>

            <!-- Alert Notification -->
              @if(session()->has('success'))
                <div class="alert alert-success">
                  {{ session()->get('success') }}
                </div>
              @endif
              @if (Session::has('failure'))
                <div class="alert alert-danger">
                   {{ Session::get('failure') }}
                </div>
              @endif
            <!-- END Alert Notification -->

          </div>
        </div>
      </div>
      <!-- END EDIT RESEARCH PROJECT -------------------------------------------------->

    </div>
</section>
@stop('contents')



@section('js-custom-script')

<!-- START DatePicker Style -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>

<script>
    $('#datepicker1').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yy/mm/dd',
        autoclose: true,
        todayHighlight: true
    });
</script>

<script>
    $('#datepicker2').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yy/mm/dd',
        autoclose: true,
        todayHighlight: true
    });
</script>
<!-- END DatePicker Style -->

@stop('js-custom-script')
