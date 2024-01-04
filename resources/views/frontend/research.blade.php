@extends('layout.main')

<?php
  use App\CmsHelper as CmsHelper;
?>

@section('css-custom')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

<!-- DatePicker Thai -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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

  <section class="content">
    <div class="container-fluid">

    <!-- START SUMMARY Total Box -->
      <div class="row">
        <div class="col-lg-3 col-md-6 mx-auto">
          <div class="small-box bg-blue mx-auto shadow">
            <div class="inner">
              <h3> {{ $research['all'] }} โครงการ</h3>
              <br>
              <p><b>โครงการทั้งหมด</b></p>
            </div>
            <div class="icon">
              <i class="fas fa-dice-d20"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
          </div>
        </div>

        <div class="col-lg-3 col-md-6 mx-auto">
          <div class="small-box bg-danger mx-auto shadow">
            <div class="inner">
              <h3>{{ $research['publish'] }} โครงการ</h3>
              <br>
              <p> โครงการที่ตีพิมพ์ </p>
            </div>
            <div class="icon">
              <i class="fas fa-dice-d20"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
          </div>
        </div>

        <div class="col-lg-3 col-md-6 mx-auto">
          <div class="small-box bg-success mx-auto shadow">
            <div class="inner">
              <h3> {{ $research['verify'] }} โครงการ</h3>
              <br>
              <p> โครงการที่ตรวจสอบแล้ว </p>
            </div>
            <div class="icon">
              <i class="fas fa-microscope"></i>
            </div>
            <!-- <a class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
          </div>
        </div>

        <div class="col-lg-3 col-md-6 mx-auto">
          <div class="small-box bg-info mx-auto shadow">
            <div class="inner">
              <h3> {{ $research['pi'] }} โครงการ</h3>
              <br>
              <p> โครงการที่เป็นผู้วิจัยหลัก</p>
            </div>
            <div class="icon">
              <i class="fas fa-user-graduate"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
          </div>
        </div>

      </div>
    </div>
  </section>
  <br>
  <!-- END SUMMARY Total Box -->



    <!-- START From Input RESEARCH PROJECT -------------------------------------------------->
    <section class="content">
      <div class="container-fluid">

    @if(Gate::allows('departments'))

      <!-- NO Show BUTTON For Departments ONLY -->

    @else

      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card shadow" style="background-color: #ff851b;">
              <div class="card-header">
                <h5 class="card-title"><b> เพิ่มข้อมูลโครงการวิจัย </b></h5>
              </div>
            </div>

            <!-- <form role="form"> -->
            <form method="POST" action="{{ route('research.insert') }}" enctype="multipart/form-data" onsubmit="disableButton()">
              @csrf

              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="exampleInput1"> ชื่อโครงการวิจัย (TH) </label>
                      <input type="text" class="form-control" name="pro_name_th">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="exampleInput1"> ชื่อโครงการวิจัย (ENG) </label>
                      <input type="text" class="form-control" name="pro_name_en">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleSelect1"> ตำแหน่งในโครงการวิจัย <font color="red"> * </font></label>
                      <!-- SELECT option ดึงมาจากฐานข้อมูล db_research_project -->
                      <select class="form-control" name="pro_position" required>
                        <option value="" disabled="true" selected="true" >กรุณาเลือก</option>
                        @foreach ($pro_position as $key => $value)
                          <option value="{{ $key }}"> {{ $value }} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleSelect1"> จำนวนผู้ร่วมวิจัย : ไม่รวมผู้วิจัยหลักและที่ปรึกษาโครงการ <font color="red"> * </font></label>
                      <!-- SELECT option ดึงมาจากฐานข้อมูล db_research_project -->
                      <select class="form-control" name="pro_co_researcher" required>
                        <option value="" disabled="true" selected="true" >กรุณาเลือก</option>
                        @foreach ($pro_co_researcher as $key => $value)
                          <option value="{{ $key }}"> {{ $value }} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleDatepicker1"> ปีที่เริ่มโครงการวิจัย <font color="red"> * </font></label>
                        <a class="one form-group" href="#" id="modal"> <b> (คำอธิบายเพิ่มเติม) </b></a>
                        <div class="input-group date">
                            <input type="text" class="form-control" id="datepicker1" placeholder="กรุณาเลือก ปี/เดือน/วัน"
                                   name="pro_start_date" autocomplete="off" required readonly>
                               <div class="input-group-append">
                                 <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                               </div>
                         </div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleDatepicker1"> ปีที่เสร็จสิ้นโครงการวิจัย <font color="red"> * </font></label>
                      <a class="two form-group" href="#" id="modal"> <b> (คำอธิบายเพิ่มเติม) </b></a>
                      <div class="input-group date">
                          <input type="text" class="form-control" id="datepicker2" placeholder="กรุณาเลือก ปี/เดือน/วัน"
                                 name="pro_end_date" autocomplete="off" required readonly>
                             <div class="input-group-append">
                               <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                             </div>
                       </div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleSelect1"> โครงการวิจัยได้รับการตีพิมพ์ในวารสารวิชาการ <font color="red"> * </font></label>
                      <!-- SELECT option ดึงมาจากฐานข้อมูล db_research_project -->
                      <select class="form-control" name="publish_status" required>
                        <option value="" disabled="true" selected="true" >กรุณาเลือก</option>
                        @foreach ($publish_status as $key => $value)
                          <option value="{{ $key }}"> {{ $value }} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row" >
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="exampleInput1"> URL ที่อยู่ออนไลน์ของรายงานวิจัยฉบับสมบูรณ์ (ถ้ามี) </label>
                      <input type="text" class="form-control" name="url_research">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="expInputFile"> อัพโหลดไฟล์ : รายงานวิจัยฉบับสมบูรณ์.pdf <font color="red"> * </font></label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" name="files" required>
                          <label class="custom-file-label" for="expInputFile"> Upload File ขนาดไม่เกิน 20 MB </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- <br> -->

                <!-- <div class="label">
                  <h4><b>หมายเหตุ : </b></h4>
                  <label> * ปีที่เริ่มโครงการ : &nbsp;&nbsp; วันที่ทำสัญญากับแหล่งทุนหรือวันที่ได้รับอนุมัติจากผู้บริหารของหน่วยงาน <font color="red">กรณีจำวัน เดือน ไมได้ ให้แทนที่ด้วย 01/01</font></label>
                  <br>
                  <label> ** ปีที่เสร็จสิ้นโครงการ : &nbsp;&nbsp; วันที่ส่งรายงานฉบับสมบูรณ์กรณีไม่ทราบ <font color="red">กรณีจำวัน เดือน ไมได้ ให้แทนที่ด้วย 31/12</font></label>
                </div> -->
              </div>

              <div class="card-footer">
                <button type="submit" class="btn btn-success float-right" value="บันทึกข้อมูล" id="btn_disabled">
                  <i class="fas fa-save"></i> &nbsp;บันทึกข้อมูล </button>
              </div>

            </form>

          </div>
        </div>
      </div>
    <br>
  @endif

    <!-- END From Input RESEARCH PROJECT -------------------------------------------------->



    <!-- START TABLE -> RESEARCH PROJECT -------------------------------------------------->
      <section class="content">
        <div class="card">
          <div class="card card-gray">
            <div class="card-header">
              <h5 class="card-title"> โครงการวิจัยที่เสร็จสิ้นแล้ว </h5>
            </div>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover" id="example55">
                <thead>
                    <tr>
                      <th class="text-center"> ลำดับ </th>
                      <th class="text-center"> Project ID </th>
                      <th class="text-center"> ชื่อโครงการวิจัยที่เสร็จสิ้นแล้ว </th>
                      <th class="text-center"> เริ่มโครงการ </th>
                      <th class="text-center"> เสร็จสิ้นโครงการ </th>
                      <th class="text-center"> ตีพิมพ์ </th>
                      @if(Gate::allows('manager'))
                        <th class="text-center"> ชื่อ/สกุล </th>
                        <th class="text-center"> หน่วยงาน </th>
                      @endif
                        <th class="text-center"> การตรวจสอบ </th>
                      @if(Gate::allows('departments'))
                        <!-- NO Show BUTTON For Departments ONLY -->
                          <th class="text-center"> ชื่อ/สกุล </th>
                          <th class="text-right"> Actions </th>
                      @else
                        <th class="text-right"> Actions </th>
                      @endif
                    </tr>
                </thead>

                <tbody>
                  @php
                      $i = 1;
                  @endphp
                  @foreach ($data_research as $value)
                  <tr>
                    <td class="text-center"> {{ $i }} </td>
                    <td class="text-center"> {{ $value->id }} </td>
                    <td class="text-left"> {{ $value->pro_name_th." ".$value->pro_name_en}} </td>
                    <td class="text-center"> {{ CmsHelper::DateThai($value->pro_start_date) }} </td>
                    <td class="text-center"> {{ CmsHelper::DateThai($value->pro_end_date) }} </td>
                    <td class="text-center"> {{ $publish_status [ $value->publish_status ] }} </td>
                  @if(Gate::allows('manager'))
                    <td class="text-center"> {{ $value->users_name }} </td>
                    <td class="text-center"> {{ $user_dep_name[$value->users_id] }} </td>
                  @endif

                    <td class="text-center">
                        @if($value->verified == "1")
                          <span class="badge bg-secondary badge-pill"><i class="fas fa-check-circle"></i> {{ $verified_list [ $value->verified ] }} </span>
                        @elseif($value->verified == "2")
                          <span class="badge bg-success badge-pill"> {{ $verified_list [ $value->verified ] }} </span>
                        @elseif($value->verified == "3")
                           <span class="badge badge-pill" style="background-color: #ff851b;"> {{ $verified_list [ $value->verified ] }} </span>
                        @elseif($value->verified == "4")
                           <span class="badge bg-warning badge-pill"> {{ $verified_list [ $value->verified ] }} </span>
                        @elseif($value->verified == "9")
                           <span class="badge bg-info badge-pill"><i class="fas fa-times-circle"></i> {{ $verified_list [ $value->verified ] }} </span>
                        @else <!-- verified == "1" คือ รอตรวจสอบ [Default] -->
                           <span class="badge bg-danger badge-pill"> รอตรวจสอบ </span>
                        @endif
                    </td>

                  @if(Gate::allows('departments'))

                    <!--  Show SOME_BUTTON For Departments ONLY -->
                    <td class="text-center"> {{ $value->users_name }} </td>

                    <!-- ACTIONS Button for Departments -->
                    <td class="td-actions text-right text-nowrap" href="#">
                      <div class="btn-group">
                        <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-cog"></i></button>
                          <div class="dropdown-menu" role="menu">
                          <!-- DOWNLOAD new-->
                              <a class="dropdown-item" href="{{ route('DownloadFile.research', ['id' => $value->id, 'files' => $value->files]) }}" title="Download">
                                <i class="fas fa-arrow-alt-circle-down"></i>&nbsp; Download
                              </a>
                          <!-- END DOWNLOAD -->

                              <div class="dropdown-divider"></div>

                          <!-- VERIFIED -->
                              <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-default{{ $value->id }}" title="Verfied">
                                <i class="fas fa-user-check"></i>&nbsp; Verified
                              </a>
                          <!-- END VERIFIED -->
                          </div>
                      </div>
                    </td>

                  @else
                    <!-- ACTIONS Button for MANAGER -->
                    <td class="td-actions text-right text-nowrap" href="#">

                      @if(Gate::allows('manager'))
                        <div class="btn-group">
                          <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-cog"></i></button>
                            <div class="dropdown-menu" role="menu">

                            <!-- DOWNLOAD new-->
                                <a class="dropdown-item" href="{{ route('DownloadFile.research', ['id' => $value->id, 'files' => $value->files]) }}" title="Download">
                                  <i class="fas fa-arrow-alt-circle-down"></i>&nbsp; Download
                                </a>

                                <div class="dropdown-divider"></div>

                            <!-- EDIT new -->
                                <a class="dropdown-item" href="{{ route('research.edit', $value->id) }}" title="Edit">
                                  <i class="fas fa-edit"></i>&nbsp; Edit
                                </a>

                                <div class="dropdown-divider"></div>

                            <!-- VERIFIED -->
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-default{{ $value->id }}" title="Verfied">
                                  <i class="fas fa-user-check"></i>&nbsp; Verified
                                </a>

                                <div class="dropdown-divider"></div>

                            <!-- DELETE -->
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#DeleteModal{{ $value->id }}" title="Delete">
                                  <i class="fas fa-trash-alt"></i>&nbsp; Delete
                                </a>

                            @if($value->verified == "2" || $value->verified == "3" || $value->verified == "9")

                                <div class="dropdown-divider"></div>

                            <!-- COMMENTS -->
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#CommentModal{{ $value->id }}" title="Comments">
                                  <i class="far fa-comment-dots"></i>&nbsp; Comments
                                </a>
                              @endif

                            </div>
                        </div>
                      @endif
                  @endif


                  <!-- Download & Edit & Comments -->
                      @if(Gate::allows('manager'))
                          <!-- NO Show BUTTON For USER ONLY -->
                      @elseif(Gate::allows('departments'))
                          <!-- NO Show BUTTON For USER ONLY -->
                      @else

                          <!-- Download -->
                          @if($value->verified == "1")
                              <button type="button" class="btn btn-secondary btn-md" data-toggle="tooltip" title="Download" disabled>
                                <i class="fas fa-arrow-alt-circle-down"></i>
                              </button>
                          @else
                            <a href=" {{ route('DownloadFile.research', ['id' => $value->id, 'files' => $value->files]) }} ">
                              <button type="button" class="btn btn-outline-primary btn-md" data-toggle="tooltip" title="Download">
                                <i class="fas fa-arrow-alt-circle-down"></i>
                              </button>
                            </a>
                          @endif

                          <!-- Comments -->
                          @if($value->verified == "2" || $value->verified == "3" || $value->verified == "9")
                              <button type="button" class="btn btn-outline-info btn-md" title="Comments" data-toggle="modal" data-target="#CommentModal{{ $value->id }}">
                                <i class="far fa-comment-dots"></i>
                              </button>
                          @endif

                          <!-- Edit -->
                          @if($value->verified == "1" || $value->verified == "9")
                              <button type="button" class="btn btn-secondary btn-md" data-toggle="tooltip" title="Edit" disabled>
                                <i class="fas fa-edit"></i>
                              </button>
                          @else
                            <a href=" {{ route('research.edit', $value->id) }} ">
                              <button type="button" class="btn btn-outline-warning btn-md" data-toggle="tooltip" title="Edit">
                                <i class="fas fa-edit"></i>
                              </button>
                            </a>
                          @endif

                          <!-- Delete -->
                          @if($value->verified != NULL)
                              <button type="button" class="btn btn-secondary btn-md" title="Delete" data-toggle="tooltip" disabled>
                                <i class="fas fa-trash-alt"></i>
                              </button>
                          @else
                              <button type="button" class="btn btn-outline-danger btn-md" title="Delete" data-toggle="modal" data-target="#DeleteModal{{ $value->id }}">
                                <i class="fas fa-trash-alt"></i>
                              </button>
                          @endif

                      @endif
                  <!-- Download & Edit & Comments -->

                  </td>


                  <!-- MODAL Delete -->
                    <div class="modal fade" id="DeleteModal{{ $value->id }}">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-body">
                            <br>
                              <img class="mx-auto d-block" src="{{ asset('img/exclamation.png') }}" alt="exclamation" style="width:90px;">
                            <br>
                              <h2 class="text-center"> ต้องการลบรายการนี้ใช่ไหม ? <br> </h2>
                              <h5 class="text-center"> Project ID. [ <font color = "red"> {{ $value->id }} </font> ]  </h5>
                            <br>
                            <div class="text-center">
                              <!-- Cancel -->
                                <button type="button" class="btn btn-danger" data-dismiss="modal" role="button" aria-disabled="true">
                                  <i class="fas fa-times-circle"></i> Cancel
                                </button>
                              <!-- Confirms -->
                              <a href="{{ route('research.delete',['id' => $value->id]) }}">
                                <button type="button" class="btn btn-success" role="button" aria-disabled="true">
                                  <i class="fas fa-trash-alt"></i> Confirms
                                </button>
                              </a>

                            </div>
                          </div> <!-- END modal-bodyl -->
                        </div>
                      </div>
                    </div>
                  <!-- END MODAL Delete -->


                  <!-- MODAL Comments -->
                    <div class="modal fade" id="CommentModal{{ $value->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title"><b><i class="far fa-comment-dots"></i> Comments</b> (Project ID. <font color="red">{{ $value->id }}</font>) </h4>
                          </div>

                      @if(Gate::allows('manager'))
                        <form action="{{ route('research.comments') }}" method="POST" enctype="multipart/form-data" onsubmit="disableButtonVerify()">
                          @csrf
                              <!-- HIDDEN Data -->
                              <input type="hidden" name="projects_id" value="{{ $value->id }}">
                              <input type="hidden" name="subject" value="{{ $value->verified }}">
                              <input type="hidden" name="receiver_id" value="{{ $value->users_id }}">
                              <input type="hidden" name="receiver_name" value="{{ $value->users_name }}">

                      @else <!-- USERS Only -->

                        <form action="{{ route('research.comments_users') }}" method="POST" enctype="multipart/form-data" onsubmit="disableButtonVerify()">
                          @csrf
                              <!-- HIDDEN Data -->
                              <input type="hidden" name="projects_id" value="{{ $value->id }}">
                              <input type="hidden" name="subject" value="{{ $value->verified }}">
                      @endif

                          <div class="modal-body">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <textarea class="form-control" name="description" rows="3" cols="100" placeholder="ข้อเสนอแนะ/คำแนะนำ"></textarea>
                                </div>
                              </div>

                            @if(Gate::allows('manager'))
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label> อัพโหลดไฟล์ : <font color="red"> (.jpg, .jpeg, .png, .doc, .docx, .xls, .xlsx, .pdf) </font></label>
                                  <div class="input-group">
                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input" name="files_upload" accept=".jpg,.png,.jpeg,.doc,.docx,.xls,.xlsx,.pdf">
                                      <label class="custom-file-label"> Upload File ขนาดไม่เกิน 10 MB </label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            @endif

                            </div> <!-- END Row -->
                            <br>
                          </div>

                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal"> Close </button>
                            <button type="submit" class="btn_disabled_verify btn btn-success float-right" value="บันทึกข้อมูล">
                              <i class="fas fa-save"></i> &nbsp;บันทึกข้อมูล
                            </button>
                          </div>
                        </form>

                        </div>
                      </div>
                    </div>
                  <!-- END MODAL Comments -->



                  <!-- MODAL Verify -->
                    <div class="modal fade" id="modal-default{{ $value->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title"><b>การตรวจสอบ</b> (Project ID. <font color="red">{{ $value->id }}</font>) </h4>
                          </div>

                        <form action="{{ route('research.verified') }}" method="POST" onsubmit="disableButtonVerify()">
                          @csrf

                          <div class="modal-body">
                            <div class="row">
                              <div class="col-md-12">
                                <!-- hidden = id -->
                                <input type="hidden" class="form-control" name="id" value="{{ $value->id }}">

                                @if(Gate::allows('manager'))
                                    <select class="form-control" name="verified">
                                        <option value="" selected="true" disabled="true"> -- กรุณาเลือก -- </option>
                                      @foreach ($ref_verified as $verify)
                                        <option value="{{ $verify->id }}" {{ $value->verified == $verify->id ? 'selected' : '' }}> {{ $verify->verify_name }} </option>
                                      @endforeach
                                    </select>
                                @elseif(Gate::allows('departments'))
                                    <select class="form-control" name="verified">
                                        <option value="" selected="true" disabled="true"> -- กรุณาเลือก -- </option>
                                      @foreach ($verified_departments as $key => $value)
                                        <option value="{{ $key }}" {{ $verified_departments == $key ? 'selected' : '' }}> {{ $value }} </option>
                                      @endforeach
                                    </select>
                                @endif

                              </div>
                            </div>
                            <br>
                          </div>

                          <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal"> Close </button>
                            <button type="submit" class="btn_disabled_verify btn btn-success float-right" value="บันทึกข้อมูล">
                              <i class="fas fa-save"></i> &nbsp;บันทึกข้อมูล
                            </button>
                          </div>
                        </form>

                        </div>
                      </div>
                    </div>
                  <!-- END MODAL Verify -->


                  </tr>
                  @php
                      $i++;
                  @endphp
                  @endforeach
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </section>
    <!-- END TABLE -> RESEARCH PROJECT -------------------------------------------------->

      </div>
  </section>
@stop('contents')



@section('js-custom-script')

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

  <!-- SweetAlert2  -->
  <script>
    document.querySelector(".one").addEventListener('click', function(){
      Swal.fire(
      "ปีที่เริ่มโครงการ",
      "วันที่ทำสัญญากับแหล่งทุนหรือวันที่ได้รับอนุมัติจากผู้บริหารของหน่วยงาน <br> <b>*กรณีจำ วัน-เดือน ไม่ได้</b> ให้แทนที่ด้วย วัน-เดือน-ปี <br> เช่น (01-01-25xx)",
      "warning"
      );
    });
    document.querySelector(".two").addEventListener('click', function(){
      Swal.fire(
      "ปีที่เสร็จสิ้นโครงการ",
      "วันที่ส่งรายงานฉบับสมบูรณ์ <br> <b>*กรณีจำ วัน-เดือน ไม่ได้</b> ให้แทนที่ด้วย วัน-เดือน-ปี <br> เช่น (31-12-25xx)",
      "warning"
      );
    });
  </script>
<!-- SweetAlert2 -->

<!-- INSERT success -->
  @if(Session::get('message'))
   <?php Session::forget('message'); ?>
    <script>
      Swal.fire({
          icon: 'success',
          title: 'บันทึกข้อมูลเรียบร้อยแล้ว',
          showConfirmButton: false,
          confirmButtonColor: '#2C6700',
          timer: 1500
      })
    </script>
  @endif

  <!-- DELETE success -->
    @if(Session::get('delete_research'))
     <?php Session::forget('delete_research'); ?>
      <script>
        Swal.fire({
          icon: 'success',
          title: 'ลบข้อมูลเรียบร้อยแล้ว',
          showConfirmButton: false,
          confirmButtonColor: '#2C6700',
          timer: 1500
        })
      </script>
    @endif

    @if(Session::get('verify'))
     <?php Session::forget('verify'); ?>
      <script>
        Swal.fire({
            icon: 'success',
            title: 'การตรวจสอบถูกดำเนินการแล้ว',
            showConfirmButton: false,
            confirmButtonColor: '#2C6700',
            timer: 2000
        })
      </script>
    @endif

    @if(Session::get('notify_send'))
     <?php Session::forget('notify_send'); ?>
      <script>
        Swal.fire({
            icon: 'success',
            title: 'ท่านได้ส่งข้อความแล้ว',
            showConfirmButton: false,
            timer: 1800
        })
      </script>
    @endif

<!-- FILE INPUT -->
  <script type="text/javascript">
    $(document).ready(function () {
      bsCustomFileInput.init();
    });
  </script>
<!-- END FILE INPUT -->


<!-- DatePicker Thai -->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/i18n/datepicker-th.js"></script>
<script>
  // var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    // $('#datepicker1').datepicker({
    //     uiLibrary: 'bootstrap4',
    //     // iconsLibrary: 'fontawesome',
    //     format: 'yyyy/mm/dd',
    //     autoclose: true,
    //     todayHighlight: true,
    //     maxDate: function() {
    //       return $('#datepicker2').val();
    //     }
    // })
  $(document).ready(function() {
    $('#example55').DataTable({
      dom: 'Bfrtip',
      "ordering": false,
      buttons: [
        'excel', 'print'
      ]
    });
  });

  // DATE-Picker-Thai use Jquery
  var CurrentDate = new Date();
  CurrentDate.setYear(CurrentDate.getFullYear() + 543);

  //DatePicker_1
    $("#datepicker1").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: '+443:+543',
        dateFormat: 'dd-mm-yy',
        maxDate: CurrentDate,
        // minDate: function() {
        //   return $('#datepicker2').val();
        // }
      });
      $('#datepicker1').datepicker("setDate", CurrentDate);

  //DatePicker_2
    $("#datepicker2").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: '+443:+543',
        dateFormat: 'dd-mm-yy',
        maxDate: CurrentDate,
        // maxDate: function() {
        //   return $('#datepicker1').val();
        // }
      });
      $('#datepicker2').datepicker("setDate", CurrentDate);

  //OnSubmit Disable Button
    function disableButton() {
        var btn = document.getElementById('btn_disabled');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Loading...'
    }

      //OnSubmit Disable Button Verify
      function disableButtonVerify() {
          var btn2 = document.getElementsByClassName("btn_disabled_verify");
            for(var i=0; i<btn2.length; i++)
              {
                btn2[i].disabled = true;
                btn2[i].innerHTML = '<span class="spinner-border spinner-border-sm"></span> Loading...';
              }
      }


</script>

@stop('js-custom-script')


@section('js-custom')

<!-- DataTables -->
<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<!-- <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> -->
<!-- <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> -->
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
@stop('js-custom')
