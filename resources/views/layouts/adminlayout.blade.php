<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1"/>
    <meta name="msapplication-tap-highlight" content="no">
    
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="Milestone">

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Milestone">

    <meta name="theme-color" content="#4C7FF0">
    
    <title>Bi-Tools</title>

    <!-- page stylesheets -->
    <!-- end page stylesheets -->

    <!-- build:css({.tmp,app}) styles/app.min.css -->
    <link rel="stylesheet" href="{{ asset('/resources/assets/frontend/vendor/bootstrap/dist/css/bootstrap.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/resources/assets/frontend/vendor/pace/themes/blue/pace-theme-minimal.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/resources/assets/frontend/vendor/font-awesome/css/font-awesome.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/resources/assets/frontend/vendor/animate.css/animate.css') }}"/>
    <link rel="stylesheet" href="{{ asset('/resources/assets/frontend/styles/app.css') }}" id="load_styles_before"/>
    <link rel="stylesheet" href="{{ asset('/resources/assets/frontend/styles/app.skins.css') }}"/>
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css"/>
    <link rel="stylesheet" href="{{ asset('/resources/assets/frontend/vendor/datatables/media/css/dataTables.bootstrap4.css') }}">
    <!-- endbuild -->

    </head>
    <body>
    <style type="text/css">
      .configuration-cog,.toggle-options{display: none;}
    </style>
    
    <div class="app">
      <!--sidebar panel-->
      <div class="off-canvas-overlay" data-toggle="sidebar"></div>
      <div class="sidebar-panel">
        <div class="brand">
          <!-- toggle offscreen menu -->
          <a href="javascript:;" data-toggle="sidebar" class="toggle-offscreen hidden-lg-up">
            <i class="material-icons">menu</i>
          </a>
          <!-- /toggle offscreen menu -->
          <!-- logo -->
          <a class="brand-logo">
            <img class="expanding-hidden" src="{{ asset('/resources/uploads/logo.png') }}" alt="logo"/>
          </a>
          <!-- /logo -->
        </div>
        <div class="nav-profile dropdown">
          <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
            <div class="user-image">
              <img src="{{ asset('/resources/uploads/avatar.jpg') }}" class="avatar img-circle" alt="user" title="user"/>
            </div>
            <div class="user-info expanding-hidden">
              {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
              <small class="bold">Administrator</small>
            </div>
          </a>
          <div class="dropdown-menu">
          
            <a class="dropdown-item" href="{{ url('admin/profile') }}">Profile</a>
            <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Logout </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
          </div>
        </div>
        <!-- main navigation -->
        <nav>
          <p class="nav-title">NAVIGATION</p>
          <ul class="nav">
            <!-- sync -->
            <li>
              <a href="{{ url('admin/sync') }}">
                <i class="material-icons text-primary">cached</i>
                <span>Sync Data</span>
              </a>
            </li>
            <!-- /sync -->
            <!-- dashboard -->
            <li>
              <a href="{{ url('admin/dashboard') }}">
                <i class="material-icons text-primary">dashboard</i>
                <span>Dashboard</span>
              </a>
            </li>
            <!-- /dashboard -->
            <!-- profile -->
            <li>
              <a href="{{ url('admin/profile') }}">
                <i class="material-icons text-primary">brightness_7</i>
                <span>Profile</span>
              </a>
            </li>
            <!-- /profile -->


            <!-- Products -->
            <li>
              <a href="{{ url('admin/profile') }}">
                <i class="material-icons text-primary">subject</i>
                <span>Products</span>
              </a>
            </li>
            <!-- /Products -->

            <!-- Products Category -->
            <li>
              <a href="{{ url('admin/profile') }}">
                <i class="material-icons text-primary">copyright</i>
                <span>Category</span>
              </a>
            </li>
            <!-- /Products Category -->


           

            <!-- Orders -->
            <li>
              <a href="javascript:;">
                <span class="menu-caret">
                  <i class="material-icons text-primary">arrow_drop_down</i>
                </span>
                <i class="material-icons text-primary">shopping_cart</i>
                <span>Orders</span>
              </a>
              <ul class="sub-menu">
                <!-- Orders -->
                <li>
                  <a href="{{ url('admin/orders') }}">
                    <i class="material-icons text-primary">visibility</i>
                    <span>Orders Details</span>
                  </a>
                </li>
                <!-- /Orders -->

               <!-- Orders settings -->
                <li>
                  <a href="{{ url('admin/orders-settings') }}">
                    <i class="material-icons text-primary">settings</i>
                    <span>Orders Settings</span>
                  </a>
                </li>
                <!-- /Orders settings -->
                
              </ul>
            </li>
            <!-- /Orders -->


            <!-- Customers -->
            <li>
              <a href="javascript:;">
                <span class="menu-caret">
                  <i class="material-icons text-primary">arrow_drop_down</i>
                </span>
                <i class="material-icons text-primary">people</i>
                <span>Customers</span>
              </a>
              <ul class="sub-menu">
                <!-- Customers -->
                <li>
                  <a href="{{ url('admin/customers') }}">
                    <i class="material-icons text-primary">visibility</i>
                    <span>Customers Details</span>
                  </a>
                </li>
                <!-- /Customers -->

               <!-- Customers settings -->
                <li>
                  <a href="{{ url('admin/customers-settings') }}">
                    <i class="material-icons text-primary">settings</i>
                    <span>Customers Settings</span>
                  </a>
                </li>
                <!-- /Customers settings -->
                
              </ul>
            </li>
            <!-- /Customers -->


            <!-- extras -->
            <li>
              <a href="javascript:;">
                <span class="menu-caret">
                  <i class="material-icons text-primary">arrow_drop_down</i>
                </span>
                <span class="badge bg-danger pull-right">HOT</span>
                <i class="material-icons text-primary">stars</i>
                <span>Extras</span>
              </a>
              <ul class="sub-menu">
               <!-- settings -->
                <li>
                  <a href="{{ url('admin/profile') }}">
                    <i class="material-icons text-primary">Settings</i>
                    <span>Settings</span>
                  </a>
                </li>
                <!-- /settings -->
                
              </ul>
            </li>
            <!-- /extras -->
            
        </nav>
        <!-- /main navigation -->
      </div>
      <!-- /sidebar panel -->
      <!-- content panel -->
      <div class="main-panel">
        <!-- top header -->
        <nav class="header navbar">
          <div class="header-inner">
            <div class="navbar-item navbar-spacer-right brand hidden-lg-up">
              <!-- toggle offscreen menu -->
              <a href="javascript:;" data-toggle="sidebar" class="toggle-offscreen">
                <i class="material-icons">menu</i>
              </a>
              <!-- /toggle offscreen menu -->
              <!-- logo -->
              <a class="brand-logo hidden-xs-down">
                <img src="{{ asset('/resources/uploads/logo_white.png') }}" alt="logo"/>
              </a>
              <!-- /logo -->
            </div>
            <a class="navbar-item navbar-spacer-right navbar-heading hidden-md-down" href="{{ url('admin/dashboard') }}">
              <span>Dashboard</span>
            </a>
            <!-- <div class="navbar-search navbar-item">
              <form class="search-form">
                <i class="material-icons">search</i>
                <input class="form-control" type="text" placeholder="Search" />
              </form>
            </div> -->
            <div class="navbar-item nav navbar-nav">
              
              <a href="{{ route('logout') }}" class="nav-item nav-link nav-link-icon"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Logout </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>
            </div>
          </div>
        </nav>
        <!-- /top header -->

        <!-- BEGIN CONTENT-->
        @yield('content')
        <div class="content-footer">
            <nav class="footer-right">
              <ul class="nav">
                <li>
                  <a href="javascript:;">Feedback</a>
                </li>
              </ul>
            </nav>
            <nav class="footer-left">
              <ul class="nav">
                <li>
                  <a href="javascript:;">
                    <span>Copyright</span>
                    &copy; 2016 Your App
                  </a>
                </li>
                <li class="hidden-md-down">
                  <a href="javascript:;">Privacy</a>
                </li>
                <li class="hidden-md-down">
                  <a href="javascript:;">Terms</a>
                </li>
                <li class="hidden-md-down">
                  <a href="javascript:;">help</a>
                </li>
              </ul>
            </nav>
          </div>
        <!-- END CONTENT -->
      </div>
      <!-- /content panel -->

      

    </div>

    <!-- build:js({.tmp,app}) scripts/app.min.js -->
    <script src="{{ asset('/resources/assets/frontend/vendor/jquery/dist/jquery.js') }}"></script>
    <script src="{{ asset('/resources/assets/frontend/vendor/PACE/pace.js') }}"></script>
    <script src="{{ asset('/resources/assets/frontend/vendor/tether/dist/js/tether.js') }}"></script>
    <script src="{{ asset('/resources/assets/frontend/vendor/bootstrap/dist/js/bootstrap.js') }}"></script>
    <script src="{{ asset('/resources/assets/frontend/vendor/fastclick/lib/fastclick.js') }}"></script>
    <script src="{{ asset('/resources/assets/frontend/scripts/constants.js') }}"></script>
    <script src="{{ asset('/resources/assets/frontend/scripts/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js"></script>
    <!-- endbuild -->

    <!-- page scripts -->
    <script src="{{ asset('/resources/assets/frontend/vendor/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('/resources/assets/frontend/vendor/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('/resources/assets/frontend/vendor/flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('/resources/assets/frontend/vendor/flot-spline/js/jquery.flot.spline.js') }}"></script>
    <script src="{{ asset('/resources/assets/frontend/vendor/bower-jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('/resources/assets/frontend/data/maps/jquery-jvectormap-us-aea.js') }}"></script>
    <script src="{{ asset('/resources/assets/frontend/vendor/jquery.easy-pie-chart/dist/jquery.easypiechart.js') }}"></script>
    <script src="{{ asset('/resources/assets/frontend/vendor/noty/js/noty/packaged/jquery.noty.packaged.min.js') }}"></script>
    <script src="{{ asset('/resources/assets/frontend/scripts/helpers/noty-defaults.js') }}"></script>
    <!-- end page scripts -->

    <!-- initialize page scripts -->
    <script src="{{ asset('/resources/assets/frontend/scripts/dashboard/dashboard.js') }}"></script>
    <!-- end initialize page scripts -->

    
     </body>
</html>
