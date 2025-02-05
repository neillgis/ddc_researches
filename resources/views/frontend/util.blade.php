@extends('layout.main')

<?php
  use App\CmsHelper as CmsHelper;
?>

@section('css-custom')
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

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
            <li class="breadcrumb-item active"> การนำไปใช้ประโยชน์ </li>
          </ol>
        </div>
      </div>
    </div>
  </div>
<!-- /.content-header -->

<!-- START CONTENT  BOX ------------------------------------------------------->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 mx-auto">
                <div class="small-box bg-red shadow">
                  <div class="inner">
                    <!-- เรียกจาก db_utilization -> โดย count id (All Record) --------->
                    <h3> {{ empty($Total_util)?'0': $Total_util }} โครงการ </h3>
                    <br>
                    <p> โครงการที่นำไปใช้ประโยชน์ทั้งหมด </p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-share-square"> </i>
                  </div>
                </div>
              </div>

              <div class="col-md-6 mx-auto">
                <div class="small-box bg-green shadow">
                  <div class="inner">
                    <!-- เรียกจาก db_utilization -> โดย count id (All Record) --------->
                    <h3> {{ empty($Total_util_verify)?'0': $Total_util_verify }} โครงการ </h3>
                    <br>
                    <p> โครงการที่นำไปใช้ประโยชน์ที่ตรวจสอบแล้ว </p>
                  </div>
                  <div class="icon">
                    <i class="fas fa-tasks"> </i>
                  </div>
                </div>
              </div>

              <div class="col-md-3 mx-auto">
                <div class="small-box bg-info shadow">
                  <div class="inner">
                    <!-- เรียกจาก db_utilization -> โดย count id -> util_type = เชิงนโยบาย --------->
                    <h3> {{ empty($Total_policy_util)?'0': $Total_policy_util }} โครงการ </h3>
                    <br>
                    <p> เชิงนโยบาย </p>
                  </div>
                  <div class="icon">
                    <i class="ion fas fa-chalkboard-teacher"></i>
                  </div>
                    <a class="one small-box-footer" href="#" id="modal">
                      คำอธิบายรายละเอียด
                      <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
              </div>


              <div class="col-md-3 mx-auto">
                <div class="small-box bg-info shadow">
                  <div class="inner">
                    <!-- เรียกจาก db_utilization -> โดย count id -> util_type = เชิงวิชาการ --------->
                    <h3> {{ empty($Total_academic_util)?'0': $Total_academic_util }} โครงการ </h3>
                    <br>
                    <p> เชิงวิชาการ </p>
                  </div>
                  <div class="icon">
                    <i class="fa fa-university"></i>
                  </div>
                    <a class="two small-box-footer" href="#" id="modal">
                      คำอธิบายรายละเอียด
                      <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
              </div>

              <div class="col-md-3 mx-auto">
                <div class="small-box bg-info shadow">
                  <div class="inner">
                    <!-- เรียกจาก db_utilization -> โดย count id -> util_type = เชิงสังคม/ชุมชน --------->
                    <h3> {{ empty($Total_social_util)?'0': $Total_social_util }} โครงการ </h3>
                    <br>
                    <p> เชิงสังคม/ชุมชน </p>
                  </div>
                  <div class="icon">
                    <i class="ion fas fa-users"></i>
                  </div>
                    <a class="three small-box-footer" href="#" id="modal">
                      คำอธิบายรายละเอียด
                      <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
              </div>

              <div class="col-md-3 mx-auto">
                <div class="small-box bg-info shadow">
                  <div class="inner">
                    <!-- เรียกจาก db_utilization -> โดย count id -> util_type = เชิงพาณิชย์ --------->
                    <h3> {{ empty($Total_commercial_util)?'0': $Total_commercial_util }} โครงการ </h3>
                    <br>
                    <p> เชิงพาณิชย์ </p>
                  </div>
                  <div class="icon">
                    <i class="ion fas fa-donate"></i>
                  </div>
                    <a class="four small-box-footer" href="#" id="modal">
                      คำอธิบายรายละเอียด
                      <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
              </div>
            </div>
            <br>
<!-- END CONTENT  BOX --------------------------------------------------------->



<!-- START FORM  INSERT ------------------------------------------------------->
      @if(Gate::allows('departments'))

      <!-- NO Show BUTTON For Departments ONLY -->

      @else

          <div class="row">
            <div class="col-md-12 mx-auto">
              <div class="card">
               <div class="card shadow" style="background-color: #ff851b;">
                <div class="card-header">
                  <h5 class="card-title"><b> เพิ่มข้อมูลการนำไปใช้ประโยชน์ </b></h5>
                </div>
              </div>

                <form method="POST" action="{{ route('util.insert') }}" enctype="multipart/form-data" onsubmit="disableButton()">
                  @csrf

                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <b><lebel for="exampleSelect1"> ชื่อโครงการ (TH-ENG) <font color="red"> * </font></lebel></b>
                            <!-- SELECT ดึงข้อมูลชื่อโครงการมาจาก -> db_research_project Table -->
                            <select class="form-control" name="pro_id" required>
                                <option value="" disabled="true" selected="true"> กรุณาเลือก </option>
                              @foreach ($form_research as $value)
                                <option value = "{{ $value->id }}"> {{ $value->pro_name_th." ".$value->pro_name_en }} </option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <b><lebel for="util_type"> ปีที่ใช้ประโยชน์ <font color="red"> * </font></lebel></b>
                                <select class="form-control" name="util_type" required>
                                    <option value="" disabled="true" selected="true" > กรุณาเลือกปีที่ใช้ประโยชน์ </option>
                                    @foreach ($form_year_util as $key => $value)
                                        <option value="{{ $value }}"> {{ $value }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <b><lebel for="util_type"> ประเภทการนำไปใช้ประโยชน์ <font color="red"> * </font></lebel></b>
                                <select class="form-control" name="util_type" required>
                                <option value="" disabled="true" selected="true" > กรุณาเลือก </option>
                                @foreach ($form_util_type as $key => $value)
                                    <option value="{{ $value }}"> {{ $value }} </option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="exampleInput1"> คำอธิบายการนำไปใช้ประโยชน์ </label>
                            <textarea class="form-control" name="util_descrip" rows="3" cols="30" placeholder="ข้อความไม่เกิน 200 ตัวอักษร"></textarea>
                          </div>
                        </div>
                      </div>

                      <div class="row" >
                        <div class="col-md-12">
                          <div class="form-group">
                          <b><lebel for="expInputFile"> อัพโหลดไฟล์ : การนำไปใช้ประโยชน์.pdf <font color="red"> * </font></lebel></b>
                              <a class="five small-box-footer" href="#" id="modal"> <b> (คำอธิบายการแนบหลักฐาน) </b></a>
                          <div class="input-group">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" name="files" required>
                              <label class="custom-file-label" for="expInputFile"> Upload File ขนาดไม่เกิน 20 MB </label>
                            </div>
                          </div>
                          </div>
                        </div>
                      </div>
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
<!-- END FORM  INSERT --------------------------------------------------------->

<!-- START TABLE LIST --------------------------------------------------------->
          <section class="content">
            <div class="card">
              <div class="card card-gray">
                <div class="card-header">
                  <h5 class="card-title"><b> โครงการที่นำไปใช้ประโยชน์ </b></h5>
                </div>
              </div>

              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-hover" style="width:100%" id="example1">
                    <thead>
                        <tr>
                          <th class="text-center"> ลำดับ </th>
                            <th class="text-center"> Util ID </th>
                            <th class="text-center"> ชื่อโครงการ </th>
                            <th class="text-center"> ปีที่เสร็จสิ้น </th>
                            <th class="text-center"> ปีที่นำไปใช้ประโยชน์ </th>
                            <th class="text-center"> การนำไปใช้ประโยชน์ </th>
                            <th class="text-center"> สถานะ </th>
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
                        @foreach ($table_util as $value)
                        <tr>
                          <td class="text-center"> {{ $i }} </td>
                          <td class="text-center"> {{ $value->id }} </td>
                          <td class="text-left"> {{ $value->pro_name_th." ".$value->pro_name_en }} </td>
                          <td class="text-center"> {{ CmsHelper::DateThai($value->pro_end_date, 'Y') }} </td>
                          <td class="text-center">
                            @if($value->util_year != NULL)
                                {{ CmsHelper::DateThai($value->util_year, 'Y')}}
                            @else
                                {{ $value->util_year != "" ? $value->util_year : '-' }}
                            @endif
                          </td>
                          <td class="text-center"> {{ $value->util_type }} </td>
                          <td class="text-center">
                            @if($value->status != NULL)
                              <span class="badge bg-info badge-pill"> {{ CmsHelper::Get_Status_Util($value->status)['status'] }} </span>
                            @else
                              {{ $value->status != "" ? $value->status : '-' }}
                            @endif
                          </td>

                        @if(Gate::allows('manager'))
                          <td class="text-center"> {{ $value->users_name }} </td>
                          <td class="text-center"> {{ $value->deptName }} </td>
                        @endif
                          <td class="text-center">
                              @if($value->verified == "1")
                                <span class="badge bg-secondary badge-pill"><i class="fas fa-check-circle"></i> {{ $verified_list [ $value->verified ] }} </span>
                              @elseif($value->verified == "2")
                                <span class="badge bg-warning badge-pill"> {{ $verified_list [ $value->verified ] }} </span>
                              @elseif($value->verified == "3")
                                 <span class="badge badge-pill" style="background-color: #ff851b;"> {{ $verified_list [ $value->verified ] }} </span>
                              @elseif($value->verified == "9")
                                 <span class="badge bg-info badge-pill"><i class="fas fa-times-circle"></i> {{ $verified_list [ $value->verified ] }} </span>
                              @else <!-- verified == "1" คือ รอตรวจสอบ [Default] -->
                                 <span class="badge bg-danger badge-pill"> รอตรวจสอบ </span>
                              @endif
                          </td>

                        @if(Gate::allows('departments'))
                          <!-- Show SOME_BUTTON For Departments ONLY -->
                          <td class="text-center"> {{ $value->fname." ".$value->lname }} </td>

                          <td class="td-actions text-right text-nowrap" href="#">
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-cog"></i></button>
                                <div class="dropdown-menu" role="menu">
                                <!-- DOWNLOAD new -->
                                    <a class="dropdown-item" href="{{ route('DownloadFile.util', ['id' => $value->id, 'files' => $value->files]) }}" title="Download">
                                      <i class="fas fa-arrow-alt-circle-down"></i>&nbsp; Download
                                    </a>

                                    <div class="dropdown-divider"></div>

                                <!-- VERIFIED -->
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-default-util{{ $value->id }}" title="Status & Verfied">
                                      <i class="fas fa-user-check"></i>&nbsp; Verified
                                    </a>
                                </div>
                            </div>
                          </td>

                        @else

                          <!-- BUTTON TOTAL -->
                          <td class="td-actions text-right text-nowrap" href="#">

                            @if(Gate::allows('manager'))
                              <div class="btn-group">
                                  <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-cog"></i></button>
                                  <div class="dropdown-menu" role="menu">
                                  <!-- DOWNLOAD new -->
                                      <a class="dropdown-item" href="{{ route('DownloadFile.util', ['id' => $value->id, 'files' => $value->files]) }}" title="Download">
                                        <i class="fas fa-arrow-alt-circle-down"></i>&nbsp; Download
                                      </a>

                                      <div class="dropdown-divider"></div>

                                  <!-- EDIT new -->
                                      <a class="dropdown-item" href="{{ route('util.edit', $value->id) }}" title="Edit">
                                        <i class="fas fa-edit"></i>&nbsp; Edit
                                      </a>

                                      <div class="dropdown-divider"></div>

                                  <!-- VERIFIED -->
                                      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-default-util{{ $value->id }}" title="Status & Verfied">
                                        <i class="fas fa-user-check"></i>&nbsp; Status & Verified
                                      </a>

                                      <div class="dropdown-divider"></div>

                                  <!-- DELETE -->
                                      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#DeleteModalUtil{{ $value->id }}" title="Delete">
                                        <i class="fas fa-trash-alt"></i>&nbsp; Delete
                                      </a>

                                  @if($value->verified == "2" || $value->verified == "3" || $value->verified == "9")

                                      <div class="dropdown-divider"></div>

                                  <!-- COMMENTS -->
                                      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#CommentUtil{{ $value->id }}" title="Comments">
                                        <i class="far fa-comment-dots"></i>&nbsp; Comments
                                      </a>
                                  @endif

                                  </div>
                              </div>
                            @endif
                        @endif


                        <!-- Download & Edit & Comments & Delete -->
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
                                  <a href="{{ route('DownloadFile.util', ['id' => $value->id, 'files' => $value->files]) }}">
                                    <button type="button" class="btn btn-outline-primary btn-md" data-toggle="tooltip" title="Download">
                                      <i class="fas fa-arrow-alt-circle-down"></i>
                                    </button>
                                  </a>
                                @endif

                                <!-- Comments -->
                                @if($value->verified == "2" || $value->verified == "3" || $value->verified == "9")
                                    <button type="button" class="btn btn-outline-info btn-md" title="Comments" data-toggle="modal" data-target="#CommentUtil{{ $value->id }}">
                                      <i class="far fa-comment-dots"></i>
                                    </button>
                                @endif

                                <!-- Edit -->
                                @if($value->verified == "1")
                                  <button type="button" class="btn btn-secondary btn-md" data-toggle="tooltip" title="Edit" disabled>
                                    <i class="fas fa-edit"></i>
                                  </button>
                                @else
                                  <a href="{{ route('util.edit', $value->id) }}">
                                    <button type="button" class="btn btn-outline-warning btn-md" data-toggle="tooltip" title="Edit">
                                      <i class="fas fa-edit"></i>
                                    </button>
                                  </a>
                                @endif

                                <!-- Delete -->
                                @if($value->verified == "1")
                                    <button type="button" class="btn btn-secondary btn-md" title="Delete" data-toggle="tooltip" disabled>
                                      <i class="fas fa-trash-alt"></i>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-outline-danger btn-md" title="Delete" data-toggle="modal" data-target="#DeleteModalUtil{{ $value->id }}">
                                      <i class="fas fa-trash-alt"></i>
                                    </button>
                                  <!-- END Delete button -->
                                @endif

                            @endif
                        <!-- Download & Edit & Comments & Delete -->

                          </td>


                          <!-- MODAL Delete -->
                            <div class="modal fade" id="DeleteModalUtil{{ $value->id }}">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                  <div class="modal-body">
                                    <br>
                                      <img class="mx-auto d-block" src="{{ asset('img/exclamation.png') }}" alt="exclamation" style="width:90px;">
                                    <br>
                                      <h2 class="text-center"> ต้องการลบรายการนี้ใช่ไหม ? <br> </h2>
                                      <h5 class="text-center"> Util ID. [ <font color = "red"> {{ $value->id }} </font> ]  </h5>
                                    <br>
                                    <div class="text-center">
                                      <!-- Cancel -->
                                        <button type="button" class="btn btn-danger" data-dismiss="modal" role="button" aria-disabled="true">
                                          <i class="fas fa-times-circle"></i> Cancel
                                        </button>
                                      <!-- Confirms -->
                                      <a href="{{ route('util.delete',['id' => $value->id]) }}">
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
                            <div class="modal fade" id="CommentUtil{{ $value->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h4 class="modal-title"><b><i class="far fa-comment-dots"></i> Comments</b> (Util ID. <font color="red">{{ $value->id }}</font>) </h4>
                                  </div>

                              @if(Gate::allows('manager'))
                                <form action="{{ route('util.comments') }}" method="POST" enctype="multipart/form-data" onsubmit="disableButtonVerify()">
                                  @csrf
                                      <!-- HIDDEN Data -->
                                      <input type="hidden" name="projects_id" value="{{ $value->id }}">
                                      <input type="hidden" name="subject" value="{{ $value->verified }}">
                                      <input type="hidden" name="receiver_id" value="{{ $value->users_id }}">
                                      <input type="hidden" name="receiver_name" value="{{ $value->users_name }}">

                              @else <!-- USERS Only -->

                                <form action="{{ route('util.comments_users') }}" method="POST" enctype="multipart/form-data" onsubmit="disableButtonVerify()">
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
                                          <label> อัพโหลดไฟล์ </label>
                                          <div class="input-group">
                                            <div class="custom-file">
                                              <input type="file" class="custom-file-input" name="files_upload">
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


                          <!-- MODAL Verify & Status -->
                            <div class="modal fade" id="modal-default-util{{ $value->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h4 class="modal-title"><b>การตรวจสอบ</b> (Util ID. <font color="red">{{ $value->id }}</font>) </h4>
                                  </div>

                                  <form action="{{ route('util.verified') }}" method="POST" onsubmit="disableButtonVerify()">
                                  @csrf

                                  <div class="modal-body">
                                    <div class="row">
                                      <div class="col-md-12">
                                        <!-- hidden = id -->
                                        <input type="hidden" class="form-control" name="id" value="{{ $value->id }}">

                                        @if(Gate::allows('manager'))
                                            <label> สถานะการนำไปใช้ประโยชน์ </label>
                                              <select class="form-control" name="status">
                                                  <option value="" selected="true" disabled="true"> -- กรุณาเลือก -- </option>
                                                @foreach ($status as $value)
                                                  <option value="{{ $value->id }}"> {{ $value->util_status }} </option>
                                                @endforeach
                                              </select>
                                            <br>
                                            <label> การตรวจสอบ </label>
                                              <select class="form-control" name="verified" >
                                                  <option value="" selected="true" disabled="true"> -- กรุณาเลือก -- </option>
                                                @foreach ($verified_list as $key => $value)
                                                  <option value="{{ $key }}" {{ $verified_list == $key ? 'selected' : '' }}> {{ $value }} </option>
                                                @endforeach
                                              </select>
                                        @elseif(Gate::allows('departments'))
                                              <select class="form-control" name="verified" >
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
                          <!-- END MODAL Verify & Status -->

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
          </div>
      </section>
<!-- END TABLE LIST ----------------------------------------------------------->
@stop('contents')


@section('js-custom-script')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script type="text/javascript">
  document.querySelector(".one").addEventListener('click', function(){
    Swal.fire("การนำไปใช้ประโยชน์เชิงนโยบาย",
    "หมายถึง พิจารณาจากการมีหลักฐานการนำข้อมูลไปประกอบการตัดสินใจในการบริหาร/กำหนดนโยบาย"
    );
  });
</script>

<script type="text/javascript">
  document.querySelector(".two").addEventListener('click', function(){
    Swal.fire("การนำไปใช้ประโยชน์เชิงวิชาการ",
    "หมายถึง พิจารณาจากการถูกอ้างอิงในวารสารใน/หรือต่างประเทศ (citation)* การนำไปอ้างอิงในการจัดทำหนังสือ หรือรายงานของหน่วยงานระดับกรม การนำไปอ้างอิงของหน่วยงานในระดับรัฐวิสาหกิจ/บริษัทมหาชน การได้รับหนังสือเรียนเชิญเป็นวิทยากรเพื่อให้ความรู้ในกรอบของผลงานวิจัยจากหน่วยงานต่าง ๆ"
    );
  });
</script>

<script type="text/javascript">
  document.querySelector(".three").addEventListener('click', function(){
    Swal.fire("การนำไปใช้ประโยชน์เชิงสังคม/ชุมชน",
    "หมายถึง พิจารณาจากการมีหลักฐานการถ่ายทอดเทคโนโลยีที่ได้จากงานวิจัยในชุมชน/ท้องถิ่นได้รับหนังสือเรียนเชิญให้ความรู้จากชุมชน/องค์กร/หน่วยงานในพื้นที่ต่าง ๆ"
    );
  });
</script>

<script type="text/javascript">
  document.querySelector(".four").addEventListener('click', function(){
    Swal.fire("การนำไปใช้ประโยชน์เชิงพาณิชย์",
    "หมายถึง พิจารณาจากการมีหลักฐานการเจรจาทางธุรกิจ ไม่นับการยื่น/จดทะเบียนคุ้มครองทรัพย์สินทางปัญญา"
    );
  });
</script>

<script type="text/javascript">
  document.querySelector(".five").addEventListener('click', function(){
    Swal.fire("การนำไปใช้ประโยชน์",
    "• เชิงนโยบาย หมายถึง พิจารณาจากการมีหลักฐานการนำข้อมูลไปประกอบการตัดสินใจในการบริหาร/กำหนดนโยบาย <br> <br> • เชิงวิชาการ หมายถึง พิจารณาจากการถูกอ้างอิงในวารสารใน/หรือต่างประเทศ (citation)* การนำไปอ้างอิงในการจัดทำหนังสือ หรือรายงานของหน่วยงานระดับกรม การนำไปอ้างอิงของหน่วยงานในระดับรัฐวิสาหกิจ/บริษัทมหาชน การได้รับหนังสือเรียนเชิญเป็นวิทยากรเพื่อให้ความรู้ในกรอบของผลงานวิจัยจากหน่วยงานต่าง ๆ <br> <br> • เชิงชุมชน/สังคม หมายถึง พิจารณาจากการมีหลักฐานการถ่ายทอดเทคโนโลยีที่ได้จากงานวิจัยในชุมชน/ท้องถิ่นได้รับหนังสือเรียนเชิญให้ความรู้จากชุมชน/องค์กร/หน่วยงานในพื้นที่ต่าง ๆ <br> <br> • เชิงพาณิชย์ หมายถึง พิจารณาจากการมีหลักฐานการเจรจาทางธุรกิจ ไม่นับการยื่น/จดทะเบียนคุ้มครองทรัพย์สินทางปัญญา",
    // "warning"
    );
  });
</script>

@if(Session::get('message'))
 <?php Session::forget('message'); ?>
  <script>
    Swal.fire({
        icon: 'success',
        title: 'บันทึกข้อมูลเรียบร้อยแล้ว',
        showConfirmButton: false,
        timer: 2000
    })
  </script>
@endif
<!-- END ALERT บันทึกข้อมูลสำเร็จ  -->

<!-- DELETE success -->
  @if(Session::get('delete_util'))
   <?php Session::forget('delete_util'); ?>
    <script>
      Swal.fire({
        icon: 'success',
        title: 'ลบข้อมูลเรียบร้อยแล้ว',
        showConfirmButton: false,
        confirmButtonColor: '#2C6700',
        timer: 2000
      })
    </script>
  @endif
<!-- END DELETE success -->

<!-- STATUS -->
@if(Session::get('status_util'))
 <?php Session::forget('status_util'); ?>
  <script>
    Swal.fire({
        icon: 'success',
        title: 'แก้ไขข้อมูลเรียบร้อยแล้ว',
        showConfirmButton: false,
        confirmButtonColor: '#2C6700',
        timer: 2000
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
        timer: 2500
    })
  </script>
@endif

@if(Session::get('Noverify'))
 <?php Session::forget('Noverify'); ?>
  <script>
    Swal.fire({
        icon: 'warning',
        title: 'Unverified Successfully',
        text: 'รายการนี้ยังไม่ได้รับการตรวจสอบอีกครั้ง',
        showConfirmButton: false,
        confirmButtonColor: '#d33',
        timer: 2500
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

<script>
//FILE INPUT
  $(document).ready(function () {
    bsCustomFileInput.init();
  });

//REPORT FILE
  $(document).ready(function() {
    $('#example1').DataTable({
      dom: 'Bfrtip',
      "ordering": false,
      buttons: [
        'excel', 'print'
      ]
    });
  });

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
                // alert(theOddOnes[i].innerHTML);
            }
    }

    //Date Input
    var CurrentDate = new Date();
    CurrentDate.setYear(CurrentDate.getFullYear() + 543);

</script>
@stop('js-custom-script')


@section('js-custom')
<!-- DataTables -->
<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
@stop('js-custom')
