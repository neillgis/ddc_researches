@extends('layout.main')

@section('css-custom')

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

  <style>
      #rcorners3 {
        border-radius: 20px;
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
            <li class="breadcrumb-item active"> ข้อมูลบุคคล / นักวิจัย </li>
          </ol>
        </div>
      </div>
    </div>
  </div>
<!-- /.content-header -->


<!-- Main content -->
<section class="content">
  <div class="container">

    <div class="row">
      <div class="col-md-5">
        <div class="card shadow" id="rcorners3">
          <div class="card-header" style="background-color: #FFD800;">
            <h4><i class="fas fa-user-alt"></i>&nbsp; <b>ข้อมูลส่วนบุคคล</b> </h4>
          </div>

          <form method="POST" action="{{ route('profile.insert') }}">
            @csrf

            <div class="card-body">
              <h5 class="profile text-right" id="prefix"></h5>
              <input type="hidden" class="form-control" name="title" id="k_prefix"> <!-- id="k_prefix" from JQuery below Declare เรียกข้อมูลเพื่อนำไป INSERT -->


              <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <h4> ชื่อ <b><a class="float-right" id="fname_th"></b></a></h4>
                    <input type="hidden" class="form-control" name="fname" id="k_fname_th">
                  </li>

                  <li class="list-group-item">
                    <h4> นามสกุล <b><a class="float-right" id="lname_th"></b></a></h4>
                    <input type="hidden" class="form-control" name="lname" id="k_lname_th">
                  </li>

                  <li class="list-group-item">
                    <h4> เลขบัตรประชาชน <b><a class="float-right" id="cid"></b></a></h4>
                    <input type="hidden" class="form-control" name="idCard" id="k_cid">
                  </li>
                </ul>

              <div class="row">
                <div class="col-md-12">
                  <label> เพศ </label>
                  <div class="border p-2" id="gender" style="background-color: #e9ecef;opacity: 1; font-size: 20px;"></div>
                  <input type="hidden" class="form-control" name="sex" id="k_gender">
                </div>
              </div>
              <br>

              <div class="row">
                <div class="col-md-12">
                  <label> E - Mail </label>
                  <div class="border p-2" id="email" style="background-color: #e9ecef;opacity: 1; font-size: 20px;"></div>
                  <input type="hidden" class="form-control" name="email" id="k_email">
                </div>
              </div>
              <br>

              <div class="row">
                <div class="col-md-12">
                  <label> ระดับการศึกษา </label>
                  <div class="border p-2" id="edu_class" style="background-color: #e9ecef;opacity: 1; font-size: 20px;"></div>
                  <input type="hidden" class="form-control" name="educationLevel" id="k_edu_class">
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="col-md-7">
          <div class="card shadow card-success" id="rcorners3">
            <div class="card-header" style="background-color: #587498;">
              <h4><i class="fas fa-hotel"></i>&nbsp; <b>หน่วยงาน / สังกัด</b> </h4>
          </div>

          <div class="card-body">
            <div class="col-md-12">
              <label for="exampleInput1"> หน่วยงาน </label>
              <div class="border p-2" id="dept_id" style="background-color: #e9ecef;opacity: 1; font-size: 20px;"></div>
              <input type="hidden" class="form-control" name="deptName" id="k_dept_id">
            </div>
            <br>

            <div class="col-md-12">
              <label for="exampleInput1"> ตำแหน่ง </label>
              <div class="border p-2" id="position" style="background-color: #e9ecef;opacity: 1; font-size: 20px;"></div>
              <input type="hidden" class="form-control" name="position" id="k_position">
            </div>
            <br>

            <div class="col-md-12">
              <label for="exampleInput1"> ระดับตำแหน่ง </label>
              <div class="border p-2" id="positionLevel" style="background-color: #e9ecef;opacity: 1; font-size: 20px;"></div>
              <input type="hidden" class="form-control" name="positionLevel" id="k_positionLevel">
            </div>
          </div>
        </div>


        <div class="card shadow card-danger" id="rcorners3">
          <div class="card-header" style="background-color: #E86850;">
            <h4><i class="fas fa-id-card-alt"></i>&nbsp; <b>ข้อมูลนักวิจัย</b> </h4>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <input type="text" class="form-control" name="nriis_id" placeholder="กรุณากรอก รหัสนักวิจัย (NRIIS ID) ถ้ามี" value="{{ $value->nriis_id }}">
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <input type="text" class="form-control" name="orcid_id" placeholder="กรุณากรอก บัตรประจำตัวนักวิจัย (ORCID ID) ถ้ามี" value="{{ $value->orcid_id }}">
              </div>
            </div>
          </div>

          <div class="card-footer">
            <button type="submit" class="btn btn-danger float-right" value="บันทึกข้อมูล">
              <i class="fas fa-save"></i> &nbsp;บันทึกข้อมูล </button>
          </div>

        </div>
      </div>
    </div>


    </form>
    </div>
  </div>
</section>
@stop('contents')


@section('js-custom-script')
<!-- SweetAlert2 -->
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> -->
<script src="{{ asset('bower_components/admin-lte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

  <!-- INSERT success -->
    @if(Session::get('messages'))
     <?php Session::forget('messages'); ?>
      <script>
        Swal.fire({
            icon: 'success',
            title: 'อัพเดทข้อมูลของท่านเรียบร้อย',
            showConfirmButton: true,
            confirmButtonColor: '#2C6700',
            timer: 2300
        })
      </script>
    @endif

@stop('js-custom-script')


@section('js-custom')
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "https://hr.ddc.moph.go.th/api/v2/employee/{{ Auth::user()->preferred_username }}",
                type: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": "bearer {{ KeycloakWeb::retrieveToken()['access_token'] }}"
                },
                success: function(result) {
                    //console.log(result)

                    $("#employee_id").text(result.employeeId);
                    $("#cid").text(result.idCard);
                    $("#k_cid").val(result.idCard);
                    $("#dept_id").text(result.deptName);
                    $("#k_dept_id").val(result.deptName);
                    $("#edu_class").text(result.educationLevel);
                    $("#k_edu_class").val(result.educationLevel);
                    $("#prefix").text(result.title);
                    $("#k_prefix").val(result.title);
                    $("#fname_th").text(result.fname);
                    $("#k_fname_th").val(result.fname);
                    $("#lname_th").text(result.lname);
                    $("#k_lname_th").val(result.lname);
                    $("#fname_en").text(result.efname);
                    $("#lname_en").text(result.elname);
                    $("#gender").text(result.sex);
                    $("#k_gender").val(result.sex);
                    $("#birthdate").text(result.birthday);
                    $("#position").text(result.position);
                    $("#k_position").val(result.position);
                    $("#tel").text(result.telephone);
                    $("#email").text(result.email);
                    $("#k_email").val(result.email);
                    $("#positionLevel").text(result.positionLevel);
                    $("#k_positionLevel").val(result.positionLevel);
                }
            });

            $.ajax({
                url: "https://hr.ddc.moph.go.th/api/v2/employee/pic/{{ Auth::user()->preferred_username }}",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": "bearer {{ KeycloakWeb::retrieveToken()['access_token'] }}"
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success (data) {
                    const url = window.URL || window.webkitURL;
                    const src = url.createObjectURL(data);
                    $('#image').attr('src', src);
                }
            });
        });

    </script>
@stop('js-custom')
