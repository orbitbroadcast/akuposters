<?php include('inc/header.php');?>
<?php 
    $url=$_SESSION['eventdata'][0]['main_url']; 
    
    if($url!="" && $_SESSION['userdata']['roleid']==0){
  ?>
<script>
    location.href="<?=$url?>";
  </script>
<?php
    }
  ?>

</head>
<body>
<!-- ======= Header ======= -->
<header id="header">
  <div class="container">
    <div id="logo" class="pull-left"> </div>
    <?php include('inc/nav.php');?>
    <!-- #nav-menu-container --> 
  </div>
</header>
<!-- End Header --> 

<!-- ======= Main Section ======= -->

<?php 
    $url=$_SESSION['eventdata'][0]['main_url']; 
  ?>
<section id="session" class="session">
  <iframe frameborder="0" style="height: 100%; overflow:scroll; width: 100%; margin:0 auto;" allow="camera *; microphone *;" src="meeting.php?url=<?=$url?>" ></iframe>
</section>

<!-- ======= End Main Section ======= --> 

<a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a> 
<!-- Vendor JS Files --> 
<script src="assets/vendor/jquery/jquery.min.js"></script> 
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> 
<script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script> 
<script src="assets/vendor/php-email-form/validate.js"></script> 
<script src="assets/vendor/venobox/venobox.min.js"></script> 
<script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script> 
<script src="assets/vendor/superfish/superfish.min.js"></script> 
<script src="assets/vendor/hoverIntent/hoverIntent.js"></script> 
<script src="assets/vendor/aos/aos.js"></script> 

<!-- Template Main JS File --> 
<script src="assets/js/main.js"></script> 
<script src="../analytics/analytics.js"></script>
</body>
</html>