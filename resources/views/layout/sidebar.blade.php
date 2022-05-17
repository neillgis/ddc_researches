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
    <span class="brand-text"> &nbsp; &nbsp;กองนวัตกรรม </span>
  </a>


  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->

          @if(Auth::hasRole('departments'))

              <!-- No Show Button for "departments" -->

          @else
             <li class="nav-item ">
               <a class="nav-link {{ Active::check('profile') }} " href="{{ route('page.profile') }}" >
                 <i class="nav-icon fas fa-user-alt"></i>
                 <p> ข้อมูลบุคคล / นักวิจัย </p>
               </a>
             </li>
           @endif

          @if(Auth::hasRole('manager') || Auth::hasRole('admin'))
              <li class="nav-item">
               <a class="nav-link {{ Active::check('summary_form') }}" href="{{ route('page.summary') }}" >
                 <i class="nav-icon far fas fa-chart-line"></i>
                 <p> สรุปข้อมูลสำหรับ (กนว.) </p>
               </a>
              </li>
          @elseif(Auth::hasRole('departments'))
              <li class="nav-item">
               <a class="nav-link {{ Active::check('summary_form') }}" href="{{ route('page.summary') }}" >
                 <i class="nav-icon far fas fa-chart-line"></i>
                 <p> สรุปข้อมูลหน่วยงาน </p>
               </a>
              </li>
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
                 <p> Export Data <i class="fas fa-chevron-down right" style="padding: 9px;"></i></p>
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
                 <i class="nav-icon fas fa-star"></i>
                 <p> คู่มือ & FAQ <i class="fas fa-chevron-down right" style="padding: 9px;"></i></p>
               </a>
             <ul class="nav nav-treeview">
               <li class="nav-item">
                 <a class="nav-link" href="{{ asset('Manual_DIR/manuals.pdf') }}" target="_blank">
                   <i class="far fa-circle nav-icon text-warning"></i>
                   <p> คู่มือการใช้งาน </p>
                 </a>
               </li>
               <li class="nav-item">
                 <a class="nav-link {{ Active::check('faq') }} " href="{{ route('page.faq') }}">
                   <i class="far fa-circle nav-icon text-success"></i>
                    <p> คำถามที่พบบ่อย (FAQ) </p>
                 </a>
               </li>
             </ul>
           </li>


           <li class="nav-header">MANAGES</li>
             <li class="nav-item">
               <a class="nav-link {{ Active::check('all.notify') }} " href="{{ route('all.notify') }}">
                 <i class="nav-icon fas fa-bell"></i>
                 <p> การแจ้งเตือนทั้งหมด </p>
               </a>
             </li>

         @if(Auth::hasRole('manager') || Auth::hasRole('admin'))
             <li class="nav-item">
               <a class="nav-link {{ Active::check('admin.users_manage') }} " href="{{ route('admin.users_manage') }}">
                 <i class="nav-icon fas fa-user-cog"></i>
                 <p> จัดการผู้ใช้งาน </p>
               </a>
             </li>

         @elseif(Auth::hasRole('departments'))
            <li class="nav-header">ANNOUNCEMENT</li>

              <li class="nav-item">
                <a class="nav-link" href="{{ asset('Manual_DIR/announce_researcher_01.pdf') }}" target="_blank">
                  <i class="far fa-circle nav-icon text-info"></i>
                  <p> เกณฑ์การแบ่งระดับนักวิจัย </p>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="{{ asset('Manual_DIR/announce_researcher_02.pdf') }}" target="_blank">
                  <i class="far fa-circle nav-icon text-info"></i>
                  <p> วิธีการส่ง & แก้ไขข้อมูล </p>
                </a>
              </li>

         @else
            <li class="nav-header">ANNOUNCEMENT</li>

              <li class="nav-item">
                <a class="nav-link" href="{{ asset('Manual_DIR/announce_researcher_01.pdf') }}" target="_blank">
                  <i class="far fa-circle nav-icon text-info"></i>
                  <p> เกณฑ์การแบ่งระดับนักวิจัย </p>
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="{{ asset('Manual_DIR/announce_researcher_02.pdf') }}" target="_blank">
                  <i class="far fa-circle nav-icon text-info"></i>
                  <p> วิธีการส่ง & แก้ไขข้อมูล </p>
                </a>
              </li>
          @endif

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>

<!-- END of Sidebar -->
