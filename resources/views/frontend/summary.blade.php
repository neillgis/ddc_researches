@extends('layout.main')

<?php
  use App\CmsHelper as CmsHelper;
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
          <div class="col-sm-12">
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

<!-- START SUM  BOX ------------------------------------------------------->
        <!-- ข้อมูลโครงการวิจัย -->
        <h4 class="badge badge-secondary badge-pill text-lg"> ข้อมูลโครงการวิจัย </h4>
            <div class="row">
              <div class=" col-sm-6 col-md-3">
                <div class="info-box">
                  <span class="info-box-icon bg-info elevation-1">
                    <!-- <i class="fas fa-cog"></i> -->
                    <i class="fas fa-chart-line"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text"> โครงการวิจัยทั้งหมด </span>
                        <h3><b> {{ empty($Total_research)?'0' : $Total_research }} </b></h3>
                  </div>
                </div>
              </div>

              <div class=" col-sm-6 col-md-3">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-danger elevation-1">
                    <i class="fas fa-user-check"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text"> ตรวจสอบแล้ว </span>
                        <h3><b> {{ empty($Total_research_verify)?'0' : $Total_research_verify }} </b></h3>
                  </div>
                </div>
              </div>

              <div class=" col-sm-6 col-md-3">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-success elevation-1">
                    <i class="fas fa-id-card-alt"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text text-auto"> ตำแหน่ง PI & Co-PI </span>
                        <h3><b> {{ empty($int_position_pi)?'0' : $int_position_pi }} </b></h3>
                  </div>
                </div>
              </div>

              <div class=" col-sm-6 col-md-3">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-warning elevation-1">
                    <i class="fas fa-users"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text text-auto"> จำนวนนักวิจัยโครงการ </span>
                        <h3><b> {{ empty($Total_research_users)?'0' : $Total_research_users }} </b></h3>
                  </div>
                </div>
              </div>
            </div> <!-- END row -->

        <!-- ข้อมูลการตีพิมพ์วารสาร -->
        <h4 class="badge badge-secondary badge-pill text-lg"> การตีพิมพ์วารสาร </h4>
            <div class="row">
              <div class=" col-sm-6 col-md-3">
                <div class="info-box">
                  <span class="info-box-icon bg-info elevation-1">
                    <!-- <i class="fas fa-cog"></i> -->
                    <i class="fas fa-chart-line"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text"> ตีพิมพ์วารสารทั้งหมด </span>
                        <h3><b> {{ empty($Total_journal)?'0' : $Total_journal }} </b></h3>
                  </div>
                </div>
              </div>

              <div class=" col-sm-6 col-md-3">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-danger elevation-1">
                    <i class="fas fa-user-check"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text"> ตรวจสอบแล้ว </span>
                        <h3><b> {{ empty($Total_journal_verify)?'0' : $Total_journal_verify }} </b></h3>
                  </div>
                </div>
              </div>

              <div class=" col-sm-6 col-md-3">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-warning elevation-1">
                    <i class="fas fa-book-reader"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text text-auto"> ระดับวารสาร (TCI 1) </span>
                        <h3><b> {{ empty($Total_journal_tci_1)?'0' : $Total_journal_tci_1 }} </b></h3>
                  </div>
                </div>
              </div>

              <div class=" col-sm-6 col-md-3">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-warning elevation-1">
                    <i class="fas fa-book-open"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text text-auto"> ระดับวารสาร (Q1 - Q3) </span>
                        <h3><b> {{ empty($Total_journal_q1_3)?'0' : $Total_journal_q1_3 }} </b></h3>
                  </div>
                </div>
              </div>
            </div> <!-- END row -->

        <!-- ข้อมูลการตีพิมพ์วารสาร -->
        <h4 class="badge badge-secondary badge-pill text-lg"> การนำไปใช้ประโยชน์ </h4>
            <div class="row">
              <div class=" col-sm-6 col-md-3">
                <div class="info-box">
                  <span class="info-box-icon bg-info elevation-1">
                    <!-- <i class="fas fa-cog"></i> -->
                    <i class="fas fa-chart-line"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text"> การนำไปใช้ประโยชน์ </span>
                        <h3><b> {{ empty($Total_util)?'0' : $Total_util }} </b></h3>
                  </div>
                </div>
              </div>

              <div class=" col-sm-6 col-md-3">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-danger elevation-1">
                    <i class="fas fa-user-check"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text"> ตรวจสอบแล้ว </span>
                        <h3><b> {{ empty($Total_util_verify)?'0' : $Total_util_verify }} </b></h3>
                  </div>
                </div>
              </div>

              <div class=" col-sm-6 col-md-3">
                <div class="info-box mb-3">
                  <span class="info-box-icon bg-success elevation-1">
                    <!-- <i class="fas fa-clipboard-check"></i> -->
                    <i class="fas fa-file-signature"></i>
                  </span>
                  <div class="info-box-content">
                    <span class="info-box-text text-auto"> เชิงนโยบาย </span>
                        <h3><b> {{ empty($Total_util_policies)?'0' : $Total_util_policies }} </b></h3>
                  </div>
                </div>
              </div>

            </div> <!-- END row -->
            <br>
<!-- END SUM  BOX --------------------------------------------------------->


<!-- START TABLE LIST --------------------------------------------------------->
          <section class="content">
            <div class="card">
              <div class="card card-gray">
                <div class="card-header">
                    <h3 class="card-title"> สรุปข้อมูลนักวิจัย </h3>
                </div>
              </div>

              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover" style="width:100%" id="example1" >
                    <thead>
                      <tr>
                      @if(Auth::hasRole('manager'))
                        <th class="text-center"> ชื่อ-นามสกุล </th>
                        <th class="text-center"> หน่วยงาน </th>
                        <th class="text-center"> โครงการวิจัย </th>
                        <th class="text-center"> ตำแหน่ง PI & Co-PI </th>
                        <th class="text-center"> วารสาร (ตรวจสอบแล้ว) </th>
                        <th class="text-center"> วารสาร (TCI 1) </th>
                        <th class="text-center"> วารสาร (Q1-Q3) </th>
                        <th class="text-center"> การนำไปใช้ประโยชน์ </th>
                        <th class="text-center"> ระดับนักวิจัย </th>
                        <th class="text-center"> ผู้ตรวจสอบ </th>
                        <th class="text-right"> Actions </th>
                      @elseif(Auth::hasRole('departments'))
                        <th class="text-center"> ชื่อ-นามสกุล </th>
                        <th class="text-center"> โครงการวิจัย </th>
                        <th class="text-center"> ตำแหน่ง PI & Co-PI </th>
                        <th class="text-center"> วารสาร (ตรวจสอบแล้ว) </th>
                        <th class="text-center"> วารสาร (TCI 1) </th>
                        <th class="text-center"> วารสาร (Q1-Q3) </th>
                        <th class="text-center"> การนำไปใช้ประโยชน์ </th>
                        <th class="text-center"> ระดับนักวิจัย </th>
                      @endif

                      </tr>
                    </thead>

                    <tbody>

                      @foreach($summary_list as $value)
                      <tr>
                            <td class="text-nowrap"> {{ $value->fullname }} </td>
                          @if(Auth::hasRole('manager'))
                            <td class="text-nowrap"> {{ $value->deptName }} </td>
                          @elseif(Auth::hasRole('departments'))
                            <!-- No Show BUTTON -->
                          @endif

                            <td class="text-center">
                                @if( isset($value->countPro))
                                    {{ ($value->countPro) }}
                                @else
                                    <font color="red"> 0 </font>
                                @endif
                            </td>
                            <td class="text-center">
                                @if( isset($value->countPosition))
                                    {{ ($value->countPosition) }}
                                @else
                                    <font color="red"> 0 </font>
                                @endif
                            </td>
                            <td class="text-center">
                                @if( isset($value->countJour))
                                    {{ ($value->countJour) }}
                                @else
                                    <font color="red"> 0 </font>
                                @endif
                            </td>
                            <td class="text-center">
                                @if( isset($value->countJour_tci_one))
                                    {{ ($value->countJour_tci_one) }}
                                @else
                                    <font color="red"> 0 </font>
                                @endif
                            </td>
                            <td class="text-center">
                                @if( isset($value->countJour_q_one2three))
                                    {{ ($value->countJour_q_one2three) }}
                                @else
                                    <font color="red"> 0 </font>
                                @endif
                            </td>
                            <td class="text-center">
                                @if( isset($value->countUtil))
                                    {{ ($value->countUtil) }}
                                @else
                                    <font color="red"> 0 </font>
                                @endif
                            </td>
                            <td class="text-center ">
                                @if($value->researcher_level == 1)
                                    <span class="badge" style="background-color:#5DADE2;"> {{ $verified_list [$value->researcher_level] }} </span>
                                @elseif($value->researcher_level == 2)
                                    <span class="badge" style="background-color:#45B39D;"> {{ $verified_list [$value->researcher_level] }} </span>
                                @elseif($value->researcher_level == 3)
                                    <span class="badge" style="background-color:#F5B041;"> {{ $verified_list [$value->researcher_level] }} </span>
                                @else
                                    <span class="badge bg-danger"> No results </span>
                                @endif
                            </td>
                          @if(Auth::hasRole('manager'))
                            <td class="text-center text-nowrap">
                                @if( isset($value->data_auditor))
                                    {{ $value->data_auditor }}
                                    <br><small><font color="red">({{ CmsHelper::DateThai($value->updated_at) }})</font></small>
                                @else
                                    <span class="badge bg-danger"> No results </span>
                                    <!-- <span class="badge badge-pill" style="background-color: #ff851b;"> No results </span> -->
                                @endif
                            </td>

                            <!-- Manage Data -->
                            <td class="td-actions text-right text-nowrap" href="#">
                                <button type="button" class="btn btn-primary btn-md" data-toggle="modal" title="Auditor" data-target="#ModalAuditor{{ $value->idCard }}">
                                  <i class="fas fa-bars"></i>
                                </button>
                            </td>

                            <!-- MODAL Verify & Status -->
                              <div class="modal fade" id="ModalAuditor{{ $value->idCard }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <form action="{{ route('summary.verified') }}" method="POST">
                                      @csrf

                                      <div class="modal-body">
                                        <br>
                                          <img class="mx-auto d-block" src="{{ asset('img/verified.png') }}" alt="exclamation" style="width:90px;">
                                        <br>
                                        <font color="darkblue"><h4 class="text-center"><b> {{ $value->fullname }}  </b></h4></font>

                                        <div class="row">
                                          <div class="col-md-12">
                                            <!-- hidden = ID -->
                                            <input type="hidden" class="form-control" name="idCard" value="{{ $value->idCard }}">
                                            <input type="hidden" class="form-control" name="data_auditor" value="{{ Auth::user()->name }}">
                                            <label> ระดับนักวิจัย </label>
                                            <select class="form-control" name="researcher_level">
                                                <option value="" selected="true" disabled="true"> -- กรุณาเลือก -- </option>
                                              @foreach ($verified_list as $key => $value)
                                                <option value="{{ $key }}" {{ $verified_list == $key ? 'selected' : '' }}> {{ $value }} </option>
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
                            <!-- END MODAL Verify & Status -->

                          @elseif(Auth::hasRole('departments'))

                              <!-- No Show BUTTON -->

                          @endif

                        </tr>
                     @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </section>

        </div>
      </section>
<!-- END TABLE LIST ----------------------------------------------------------->
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
        "ordering": false,
        // "buttons": ["excel"]
        buttons: [
          'pageLength',
          'excel',
        ]
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

@stop('js-custom')
