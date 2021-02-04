@extends('layout.main')

@section('css-custom')

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

          <!-- <form method="POST" action="{{-- route('research.insert') --}}"> -->
            @csrf

            <div class="card-body">
              <h5 class="profile text-right" id="prefix"></h5>

              <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <h4> ชื่อ <b><a class="float-right" id="fname_th"></b></a></h4>
                  </li>

                  <li class="list-group-item">
                    <h4> นามสกุล <b><a class="float-right" id="lname_th"></b></a></h4>
                  </li>

                  <li class="list-group-item">
                    <h4> เลขบัตรประชาชน <b><a class="float-right" id="cid"></b></a></h4>
                  </li>
                </ul>

              <div class="row">
                <div class="col-md-12">
                  <label> เพศ </label>
                  <div class="border p-2" id="gender" style="background-color: #e9ecef;opacity: 1; font-size: 20px;"></div>
                </div>
              </div>
              <br>

              <div class="row">
                <div class="col-md-12">
                  <label> E - Mail </label>
                  <div class="border p-2" id="email" style="background-color: #e9ecef;opacity: 1; font-size: 20px;"></div>
                </div>
              </div>
              <br>

              <div class="row">
                <div class="col-md-12">
                  <label> ระดับการศึกษา </label>
                  <div class="border p-2" id="edu_class" style="background-color: #e9ecef;opacity: 1; font-size: 20px;"></div>
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
              </div>
              <br>

            <div class="col-md-12">
              <label for="exampleInput1"> ตำแหน่ง </label>
              <div class="border p-2" id="position" style="background-color: #e9ecef;opacity: 1; font-size: 20px;"></div>
            </div>
            <br>
          </div>
        </div>
        <br>


        <div class="card shadow card-danger" id="rcorners3">
          <div class="card-header" style="background-color: #E86850;">
            <h4><i class="fas fa-id-card-alt"></i>&nbsp; <b>ข้อมูลนักวิจัย</b> </h4>

          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <input type="text" class="form-control" placeholder="กรุณากรอก รหัสนักวิจัย (NRMS ID) ถ้ามี"
                value="">
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <input type="text" class="form-control" placeholder="กรุณากรอก บัตรประจำตัวนักวิจัย (ORCID ID) ถ้ามี"
                  value="">
              </div>
            </div>
          </div>

          <div class="card-footer">
            <button type="submit" class="btn btn-danger float-right" value="บันทึกข้อมูล">
              <i class="fas fa-save"></i> &nbsp;บันทึกข้อมูล </button>
          </div>

        </form>
        </div>
      </div>
    </div>
  </div>
</section>
@stop('contents')


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
                    $("#dept_id").text(result.deptName);
                    $("#edu_class").text(result.educationLevel);
                    $("#prefix").text(result.title);
                    $("#fname_th").text(result.fname);
                    $("#lname_th").text(result.lname);
                    $("#fname_en").text(result.efname);
                    $("#lname_en").text(result.elname);
                    $("#gender").text(result.sex);
                    $("#birthdate").text(result.birthday);
                    $("#position").text(result.position);
                    $("#tel").text(result.telephone);
                    $("#email").text(result.email);
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
