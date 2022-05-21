<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<link rel="icon" href="<?= APP_LOGO ?>" />
<meta name="description" content="Sistemas Online">

<title>Histema Helpdesk </title>
<!-- angular  -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.8.2/angular-csp.min.css" integrity="sha512-nptw3cPhphu13Dy21CXMS1ceuSy2yxpKswAfZ7bAAE2Lvh8rHXhQFOjU+sSnw4B+mEoQmKFLKOj8lmXKVk3gow==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.8.2/angular.min.js" integrity="sha512-7oYXeK0OxTFxndh0erL8FsjGvrl2VMDor6fVqzlLGfwOQQqTbYsGPv4ZZ15QHfSk80doyaM0ZJdvkyDcVO7KFA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.8.2/angular-csp.min.css" integrity="sha512-nptw3cPhphu13Dy21CXMS1ceuSy2yxpKswAfZ7bAAE2Lvh8rHXhQFOjU+sSnw4B+mEoQmKFLKOj8lmXKVk3gow==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- <link css panel de plantillas"> -->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="public/assets/css/bootstrap.css">
<link rel="stylesheet" href="public/assets/vendors/simple-datatables/style.css">
<link rel="stylesheet" href="public/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
<link rel="stylesheet" href="public/assets/vendors/bootstrap-icons/bootstrap-icons.css">
<link rel="stylesheet" href="public/assets/css/app.css">
<link rel="stylesheet" href="public/assets/css/pages/error.css">
<link rel="stylesheet" href="public/assets/css/pages/auth.css">

<!-- Include Choices CSS -->
<link rel="stylesheet" href="public/assets/vendors/choices.js/choices.min.css" />

<!-- css  -->
<?php
APP_DIRS::GET_ALL_APP_DIRS('app/src/css', '', 'css');
?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-PMjWzHVtwxdq7m7GIxBot5vdxUY+5aKP9wpKtvnNBZrVv1srI8tU6xvFMzG8crLNcMj/8Xl/WWmo/oAP/40p1g==" crossorigin="anonymous" />
<!-- ==========================================ALERTIFY======================================================================== -->
<!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css" />
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css" />
<!-- SweetAlert -->
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>
<script src="public/assets/js/jquery-3.2.1.min.js"></script>
<!-- <script src="https://cdn.zingchart.com/zingchart.min.js"></script> -->
<script src="plugin/chart/zingchart.min.js"></script>