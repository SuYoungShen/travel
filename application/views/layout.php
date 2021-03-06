<!DOCTYPE HTML>
 <html>
   <head>
     <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
     <meta charset="utf-8">
     <!-- Description, Keywords and Author -->
     <meta name="description" content="">
     <meta name="author" content="">
     <base href="<?=base_url();?>">

     <title>歡迎~<?=$this->session->userdata('user_name')? $this->session->userdata('user_name'):"您";?>的到來</title>
     <!-- <title>:: avana LLC ::</title> -->

     <link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon">

     <link href="assets/css/style.css" rel="stylesheet" type="text/css">
     <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
     <link href="assets/css/responsive.css" rel="stylesheet" type="text/css">
     <link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
     <link href="assets/css/sweetalert2.min.css" rel="stylesheet">

     <link href="assets/css/effects/set2.css" rel="stylesheet" type="text/css">
     <link href="assets/css/effects/normalize.css" rel="stylesheet" type="text/css">
     <link href="assets/css/effects/component.css"  rel="stylesheet" type="text/css" >
     <link href="assets/css/bootstrap-select.min.css"  rel="stylesheet" type="text/css" >
     <script src="assets/js/sweetalert2.min.js" type="text/javascript"></script>
     <script src="assets/js/jquery.min.js" type="text/javascript"></script>
     <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
     <!-- 警告視窗 -->
     <link rel="stylesheet" href="assets/css/sweetalert2.min.css">
     <script type="text/javascript" src="assets/js/sweetalert2.min.js"></script>
     <!-- 警告視窗 -->
     <!-- jquery cookie -->
     <script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
     <!-- jquery cookie -->

     <!-- DataTable -->
     <link rel="stylesheet" href="assets/css/responsive.bootstrap.min.css">
     <link rel="stylesheet" href="assets/css/dataTables.bootstrap.min.css">
     <!-- DataTable -->
     <?php
     if ($this->uri->segment(1) == 'details'){
       echo $map['js'];
     }
     ?>

     <style>
     .carousel-inner > .item > img,
     .carousel-inner > .item > a > img {
       width: 70%;
       margin: 0 auto;
     }
     .carousel-control{
       color: black;
     }
     .carousel-control.left{
       background-image: linear-gradient(to right,rgba(0,0,0,0) 0,rgba(0,0,0,0) 100%);
     }
     .carousel-control.right{
       background-image: linear-gradient(to right,rgba(0,0,0,0) 0,rgba(0,0,0,0) 100%);
     }
     figure.effect-oscar h2{
       margin: 10% 0 10px 0;
     }
     .grid-lod li a, .grid-lod li img, .main_Img{
       margin: auto;
     }
     figure.effect-oscar {
       background-color: #3085a3;
     }
   </style>

  </head>

    <body>
      <?php
        include ("header.php");
        include ($page);
        include ("footer.php");
      ?>
