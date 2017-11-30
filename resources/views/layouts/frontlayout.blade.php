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
    <!-- endbuild -->

    </head>
    <body>
        <!-- BEGIN CONTENT-->
        @yield('content')
        <!-- END CONTENT -->
   

    <!-- main area -->
        <div class="main-content">
          <div class="content-view"></div>
          <!-- bottom footer -->
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
          <!-- /bottom footer -->
        </div>
        <!-- /main area -->

    <!-- build:js({.tmp,app}) scripts/app.min.js -->
    <script src="{{ asset('/resources/assets/frontend/vendor/jquery/dist/jquery.js') }}"></script>
    <script src="{{ asset('/resources/assets/frontend/vendor/pace/pace.js') }}"></script>
    <script src="{{ asset('/resources/assets/frontend/vendor/tether/dist/js/tether.js') }}"></script>
    <script src="{{ asset('/resources/assets/frontend/vendor/bootstrap/dist/js/bootstrap.js') }}"></script>
    <script src="{{ asset('/resources/assets/frontend/vendor/fastclick/lib/fastclick.js') }}"></script>
    <script src="{{ asset('/resources/assets/frontend/scripts/constants.js') }}"></script>
    <script src="{{ asset('/resources/assets/frontend/scripts/main.js') }}"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js"></script>
    <!-- endbuild -->

    <!-- page scripts -->
    <!-- end page scripts -->

    <!-- initialize page scripts -->
    <!-- end initialize page scripts -->

     </body>
</html>
