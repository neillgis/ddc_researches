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
  td {
    text-align: center;
  }
  </style>
<!-- END Fonts Style : Kanit -->

@stop


@section('contents')


<div class="content-wrapper">
  <br>
  <section class="content">
  <div class="container-fluid">
  <div class="row justify-content-md-center">
  <div class="col-xxl-10 col-md-10">

    <div align="right" class="mb-2">
      <a href="#" class="btn btn-danger btn-buy-now" 
      data-toggle="modal" data-target='#popup' onclick="popup_add()">
      <i class="fa fa-plus mr-2"></i>เพิ่มข้อมูลใหม่
      </a>
    </div>
    <div class="card shadow card-success">
        <div class="card-header" style="background-color: #54BEAE;">
          <h4><i class="fas fa-hotel"></i>&nbsp; <b>ตั้งค่าหน่วยงาน</b> </h4>
      </div>

      <div class="card-body">
        <div class="table-responsive hover">
          <table id="example55" class="table table-hover table-reponsive">
            <thead class="text-nowrap" style="background-color: #F0F8FF;">
              <tr>
                <th class="text-center"> sso_id </th>
                <th> หน่วยงาน </th>
                <th> ประเภท </th>
                <th class="text-center"> Actions </th>
              </tr>
            </thead>
            <tbody>
            @foreach($dep as $col)
              <tr>
                <td>{{ $col->sso }}</td>
                <td><div align="left">{{ $col->depart_name }}</div></td>
                <td>{{ $col->depart_type }}</td>
                <td>
                <button class="btn bg-gradient-warning btn-sm" title="แก้ไขข้อมูล"
                  data-toggle="modal" data-target="#popup" 
                  onclick="popup_update('{{ $col->id }}')">
                  <i class="fas fa-edit"></i>
                </button>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      
      </div> <!-- card-body -->
    </div>

  </div></div></div>
  </section>
</div>


<div class="modal" id="popup" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="popup_header"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="" id="formPopup">
          {{csrf_field()}}
          <label>SSO_DEPID</label><br>
          <input type="text" class="form-control" name="sso_id" id="sso_id" value="">
          <label>ชื่อหน่วยงาน</label><br>
          <input type="text" class="form-control" name="depart_name" id="depart_name" value="">
          <label>ประเภท</label><br>
          <select class="form-control" name="depart_type" id="depart_type">
            <option value="ส่วนกลาง">ส่วนกลาง</option>
            <option value="ภูมิภาค">ภูมิภาค</option>
          </select>
          

          <br>
          <button type="submit" class="btn btn-block btn-primary" id="btn_submit">ยืนยัน</button>
          </div>

        </form>
      </div>
    </div>
  </div>
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



<script>
  var dep = <?=json_encode($dep)?>;
  function popup_add() {
    $("#popup_header").html("เพิ่มข้อมูล");
    $("#btn_submit").attr("class","btn btn-block btn-primary");
    $("#formPopup").attr("action", "{{ Route('setdep.insert') }}");
  }

  function popup_update(id) {
    $("#popup_header").html("แก้ไขข้อมูล");
    $("#btn_submit").attr("class","btn btn-block btn-warning");
    $("#formPopup").attr("action", "{{ Route('setdep.update') }}"+"/"+id);

    for (const [key, value] of Object.entries(dep)) {
      if( id == value['id'] ) {
        $("#sso_id").val(value["sso"]);
        $("#depart_name").val(value["depart_name"]);
        $("#depart_type").val(value["depart_type"]);
        break;
      }
    }
  }
</script>


@stop
