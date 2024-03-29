<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
      <meta property="og:description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <title>Dashborad Admin</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin/main.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin/sweetalert.css')}}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="{{ asset('js/admin/jquery-3.2.1.min.js')}}"></script>
  <script src="{{ asset('js/admin/ckeditor/ckeditor.js')}}"></script>
  <script src="{{ asset('js/admin/plugins/sweetalert.min.js')}}"></script>
  <script type="text/javascript">
    var APP_URL = {!! json_encode(url('/')) !!}
  </script>
  </head>
  <body class="app sidebar-mini rtl">
    
@include('Admin.includes.admin_header')
<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
@include('Admin.includes.admin_sidebar')
<main class="app-content">
@include('flash-message')
@yield('content')
 </main>
 
    <!-- Essential javascripts for application to work ABCD-->
	
  <script src="{{ asset('js/admin/popper.min.js')}}"></script>
	<script src="{{ asset('js/admin/bootstrap.min.js')}}"></script>
	<script src="{{ asset('js/admin/plugins/pace.min.js')}}"></script>
  <script src="{{ asset('js/admin/main.js')}}"></script>
   
  </body>
</html>


