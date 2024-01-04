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
  th, td {
    text-align: center;
  }
  </style>
<!-- END Fonts Style : Kanit -->

@stop


@section('contents')


  <section class="content"><br>
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
        <h4><i class="fas fa-users"></i>&nbsp; <b>สิทธิ์ผู้ใช้งาน ({{number_format(count($users)) }} คน)</b> </h4>
      </div>
      <div class="card-body">
        <div class="table-responsive hover">
          <table id="example55" class="table table-hover table-reponsive">
            <thead class="text-nowrap" style="background-color: #F0F8FF;">
              <tr>
                <th class="text-center"> รหัส </th>
                <th> ชื่อ-สกุล </th>
                <th> หน่วยงาน </th>
                <th> สิทธิ์ </th>
                <th class="text-center"> Actions </th>
              </tr>
            </thead>

            <tbody>
              @foreach($users as $col)
                  <tr>
                    <td>{{ CmsHelper::fixid($col->cid) }}</td>
                    <td><div align="left">{{ $col->name }}</div></td>
                    <td><div align="left">{{ empty($dep[$col->dep_id])?"-":$dep[$col->dep_id] }}</div></td>
                    <td>{{ $col->role }}</td>

                    <td class="text-nowrap">
                      <button class="btn bg-gradient-warning btn-sm" title="แก้ไขข้อมูล" id='btn_{{ $col->cid }}'
                        data-toggle="modal" data-target="#popup" 
                        onclick="popup_update('{{ $col->id }}')">
                        <i class="fas fa-edit"></i>
                      </button>
                      <button class="btn bg-gradient-danger btn-sm" title="ลบข้อมูล"
                        onclick="popup_delete('{{ $col->id }}', '{{$col->name}}')">
                        <i class="fas fa-trash"></i>
                      </button>
                    </td>
                  </tr>

                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    </div></div></div>
  </section>




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
        
          <span>เลขบัตรประชาชน</span>
          <div class="input-group mb-3" id="area_cid">
            <input type="text" class="form-control" name="cid" id='cid' maxlength="13" 
              OnKeyPress="return chkNumber(this)" required>
            <div class="input-group-append">
              <button class="btn btn-outline-secondary" type="button" onclick="fn_find_cid()">ค้นหา</button>
            </div>
          </div>

          <div id="massage_error" class="text-danger"></div>

          <div id="area_detail" style="display: none;">
          <span>ชื่อ-นามสกุล</span>
          <input type="text" class="form-control" name="name" id="name" readonly>

          <span>หน่วยงาน</span>
          <input type="hidden"name="dep_id" id="dep_id">
          <input type="text" class="form-control" name="dep_name" id="dep_name" readonly>

          <span>สิทธิ์</span>
          <select class="form-control" name="role" id="role">
            @foreach( $role as $id=>$name )
            <option value="{{$id}}">{{$name}}</option>
            @endforeach
          </select>

          <br>
          <button type="submit" class="btn btn-block btn-primary" id="btn_submit">ยืนยัน</button>
          <input type="reset" id="btn_reset" style="display: none;">
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
        'pageLength','excel'
      ]
    });
  });
</script>


@if( !empty($_GET['Success']) )
    <script>
      Swal.fire({
        icon: 'success',
        title: "{{ $_GET['Success'] }}",
        showConfirmButton: false,
        timer: 1500
      })
      window.history.pushState({page: "another"}, "another page", "/manuser_home");
    </script>
  @endif
  @if(session()->has('Error'))
    <script>
      Swal.fire({
        icon: 'warning',
        title: "{{Session::get('Error')}}",
        showConfirmButton: false,
        timer: 1500
      })
    </script>
  @endif



<script>
  var dep = <?=json_encode($dep)?>;
  var users = <?=json_encode($users)?>;

  function popup_add() {
    $('#formPopup').trigger("reset");
    $("#area_detail").hide();
    $("#popup_header").html("เพิ่มข้อมูล");
    $("#btn_submit").attr("class","btn btn-block btn-primary");
    $("#formPopup").attr("action", "{{ Route('manuser.insert') }}");
  }

  function popup_update(id) {
    $('#formPopup').trigger("reset");
    $("#area_detail").show();
    $("#popup_header").html("แก้ไขข้อมูล");
    $("#btn_submit").attr("class","btn btn-block btn-warning");
    $("#formPopup").attr("action", "{{ Route('manuser.update') }}"+"/"+id);

    for (const [key, value] of Object.entries(users)) {
      if( id == value['id'] ) {
        $("#cid").val( value['cid'] );
        $("#name").val( value['name'] );
        $("#dep_name").val( dep[value['dep_id']] );
        $("#role").val( value['role'] );
        break;
      }
    }
  }

  function popup_delete(id, name) {
    Swal.fire({
      title: 'ยืนยันการลบ',
      text: name,
      confirmButtonText: 'ยืนยันการลบ',
      confirmButtonColor: '#dc3545',
      showCancelButton: true,
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "{{Route('manuser.delete')}}"+"/"+id;
      }
    })
  }


  function fn_find_cid() {
    var cid = $("#cid").val();
    if( cid.length==13 ) {

        $.ajax({
          url: "{{route('user_detail')}}"+"/"+cid,
          success:function(response){
            if(response) {
              if( response['data'] != "[]" ) {
                var obj = JSON.parse(response['data']);
                //-------------------------
                $("#area_detail").show();
                $("#massage_error").html('');
                $("#name").val(obj['user_name']);
                $("#dep_id").val(obj['dep_id']);

                if( dep[obj['dep_id']] ) {
                  $("#dep_name").val( dep[obj['dep_id']] );
                }else{
                  $("#dep_name").val( obj['dep_id'] );
                }
                
                //-------------------------
              }else{
                $("#btn_reset").click();
                $("#area_detail").hide();
                $("#massage_error").html('ไม่พบพนักงานที่ท่านค้นหา');
              }
            }
          },
        });
      
    }
  }
  //------------------------------
  function chkNumber(ele)
  {
    var vchar = String.fromCharCode(event.keyCode);
    if ((vchar<'0' || vchar>'9') && (vchar != '.')) return false;
    ele.onKeyPress=vchar;
  }
</script>


@stop
