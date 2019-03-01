<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistema Dominical</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcat icon" href="{{ asset('img/favicon.jpg') }}"> <!-- Icono navegacion -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/template.css') }}"> <!-- CSS -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' /><!-- GOOGLE FONTS-->

    <style>
        .fade-enter-active, .fade-leave-active {
            transition: opacity .5s;
        }
        .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
          opacity: 0;
        }
    </style>

</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="navbar-brand" style="margin: 0; padding:0;">
                    <img src="{{ asset('img/banner.png') }}" style="width: 100%; height: 100%;">
                </div>
            </div>

            <div class="header-right">
                <!--
                <a href="message-task.html" class="btn btn-info" title="New Message"><b>30 </b><i class="fa fa-envelope-o fa-2x"></i></a>
                <a href="message-task.html" class="btn btn-primary" title="New Task"><b>40 </b><i class="fa fa-bars fa-2x"></i></a>
                -->
                <a href="{{ asset('pdf/manual_del_usuario.pdf') }}" target="_blank" class="btn btn-primary" title="Manual del Usuario"><i class="far fa-file-alt fa-2x"></i></a>

                <a class="btn btn-danger" title="Logout" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                   document.getElementById('logout-form').submit();">
                    <i class="fa fa-exclamation-circle fa-2x"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            </div>
        </nav>
        
        <div id="app">

            <sidebar></sidebar>

            <div id="page-wrapper">
                <div id="page-inner">
                   
                        <router-view></router-view>
                   
                </div>
            </div>
            
        </div>
    </div>

    <!-- JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>

</body>
</html>
