<?php include('inc/header.php');?>
<?php
$msg='';
if(isset($_POST['btn_submit'])){
extract($_POST);
  $eventid=$_SESSION['eventdata'][0]['id'];
  $qry="insert into tbl_helpdesk (cname,email,subject,message,eventid) values('$name','$email','$subject','$message',$eventid)";
  
  if ($conn->query($qry) === TRUE) {
      $msg= "Your message has been sent. Thank you!";
    } else {
      $msg= "Error: " . $qry . "<br>" . $conn->error;
    } 
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

<!-- ======= Intro Section ======= -->

<iframe src="https://tawk.to/chat/5fb71853920fc91564c8cafc/default" frameborder="0" style="overflow:hidden;height:100%;width:100%; position:absolute;top:0px;left:0px;right:0px;bottom:0px" height="100%" width="100%" ></iframe>
<a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a> 

<!-- Vendor JS Files --> 
<!-- <script src="assets/vendor/php-email-form/validate.js"></script>  --> 
<script src="assets/vendor/jquery/jquery.min.js"></script> 
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> 
<script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script> 
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