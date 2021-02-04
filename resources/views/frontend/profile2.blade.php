@extends('layout.main')

<?php
  use App\CmsHelper as CmsHelper;
?>

@section('css-custom')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

<!-- DatePicker Style -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css">

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
            <li class="breadcrumb-item active"> ข้อมูลโครงการวิจัย </li>
          </ol>
        </div>
      </div>
    </div>
  </div>
<!-- /.content-header -->


<!-- Main content -->
<section class="content">
  <div class="container">

    <form>

    <div class="row">
      <div class="col-md-6">
        <div class="card shadow card-pink" id="rcorners3">
          <!-- <div class="card-header">
            <h4>Quick Example</h4>
          </div> -->

            <div class="card-body">
              <div class="card card-widget widget-user" id="rcorners3">

              <div class="widget-user-header" id="rcorners3" style="background-color: #FEF6EB;">
                <!-- <h3 class="widget-user-username">Alexander Pierce</h3>
                <h5 class="widget-user-desc">Founder &amp; CEO</h5> -->
              </div>

              <div class="widget-user-image">
                <img class="img-circle elevation-4" src="../dist/img/user1-128x128.jpg" alt="User Avatar" style="width:150px">
              </div>

              <div class="card-footer">
                <!-- <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">3,200</h5>
                      <span class="description-text">SALES</span>
                    </div>
                  </div>

                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <h5 class="description-header">13,000</h5>
                      <span class="description-text">FOLLOWERS</span>
                    </div>
                  </div>

                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header">35</h5>
                      <span class="description-text">PRODUCTS</span>
                    </div>
                  </div>
                </div> -->

              </div>

            </div>
            <br>


              <div class="form-group">
                <i class="far fa-user-circle"></i>
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
              </div>
              <div class="form-group">
                <label for="exampleInputFile">File input</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="exampleInputFile">
                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                  </div>
                  <div class="input-group-append">
                    <span class="input-group-text">Upload</span>
                  </div>
                </div>
              </div>
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
              </div>
            </div>

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Different Height</h3>
          </div>
          <div class="card-body">
            <input class="form-control form-control-lg" type="text" placeholder=".form-control-lg">
            <br>
            <input class="form-control" type="text" placeholder="Default input">
            <br>
            <input class="form-control form-control-sm" type="text" placeholder=".form-control-sm">
          </div>
        </div>
      </div>
      </div>


      


    </form>

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
                    $("#dept_id").text(result.deptId + '|'+result.deptName);
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
@endsection
