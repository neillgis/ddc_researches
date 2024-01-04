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
      <a href="#" class="btn btn-danger btn-buy-now" onclick="update_all()">
      <i class="fas fa-link mr-2"></i>อัพเดททั้งหมด
      </a>
    </div>

    <div class="card shadow card-success">
      <div class="card-header" style="background-color: #ff74b4;">
        <div class="row">
          <div class="col-md-10">
          <h4><i class="fas fa-user-cog"></i>&nbsp; <b>จัดการผู้ใช้งาน ({{number_format(count($users)) }} คน)</b> </h4>
          </div>
          <div class="col-md-2">
            <select class="form-control" onchange="sel_status(this)">
              <option value="1" <?=( $status==1?'selected':'' )?>>ปกติ</option>
              <option value="0" <?=( $status==0?'selected':'' )?>>ออก</option>
            </select>
          </div>
        </div>
        
      </div>
      <div class="card-body">
        <div class="table-responsive hover">
          <table id="example55" class="table table-hover table-reponsive">
            <thead class="text-nowrap" style="background-color: #F0F8FF;">
              <tr>
                <th class="text-center"> id </th>
                <th> ชื่อ-สกุล </th>
                <th> หน่วยงาน </th>
                <th> ตำแหน่ง </th>
                <th> อัพเดทล่าลุด </th>
                <th class="text-center"> จัดการ </th>
              </tr>
            </thead>
            <tbody>
            @foreach($users as $x=>$value)
              <tr>
                <td>{{ $value->id }}</td>
                <td><div align="left">{{ $value->title.''.$value->fname.' '.$value->lname }}</div></td>
                <td><div align="left">{{ (empty($value->deptName)?"-":$value->deptName) }}</div></td>
                <td><div align="left">{{ (empty($value->position)?"-":$value->position) }}</div></td>
                <td id="edit_date_{{$value->id}}">{{ CmsHelper::DateThai($value->edit_date) }}</td>
                <td nowrap>
                  @if( $status==1 )
                  <button type="button" class="btn btn-outline-primary btn-sm" title="แก้ไข" onclick="popup_edit('{{ $value->id }}')">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button type="button" class="btn btn-outline-danger btn-sm" title="ลบ" onclick="popup_delete('{{ $value->id }}','<?=($value->title.$value->fname.' '.$value->lname)?>')">
                    <i class="fas fa-trash"></i>
                  </button>
                  @else
                  <button type="button" class="btn btn-outline-danger btn-sm" title="คืนการเป็นสมาชิก" onclick="popup_re('{{ $value->id }}','<?=($value->title.$value->fname.' '.$value->lname)?>')">
                    <i class="fas fa-reply-all"></i>
                  </button>
                  @endif
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    </div></div></div>
  </section>

  <div class="modal" id="popup_update" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">กำลังอัพเดท</h5>
        <button type="button" class="close" onclick="page_reload()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <img src="{{ asset('img/loading.gif') }}" class="w-50">
        <div class="h1">
        <span id="run_number">0</span>
        /
        <span>{{ count($users) }}</span>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal" id="popup" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">แก้ไขข้อมูลสมาชิก</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="" id="formPopup">
          {{csrf_field()}}
          <label>ชื่อ</label><span class="ml-2 text-danger" id="err_name"></span>
          <div class="row mb-2">
            <div class="col-md-2">
              <input type="text" class="form-control" name='title' id='title'>
            </div>
            <div class="col-md-5">
              <input type="text" class="form-control" name='fname' id='fname'>
            </div>
            <div class="col-md-5">
              <input type="text" class="form-control" name='lname' id='lname'>
            </div>
          </div>

          <label>หน่วยงาน</label><span class="ml-2 text-danger" id="err_dep"></span>
          <input type="hidden" name="dep_name" id="dep_name">
          <select class="form-control mb-2" name="dep_id" id="dep_id">
          @foreach( $dep as $d )
          <option value='{{ $d->sso }}'>{{ $d->depart_name }}</option>
          @endforeach
          </select>

          <label>ตำแหน่ง</label><span class="ml-2 text-danger" id="err_position"></span>
          <input type="text" class="form-control" name='position' id='position'>
          

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
      window.history.pushState({page: "another"}, "another page", "/users-manage");
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
  function page_reload() {
    window.location.replace("{{ Route('admin.users_manage') }}");
  }
  function sel_status(node) {
    let id = $(node).val();
    window.location.replace("{{ Route('admin.users_manage') }}"+"/"+id);
  }

  function popup_delete(id, name) {
    Swal.fire({
      title: 'ปรับสถานะเป็นออก',
      text: name,
      confirmButtonText: 'ยืนยัน',
      confirmButtonColor: '#dc3545',
      showCancelButton: true,
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "{{Route('admin.users_manage_delete')}}"+"/"+id;
      }
    })
  }

  function popup_re(id, name) {
    Swal.fire({
      title: 'ยืนยันการคืนสภาพสมาชิก',
      text: name,
      confirmButtonText: 'ยืนยัน',
      confirmButtonColor: '#dc3545',
      showCancelButton: true,
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "{{ Route('admin.users_manage_backtomem') }}"+"/"+id;
      }
    })
  }

  var users = <?=json_encode($users, JSON_UNESCAPED_UNICODE)?>;
  function popup_edit(id) {
    for (const [key, value] of Object.entries(users)) {
      if( value['id'] == id ) {
        $('#formPopup').trigger("reset");
        $("#formPopup").attr("action", "{{ Route('admin.users_manage_update') }}"+"/"+id);
        fn_find_cid(id, value);
        break;
      }
    }
  }


  function fn_find_cid(id, value) {
    let cid =  value['idCard'];
    if( cid.length==13 ) {
        $.ajax({
          url: "{{route('user_detail')}}"+"/"+cid,
          success:function(response){
            if(response) {
              if( response['data'] != "[]" ) {
                let obj = JSON.parse(response['data']);

                $("#title").val(obj['title'].trim());
                $("#fname").val(obj['fname'].trim());
                $("#lname").val(obj['lname'].trim());
                $("#dep_id").val(obj['dep_id']);
                let dep_name = $("#dep_id option:selected").text();
                $("#dep_name").val(dep_name.trim());
                $("#position").val(obj['position'].trim());

                if( value['title'].trim() != obj['title'].trim() || 
                    value['fname'].trim() != obj['fname'].trim() || 
                    value['lname'].trim() != obj['lname'].trim() ) {
                  $("#err_name").text("update");
                }

                if( value['dept_id'] != obj['dep_id'] ) {
                  $("#err_dep").text("update");
                }
                if( value['position'].trim() != obj['position'].trim() ) {
                  $("#err_position").text("update");
                }
                
                let myModal = new bootstrap.Modal(document.getElementById('popup'));
                myModal.show();
              }else{
                let name = value['title']+value['fanme']+" "+value['lname'];
                popup_delete(id, name);
              }
            }
          },
        });
    }
  }

  function update_all() {
    let myModal = new bootstrap.Modal(document.getElementById('popup_update'));
    myModal.show();

    let i=0;
    let num=0;
    let curr_date = "{{ date('Y-m-d') }}";
    for (const [key, value] of Object.entries(users)) {
      if( curr_date != value['edit_date'] ) {
        i++;
        setTimeout(function timer() {
          $("#run_number").text(num);
          num++;
            let cid =  value['idCard'];
            $.ajax({
              url: "{{route('user_detail')}}"+"/"+cid,
              success:function(response){
                if(response) {
                  if( response['data'] != "[]" ) {
                    let obj = JSON.stringify(response['data']);
                    ajax_update(value['id'], obj);
                  }else{
                    ajax_del(value['id']);
                  }
                }
              },
            });
        }, i * 500);
      }else{
        num++;
      }

    }
  }

  function ajax_del(user_id) {
    $.ajax({
      url: "{{route('ajax.users_manage_delete')}}"+"/"+user_id,
      success:function(response){
        if(response) {
          if( response['msg'] == "ok" ) {
            $("#edit_date_"+user_id).text(response['data']);
          }
        }
      },
    });
  }

  function ajax_update(user_id, obj) {
    $.ajax({
      url: "{{route('ajax.users_manage_update')}}"+"/"+user_id+"?obj="+obj,
      success:function(response){
        if(response) {
          console.log(response);
          if( response['msg'] == "ok" ) {
            $("#edit_date_"+user_id).text(response['data']);
          }
        }
      },
    });
  }

</script>
@stop