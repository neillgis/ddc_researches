<!-- Topbar -->

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
         <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false" id="navbarDropdown" v-pre>
             <i class="nav-icon far fas fa-user"></i>

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
              <a class="dropdown-item" href="https://hr.ddc.moph.go.th" target="_blank">แก้ไขข้อมูลส่วนตัว</a>
          @endif

           <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('keycloak.logout') }}">{{ __('ออกจากระบบ') }}</a>

           <form id="logout-form" action="#" method="POST" style="display: none;">
               @csrf
           </form>
         </div>
       </li>

    </ul>
  </nav>

<!-- End of Topbar -->
