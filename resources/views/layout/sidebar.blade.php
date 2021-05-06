<!-- Main Sidebar Container -->

<style media="screen">
.nav-sidebar .nav-item>.nav-link {
  padding: 15px;
}

.sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active, .sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active {
    background-color: #808080;
    color: #fff;
}
</style>


<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link">
    <img src="{{ asset('dist/img/moph-logo.png') }}" alt="MOPH" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text"><b> &nbsp; &nbsp;DIR </b></span>
  </a>


  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
           <li class="nav-item ">
             <a class="nav-link {{ Active::check('profile') }} " href="{{ route('page.profile') }}" >
               <i class="nav-icon fas fa-user-alt"></i>
               <p> ข้อมูลบุคคล / นักวิจัย </p>
             </a>
           </li>

          @if(Auth::hasRole('manager') || Auth::hasRole('admin'))
            <!-- <li class="nav-item">
             <a class="nav-link {{-- Active::check('summary_form') --}}" href="{{-- route('page.summary') --}}" >
               <i class="nav-icon far fas fa-chart-line"></i>
               <p> สรุปข้อมูลสำหรับ (กนว.) </p>
             </a>
            </li> -->
          @endif

             <li class="nav-item ">
               <a class="nav-link {{ Active::check('research_form') }} " href="{{ route('page.research') }}" >
                 <i class="nav-icon fas fa-book"></i>
                 <p> ข้อมูลโครงการวิจัย </p>
               </a>
             </li>

             <li class="nav-item ">
               <a class="nav-link {{ Active::check('journal_form') }} " href="{{ route('page.journal') }}" >
                 <i class="nav-icon fa fa-map"></i>
                 <p> ข้อมูลการตีพิมพ์วารสาร </p>
               </a>
             </li>

             <li class="nav-item ">
               <a class="nav-link {{ Active::check('util_form') }} " href="{{ route('page.util') }}" >
                 <i class="nav-icon fas fa-tree"></i>
                 <p> การนำไปใช้ประโยชน์ </p>
               </a>
             </li>

            @if(Auth::hasRole('manager') || Auth::hasRole('admin'))
             <li class="nav-item ">
               <a class="nav-link " href="#" >
                 <i class="nav-icon fas fa-download"></i>
                 <p> Export Data </p>
               </a>
               <ul class="nav nav-treeview">
                 <li class="nav-item">
                   <a class="nav-link" href="{{ route('export_research') }}" >
                     <i class="far fa-circle nav-icon text-warning"></i>
                     <p> โครงการวิจัย </p>
                   </a>
                 </li>
                 <li class="nav-item">
                   <a class="nav-link" href="{{ route('export_journal') }}" >
                     <i class="far fa-circle nav-icon text-warning"></i>
                     <p> การตีพิมพ์วารสาร </p>
                   </a>
                 </li>
                 <li class="nav-item">
                   <a class="nav-link" href="{{ route('export_util') }}" >
                     <i class="far fa-circle nav-icon text-warning"></i>
                     <p> นำไปใช้ประโยชน์ </p>
                   </a>
                 </li>
               </ul>
             </li>
            @endif

             <li class="nav-item ">
               <a class="nav-link " href="#" >
                 <i class="nav-icon fas fa-bookmark"></i>
                 <p> คู่มือ & FAQ <span class="right badge badge-danger"> New </span></p>
               </a>
             <ul class="nav nav-treeview">
               <li class="nav-item">
                 <a class="nav-link" href="{{ asset('Manual_DIR/manual.pdf') }}" target="_blank">
                   <i class="far fa-circle nav-icon text-warning"></i>
                   <p> คู่มือการใช้งาน </p>
                 </a>
               </li>
               <!-- <li class="nav-item">
                 <a class="nav-link" href="#" target="_blank">
                   <i class="far fa-circle nav-icon text-warning"></i>
                    <p> FAQ </p>
                 </a>
               </li> -->
             </ul>
           </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

<!-- END of Sidebar -->
