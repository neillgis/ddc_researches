@extends('layout.main')

<?php
  use App\CmsHelper as CmsHelper;
?>

@section('css-custom-script')
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

@stop

@section('contents')
<div class="content-wrapper">

  <section class="content">
  <div class="container">
    <br>
      <h1 class="text-center mt-4 mb-4"><b><i class="far fa-bell"></i> Notifications </b></h1>

    <div class="row justify-content-md-center">
      <div class="col-xxl-8 col-md-8">
        @if((count($data_notify)>0) ? 'enabled' : '')
          <div class="row">
            <div class="col-md-12">
              <div class="timeline">
                <div class="time-label">
                  <span class="bg-olive"> Notifications </span>
                </div>
          @endif

                @foreach($data_notify as $value)
                  <div class="mb-4">
                    <i class="fas fa-envelope bg-yellow"></i>
                    <div class="timeline-item">
                        @if($value->subject == "2")
                          <span class="time"><i class="fas fa-comment-dots text-warning"></i> {{ $verified [$value->subject] }} </span>
                        @elseif($value->subject == "3")
                          <span class="time"><i class="fas fa-comment-dots text-warning"></i> {{ $verified [$value->subject] }} </span>
                        @elseif($value->subject == "9")
                          <span class="time"><i class="fas fa-comment-dots text-warning"></i> {{ $verified [$value->subject] }} </span>
                        @else
                          <span class="time"><i class="fas fa-comment-dots text-warning"></i> - </span>
                        @endif
                      <h3 class="timeline-header" style="background-color:#fafcff;">
                        <div class="col-md-12">
                          <font color="red"><b> {{ CmsHelper::DateThaiFull($value->send_date) }} </b></font><br>
                          <small class="text-muted"><font color="#17a2b8"><b> ผู้ส่งข้อความ :</b></font> {{ $value->sender_name }} <font color="#17a2b8" class="ml-4"><b> หน่วยงาน :</b></font> {{ CmsHelper::Get_UserOrganize($value->sender_id)['deptName'] }} </small>
                        </div>
                      </h3>
                        <div class="timeline-body shadow">
                          <div class="col-md-12">
                            <div class="form-group row">
                              <label class="col-md-2"> หมวดหมู่ : </label>
                              <div class="col-md-8">
                                @if($value->category != NULL)
                                    {{ $category [$value->category] }}
                                @else
                                    -
                                @endif
                              </div>

                              @if($value->pro_id_journal != NULL)
                                  <div class="col-md-2">
                                    <span class="text-muted"><font color="red"><b> Project </b></font> : {{ empty($value->pro_id_journal) ? '-' : $value->pro_id_journal }} </span>
                                  </div>
                              @else
                                  <div class="col-md-2">
                                    <span class="text-muted"><font color="red"><b> Project </b></font> : {{ empty($value->projects_id) ? '-' : $value->projects_id }} </span>
                                  </div>
                              @endif
                            </div>

                            <div class="form-group row">
                              <label class="col-md-2"> คำอธิบาย : </label>
                              <div class="col-md-10">
                                @if($value->description != NULL)
                                    {{ $value->description }}
                                @else
                                    -
                                @endif
                              </div>
                            </div>

                            <div class="form-group row">
                              <label class="col-md-2"> URL : </label>
                              <a href="{{ route('redirect.url', ['url_redirect' => $value->url_redirect]) }}" target="_blank"> {{ empty($value->url_redirect) ? '-' : $value->url_redirect }} </a>
                            </div>

                          @if($value->files_upload != NULL)
                            <hr class="mb-3">
                            <div class="form-group row">
                              <label class="col-md-2"> ไฟล์แนบ : </label>
                              <a href="{{ route('DownloadFile.Notify', [ 'id' => $value->id, 'files_upload' => $value->files_upload ]) }}" title="Download-File"><i class="fas fa-paperclip"></i> {{ empty($value->files_upload) ? '-' : $value->files_upload }} </a>
                            </div>
                          @endif

                          @if(Gate::allows('manager'))
                            <div class="text-right">
                                <button type="button" class="btn btn-outline-info rounded-pill" data-toggle="modal" data-target="#ManagerVerify{{ $value->id }}">
                                  <i class="far fa-check-circle"></i> ตรวจสอบ
                                </button>
                            </div>
                          @endif


                                <!-- MODAL "ManagerVerify" -->
                                  <div class="modal fade" id="ManagerVerify{{ $value->id }}">
                                    <div class="modal-dialog">
                                      <div class="modal-content">
                                        <div class="modal-body">
                                          <br>
                                            <img class="mx-auto d-block mb-4" src="{{ asset('img/exclamation.png') }}" alt="exclamation" style="width:90px;">
                                            <h5 class="text-center">
                                                @if($value->pro_id_journal != NULL)
                                                    <span class="text-muted"><font color="red"><b> Project </b></font> : {{ empty($value->pro_id_journal) ? '-' : $value->pro_id_journal }} </span>
                                                @else
                                                    <span class="text-muted"><font color="red"><b> Project </b></font> : {{ empty($value->projects_id) ? '-' : $value->projects_id }} </span>
                                                @endif
                                            </h5>
                                            <h3 class="text-center mb-4"> คุณตรวจสอบรายการนี้แล้วใช่ไหม ? <br> </h3>

                                          <div class="text-center mb-3">
                                            <!-- Cancel -->
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal" role="button" aria-disabled="true">
                                                <i class="far fa-times-circle"></i> Cancel
                                              </button>
                                            <!-- Confirms -->
                                            <a href="{{ route('update.manager-verfiry',[ 'id' => $value->id ]) }}">
                                              <button type="button" class="btn btn-info" role="button" aria-disabled="true">
                                                <i class="far fa-check-circle"></i> ตรวจสอบแล้ว
                                              </button>
                                            </a>

                                          </div>
                                        </div> <!-- END modal-body -->
                                      </div>
                                    </div>
                                  </div>
                                <!-- END MODAL "ManagerVerify" -->


                        </div> <!-- END Col -->
                        </div> <!-- END Timeline -->
                    </div> <!-- END timeline-item -->
                  </div>
                @endforeach
              </div>
            </div>
          </div>
      </div> <!-- END Column -->
    </div> <!-- END Rows -->


  </div>  <!-- END container -->
  </section>
</div>
@stop


@section('js-custom-script')
@stop
