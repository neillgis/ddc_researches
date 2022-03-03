<?php
  use App\CmsHelper;
  use App\NotificationAlert;
  use Carbon\Carbon;

  if(Auth::user()->preferred_username){
    $CountNewMessage  = count(NotificationAlert::CountNewMessage(Auth::user()->preferred_username));
    $ListMessage = NotificationAlert::ListMessage();
  }
?>

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item dropdown">

        @if($CountNewMessage != 0)
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-danger navbar-badge">@if(isset($CountNewMessage)) {{ $CountNewMessage }} @endif</span>
          </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <a href="{{ route('all.notify') }}" class="dropdown-item">
                <i class="fas fa-envelope py-2 mr-3 text-secondary"></i>
                <font color="red"><b> ดูการแจ้งเตือนทั้งหมด </b></font>
              </a>
            </div>

        @else

            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="far fa-bell"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <a href="#" class="dropdown-item">
                <i class="fas fa-envelope py-2 mr-3"></i>
                ไม่มีการแจ้งเตือน
              </a>
            </div>
        @endif
      </li>


       <li class="nav-item dropdown">
         <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false" id="navbarDropdown" v-pre>
             <i class="nav-icon fas fa-user-circle"></i>

                 <b> {{ Auth::user()->name }}</b>

                 <span class="caret"></span>
         </a>

         <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

           <!-- <a class="dropdown-item" href="#"> -->
             <a class="dropdown-item">

            status :
            @if(Gate::allows('keycloak-web', ['manager']))
                <font color="red"><b>MANAGER</b></font>
            @elseif (Gate::allows('keycloak-web', ['admin']))
                <b>ADMIN</b>
            @elseif (Gate::allows('keycloak-web', ['departments']))
                <font color="#32977e"><b>ADMIN-DEPARTMENT</b></font>
            @else
                 <font color="red"><b>USER</b></font>
            @endif
             <!-- {{ __('แก้ไขข้อมูลส่วนตัว') }} -->
           </a>

          @if(Auth::hasRole('departments'))

             <!-- NO Show BUTTON For Departments ONLY -->

          @else
           <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="https://hr-ddc.moph.go.th" target="_blank">แก้ไขข้อมูลส่วนตัว</a>
          @endif

           <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('keycloak.logout') }}"><i class="fas fa-power-off"></i> {{ __('ออกจากระบบ') }}</a>

           <form id="logout-form" action="#" method="POST" style="display: none;">
               @csrf
           </form>
         </div>
       </li>

    </ul>
  </nav>

<!-- End of Topbar -->
