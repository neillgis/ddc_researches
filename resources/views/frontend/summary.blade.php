@extends('layout.main')
<?php
  use App\CmsHelper as CmsHelper;
  function gen($icon, $color, $name='', $num=0) {
    echo "<div class=' col-sm-6 col-md-3'>
    <div class='info-box'>
      <span class='info-box-icon $color elevation-1'><i class='$icon'></i></span>
      <div class='info-box-content'>
        <span class='info-box-text'> $name </span>
            <h3><b>".number_format($num)."</b></h3>
      </div>
    </div>
    </div>";
  }
?>
@section('css-custom')
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

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
    th,td {
      text-align: center;
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
          <div class="col-md-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"> สรุปข้อมูลสำหรับ (กนว.) </li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  <!-- /.content-header -->

  <section class="content">
    <div class="container-fluid">
      <h4 class="badge badge-secondary badge-pill text-lg"> โครงการวิจัย </h4>
      <div class="row">
        <?php
        gen("fas fa-chart-line", "bg-info", "โครงการวิจัยทั้งหมด", $research['all']);
        gen("fas fa-user-check", "bg-danger", "ตรงเงื่อนไข", $research['verify']);
        gen("fas fa-id-card-alt", "bg-success", "ตำแหน่ง PI & Co-PI", $research['pi']);
        gen("fas fa-users", "bg-warning", "ตำแหน่งผู้ร่วมวิจัย", $research['users']);
        ?>
    </div>

    <h4 class="badge badge-secondary badge-pill text-lg"> การตีพิมพ์วารสาร </h4>
    <div class="row">
    <?php
        gen("fas fa-chart-line", "bg-info", "บทความตีพิมพ์ทั้งหมด", $journal['all']);
        gen("fas fa-user-check", "bg-danger", "ตรงเงื่อนไข", $journal['verify']);
        gen("fas fa-book-reader", "bg-warning", "วารสารระดับชาติ (TCI 1)", $journal['tci1']);
        gen("fas fa-book-open", "bg-warning", "วารสารระดับนานาชาติ (Q1 - Q3)", $journal['q1q3']);
        ?>
    </div>

    <h4 class="badge badge-secondary badge-pill text-lg"> การนำไปใช้ประโยชน์ </h4>
    <div class="row">
    <?php
        gen("fas fa-chart-line", "bg-info", "การนำไปใช้ประโยชน์ทั้งหมด", $util['all']);
        gen("fas fa-user-check", "bg-danger", "ตรงเงื่อนไข", $util['verify']);
        gen("fas fa-file-signature", "bg-success", "เชิงนโยบาย", $util['policy']);
        gen("fas fa-chart-line", "bg-success", "เชิงวิชาการ", $util['academic']);
        ?>
    </div>
    <h4 class="badge badge-secondary badge-pill text-lg"> จำนวนนักวิจัย </h4>
    <div class="row">
    <?php
        gen("fas fa-users", "bg-warning", "จำนวนนักวิจัยโครงการ", $research_level['total_researcher']);
        ?>
    </div>
    <div class="row">
    <?php
        gen("fas fa-baby", "bg-light", "ระดับฝึกหัด", $research_level['training_level']);
        gen("fas fa-child", "bg-light", "ระดับต้น", $research_level['beginner_level']);
        gen("fas fa-walking", "bg-light", "ระดับกลาง", $research_level['intermediate_level']);
        gen("fas fa-running", "bg-light", "ระดับสูง", $research_level['advanced_level']);
        ?>
    </div>

    </div>
  </section>



    <section class="content">
      <div class="card">
        <div class="card card-gray">
          <div class="card-header">

              <div class="row">
                <div class="col-md-8">
                  <h3 class="card-title"> สรุปข้อมูลนักวิจัย </h3>
                </div>
                <div class="col-md-2 my-1" align="right">
                  <button type="button" class="btn-outline-light" onclick="fn_front(0)">a</button>
                  <button type="button" class="btn-outline-light" onclick="fn_front(1)">A</button>
                </div>
                <div class="col-md-2">
                  <select class="form-control" onchange="sel_status(this)">
                    <option value="1" <?=( $status==1?'selected':'' )?>>มีโครงการวิจัยหรือวารสาร</option>
                    <option value="0" <?=( $status==0?'selected':'' )?>>ไม่มีโครงการวิจัยหรือวารสาร</option>
                  </select>
                </div>
              </div>

          </div>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-sm small" style="width:100%" id="example1" >
              <thead>
                <tr>{!!  "<th>".implode("</th><th>",$tbheader)."</th>"  !!}</tr>
              </thead>
              <tbody>
              @foreach( $tbbody as $item )
              <tr class="text-nowrap">{!!  "<td>".implode("</td><td>",$item)."</td>"  !!}</tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>




    <div class="modal fade" id="ModalAuditor" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <form action="{{ route('summary.verified') }}" method="POST">
              @csrf
              <div class="modal-body">
                <br>
                  <img class="mx-auto d-block" src="{{ asset('img/verified.png') }}" alt="exclamation" style="width:90px;">
                <br>
                <font color="darkblue"><h4 class="text-center" ><b id="fullname"></b></h4></font>

                <div class="row">
                  <div class="col-md-12">
                    <!-- hidden = ID -->
                    <input type="hidden" class="form-control" name="idCard" id="idCard">
                    <input type="hidden" class="form-control" name="data_auditor" value="{{ Auth::user()->name }}">
                    <label> ระดับนักวิจัย </label>
                    <select class="form-control" name="researcher_level" id="researcher_level">
                        <option value="" selected="true" disabled="true"> -- กรุณาเลือก -- </option>
                      @foreach ($verified_list as $key => $value)
                        <option value="{{ $key }}"> {{ $value }} </option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <br>
              </div>

              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"> Close </button>
                <button type="submit" class="btn btn-success float-right" value="บันทึกข้อมูล">
                  <i class="fas fa-save"></i> &nbsp;Save Change
                </button>
              </div>
            </form>

          </div>
        </div>
      </div>

@stop('contents')


@section('js-custom-script')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- VERIFIED -->
  @if(Session::get('auditor'))
   <?php Session::forget('auditor'); ?>
    <script>
      Swal.fire({
          icon: 'success',
          title: 'ตรวจสอบเรียบร้อยแล้ว',
          showConfirmButton: false,
          confirmButtonColor: '#2C6700',
          timer: 3800
      })
    </script>
  @endif

<!-- Data Table -->
  <script type="text/javascript" class="init">
    $(document).ready(function() {
      $('#example1').DataTable({
        dom: 'Bfrtip',
        "lengthMenu": [ 10, 25, 50, 75, 100 ],
        "lengthChange": true,
        // "ordering": false,
        // "buttons": ["excel"]
        buttons: [
          'pageLength',
          'excel',
        ],
        order: [[3, 'desc']]
      });
    });
  </script>
@stop('js-custom-script')


@section('js-custom')
<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<!-- <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> -->
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
<script>
  var data_users = <?=json_encode($data_users, JSON_UNESCAPED_UNICODE)?>;
  function popup(cid) {
    for (const [key, value] of Object.entries(data_users)) {
      if(cid == value['idCard']) {
        $("#fullname").text(value['title']+value['fname']+" "+value['lname']);
        $("#idCard").val(value['idCard']);
        $("#researcher_level").val(value['researcher_level']);
        //-------------------------------------
        let myModal = new bootstrap.Modal(document.getElementById('ModalAuditor'));
        myModal.show();
        break;
      }
    }
  }

  function sel_status(node) {
    let id = $(node).val();
    window.location.replace("{{ Route('page.summary') }}"+"/"+id);
  }

  function fn_front(id) {
    $("#example1").removeClass("small");
    if(id==0) {
      $("#example1").addClass("small");
    }
  }
</script>
@stop('js-custom')
