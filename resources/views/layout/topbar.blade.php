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
                 {{ Auth::user()->preferred_username }}
                 <!-- <i class="far fa-user"></i> -->
                 <!-- <div class="row"> -->
                     <!-- <div id="fname_th"></div>
                     <div id="lname_th"></div> -->
                 <!-- </div> -->

              <span class="caret"></span>
         </a>

         <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

           <!-- <a class="dropdown-item" href="#">
             {{ __('แก้ไขประวัติส่วนตัว') }}
           </a>

           <div class="dropdown-divider"></div> -->
           <a class="dropdown-item" href="{{ route('keycloak.logout') }}">{{ __('ออกจากระบบ') }}</a>

           <form id="logout-form" action="#" method="POST" style="display: none;">
               @csrf
           </form>
         </div>
       </li>

    </ul>
  </nav>

<!-- End of Topbar -->
