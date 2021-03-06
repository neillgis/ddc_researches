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
            <li class="breadcrumb-item active"> แก้ไข (สรุปข้อมูลนักวิจัย) </li>
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
                <h5><b> แก้ไข (สรุปข้อมูลนักวิจัย) </b></h5>
              </div>
            </div>

            <!-- <form role="form"> -->
            <form action="{{ route('summary.save') }}" method="POST">
              @csrf

              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 mx-auto">
                    <div class="form-group">
                      <label for="exampleSelect1"> ชื่อ-นามสกุล </label>

                      <input type="text" class="form-control" name="users_name" value="{{ $edit_users->users_name }}" readonly>
                    </div>
                  </div>
                </div>

                <!-- <div class="row">
                  <div class="col-md-6 mx-auto">
                    <div class="form-group">
                      <label for="exampleSelect1"> หน่วยงาน </label>
                      <input type="text" class="form-control" name="depart_name" value="{{-- $edit_depart->depart_name --}}" readonly>
                    </div>
                  </div>
                </div> -->

                <div class="row">
                  <div class="col-md-6 mx-auto">
                    <div class="form-group">
                      <label for="exampleSelect1"> ระดับนักวิจัย </label>

                      <!-- Query Array เพื่อมา UPDATE users -->
                      <select class="form-control" name="researcher_level">
                        <option value="" disabled="true" selected="true" >กรุณาเลือก</option>
                        @foreach ($edit_lev as $key => $value)
                          <option value="{{ $key }}"
                          {{$edit_users->researcher_level == $key ? 'selected' : '' }}> {{ $value }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mx-auto">
                    <div class="form-group">
                      <!-- แสดงชื่อผู้ตรวจสอบ (ให้ระดับนักวิจัย) -->
                      <label for="exampleSelect1"> ผู้ตรวจสอบ (ให้ระดับนักวิจัย) </label>

                      <!-- Query Array เพื่อมา UPDATE users -->
                      <!-- <select class="form-control" name="">
                        @foreach ($edit_lev as $key => $value)
                          <option value="{{ $key }}"
                          {{$edit_users->researcher_level == $key ? 'selected' : '' }}> {{ $value }}
                          </option>
                        @endforeach
                      </select> -->
                    </div>
                  </div>
                </div>


              </div>

              <div class="card-footer">
                <a class="btn btn-danger float-left" href="{{ route('page.summary') }}">
                  <i class="fas fa-arrow-alt-circle-left"></i>
                    ย้อนกลับ
                </a>

                @if (Gate::allows('keycloak-web', ['manager']))
                  <button type="submit" class="btn btn-success float-right" value="บันทึกข้อมูล">
                    <i class="fas fa-save"></i>
                      &nbsp;บันทึกข้อมูล
                  </button>
                @endif

              </div>
            </form>

          </div>
        </div>
      </div>
<!-- END EDIT SUMMARY ------------------------------------------------------------->

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



@stop('js-custom-script')
