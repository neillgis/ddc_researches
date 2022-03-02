@extends('layout.main')

<?php
  use App\CmsHelper as CmsHelper;
?>

@section('css-custom')
<!-- DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
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

@stop


@section('contents')

<!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active"> ข้อมูลผู้ใช้งานทั้งหมด </li>
          </ol>
        </div>
      </div>
    </div>
  </div>
<!-- /.content-header -->

<div class="content-wrapper">

  <section class="content">
    <div class="container-fluid">
      <br>

      <div class="row justify-content-md-center">
        <div class="col-xxl-10 col-md-10">
          <h1 class="text-center mt-1 mb-4"><b><i class="fas fa-user-cog"></i> จัดการผู้ใช้งาน </b></h1>

            <div class="card" style="border-radius:12px; box-shadow: rgba(50, 50, 93, 0.25) 0px 13px 27px -5px, rgba(0, 0, 0, 0.3) 0px 8px 16px -8px;">
                <div class="card-body">
                  <div class="table-responsive hover">
                    <table id="example55" class="table table-hover table-reponsive">
                      <thead class="text-nowrap" style="background-color: #F0F8FF;">
                        <tr>
                          <th class="text-center"> ลำดับ </th>
                          <th> ชื่อ-สกุล </th>
                          <th> หน่วยงาน </th>
                          <th> ตำแหน่ง </th>
                          <th class="text-center"> Actions </th>
                        </tr>
                      </thead>

                      <tbody>
                        @php
                        $i = 1;
                        @endphp
                        @foreach($users as $value)
                          <tr>
                            <td class="text-center"> {{ $i }} </td>
                            <td> {{ $value->title.''.$value->fname.' '.$value->lname }} </td>
                            <td>
                              @if($value->deptName != NULL)
                                  {{ $value->deptName }}
                              @else
                                  -
                              @endif
                            </td>
                            <td>
                              @if($value->position != NULL)
                                  {{ $value->position }}
                              @else
                                  -
                              @endif
                            </td>
                            <td class="text-center">
                                <!-- DELETE -->
                                <button type="button" class="btn btn-outline-danger btn-sm" title="Delete" data-toggle="modal" data-target="#DeleteEmployee{{ $value->id }}">
                                  <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>

                              <!-- MODAL Delete -->
                                <div class="modal fade" id="DeleteEmployee{{ $value->id }}">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-body">
                                        <br>
                                          <img class="mx-auto d-block mb-4" src="{{ asset('img/exclamation.png') }}" alt="exclamation" style="width:90px;">
                                          <h5 class="text-center text-primary mb-3"> {{ $value->title.''.$value->fname.' '.$value->lname }} </h5>
                                          <h3 class="text-center mb-4"> ต้องการลบรายการนี้ใช่ไหม ? <br> </h3>

                                        <div class="text-center mb-3">
                                          <!-- Cancel -->
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal" role="button" aria-disabled="true">
                                              <i class="fas fa-times-circle"></i> Cancel
                                            </button>
                                          <!-- Confirms -->
                                          <a href="{{ route('admin.users_manage_delete',[ 'users_id' => $value->id ]) }}">
                                            <button type="button" class="btn btn-danger" role="button" aria-disabled="true">
                                              <i class="fas fa-trash-alt"></i> Confirms
                                            </button>
                                          </a>

                                        </div>
                                      </div> <!-- END modal-body -->
                                    </div>
                                  </div>
                                </div>
                              <!-- END MODAL Delete -->

                          </tr>
                          @php
                              $i++;
                          @endphp
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div> <!-- END Card-Body -->

            </div> <!-- END Card -->
          </div> <!-- END Column -->
      </div> <!-- END Row -->
    </div>
  </section>

</div>
@stop

@section('js-custom-script')
<!-- DataTables -->
<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
  $(document).ready(function() {
    $('#example55').DataTable({
      dom: 'Bfrtip',
      buttons: [
        // 'excel', 'print'
      ]
    });
  });
</script>

  @if(Session::get('deleted_msg'))
   <?php Session::forget('deleted_msg'); ?>
    <script>
      Swal.fire({
          icon: 'success',
          title: 'ลบข้อมูลเรียบร้อยแล้ว',
          showConfirmButton: true,
          timer: 1300
      })
    </script>
  @endif

@stop
