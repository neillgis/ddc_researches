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
              @if(Session::get('curr_role') == "user")
              <b> {{ Auth::user()->name }} </b>
              @elseif(Session::get('curr_role') == "departments")
              <b> {{ Session::get('dep_name') }}</b>
              @else
              <b> {{ Session::get('curr_role') }} </b>
              @endif
              <span class="caret"></span>
         </a>

         <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

            @cannot('user')
            <a class="cursor-pointer dropdown-item {{ ((Session::get('curr_role') != 'user')?'active':'') }}" 
              onclick="switch_to('{{ Session::get('role') }}')">{{ Session::get('role') }}</a>
            @endcan
            <a class="cursor-pointer dropdown-item {{ ((Session::get('curr_role') == 'user')?'active':'') }}" 
              onclick="switch_to('user')">user</a>

            
          @if(Gate::allows('departments'))

             <!-- NO Show BUTTON For Departments ONLY -->

          @else
           <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="https://hr-ddc.moph.go.th" target="_blank">แก้ไขข้อมูลส่วนตัว</a>
          @endif

           <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('logout') }}"><i class="fas fa-power-off"></i> {{ __('ออกจากระบบ') }}</a>

           <form id="logout-form" action="#" method="POST" style="display: none;">
               @csrf
           </form>
         </div>
       </li>

    </ul>
  </nav>

<!-- End of Topbar -->
