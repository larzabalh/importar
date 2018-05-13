<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

        <!-- Bootstrap Core CSS -->
        <link href="{{ asset('css/admin/bootstrap.min.css') }}" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="{{ asset('css/admin/metisMenu.min.css') }}" rel="stylesheet">

        <!-- Timeline CSS -->
        <link href="{{ asset('css/admin/timeline.css') }}" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="{{ asset('css/admin/startmin.css') }}" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="{{ asset('css/admin/morris.css') }}" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="{{ asset('css/admin/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">

        <link rel="stylesheet" href="{{ asset('js/tooltipster/css/tooltipster.bundle.min.css') }}">
        <link rel="stylesheet" href="{{ asset('js/tooltipster/css/tooltipster-sideTip-light.min.css') }}">

        <!--
        <link rel="stylesheet" href="{{ asset('css/admin/dataTables/jquery.dataTables.min.css') }}"></script>
        <link rel="stylesheet" href="{{ asset('css/admin/dataTables/buttons.dataTables.min.css') }}"></script>
      -->

        <!-- My Styles -->

        <link rel="stylesheet" href="{{ asset('css/admin/docs.css') }}">
        <link rel="stylesheet" href="{{ asset('css/admin/app.css') }}">

        @yield('add-css')
    </head>
