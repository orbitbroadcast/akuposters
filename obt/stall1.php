<?php include('inc/header.php');?>
</head>
<body class="stall-bg" style="background-image: url(/uploads/ext/stall1.jpg);">

<!-- ======= Header ======= -->

<header id="header">
  <div class="container">
    <div id="logo" class="pull-left"> </div>
    <?php include('inc/nav.php');?>
    <!-- #nav-menu-container --> 
    
  </div>
</header>
<!-- End Header --> 

<!-- ======= Exhibitors Section ======= -->

<?php

$id=$_GET['id'];
$exhibitors=get_all_exhibitors("id=1");
$exhibitor=$exhibitors[0];

$poster1=@explode(".",str_replace('../','',$exhibitor['poster1']))[1];
$poster2=@explode(".",str_replace('../','',$exhibitor['poster2']))[1];
$pdf1=@explode(".",str_replace('../','',$exhibitor['pdf1']))[1];
$pdf2=@explode(".",str_replace('../','',$exhibitor['pdf2']))[1];
$pdf5=@explode(".",str_replace('../','',$exhibitor['pdf5']))[1];

?>
<a href="<?=$exhibitor['videourl']?>" class="venobox video-stall-link mb-4" data-vbtype="video" data-autoplay="true"></a> 
<a href="exhibitors.php" class="close" data-vbtype="video" data-autoplay="true"><i class="fas fa-times-circle"></i></a>
<div id="options"> <a href="exhibitors.php" class="exhibitors-hall-icon">Exhibitors Hall</a>
  <?php if(strlen($exhibitor['videourl'])>0){ ?>
  <div class="session-container" >
    <a href="<?=$exhibitor['videourl']?>" class="venobox video-icon mb-4" data-vbtype="video" data-autoplay="true">Video</a> </div>
  <?php } ?>
  <?php if(strlen($poster1)>0){ ?>
  <a href="<?=$exhibitor['poster1']?>" target="_blank" class="pdf-icon">Poster 1</a>
  <?php } ?>
  <?php if(strlen($poster2)>0){ ?>
  <a href="<?=$exhibitor['poster2']?>" target="_blank"  class="pdf-icon">Poster 2</a>
  <?php } ?>
  <?php if(strlen($pdf1)>0){ ?>
  <a href="<?=$exhibitor['pdf1']?>" target="_blank"  class="pdf-icon">Poster 3</a>
  <?php } ?>
  <?php if(strlen($pdf2)>0){ ?>
  <a href=".<?=$exhibitor['pdf2']?>" target="_blank"  class="pdf-icon">Poster 4</a>
  <?php } ?>
  <?php if(strlen($pdf5)>0){ ?>
  <a href=".<?=$exhibitor['pdf5']?>" target="_blank" class="pdf-icon">Poster 5</a>
  <?php }?>
  <a href="video-chat.php?url=https://meet.jit.si/HIGH-Q" class="video-chat-icon venobox video-icon mb-4" data-vbtype="iframe">Video Chat</a> </div>

<!-- End Exhibitors Section --> 

<?php include('inc/footer.php');?>