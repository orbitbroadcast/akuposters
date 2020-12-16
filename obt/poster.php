<?php include('inc/header.php');?>
<?php


$homepage_data=get_homepage_banners("eventid=".$_SESSION['eventdata'][0]['id']);
for($j=0;$j<sizeof($homepage_data);$j++){
  $hpage_data=$homepage_data[$j];
}

?>

</head>

<body id="poster">

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
<div class="poster-container">
  <?php if($_SESSION['eventdata'][0]['poster']==1){?>
  <?php
                            $_top_event_id=(isset($_SESSION['eventdata'][0]['id']))?$_SESSION['eventdata'][0]['id']:0;
                            $categories=get_all_categories("eventid=$_top_event_id and status=1");
                            for($i=0;$i<sizeof($categories);$i++){
                ?>
  <div class="poster-frame"  data-aos="fade-up" data-aos-delay="100"><a href="posterall.php?id=<?=$categories[$i]['catid']?>"><img src="<?=$categories[$i]['catimage']?>">
    <p>
      <?=$categories[$i]['catname']?>
    </p>
    </a></div>
  <?php
                            }
                ?>
  <?php }?>
</div>

<!-- ======= End Main Section ======= -->

<?php include('inc/footer.php');?>
