@extends('layout.main')

<?php
  use App\CmsHelper as CmsHelper;
?>

@section('css-custom')

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

  <!-- ModalCard Style -->
  <style>
    .session-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .session-card:hover {
            border-color: #007bff;
            box-shadow: 0 4px 12px rgba(0,123,255,0.15);
        }

        .session-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
            padding: 15px 20px;
            border-radius: 8px 8px 0 0;
        }

        .session-title {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
            color: #495057;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .session-body {
            padding: 20px;
        }

        .scopus-card .session-header {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border-bottom-color: #f39c12;
        }

        .scopus-card .session-title {
            color: #d68910;
        }

        .scopus-card:hover {
            border-color: #f39c12;
            box-shadow: 0 4px 12px rgba(243,156,18,0.15);
        }

        .wos-card .session-header {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            border-bottom-color: #17a2b8;
        }

        .wos-card .session-title {
            color: #138496;
        }

        .wos-card:hover {
            border-color: #17a2b8;
            box-shadow: 0 4px 12px rgba(23,162,184,0.15);
        }

        .scholar-card .session-header {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-bottom-color: #28a745;
        }

        .scholar-card .session-title {
            color: #1e7e34;
        }

        .scholar-card:hover {
            border-color: #28a745;
            box-shadow: 0 4px 12px rgba(40,167,69,0.15);
        }

        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 6px;
            border: 1px solid #ced4da;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
        }

        .session-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
  </style>
  <!--END ModalCard Style -->

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
      .green-btn {
        background: #5dd982;
        color: black;
        pointer-events: none;
      }

      .green-btn::hover {
        background: inherit;
        box-shadow: none;
        transform: none;
      }

      .btn-blue-dark {
        background-color: #0056b3;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: background-color 0.2s ease, transform 0.1s ease;
      }

      .btn-blue-dark:hover {
        background-color: #004494;
      }

      .btn-blue-dark:active {
        background-color: #003370;
        transform: translateY(1px);
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
    <br>

  <!-- SHOW DATA for "departments" ONLY -->
  @if(Gate::allows('departments'))

    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card card-outline shadow">
          <div class="card-header" style="background-color: #54BEAE;">
            <h4><i class="fas fa-hotel"></i>&nbsp; ข้อมูลหน่วยงาน / องค์กร </h4>
          </div>

            <div class="card-body">
                <br>
                  <img class="mx-auto d-block" src="{{ asset('img/moph-logo.png') }}" alt="building" style="width:140px;">
                <br>
                  <h4 class="text-center">{{ Session::get('dep_id') }}</h4>
                <br>
                  <h3 class="text-center">{{ Session::get('dep_name') }}</h3>
                <br>
            </div> <!-- end card-body -->
        </div>
      </div>
    </div>
</section>


  @else


  <section class="content">
    <div class="container">

    <div class="row">
      <div class="col-md-6">
        <div class="card shadow" id="rcorners3">
          <div class="card-header" style="background-color: #54BEAE;">
            <h4 style="color:#FFFFFF;"><i class="fas fa-user-alt"></i>&nbsp; <b>ข้อมูลส่วนบุคคล</b> </h4>
          </div>

          <form method="POST" action="{{ route('profile.insert') }}">
            @csrf

            <div class="card-body">
              <h4 class="profile text-right" id="prefix"></h4>
              <!-- id="k_prefix" from Ajax below Declare for INSERT -->
              <input type="hidden" name="title" id="k_prefix">
              <input type="hidden" name="idCard" id="k_cid">
              <input type="hidden" name="sex" id="k_gender">
              <input type="hidden" name="dept_id" id="dept_id">

              <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <h4> ชื่อ <b><a class="float-right" id="fname_th"></b></a></h4>
                    <input type="hidden" class="form-control" name="fname" id="k_fname_th">
                  </li>

                  <li class="list-group-item">
                    <h4> นามสกุล <b><a class="float-right" id="lname_th"></b></a></h4>
                    <input type="hidden" class="form-control" name="lname" id="k_lname_th">
                  </li>
              </ul>


              <div class="row">
                <div class="col-md-12">
                  <label> เบอร์โทร </label>
                  <div class="border p-2" id="mobile" style="background-color: #e9ecef;opacity: 1; font-size: 18px;"></div>
                  <input type="hidden" class="form-control" name="mobile" id="k_mobile">
                </div>
              </div>
              <br>

              <div class="row">
                <div class="col-md-12">
                  <label> E - Mail </label>
                  <div class="border p-2" id="email" style="background-color: #e9ecef;opacity: 1; font-size: 18px;"></div>
                  <input type="hidden" class="form-control" name="email" id="k_email">
                </div>
              </div>
              <br>

              <div class="row">
                <div class="col-md-12">
                  <label> ระดับการศึกษา </label>
                  <div class="border p-2" id="edu_class" style="background-color: #e9ecef;opacity: 1; font-size: 18px;"></div>
                  <input type="hidden" class="form-control" name="educationLevel" id="k_edu_class">
                </div>
              </div>
              <br><br>
            </div>
          </div>
        </div>


        <div class="col-md-6">
          <div class="card shadow card-success" id="rcorners3">
            <div class="card-header" style="background-color: #54BEAE;">
              <h4><i class="fas fa-hotel"></i>&nbsp; <b>หน่วยงาน / สังกัด</b> </h4>
          </div>

          <div class="card-body">
            <div class="col-md-12">
              <label for="exampleInput1"> หน่วยงาน </label>
              <div class="border p-2" id="workBu1Name" style="background-color: #e9ecef;opacity: 1; font-size: 18px;"></div>
              <input type="hidden" class="form-control" name="deptName" id="k_workBu1Name">
            </div>
            <br>

            <div class="col-md-12">
              <label for="exampleInput1"> ตำแหน่ง </label>
              <div class="border p-2" id="position" style="background-color: #e9ecef;opacity: 1; font-size: 18px;"></div>
              <input type="hidden" class="form-control" name="position" id="k_position">
            </div>
            <br>

            <div class="col-md-12">
              <label for="exampleInput1"> ระดับตำแหน่ง </label>
              <div class="border p-2" id="positionLevel" style="background-color: #e9ecef;opacity: 1; font-size: 18px;"></div>
              <input type="hidden" class="form-control" name="positionLevel" id="k_positionLevel">
            </div>
          </div> <!-- card-body -->
        </div>


        <div class="card shadow card-danger" id="rcorners3">
          <div class="card-header" style="background-color: #54BEAE;">
            <h4><i class="fas fa-id-card-alt"></i>&nbsp; <b>ข้อมูลนักวิจัย</b> </h4>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                @if((count($data)>0)?'disabled':'')
                  <button type="button" class="btn btn-warning shadow" data-toggle="modal" data-target="#modal-edit-profile">
                    <i class="fas fa-user-edit"></i>
                    &nbsp;แก้ไขข้อมูลนักวิจัย
                  </button>
                  @if (($h_index_data['0']->spIndex != null || $h_index_data['0']->wosIndex != null || $h_index_data['0']->gsIndex != null) ? 'disabled' : '')
                    <button type="button" class="btn btn-blue-dark shadow" data-toggle="modal" data-target="#modal-edit-hindex">แก้ไขข้อมูล H-index</button>
                  @else
                    <button type="button" class="btn btn-blue-dark shadow" data-toggle="modal" data-target="#modal-edit-hindex">เพิ่มข้อมูล H-index</button>
                  @endif
                @else
                  <button type="button" class="btn btn-info shadow" data-toggle="modal" data-target="#modal-default"
                    <?=(count($data)>0)?'disabled':''?>> <!-- Check Value in เพิ่มข้อมูลนักวิจัย if>0 = disabled  -->
                    <i class="fas fa-plus-circle"></i>
                    &nbsp;เพิ่มข้อมูลนักวิจัย
                  </button>

                  <button type="button" class="btn btn-danger shadow" data-toggle="modal" data-target="#modal-Nodata"
                    <?=(count($data)>0)?'disabled':''?>> <!-- Check Value in เพิ่มข้อมูลนักวิจัย if>0 = disabled  -->
                    <i class="fas fa-check"></i>
                    &nbsp;หากไม่มีข้อมูลเพิ่ม กรุณากดยืนยัน
                  </button>
                @endif

                @if((count($data)>0)?'disabled':'')
                    <div class="btn green-btn shadow">
                        {{$researcherLevel['icon']}}{{$researcherLevel['text']}}
                    </div>
                @endif

              </div>
            </div>
            <br>

          <!-- CHECK Condition if have DATA -->
          @if((count($data)>0)?'disabled':'')

            <div class="row">
                <div class="col-md-6">
                  <label for="exampleInput1"> รหัสนักวิจัยจาก NRIIS </label>
                  <span></br>ลิงก์ไปยังเว็บไซต์ <a href="https://nriis.go.th/Login.aspx">NRIIS</a></span>
                    @foreach($data as $value)
                        @if($value->nriis_id != "")
                          <div class="border p-2" style="background-color: #e9ecef;opacity: 1; font-size: 16px;">
                            {{ $value->nriis_id }}
                          </div>
                        @else
                          <div class="border p-2" style="background-color: #e9ecef;opacity: 1; font-size: 16px;">
                             -
                          </div>
                        @endif
                    @endforeach
                </div>

                <div class="col-md-6">
                  <label for="exampleInput1"> เลขประจำตัวนักวิจัยจาก ORCID ID </label>
                  <span></br>ลิงก์ไปยังเว็บไซต์ <a href="https://orcid.org/signin">ORCID ID</a></span>
                    @foreach($data as $value)
                        @if($value->orcid_id != "")
                          <div class="border p-2" style="background-color: #e9ecef;opacity: 1; font-size: 16px;">
                            {{ $value->orcid_id }}
                          </div>
                        @else
                          <div class="border p-2" style="background-color: #e9ecef;opacity: 1; font-size: 16px;">
                             -
                          </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @if ((($h_index_data['0']->spIndex != null || $h_index_data['0']->wosIndex != null || $h_index_data['0']->gsIndex != null) ? 'disabled' : ''))
                <div class="row mt-2">
                    <div class="col-md-4">
                        <label for="exampleInput1"> ฐานข้อมูล <br>Scopus </label>
                        <span></br>ลิงก์ไปยังเว็บไซต์ <br><a href="https://www.scopus.com/freelookup/form/author.uri">Scopus</a></span>
                        @foreach($h_index_data as $value)
                            @if($value->spIndex != "")
                            <div class="border p-2" style="background-color: #e9ecef;opacity: 1; font-size: 16px;">
                                {{ $value->spIndex }}
                            </div>
                            @else
                            <div class="border p-2" style="background-color: #e9ecef;opacity: 1; font-size: 16px;">
                                -
                            </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="col-md-4">
                        <label for="exampleInput1"> ฐานข้อมูล <br>Web Of Science </label>
                        <span></br>ลิงก์ไปยังเว็บไซต์ <br><a href="https://shorturl-ddc.moph.go.th/gTUFG">Web Of Science</a></span>
                        @foreach($h_index_data as $value)
                            @if($value->wosIndex != "")
                            <div class="border p-2" style="background-color: #e9ecef;opacity: 1; font-size: 16px;">
                                {{ $value->wosIndex }}
                            </div>
                            @else
                            <div class="border p-2" style="background-color: #e9ecef;opacity: 1; font-size: 16px;">
                                -
                            </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="col-md-4">
                        <label for="exampleInput1"> ฐานข้อมูล <br>Google Scholar </label>
                        <span></br>ลิงก์ไปยังเว็บไซต์ <br><a href="https://scholar.google.com/">Google Scholar</a></span>
                        @foreach($h_index_data as $value)
                            @if($value->gsIndex != "")
                            <div class="border p-2" style="background-color: #e9ecef;opacity: 1; font-size: 16px;">
                                {{ $value->gsIndex }}
                            </div>
                            @else
                            <div class="border p-2" style="background-color: #e9ecef;opacity: 1; font-size: 16px;">
                                -
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
          @else

            <!-- No Show BUTTON -->

          @endif
          </div> <!-- card-body -->
        </div>


      <!-- MODAL INSERT [modal-default] -->
        <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header shadow" style="background-color: #fcb8ac;">
                <h4 class="modal-title"><b> เพิ่มข้อมูลนักวิจัย </b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                    <label for="exampleInput1"> รหัสนักวิจัย </label>
                    <input type="text" class="form-control" name="nriis_id" placeholder="รหัสนักวิจัย (NRIIS ID) *ถ้ามี" maxlength="10">
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-12">
                    <label for="exampleInput1"> เลขประจำตัวนักวิจัย </label>
                    <input type="text" class="form-control" name="orcid_id" placeholder="เลขประจำตัวนักวิจัย (ORCID ID) *ถ้ามี">
                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"> Close </button>
                <button type="submit" class="btn btn-danger float-right" value="บันทึกข้อมูล">
                  <i class="fas fa-save"></i> &nbsp;บันทึกข้อมูล
                </button>
              </div>
            </div>
          </div>
        </div>
      <!-- END MODAL [modal-default] -->


      <!-- MODAL [modal-NO data] -->
        <div class="modal fade" id="modal-Nodata">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header shadow" style="background-color: #fcb8ac;">
                <h4 class="modal-title"><b> ไม่มีข้อมูลนักวิจัย </b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                    <br>
                    <h3 class="text-center"> กรุณากดปุ่ม <b>"บันทึกข้อมูล"</b> <br></h3>
                    <h4  class="text-center"> หากท่านไม่มีข้อมูลนักวิจัย </h4>
                    <br>
                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"> Close </button>
                <button type="submit" class="btn btn-danger float-right" value="บันทึกข้อมูล">
                  <i class="fas fa-save"></i> &nbsp;บันทึกข้อมูล
                </button>
              </div>
            </div>
          </div>
        </div>
      <!-- END MODAL [modal-NO data] -->

        <br>
      </div>
    </div>
  </form>


      <!-- MODAL EDIT [modal-edit-hindex] -->
      @if ((count($h_index_data)>0)?'disabled':'')
        <div class="modal fade" id="modal-edit-hindex">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                @if (($h_index_data['0']->spIndex != null || $h_index_data['0']->wosIndex != null || $h_index_data['0']->gsIndex != null) ? 'disabled' : '')
                    <h4 class="modal-title"><i class="fas fa-user-edit"></i><b> แก้ไขข้อมูล H-index </b></h4>
                @else
                    <h4 class="modal-title"><i class="fas fa-user-edit"></i><b> เพิ่มข้อมูล H-index </b></h4>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form action="{{ route('profile.h_index') }}" method="POST">
                @csrf

                <div class="modal-body">
                    <div class="row">
                    <div class="col-md-12">
                        <!-- Scopus Session -->
                            <div class="session-card scopus-card">
                                <div class="session-header">
                                    <h6 class="session-title">
                                        <div class="session-icon">
                                            <i class="fas fa-microscope"></i>
                                        </div>
                                        Scopus
                                    </h6>
                                </div>
                                <div class="session-body">
                                    <div class="form-group">
                                        <label class="form-label">รหัสผู้ใช้งาน <a
                                            href="https://www.scopus.com/freelookup/form/author.uri">
                                                Scopus
                                            </a>
                                        </label>
                                        <input type="text" class="form-control" placeholder="กรอกรหัสผู้ใช้งาน" name="spID" value="{{ $edit_profile->spID }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Citations</label>
                                        <input type="number" class="form-control" placeholder="จำนวน Citations" name="spCite" value="{{ $edit_profile->spCite }}">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="form-label">ค่า H-index จาก Scopus</label>
                                        <input  type="number"
                                                class="form-control"
                                                placeholder="กรอกค่า H-index"
                                                name="spIndex"
                                                value="{{ $edit_profile->spIndex }}"
                                                min="0" max="99"
                                        >
                                    </div>
                                </div>
                            </div>

                            <!-- Web of Science Session -->
                            <div class="session-card wos-card">
                                <div class="session-header">
                                    <h6 class="session-title">
                                        <div class="session-icon">
                                            <i class="fas fa-globe"></i>
                                        </div>
                                        Web of Science
                                    </h6>
                                </div>
                                <div class="session-body">
                                    <div class="form-group">
                                        <label class="form-label">รหัสผู้ใช้งาน <a
                                            href="https://shorturl-ddc.moph.go.th/gTUFG">
                                                Web of science
                                            </a>
                                        </label>
                                        <input type="text" class="form-control" placeholder="กรอกรหัสผู้ใช้งาน" name="wosID" value="{{ $edit_profile->wosID }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Citations</label>
                                        <input type="number" class="form-control" placeholder="จำนวน Citations" name="wosCite" value="{{ $edit_profile->wosCite }}">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="form-label">ค่า H-index จาก Web of Science</label>
                                        <input  type="number"
                                                class="form-control"
                                                placeholder="กรอกค่า H-index"
                                                name="wosIndex"
                                                value="{{ $edit_profile->wosIndex }}"
                                                min="0" max="99"
                                        >
                                    </div>
                                </div>
                            </div>

                            <!-- Google Scholar Session -->
                            <div class="session-card scholar-card">
                                <div class="session-header">
                                    <h6 class="session-title">
                                        <div class="session-icon">
                                            <i class="fas fa-graduation-cap"></i>
                                        </div>
                                        Google Scholar
                                    </h6>
                                </div>
                                <div class="session-body">
                                    <div class="form-group">
                                        <label class="form-label">รหัสผู้ใช้งาน <a
                                            href="https://scholar.google.com/">
                                                Google Scholar
                                            </a>
                                        </label>
                                        <input type="text" class="form-control" placeholder="กรอกรหัสผู้ใช้งาน" name="gsID" value="{{ $edit_profile->gsID }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Citations</label>
                                        <input type="number" class="form-control" placeholder="จำนวน Citations" name="gsCite" value="{{ $edit_profile->gsCite }}">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="form-label">ค่า H-index จาก Google Scholar</label>
                                        <input  type="number"
                                                class="form-control"
                                                placeholder="กรอกค่า H-index"
                                                name="gsIndex"
                                                value="{{ $edit_profile->gsIndex }}"
                                                min="0" max="99"
                                        >
                                    </div>
                                </div>
                            </div>
                    </div>
                    </div>
                    <br>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal"> Close </button>
                    <button type="submit" class="btn btn-warning float-right" value="บันทึกข้อมูล">
                    <i class="fas fa-save"></i> &nbsp;บันทึกข้อมูล
                    </button>
                </div>
                </form>
            </div>
            </div>
        </div>
      @endif
      <!-- END MODAL [modal-edit-hindex] -->

      <!-- MODAL EDIT [modal-edit-profile] -->
        <div class="modal fade" id="modal-edit-profile">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title"><i class="fas fa-user-edit"></i><b> เพิ่มข้อมูล H-index </b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="{{ route('profile.save') }}" method="POST">
                @csrf

                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-12">
                      <label for="exampleInput1"> รหัสนักวิจัย </label>
                      @if(count($data)>0?'disabled':'')
                          <input type="text" class="form-control" name="nriis_id" value="{{ $edit_profile->nriis_id }}" maxlength="10">
                      @else
                          -
                      @endif
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-12">
                      <label for="exampleInput1"> เลขประจำตัวนักวิจัย </label>
                      @if(count($data)>0?'disabled':'')
                          <input type="text" class="form-control" name="orcid_id" value="{{ $edit_profile->orcid_id }}">
                      @else
                          -
                      @endif
                    </div>
                  </div>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal"> Close </button>
                  <button type="submit" class="btn btn-warning float-right" value="บันทึกข้อมูล">
                    <i class="fas fa-save"></i> &nbsp;บันทึกข้อมูล
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      <!-- END MODAL [modal-edit-profile] -->

  </div>
</section>
@endif

@stop('contents')


@section('js-custom-script')

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

  <!-- INSERT success -->
    @if(Session::get('messages'))
     <?php Session::forget('messages'); ?>
      <script>
        Swal.fire({
            icon: 'success',
            title: 'อัพเดทข้อมูลของท่านเรียบร้อย',
            showConfirmButton: false,
            confirmButtonColor: '#2C6700',
            timer: 2000
        })
      </script>
    @endif

@stop('js-custom-script')


@section('js-custom')
    <script>
      var profile = <?=json_encode($edit_profile, JSON_UNESCAPED_UNICODE)?>;

        $(document).ready(function() {
            $.ajax({
                url: "https://hr-ddc.moph.go.th/api/v2/employee/{{ Auth::user()->preferred_username }}",
                type: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": "bearer {{ KeycloakWeb::retrieveToken()['access_token'] }}"
                },
                success: function(result) {
                    // console.log(result)
                    chk_update(result);

                    $("#employee_id").text(result.employeeId);
                    $("#cid").text(result.idCard);
                    $("#k_cid").val(result.idCard);
                    $("#dept_id").val(result.workBu1);
                    $("#k_dept_id").val(result.deptName);
                    $("#workBu1Name").text(result.workBu1Name);
                    $('#k_workBu1Name').val(result.workBu1Name);
                    $("#edu_class").text(result.educationLevel);
                    $("#k_edu_class").val(result.educationLevel);
                    $("#prefix").text(result.title);
                    $("#k_prefix").val(result.title);
                    $("#fname_th").text(result.fname);
                    $("#k_fname_th").val(result.fname);
                    $("#lname_th").text(result.lname);
                    $("#k_lname_th").val(result.lname);
                    $("#fname_en").text(result.efname);
                    $("#lname_en").text(result.elname);
                    $("#gender").text(result.sex);
                    $("#k_gender").val(result.sex);
                    $("#birthdate").text(result.birthday);
                    $("#position").text(result.position);
                    $("#k_position").val(result.position);
                    $("#mobile").text(result.mobile);
                    $("#k_mobile").val(result.mobile);
                    $("#email").text(result.email);
                    $("#k_email").val(result.email);
                    $("#positionLevel").text(result.positionLevel);
                    $("#k_positionLevel").val(result.positionLevel);
                }
            });

            /*
            $.ajax({
                url: "https://hr-ddc.moph.go.th/api/v2/employee/pic/{{ Auth::user()->preferred_username }}",
                headers: {
                    "Content-Type": "application/json",
                    "Authorization": "bearer {{ KeycloakWeb::retrieveToken()['access_token'] }}"
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success (data) {
                    const url = window.URL || window.webkitURL;
                    const src = url.createObjectURL(data);
                    $('#image').attr('src', src);
                }
            });
            */
        });


        function chk_update(sso) {
          // console.log(sso);
            let chk = false;
            let update = {};
            if(profile) {
              if( profile['title'] != sso.title ) {
                chk = true;
                update['title'] = sso.title;
              }
              if( profile['fname'] != sso.fname ) {
                chk = true;
                update['fname'] = sso.fname;
              }
              if( profile['lname'] != sso.lname ) {
                chk = true;
                update['lname'] = sso.lname;
              }
              if( profile['educationLevel'] != sso.educationLevel ) {
                chk = true;
                update['educationLevel'] = sso.educationLevel;
              }

              if( profile['email'] != sso.email ) {
                chk = true;
                update['email'] = sso.email;
              }
              if( profile['mobile'] != sso.mobile ) {
                chk = true;
                update['mobile'] = sso.mobile;
              }

              if( profile['dept_id'] != sso.workBu1 ) {
                chk = true;
                update['dept_id'] = sso.dept_id;
              }
              if( profile['deptName'] != sso.workBu1Name ) {
                chk = true;
                update['deptName'] = sso.workBu1Name;
              }
              // if( profile['deptName'] != sso.deptName ) {
              //   chk = true;
              //   update['deptName'] = sso.deptName;
              // }
              if( profile['position'] != sso.position ) {
                chk = true;
                update['position'] = sso.position;
              }
              if( profile['positionLevel'] != sso.positionLevel ) {
                chk = true;
                update['positionLevel'] = sso.positionLevel;
              }

              if( chk ) {
                update['id'] = profile['id'];
                let json_data = JSON.stringify(update);
                $.ajax({
                  url: "{{Route('profile.chk_update')}}"+"/"+json_data,
                  headers: {
                      "Content-Type": "application/json",
                  },
                  xhrFields: {
                      responseType: 'blob'
                  },
                  success (msg) {
                    console.log(msg);
                  }
              });
              }
            }
        }
    </script>
@stop('js-custom')
