<!doctype html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> {{ $general->sitename(__($pageTitle)) }}</title>
    @include('partials.seo')
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/bootstrap.min.css') }}">
    <!-- fontawesome 5  -->
    <link rel="stylesheet" href="{{asset('assets/global/css/all.min.css')}}">
    <!-- line-awesome webfont -->
    <link rel="stylesheet" href="{{asset('assets/global/css/line-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/owl.min.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/odometer.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/main.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue.'css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset($activeTemplateTrue. 'css/color.php?color='.$general->base_color.'&secondColor='.$general->secondary_color) }}">
    <link rel="shortcut icon" href="{{ getImage('assets/images/logoIcon/favicon.png', '128x128') }}"
        type="image/x-icon">
    <link rel="stylesheet" href="{{asset('assets/shop/global.css')}}">
    <link rel="stylesheet" href="{{asset('assets/shop/index.css')}}">
    <link rel="stylesheet" href="{{asset('assets/shop/shop.css')}}">

</head>
<body>
    <div id="app">
    <example-component ></example-component>
    @yield('content')
    </div>

        
    <script src="{{asset('assets/global/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{ asset($activeTemplateTrue.'js/modernizr-3.6.0.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue.'js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue.'js/bootstrap.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue.'js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue.'js/magnific-popup.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue.'js/owl.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue.'js/wow.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue.'js/odometer.min.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue.'js/viewport.jquery.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue.'js/nice-select.js') }}"></script>
    <script src="{{ asset($activeTemplateTrue.'js/zoomsl.min.js')}}"></script>
    <script src="{{ asset($activeTemplateTrue.'js/main.js') }}"></script>
    <script src="{{ asset('core/public/js/app.js')}}" defer></script>


    <!-- clarity -->
@if(env('APP_ENV') != 'local')
<script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "ftk1l71o4c");
</script>
@endif


    {{-- Script File pushed from blades --}}
    @stack('script-lib')
    {{-- Load third party plugins --}}
    @include('partials.plugins')
    {{-- Load izitoast --}}
    @include('partials.notify')
    {{-- Javascript Codes By Backend Dev --}}
    @include($activeTemplate.'script.main')
    {{-- Scripts pushed from blades --}}
    @stack('script')

    <script>
        'use strict';

        $('.policy').on('click',function(){
            $.get('{{route('cookie.accept')}}', function(response){
                $('.cookie__wrapper').removeClass('show');
            });
        });

        setTimeout(() => {
            $('.cookie__wrapper').addClass('show');
        }, 2000);

    </script>
</body>

</html>
