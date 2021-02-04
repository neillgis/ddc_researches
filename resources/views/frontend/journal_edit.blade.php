@extends('layout.main')


@section('css-custom')
<!-- <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css"> -->

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
            <li class="breadcrumb-item active"> แก้ไขข้อมูลการตีพิมพ์วารสาร </li>
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
            <div class="card shadow" style="background-color: #ff851b;">
              <div class="card-header">
                <h5><b> แก้ไข (ข้อมูลการตีพิมพ์วารสาร) </b></h5>
              </div>
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
                      <!-- hidden = id -->
                      <input type="hidden" class="form-control" name="id" value="{{ $data->id }}">
                      <!-- hidden = pro_id -->
                      <input type="hidden" class="form-control" name="pro_id" value="{{ $data->pro_id }}">
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
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleDatepicker1"> ปีที่พิมพ์ (Year) </label>
                      <input type="text" class="form-control" name="publish_years" value="{{ $data->publish_years }}">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="exampleDatepicker1"> ฉบับที่ (Issue) </label>
                      <input type="text" class="form-control" name="publish_no" value="{{ $data->publish_no }}">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="exampleDatepicker1"> เล่มที่ (Volume) </label>
                      <input type="text" class="form-control" name="publish_volume" value="{{ $data->publish_volume }}">
                    </div>
                  </div>

                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="exampleInput1"> หน้าแรก (First Page) </label>
                      <input type="text" class="form-control" name="publish_firstpage" value="{{ $data->publish_firstpage }}" maxlength="3">
                    </div>
                  </div>

                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="exampleInput1"> หน้าสุดท้าย (Last Page) </label>
                      <input type="text" class="form-control" name="publish_firstpage" value="{{ $data->publish_lastpage }}" maxlength="3">
                    </div>
                  </div>

                </div>


                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInput1"> เลข DOI (ถ้ามี) </label>
                      <input type="text" class="form-control" name="doi_number" value="{{ $data->doi_number }}">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleSelect1"> การมีส่วนร่วมในบทความ </label>
                      <!-- <input type="text" class="form-control" name="contribute" value="{{-- $data->contribute --}}"> -->

                      <select class="form-control" name="contribute">
                        @foreach ($datay as $key => $value)
                          <option value="{{ $key }}" {{ $data->contribute == $key ? 'selected' : '' }}> {{ $value }} </option>
                        @endforeach
                      </select>

                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleSelect1"> ท่านเป็นผู้รับผิดชอบบทความ (Correspondence) </label>
                      <select class="form-control" name="corres">
                        @foreach ($dataz as $key => $value)
                          <option value="{{ $key }}" {{ $data->corres == $key ? 'selected' : '' }}> {{ $value }} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="exampleSelect1"> บทความนี้เป็นผลจากโครงการวิจัย </label>
                        <input type="text" class="form-control" name="pro_id" value="{{ $data->pro_name_en }}" disabled>
                      </div>
                    </div>
                </div>

                <div class="row" >
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="exampleInput1"> URL ที่อยู่ออนไลน์ของบทความ (ถ้ามี) </label>
                      <input type="text" class="form-control" name="url_journal" value="{{ $data->url_journal }}">
                    </div>
                  </div>
                </div>
              </div>


            <div class="card-footer">
              <a class="btn btn-danger float-left" href="{{ route('page.journal') }}">
                <i class="fas fa-arrow-alt-circle-left"></i>
                  ย้อนกลับ
              </a>

            <!-- {{-- @if(Auth::hasRole('manager') || Auth::hasRole('user')) --}} -->
              <button type="submit" class="btn btn-success float-right" value="บันทึกข้อมูล">
                <i class="fas fa-save"></i> &nbsp;บันทึกข้อมูล
              </button>
            <!-- {{-- @endif --}} -->

            </div>
          </form>
        </div>
      </div>
    </div>

    <!--- END EDIT  --->

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
