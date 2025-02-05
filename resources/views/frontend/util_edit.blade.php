@extends('layout.main')

@section('css-custom')
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

  <!-- Fonts Style : Kanit -->
  <style>
    body {
      font-family: 'Kanit', sans-serif;
    }
    h1 {
      font-family: 'Kanit', sans-serif;
    }
  </style>

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
            <li class="breadcrumb-item active"> แก้ไขการนำไปใช้ประโยชน์ </li>
          </ol>
        </div>
      </div>
    </div>
  </div>
<!-- /.content-header -->

  <section class="content">
    <div class="container">

<!-- START EDIT SUMMARY -------------------------------------------------->
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card shadow" style="background-color: #ff851b;">
              <div class="card-header">
                <h5><b> แก้ไข (การนำไปใช้ประโยชน์) </b></h5>
              </div>
            </div>

            <form action="{{ route('util.save') }}" method="POST" enctype="multipart/form-data" onsubmit="disableButton()">
              @csrf

              <div class="card-body">
                <div class="row">
                  <div class="col-md-11 mx-auto">
                    <div class="form-group">
                      <label for="exampleSelect1"> ชื่อ-สกุล (นักวิจัย) </label>
                      <input type="text" class="form-control" name="users_name" value="{{ $edit_data->users_name }}" readonly>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-11 mx-auto">
                    <div class="form-group">
                      <label for="exampleSelect1"> ชื่อโครงการ (TH-ENG) </label>
                      <input type="hidden" class="form-control" name="id" value="{{ $edit_data->id }}">
                      <input type="text" class="form-control" name="project_fullname" value="{{ $edit_data->pro_name_th." ".$edit_data->pro_name_en }}" readonly>
                    </div>
                  </div>
                </div>

                <div class="row">
                    <div class="col-md-11 mx-auto">
                        <div class="form-group">
                            <label for="exampleSelect1"> ปีที่ใช้ประโยชน์ </label>
                              <!-- Query Array เพื่อมา UPDATE users -->
                              <select class="form-control" name="util_year">
                                @foreach ($edit_util_year as $key => $value)
                                  <option value="{{ $value }}" {{ $edit_util->util_year + 543 == $value ? 'selected' : '' }}> {{ $value }}
                                  </option>
                                @endforeach
                              </select>
                          </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-md-11 mx-auto">
                    <div class="form-group">
                      <label for="exampleSelect1"> ประเภทการนำไปใช้ประโยชน์ </label>
                        <!-- Query Array เพื่อมา UPDATE users -->
                        <select class="form-control" name="util_type">
                          @foreach ($edit_utiltype as $key => $value)
                            <option value="{{ $key }}" {{ $edit_util->util_type == $key ? 'selected' : '' }}> {{ $value }}
                            </option>
                          @endforeach
                        </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-11 mx-auto">
                    <div class="form-group">
                      <label for="exampleInput1"> คำอธิบายการนำไปใช้ประโยชน์ </label>
                      <textarea class="form-control" name="util_descrip" rows="3" cols="30">{{ $edit_util->util_descrip }}</textarea>
                    </div>
                  </div>
                </div>
              </div> <!-- END Card-body -->
          </div> <!-- END Card -->



          <div class="card">
            <div class="card-body">

              <div class="row">
                <div class="col-md-11 mx-auto">
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
                <a class="btn btn-secondary float-left" href="{{ route('page.util') }}">
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
<!-- END EDIT SUMMARY ------------------------------------------------------------->

    </div>
</section>
@stop('contents')


@section('js-custom-script')
<script>
  //FILE INPUT
  $(document).ready(function () {
    bsCustomFileInput.init();
  });
</script>
@stop('js-custom-script')
