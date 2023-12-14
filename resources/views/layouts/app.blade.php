<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Veacha</title>
      <link rel="icon" href="{{ asset('favicon.png') }}">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
      <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
      <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
	   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
      <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/bootstrap-datepicker/css/bootstrap-datepicker.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.css') }}">
      <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
      <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
      <!-- Google Font: Source Sans Pro -->
      <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
   </head>
   <body class="hold-transition sidebar-mini layout-fixed">
      <div class="wrapper">
         <aside class="main-sidebar sidebar-dark-primary elevation-4 ">
            {{-- <a href="#" class="sidebar-toggle text-white" data-toggle="push-menu" role="button">
               <i class="fa fa-times icon-toggle"></i>
             </a>
             <br> --}}
            <a href="{{ url('/home') }}" class="brand-link">
            <img src="{{ asset('logo_white.png') }}" alt=" Logo" class="brand-image img-circle" style="border: 2px solid #4c94ff; padding: 4px;">
            <span class="brand-text font-weight-light"> <strong>{{ __('veacha.app_name')}}</strong></span>
            </a>
            
            <div class="sidebar pull-right">
               <nav class="mt-2">
                  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                     <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                           <i class="nav-icon fas fa-th-large"></i>
                           <p>
                               {{ Auth::user()->name }}
                           </p>
                        </a>
                        <ul class="nav nav-treeview">
                           <li class="nav-item has-treeview">
                              <a href="#" class="nav-link">
                                 <i class="nav-icon fas fa-language"></i>
                                 <p>
                                 {{ __('veacha.language')}}
                                 <i class="right fas fa-angle-left"></i>
                                 </p>
                              </a>
                              <ul class="nav nav-treeview" style="display: none;">
                                 <li class="nav-item">
                                 <a href="{{ url('lang/en')}}" id="en" class="nav-link">
                                    <img src="{{asset('dist/img/en.png')}}" class="nav-icon" width="30px" height="20x">
                                    <p>{{ __('veacha.english')}}</p>
                                 </a>
                                 </li>
                                 <li class="nav-item">
                                 <a href="{{ url('lang/kh')}}" id="kh" class="nav-link">
                                    <img src="{{asset('dist/img/kh.png')}}" class="nav-icon" width="30px" height="20x">
                                    <p>{{ __('veacha.khmer')}}</p>
                                 </a>
                                 </li>
                              </ul>
                           </li>
                           <li class="nav-item">
                              <a href="{{ url('editUser',Auth::user()->id) }}" class="nav-link">
                              <i class="nav-icon fas fa-user padding-right"></i> {{ __('veacha.update_profile')}}
                              </a>
                           </li>
                           
                           <li class="nav-item">                              
                              <a href="{{ url('changePassword',Auth::user()->id) }}" class="nav-link">
                              <i class="nav-icon fas fa-key padding-right"></i>{{ __('veacha.change_password')}}
                              </a>
                           </li>
                           <li class="nav-item">
                                 <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                 <i class="nav-icon fa fa-power-off padding-right"></i> {{ __('veacha.logout') }}
                                 </a>
                                 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                 </form>
                           </li>
                        </ul>
                     </li>
                     @can('user-list')
                     <li class="nav-item">
                        <a href="{{ url('/home') }}" class="{{ (request()->is('home*')) ? 'nav-link active-menu' : 'nav-link'}}">
                           <i class="nav-icon fas fa-tachometer-alt"></i>
                           <p>
                              {{ __('veacha.dashboard')}}
                           </p>
                        </a>
                     </li>
                     @endcan
                     <li class="nav-item">
                        <a href="{{ url('yourwork')}}" class="{{ (request()->is('yourwork*')) ? 'nav-link active-menu' : 'nav-link'}}">
                           <i class="nav-icon fas fa-th"></i>
                           <p>
                              {{ __('veacha.your_work')}}
                           </p>
                        </a>
                     </li>
                     @can('project-list')
                     <li class="nav-item has-treeview">
                        <a href="{{ route('projects.index')}}" class="{{ (request()->is('projects*')) ? 'nav-link active-menu' : 'nav-link'}}">
                           <i class="nav-icon fas fa-folder"></i>
                           <p>
                              {{ __('veacha.projects')}}
                           </p>
                        </a>
                     </li>
                     @endcan
                     <!-- <li class="nav-item has-treeview">
                        <a href="{{ route('users.index') }}" class="{{ (request()->is('users*')) ? 'nav-link active-menu' : 'nav-link'}}">
                           <i class="nav-icon fas fa-users"></i>
                           <p>
                              People
                           </p>
                        </a>
                     </li> -->
                     <li class="nav-item has-treeview {{(request()->is('users*')) || (request()->is('roles*')) || (request()->is('logs*')) ? 'menu-open' : ''}}">
                        @can('user-list')
                        <a href="#" class="nav-link">
                           <i class="nav-icon fas fa-cog"></i>
                           <p>
                              {{ __('veacha.settings')}}
                           </p>
                        </a>
                        @endcan
                        <ul class="nav nav-treeview">
                           @can('user-list')
                           <li class="nav-item">
                              <a href="{{ route('users.index') }}" class="{{ (request()->is('users*')) ? 'nav-link active-menu' : 'nav-link'}}">
                                 <i class="fa fa-users nav-icon"></i>
                                 <p>{{ __('veacha.users')}}</p>
                              </a>
                           </li>
                           @endcan
                           @can('role-list')<li class="nav-item">
                              <a href="{{ url('roles') }}" class="{{ (request()->is('roles*')) ? 'nav-link active-menu' : 'nav-link'}}">
                                 <i class="fa fa-sitemap nav-icon"></i>
                                 <p>{{ __('veacha.roles_permissions')}}</p>
                              </a>
                           </li>
                           @endcan
                           @can('user-list')
                           <li class="nav-item">
                              <a href="{{ url('logs') }}" class="{{ (request()->is('logs*')) ? 'nav-link active-menu' : 'nav-link'}}">
                                 <i class="fa fa-archive nav-icon"></i>
                                 <p>{{ __('veacha.logs')}}</p>
                              </a>
                           </li>
                           @endcan
                        </ul>
                     </li>
                  </ul>
               </nav>
            </div>
         </aside>
        
         <div class="content-wrapper" style="margin-top: 15px;min-height: 350px;">
             <a href="#" class="sidebar-toggle " data-toggle="push-menu" role="button">
            <i class="fa fa-bars icon-toggle-bar"></i>
         </a>
            @yield('content-wrapper')
            <section class="content">
               @yield('content')
            </section>
         </div>
         <footer class="main-footer">
            <strong>Copyright &copy; {{ now()->year }} <a href="{{ url('/home')}}">VEACHA</a>.</strong> All rights reserved.
         </footer>
      </div>
      <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
      <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
      <script>
         $.widget.bridge('uibutton', $.ui.button)
      </script>
      <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
      <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
      <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
      <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
      <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
      <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
      <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
      <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
      <script src="{{ asset('dist/js/adminlte.js') }}"></script>
      <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
      <script src="{{ asset('dist/js/pages/dashboard2.js') }}"></script>
      <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
      <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
      <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
      <script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
      <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
      @yield('js')
      <script>
        $(function () {
            $('.sidebar-toggle').on('click', function () {
               $('.sidebar-mini').toggleClass('sidebar-collapse sidebar-open');
            });
            $('.datatable').DataTable({
               "paging": true,
               "lengthChange": false,
               "searching": false,
               "button": true,
               "ordering": true,
               "info": true,
               "autoWidth": false,
               "dom": 'Bfrtip',
               "buttons": [
                  'copy', 'csv', 'excel', 'pdf', 'print'
               ]
            });

            $(".alert").slideDown(100).delay(5000).slideUp(100);
            // Summernote
            $('.textarea').summernote();
            //Initialize Select2 Elements
            $('.select2').select2();
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });

        //File upload preview image
        $(".button-photo").click(function () {
            $(".input-file").click();
            return false;
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

      </script>
   </body>
</html>