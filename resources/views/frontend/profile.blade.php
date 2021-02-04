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
            <li class="breadcrumb-item active"> ข้อมูลบุคคล / นักวิจัย </li>
          </ol>
        </div>
      </div>
    </div>
  </div>
<!-- /.content-header -->


<!-- Main content -->
<section class="content">
  <div class="container-fluid">

    <div class="row">
      <div class="col-md-6">
        <div class="card shadow" id="rcorners3">
          <div class="card-header">
            <h4><i class="fas fa-user-circle"></i> ข้อมูลบุคคล / นักวิจัย </h4>
          </div>

          <form>
            <div class="card-body">
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
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>


      </div>
      <!--/.col (left) -->
      <!-- right column -->
      <div class="col-md-6">
        <!-- Form Element sizes -->
          <div class="card shadow card-success" id="rcorners3">
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
          <!-- /.card-body -->
        </div>
        <br>
        <!-- /.card -->

        <div class="card shadow card-danger" id="rcorners3">
          <div class="card-header">
            <h3 class="card-title">Different Width</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-3">
                <input type="text" class="form-control" placeholder=".col-3">
              </div>
              <div class="col-4">
                <input type="text" class="form-control" placeholder=".col-4">
              </div>
              <div class="col-5">
                <input type="text" class="form-control" placeholder=".col-5">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>




@stop('contents')


@section('js-custom-script')

@stop('js-custom-script')



@section('js-custom')

@stop('js-custom')
