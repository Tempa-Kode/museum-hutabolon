<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <meta name="keywords"
        content="HTML5,CSS3,HTML,Template,Multi-Purpose,M_Adnan,Corporate Theme,Museum HTML5 Template Purpose,Museum - Premium HTML5 Template,Museum - Premium HTML5 Template">
    <meta name="description" content="Museum - Premium HTML5 Template">
    <meta name="author" content="M_Adnan">

    <!-- FONTS ONLINE -->
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:500,600,700,100,800,900,400,200,300' rel='stylesheet'
        type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,800,700italic'
        rel='stylesheet' type='text/css'>

    <!--MAIN STYLE-->
    <link href="{{ asset('home/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('home/css/main.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('home/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('home/css/responsive.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('home/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('home/rs-plugin/css/settings.css') }}" media="screen" />
    <style>
        .slider-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(220, 100, 30, 0.6); /* Ganti warna dan opacity sesuai kebutuhan */
            z-index: 1;
            pointer-events: none;
        }
        .tp-banner li {
            position: relative;
        }
        .tp-caption, .tp-resizeme {
            z-index: 2;
            position: relative;
        }
    </style>
</head>

<body>

    <!-- Page Wrap -->
    <div id="wrap">

        <!-- Header -->
        <header>
            <!-- Top Bar -->
            <div class="container">
                <div class="top-bar">
                    <div class="open-time">
                        <p><i class="ion-ios-clock-outline"></i>  Jam buka museum: 8.00 WIB hingga 17.00 WIB. Buka setiap hari</p>
                    </div>
                    <div class="call">
                        <p><i class="ion-headphone"></i> 1800 123 4659</p>
                    </div>
                </div>
            </div>

            <!-- Logo -->
            <div class="container">
                <div class="logo"> <a href="#."><img src="{{ asset('home/images/logo.png') }}"alt=""></a> </div>

                <!-- Nav -->
                <nav>
                    <ul id="ownmenu" class="ownmenu">
                        <li class="active"><a href="{{ route('home') }}">HOME</a></li>
                        <li><a href="gallery.html"> Gallery </a></li>
                        <li><a href="event.html"> EVENT </a></li>
                        <li><a href="contact.html"> Contact</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <!-- Header End -->
        @yield('body')

         <!--======= Footer =========-->
        <footer>
            <div class="container">

                <!-- Footer Link -->

                <ul class="foot-link">
                    <li><a href="{{ route('home') }}">Home </a></li>
                    <li><a href="#."> Gallery </a></li>
                    <li><a href="#."> Events </a></li>
                    <li><a href="#."> Contact</a></li>
                </ul>
                <!-- Footer Logo -->
                <div class="foot-logo"> <img src="{{ asset('home/images/logo-footer.png') }}" alt=""> </div>

                <!-- Footer Logo -->
                <div class="under-footer">
                    <ul class="con-info">
                        <li>
                            <p> <i class="fa fa-map-marker"></i>Jalan Pelabuhan, Simanindo Sangkal, Simanindo, Samosir Regency, North Sumatra 22395</p>
                        </li>
                        {{-- <li>
                            <p> <i class="fa fa-phone"></i>(123) 456-7890</p>
                        </li>
                        <li>
                            <p> <i class="fa fa-envelope"></i>mail@museum.com</p>
                        </li> --}}
                    </ul>
                    {{-- <ul class="social-link">
                        <li><a href="#.">Facebook </a></li>
                        <li><a href="#."> Twitter </a></li>
                        <li><a href="#."> Linkedin </a></li>
                        <li><a href="#."> instagram </a></li>
                    </ul> --}}
                </div>
            </div>
        </footer>

    </div>
    <!-- Wrap End -->

    <script src="{{ asset('home/js/jquery-1.11.0.min.js') }}"></script>
    <script src="{{ asset('home/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('home/js/own-menu.js') }}"></script>
    <script src="{{ asset('home/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('home/js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('home/js/smooth-scroll.js') }}"></script>
    <script src="{{ asset('home/js/jquery.prettyPhoto.js') }}"></script>

    <!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
    <script type="text/javascript" src="{{ asset('home/rs-plugin/js/jquery.themepunch.tools.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('home/rs-plugin/js/jquery.themepunch.revolution.min.js') }}"></script>
    <script src="{{ asset('home/js/main.js') }}"></script>
    <script type="text/javascript">
        /*-----------------------------------------------------------------------------------*/
        /*  SLIDER REVOLUTION
        /*-----------------------------------------------------------------------------------*/
        jQuery('.tp-banner').show().revolution({
            dottedOverlay: "none",
            delay: 10000,
            startwidth: 1170,
            startheight: 630,
            navigationType: "bullet",
            navigationArrows: "solo",
            navigationStyle: "preview4",
            parallax: "mouse",
            parallaxBgFreeze: "on",
            parallaxLevels: [7, 4, 3, 2, 5, 4, 3, 2, 1, 0],
            keyboardNavigation: "on",
            shadow: 0,
            fullWidth: "on",
            fullScreen: "off",
            shuffle: "off",
            autoHeight: "off",
            forceFullWidth: "off",
            fullScreenOffsetContainer: ""
        });
    </script>
    </script>
</body>

</html>
