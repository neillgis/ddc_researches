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

<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/>

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
<section class="content">
  <div class="container-fluid">

<!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active"> ข้อมูลการตีพิมพ์วารสาร </li>
          </ol>
        </div>
      </div>
    </div>
  </div>
<!-- /.content-header -->

    <!-- START SUMMARY Total Box -->
      <div class="row">
        <div class="col-md-4 mx-auto">
          <div class="small-box bg-danger mx-auto shadow">
            <div class="inner">
              <h3> {{ empty($Total_journal)?'0': $Total_journal }} บทความ </h3>
              <br>
              <p> ตีพิมพ์วารสารทั้งหมด </p>
            </div>
            <div class="icon">
              <i class="fas fa-book-reader"></i>
            </div>
          </div>
        </div>

        <div class="col-md-4 mx-auto">
          <div class="small-box bg-green mx-auto shadow">
            <div class="inner">
              <h3> {{ empty($Total_journal_verify)?'0': $Total_journal_verify }} บทความ </h3>
              <br>
              <p> ตีพิมพ์วารสารที่ตรวจสอบแล้ว </p>
            </div>
            <div class="icon">
              <i class="fas fa-microscope"></i>
            </div>
            <!-- <a class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
          </div>
        </div>

        <div class="col-md-4 mx-auto">
          <div class="small-box bg-info mx-auto shadow">
            <div class="inner">
              <h3> {{ empty($Total_master_jour)?'0': $Total_master_jour }} บทความ </h3>
              <br>
              <p> วารสารที่เป็นผู้นิพนธ์หลัก </p>
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



  <!-- START From Input JOURNAL PROJECT -------------------------------------------------->
<section class="content">
  <div class="container-fluid">

  @if(Auth::hasRole('departments'))

    <!-- NO Show BUTTON For Departments ONLY -->

  @else

    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card shadow" style="background-color: #ff851b;">
            <div class="card-header">
              <h5 class="card-title"><b> เพิ่มข้อมูลการตีพิมพ์วารสาร </b></h5>
            </div>
          </div>

            <!-- <form role="form"> -->
            <form method="POST" action="{{ route('journal.insert') }}" enctype="multipart/form-data" onsubmit="disableButton()">
             @csrf

              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInput1"> ชื่อบทความ (TH) </label>
                      <input type="text" class="form-control" name="article_name_th" >
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInput1"> ชื่อบทความ (ENG) </label>
                      <input type="text" class="form-control" name="article_name_en">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInput1"> ชื่อวารสาร (TH) </label>
                      <input type="text" class="form-control" name="journal_name_th" >
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInput1"> ชื่อวารสาร (ENG) </label>
                      <input type="text" class="form-control" name="journal_name_en">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInput1"> ปีที่พิมพ์ (Year) <font color="red"> * </font></label>
                        <div class="input-group date">
                              <input type="text" class="form-control datetimepicker-input" placeholder="กรุณาเลือกเป็นปี ค.ศ." name="publish_years"
                                     id="datepicker4" autocomplete="off" required readonly>
                             <div class="input-group-append" >
                               <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                             </div>
                         </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInput1"> ฉบับที่ (Issue) <font color="red"> * </font></label>
                      <input type="text" class="form-control" name="publish_no" maxlength="2"
                             onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลขเท่านั้น !'); this.value='';}" required>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInput1"> เล่มที่ (Volume) <font color="red"> * </font></label>
                      <input type="text" class="form-control" name="publish_volume" maxlength="3"
                             onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลขเท่านั้น !'); this.value='';}" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInput1"> หน้าแรก (First Page) <font color="red"> * </font></label>
                      <input type="text" class="form-control" placeholder="xxxx" name="publish_firstpage" maxlength="4"
                             onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลขเท่านั้น !'); this.value='';}" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInput1"> หน้าสุดท้าย (Last Page) <font color="red"> * </font></label>
                      <input type="text" class="form-control" placeholder="xxxx" name="publish_lastpage" maxlength="4"
                             onKeyUp="if(isNaN(this.value)){ alert('กรุณากรอกตัวเลขเท่านั้น !'); this.value='';}" required>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInput1"> เลข DOI (ถ้ามี) </label>
                      <input type="text" class="form-control" name="doi_number">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleSelect1"> การมีส่วนร่วมในบทความ <font color="red"> * </font></label>
                      <!-- SELECT option ดึงมาจาก ARRAY->contribute -->
                      <select class="form-control" name="contribute" required>
                        <option value="" disabled="true" selected="true" >กรุณาเลือก</option>
                        @foreach ($contribute as $key => $value)
                          <option value="{{ $key }}"> {{ $value }} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleSelect1"> ท่านเป็นผู้รับผิดชอบบทความ (Correspondence) <font color="red"> * </font></label>
                      <!-- SELECT option ดึงมาจาก ARRAY->corres -->
                      <select class="form-control" name="corres" required>
                        <option value="" disabled="true" selected="true" >กรุณาเลือก</option>
                        @foreach ($corres_sl as $key => $value)
                          <option value="{{ $key }}"> {{ $value }} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="exampleSelect1"> บทความนี้เป็นผลจากโครงการวิจัย <font color="red"> * </font></label>
                      <!-- SELECT Table -> db_research_project -->
                      <select class="form-control" name="pro_id" required>
                          <option value="" disabled="true" selected="true"> -- กรุณาเลือก -- </option>
                          <option value=""> ไม่ได้มาจากโครงการวิจัย </option>
                        @foreach ($journal_res as $value)
                          <option value = "{{ $value->id }}"> {{ $value->pro_name_en }} {{ $value->pro_name_th }} </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <!-- URL ที่อยู่ออนไลน์ของบทความ -->
                <div class="row" >
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="exampleInput1"> URL ที่อยู่ออนไลน์ของบทความ (ถ้ามี) </label>
                      <input type="text" class="form-control" name="url_journal">
                    </div>
                  </div>
                </div>

                <div class="row" >
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="expInputFile"> อัพโหลดไฟล์ : บทคัดย่อ (Abstracts).pdf <font color="red"> * </font></label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" name="files" required>
                          <label class="custom-file-label" for="expInputFile"> Upload File ขนาดไม่เกิน 10 MB </label>
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
  <!-- END From Input JOURNAL PROJECT -------------------------------------------------->



  <!-- START TABLE -> JOURNAL PROJECT -------------------------------------------------->

        <div class="card">
          <div class="card card-secondary shadow">
            <div class="card-header">
              <h3 class="card-title"> บทความที่ตีพิมพ์แล้ว </h3>
            </div>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover" id="example44">
                <thead>
                    <tr>
                      <th class="text-center"> ลำดับ </th>
                      <th class="text-center"> Project ID </th>
                      <th> ชื่อบทความ (ENG) </th>
                      <th> ชื่อวารสาร (ENG) </th>
                      <th class="text-center"> ตีพิมพ์ </th>
                      <th class="text-center"> ระดับ </th>
                    @if(Auth::hasRole('manager'))
                      <th class="text-center"> ชื่อ/สกุล </th>
                      <th class="text-center"> หน่วยงาน </th>
                    @endif
                      <th class="text-center"> การตรวจสอบ </th>
                    @if(Auth::hasRole('departments'))
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
                  @foreach ($journals as $value)
                  <tr>
                    <td class="text-center"> {{ $i }} </td>
                    <td class="text-center"> {{ $value->pro_id }} </td>
                    <td> {{ $value->article_name_en }} </td>
                    <td> {{ $value->journal_name_en }} </td>
                    <td class="text-center"> {{ $value->publish_years }} </td>
                    <td class="text-center">
                      @if($value->status != NULL)
                        <span class="badge bg-info badge-pill"> {{ CmsHelper::Get_Status($value->status)['status'] }} </span>
                      @else
                        {{ $value->status != "" ? $value->status : '-' }}
                      @endif
                    </td>
                  @if(Auth::hasRole('manager'))
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

                  @if(Auth::hasRole('departments'))

                    <!-- Show SOME_BUTTON For Departments ONLY -->
                    <td class="text-center"> {{ $value->fname." ".$value->lname }} </td>

                    <!-- ACTIONS Button for Departments -->
                    <td class="td-actions text-right text-nowrap" href="#">
                      <div class="btn-group">
                        <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-cog"></i></button>
                          <div class="dropdown-menu" role="menu">
                            <!-- DOWNLOAD new-->
                                <a class="dropdown-item" href="{{ route('DownloadFile.journal', ['id' => $value->id, 'files' => $value->files]) }}" title="Download">
                                  <i class="fas fa-arrow-alt-circle-down"></i>&nbsp; Download
                                </a>

                              <div class="dropdown-divider"></div>

                            <!-- VERIFIED -->
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-default{{ $value->id }}" title="Status & Verfied">
                                  <i class="fas fa-user-check"></i>&nbsp; Verified
                                </a>
                          </div>
                      </div>
                    </td>

                  @else
                      <!-- BUTTON TOTAL -->
                      <td class="td-actions text-center text-nowrap" href="#">

                        @if(Auth::hasRole('manager'))
                          <div class="btn-group">
                            <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-cog"></i></button>
                              <div class="dropdown-menu" role="menu">

                              <!-- DOWNLOAD new-->
                                  <a class="dropdown-item" href="{{ route('DownloadFile.journal', ['id' => $value->id, 'files' => $value->files]) }}" title="Download">
                                    <i class="fas fa-arrow-alt-circle-down"></i>&nbsp; Download
                                  </a>

                                  <div class="dropdown-divider"></div>

                              <!-- EDIT new -->
                              @if($value->pro_id == NULL)
                                  <a class="dropdown-item" href="{{ route('journal.edit2', ['id' => $value->id]) }}" title="Edit">
                                    <i class="fas fa-edit"></i>&nbsp; Edit
                                  </a>
                              @else
                                  <a class="dropdown-item" href="{{ route('journal.edit', ['id' => $value->id, 'pro_id' => $value->pro_id]) }}" title="Edit">
                                    <i class="fas fa-edit"></i>&nbsp; Edit
                                  </a>
                              @endif

                                  <div class="dropdown-divider"></div>

                              <!-- VERIFIED -->
                                  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-default{{ $value->id }}" title="Status & Verfied">
                                    <i class="fas fa-user-check"></i>&nbsp; Status & Verified
                                  </a>

                                  <div class="dropdown-divider"></div>

                              <!-- DELETE -->
                                  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#DeleteJournal{{ $value->id }}" title="Delete">
                                    <i class="fas fa-trash-alt"></i>&nbsp; Delete
                                  </a>

                              @if($value->verified == "2" || $value->verified == "3" || $value->verified == "9")

                                  <div class="dropdown-divider"></div>

                              <!-- COMMENTS -->
                                  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#CommentJournal_1{{ $value->id }}" title="Comments">
                                    <i class="far fa-comment-dots"></i>&nbsp; Comments
                                  </a>
                              @endif

                              </div>
                          </div>
                        @endif
                  @endif



                  <!-- Download & Edit -->
                      @if(Auth::hasRole('manager'))
                          <!-- NO Show BUTTON For USER ONLY -->
                      @elseif(Auth::hasRole('departments'))
                          <!-- NO Show BUTTON For USER ONLY -->
                      @else

                          <!-- Download -->
                          @if($value->verified == "1")
                            <button type="button" class="btn btn-secondary btn-md" data-toggle="tooltip" title="Download" disabled>
                              <i class="fas fa-arrow-alt-circle-down"></i>
                            </button>
                          @else
                            <a href=" {{ route('DownloadFile.journal', ['id' => $value->id, 'files' => $value->files]) }} ">
                              <button type="button" class="btn btn-primary btn-md" data-toggle="tooltip" title="Download">
                                <i class="fas fa-arrow-alt-circle-down"></i>
                              </button>
                            </a>
                          @endif

                          <!-- Comments -->
                          @if($value->verified == "2" || $value->verified == "3" || $value->verified == "9")
                              <button type="button" class="btn btn-outline-info btn-md" title="Comments" data-toggle="modal" data-target="#CommentJournal_1{{ $value->id }}">
                                <i class="far fa-comment-dots"></i>
                              </button>
                          @endif

                          <!-- Edit -->
                          @if($value->verified == "1" || $value->verified == "2" || $value->verified == "3" || $value->verified == "9")
                            <button type="button" class="btn btn-secondary btn-md" data-toggle="tooltip" title="Edit" disabled>
                              <i class="fas fa-edit"></i>
                            </button>
                          @elseif($value->pro_id == NULL)
                            <a href=" {{ route('journal.edit2', ['id' => $value->id]) }} ">
                              <button type="button" class="btn btn-warning btn-md" data-toggle="tooltip" title="Edit">
                                <i class="fas fa-edit"></i>
                              </button>
                            </a>
                          @else
                            <a href=" {{ route('journal.edit', ['id' => $value->id, 'pro_id' => $value->pro_id]) }} ">
                              <button type="button" class="btn btn-warning btn-md" data-toggle="tooltip" title="Edit">
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
                              <button type="button" class="btn btn-danger btn-md" title="Delete" data-toggle="modal" data-target="#DeleteJournal{{ $value->id }}">
                                <i class="fas fa-trash-alt"></i>
                              </button>
                          @endif

                      @endif
                  <!-- Download & Edit & Comments -->

                    </td>


                    <!-- MODAL Delete -->
                      <div class="modal fade" id="DeleteJournal{{ $value->id }}">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-body">
                              <br>
                                <img class="mx-auto d-block" src="{{ asset('img/exclamation.png') }}" alt="exclamation" style="width:90px;">
                              <br>
                                <h2 class="text-center"> ต้องการลบรายการนี้ใช่ไหม ? <br> </h2>
                                <h5 class="text-center"> Project ID. [ <font color = "red"> {{ $value->pro_id }} </font> ]  </h5>
                              <br>
                              <div class="text-center">
                                <!-- Cancel -->
                                  <button type="button" class="btn btn-danger" data-dismiss="modal" role="button" aria-disabled="true">
                                    <i class="fas fa-times-circle"></i> Cancel
                                  </button>
                                <!-- Confirms -->
                                <a href="{{ route('journal.delete',['id' => $value->id]) }}">
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
                      <div class="modal fade" id="CommentJournal_1{{ $value->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title"><b><i class="far fa-comment-dots"></i> Comments</b> (Project ID. <font color="red">{{ $value->pro_id }}</font>) </h4>
                            </div>

                        @if(Auth::hasRole('manager'))
                          <form action="{{ route('journal.comments') }}" method="POST" enctype="multipart/form-data" onsubmit="disableButtonVerify()">
                            @csrf
                                <!-- HIDDEN Data -->
                                <input type="hidden" name="projects_id" value="{{ $value->id }}">
                                <input type="hidden" name="pro_id" value="{{ $value->pro_id }}">
                                <input type="hidden" name="subject" value="{{ $value->verified }}">
                                <input type="hidden" name="receiver_id" value="{{ $value->users_id }}">
                                <input type="hidden" name="receiver_name" value="{{ $value->users_name }}">

                        @else <!-- USERS Only -->

                          <form action="{{ route('journal.comments_users') }}" method="POST" enctype="multipart/form-data" onsubmit="disableButtonVerify()">
                            @csrf
                                <!-- HIDDEN Data -->
                                <input type="hidden" name="projects_id" value="{{ $value->id }}">
                                <input type="hidden" name="pro_id" value="{{ $value->pro_id }}">
                                <input type="hidden" name="subject" value="{{ $value->verified }}">
                        @endif

                            <div class="modal-body">
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <textarea class="form-control" name="description" rows="3" cols="100" placeholder="ข้อเสนอแนะ/คำแนะนำ"></textarea>
                                  </div>
                                </div>

                              @if(Auth::hasRole('manager'))
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
                      <div class="modal fade" id="modal-default{{ $value->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title"><b>การตรวจสอบ</b> (Project ID. <font color="red">{{ $value->pro_id }}</font>) </h4>
                            </div>

                          <form action="{{ route('journal.verified') }}" method="POST" onsubmit="disableButtonVerify()">
                            @csrf

                            <div class="modal-body">
                              <div class="row">
                                <div class="col-md-12">
                                  <!-- hidden = id -->
                                  <input type="hidden" class="form-control" name="id" value="{{ $value->id }}">

                                  @if(Auth::hasRole('manager'))
                                      <label> ระดับของวารสาร </label>
                                      <select class="form-control" name="status" >
                                          <option value="" selected="true" disabled="true"> -- กรุณาเลือก -- </option>
                                        @foreach ($status as $value)
                                          <option value="{{ $value->id }}"> {{ $value->journal_status }} </option>
                                        @endforeach
                                      </select>
                                      <br>
                                      <label> การตรวจสอบ </label>
                                      <select class="form-control" name="verified">
                                          <option value="" selected="true" disabled="true"> -- กรุณาเลือก -- </option>
                                        @foreach ($verified_list as $key => $value)
                                          <option value="{{ $key }}" {{ $verified_list == $key ? 'selected' : '' }}> {{ $value }} </option>
                                        @endforeach
                                      </select>
                                  @elseif(Auth::hasRole('departments'))
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
  <!-- END TABLE -> JOURNAL PROJECT -------------------------------------------------->


<br>


  @if(Auth::hasRole('manager'))
    <!-- START TABLE -> JOURNAL (** กรณี ไม่ได้มาจากโครงการวิจัย) -------------------------------------------------->
        <div class="card">
          <div class="card card-secondary shadow">
            <div class="card-header">
              <h3 class="card-title"><b> บทความที่ตีพิมพ์แล้ว <font color="orange">( กรณี ไม่ได้มาจากโครงการวิจัย )</font></b></h3>
            </div>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover" id="example55">
                <thead>
                    <tr>
                      <th class="text-center"> ลำดับ </th>
                      <th> ชื่อบทความ (ENG) </th>
                      <th> ชื่อวารสาร (ENG) </th>
                      <th class="text-center"> ตีพิมพ์ </th>
                      <th class="text-center"> ระดับ </th>
                    @if(Auth::hasRole('manager'))
                      <th class="text-center"> ชื่อ/สกุล </th>
                      <th class="text-center"> หน่วยงาน </th>
                    @endif
                      <th class="text-center"> การตรวจสอบ </th>
                      <th class="text-right"> Actions </th>
                    </tr>
                </thead>

                <tbody>
                  @php
                      $i = 1;
                  @endphp
                  @foreach ($not_from_project as $value)
                  <tr>
                    <td class="text-center"> {{ $value->id }} </td>
                    <td> {{ $value->article_name_en }} </td>
                    <td> {{ $value->journal_name_en }} </td>
                    <td class="text-center"> {{ $value->publish_years }} </td>
                    <td class="text-center">
                      @if($value->status != NULL)
                        <span class="badge bg-info badge-pill"> {{ CmsHelper::Get_Status($value->status)['status'] }} </span>
                      @else
                        {{ $value->status != "" ? $value->status : '-' }}
                      @endif
                    </td>
                  @if(Auth::hasRole('manager'))
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

                    <!-- Download button -->
                    <td class="td-actions text-right text-nowrap" href="#">

                      @if(Auth::hasRole('manager'))
                        <div class="btn-group">
                          <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"><i class="fas fa-cog"></i></button>
                            <div class="dropdown-menu" role="menu">
                            <!-- DOWNLOAD old -->
                          <!-- {{-- @if($value->verified == "1" || $value->verified == "9")
                                <a class="dropdown-item disabled" href="#" title="Download">
                                  <i class="fas fa-arrow-alt-circle-down"></i>&nbsp; Download
                                </a>
                            @else
                                <a class="dropdown-item" href="{{ route('DownloadFile.journal', ['id' => $value->id, 'files' => $value->files]) }}" title="Download">
                                  <i class="fas fa-arrow-alt-circle-down"></i>&nbsp; Download
                                </a>
                            @endif --}} -->

                            <!-- DOWNLOAD old -->
                                <a class="dropdown-item" href="{{ route('DownloadFile.journal', ['id' => $value->id, 'files' => $value->files]) }}" title="Download">
                                  <i class="fas fa-arrow-alt-circle-down"></i>&nbsp; Download
                                </a>
                            <!-- END DOWNLOAD -->

                                <div class="dropdown-divider"></div>

                              <!-- EDIT old For NO-pro_id -->
                          <!-- {{-- @if($value->verified == "1" || $value->verified == "2" || $value->verified == "3" || $value->verified == "9")
                                <a class="dropdown-item disabled" href="#" title="Edit">
                                  <i class="fas fa-edit"></i>&nbsp; Edit
                                </a>
                            @elseif($value->pro_id == NULL)
                                <a class="dropdown-item" href="{{ route('journal.edit2', ['id' => $value->id]) }}" title="Edit">
                                  <i class="fas fa-edit"></i>&nbsp; Edit
                                </a>
                            @else
                                <a class="dropdown-item" href="{{ route('journal.edit', ['id' => $value->id, 'pro_id' => $value->pro_id]) }}" title="Edit">
                                  <i class="fas fa-edit"></i>&nbsp; Edit
                                </a>
                            @endif --}} -->

                            <!-- EDIT new For NO-pro_id -->
                            @if($value->pro_id == NULL)
                                <a class="dropdown-item" href="{{ route('journal.edit2', ['id' => $value->id]) }}" title="Edit">
                                  <i class="fas fa-edit"></i>&nbsp; Edit
                                </a>
                            @else
                                <a class="dropdown-item" href="{{ route('journal.edit', ['id' => $value->id, 'pro_id' => $value->pro_id]) }}" title="Edit">
                                  <i class="fas fa-edit"></i>&nbsp; Edit
                                </a>
                            @endif
                            <!-- END EDIT -->

                                <div class="dropdown-divider"></div>

                            <!-- VERIFIED -->
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-default{{ $value->id }}" title="Status & Verfied">
                                  <i class="fas fa-user-check"></i>&nbsp; Status & Verified
                                </a>
                            <!-- END VERIFIED -->

                                <div class="dropdown-divider"></div>

                            <!-- DELETE -->
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#DeleteJournal{{ $value->id }}" title="Delete">
                                  <i class="fas fa-trash-alt"></i>&nbsp; Delete
                                </a>
                            <!-- END DELETE -->
                            </div>
                        </div>
                      @endif



                  <!-- Download & Edit -->
                      @if(Auth::hasRole('manager'))
                          <!-- NO Show BUTTON For USER ONLY -->
                      @elseif(Auth::hasRole('departments'))
                          <!-- NO Show BUTTON For USER ONLY -->
                      @else

                          <!-- Download button -->
                              <!-- {{-- @if(Auth::hasRole('manager') || Auth::hasRole('user')) --}} -->
                          @if($value->verified == "1" || $value->verified == "9")
                            <button type="button" class="btn btn-secondary btn-md" data-toggle="tooltip" title="Edit" disabled>
                              <i class="fas fa-arrow-alt-circle-down"></i>
                            </button>
                          @else
                            <a href=" {{ route('DownloadFile.journal', ['id' => $value->id, 'files' => $value->files]) }} ">
                              <button type="button" class="btn btn-primary btn-md" data-toggle="tooltip" title="Download">
                                <i class="fas fa-arrow-alt-circle-down"></i>
                              </button>
                            </a>
                          @endif


                          <!-- Edit button -->
                          @if($value->verified == "1" || $value->verified == "2" || $value->verified == "3" || $value->verified == "9")
                            <button type="button" class="btn btn-secondary btn-md" data-toggle="tooltip" title="Edit" disabled>
                              <i class="fas fa-edit"></i>
                            </button>
                          @elseif($value->pro_id == NULL)
                            <a href=" {{ route('journal.edit2', ['id' => $value->id]) }} ">
                              <button type="button" class="btn btn-warning btn-md" data-toggle="tooltip" title="Edit2">
                                <i class="fas fa-edit"></i>
                              </button>
                            </a>
                          @else
                            <a href=" {{ route('journal.edit', ['id' => $value->id, 'pro_id' => $value->pro_id]) }} ">
                              <button type="button" class="btn btn-warning btn-md" data-toggle="tooltip" title="Edit">
                                <i class="fas fa-edit"></i>
                              </button>
                            </a>
                          @endif
                      @endif
                  <!-- Download & Edit -->

                    </td>


                    <!-- MODAL Delete not_from_project -->
                      <div class="modal fade" id="DeleteJournal{{ $value->id }}">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-body">
                              <br>
                                <img class="mx-auto d-block" src="{{ asset('img/exclamation.png') }}" alt="exclamation" style="width:90px;">
                              <br>
                                <h2 class="text-center"> ต้องการลบรายการนี้ใช่ไหม ? <br> </h2>
                                <h5 class="text-center"> ลำดับ [ <font color = "red"> {{ $value->id }} </font> ]  </h5>
                              <br>
                              <div class="text-center">
                                <!-- Cancel -->
                                  <button type="button" class="btn btn-danger" data-dismiss="modal" role="button" aria-disabled="true">
                                    <i class="fas fa-times-circle"></i> Cancel
                                  </button>
                                <!-- Confirms -->
                                <a href="{{ route('journal.delete',['id' => $value->id]) }}">
                                  <button type="button" class="btn btn-success" role="button" aria-disabled="true">
                                    <i class="fas fa-trash-alt"></i> Confirms
                                  </button>
                                </a>

                              </div>
                            </div> <!-- END modal-bodyl -->
                          </div>
                        </div>
                      </div>
                    <!-- END MODAL Delete not_from_project -->


                    <!-- MODAL Verfied & Status not_from_project -->
                      <div class="modal fade" id="modal-default{{ $value->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title"><b>การตรวจสอบ</b> (ID <font color="red">{{ $value->id }}</font>) </h4>
                            </div>

                          <form action="{{ route('journal.verified') }}" method="POST" onsubmit="disableButtonVerify()">
                            @csrf

                            <div class="modal-body">
                              <div class="row">
                                <div class="col-md-12">
                                  <!-- hidden = id -->
                                  <input type="hidden" class="form-control" name="id" value="{{ $value->id }}">
                                  <label> ระดับของวารสาร </label>
                                  <select class="form-control" name="status" >
                                      <option value="" selected="true" disabled="true"> -- กรุณาเลือก -- </option>
                                    @foreach ($status as $value)
                                      <option value="{{ $value->id }}"> {{ $value->journal_status }} </option>
                                    @endforeach
                                  </select>
                                  <br>
                                  <label> การตรวจสอบ </label>
                                  <select class="form-control" name="verified">
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
                              <button type="submit" class="btn_disabled_verify btn btn-success float-right" value="บันทึกข้อมูล">
                                <i class="fas fa-save"></i> &nbsp;บันทึกข้อมูล
                              </button>
                            </div>
                          </form>

                          </div>
                        </div>
                      </div>
                    <!-- END MODAL Verify & Status not_from_project-->

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
  <!-- END TABLE -> JOURNAL PROJECT (** กรณี ไม่ได้มาจากโครงการวิจัย) -------------------------------------------------->
    @endif
  </div>
</section>

@stop('contents')


@section('js-custom-script')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

  <!-- INSERT -->
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

  <!-- DELETE -->
  @if(Session::get('deletejournal'))
   <?php Session::forget('deletejournal'); ?>
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

  <!-- STATUS -->
  @if(Session::get('statusjournal'))
   <?php Session::forget('statusjournal'); ?>
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

  <!-- VERIFIED -->
  @if(Session::get('verify2'))
   <?php Session::forget('verify2'); ?>
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

  <!-- Un VERIFIED -->
  @if(Session::get('Noverify'))
   <?php Session::forget('Noverify'); ?>
    <script>
      Swal.fire({
          icon: 'warning',
          title: 'รายการนี้ยังไม่ได้ตรวจสอบ',
          // text: 'รายการนี้ยังไม่ได้ตรวจสอบ',
          showConfirmButton: true,
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


<!-- START ALERT บันทึกข้อมูลสำเร็จ  -->
<script type="text/javascript">
  $(document).ready(function () {
    window.setTimeout(function() {
      $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
          $(this).remove();
      });
    }, 2000);
  });
</script>
<!-- END ALERT บันทึกข้อมูลสำเร็จ  -->


<!-- DatePicker YEAR -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->


<script>
//END DatePicker YEAR
  $("#datepicker4").datepicker({
      format: "yyyy",
      viewMode: "years",
      minViewMode: "years",
      autoclose: true,
  });

//END FILE INPUT
  $(document).ready(function () {
    bsCustomFileInput.init();
  });

// Data-Table44
  $(document).ready(function() {
    $('#example44').DataTable({
      dom: 'Bfrtip',
      buttons: [
        'excel', 'print'
      ]
    });
  });

  // Data-Table55
  $(document).ready(function() {
    $('#example55').DataTable({
      dom: 'Bfrtip',
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
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
@stop('js-custom')
