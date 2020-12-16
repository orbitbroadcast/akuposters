<?php include('inc/header.php');?>
<?php

$homepage_data=get_homepage_banners("eventid=".$_SESSION['eventdata'][0]['id']);
for($j=0;$j<sizeof($homepage_data);$j++){
  $hpage_data=$homepage_data[$j];
}



/****************** Agenda Ticker DB variables ******************/
$agenda_ticker_data=select("select * from  tbl_agenda_ticker where status=1 and eventid=".$_SESSION['eventdata'][0]['id']);

$agenda_status=$agenda_ticker_data[0]['status'];
$agenda_ticker1=$agenda_ticker_data[0]['agenda_ticker1'];
$agenda_ticker2=$agenda_ticker_data[0]['agenda_ticker2'];
$agenda_ticker3=$agenda_ticker_data[0]['agenda_ticker3'];
/****************** Agenda Ticker DB variables ******************/

?>
</head>

<body class="intro" style="overflow:hidden;">

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

<a class="poster-link1" href="posterall.php?id=20"></a> 
<a class="poster-link2" href="posterall.php?id=21"></a> 
<a class="poster-link3" href="posterall.php?id=22"></a> 
<a class="poster-link4" href="posterall.php?id=23"></a> 
<a class="poster-link5" href="posterall.php?id=24"></a> 
<a class="poster-link6" href="posterall.php?id=25"></a> 
<a class="poster-link7" href="posterall.php?id=26"></a> 
<!-- 
<div class="platinium-sponser">
  <?php if($hpage_data['PlatiniumSponserURL']==""){ ?>
  <img src="assets/img/platnium.png">
  <?php } else {?>
  <img src="<?=$hpage_data['PlatiniumSponserURL']?>">
  <?php  } ?>
</div>
<div class="gold-sponser-left">
  <?php if($hpage_data['Gold1SponserURL']==""){ ?>
  <img src="assets/img/gold.png">
  <?php } else {?>
  <img src="<?=$hpage_data['Gold1SponserURL']?>">
  <?php  } ?>
</div>
<div class="silver-sponser-left">
  <?php if($hpage_data['Silver1SponserURL']==""){ ?>
  <img src="assets/img/silver.png">
  <?php } else {?>
  <img src="<?=$hpage_data['Silver1SponserURL']?>">
  <?php  } ?>
</div>
<div class="basic-sponser-left">
  <?php if($hpage_data['Basic1SponserURL']==""){ ?>
  <img src="assets/img/basic.png">
  <?php } else {?>
  <img src="<?=$hpage_data['Basic1SponserURL']?>">
  <?php  } ?>
</div>
<div class="gold-sponser-right">
  <?php if($hpage_data['Gold2SponserURL']==""){ ?>
  <img src="assets/img/gold.png">
  <?php } else {?>
  <img src="<?=$hpage_data['Gold2SponserURL']?>">
  <?php  } ?>
</div>
<div class="silver-sponser-right">
  <?php if($hpage_data['Silver2SponserURL']==""){ ?>
  <img src="assets/img/silver.png">
  <?php } else {?>
  <img src="<?=$hpage_data['Silver2SponserURL']?>">
  <?php  } ?>
</div>
<div class="basic-sponser-right">
  <?php if($hpage_data['Basic2SponserURL']==""){ ?>
  <img src="assets/img/basic.png" >
  <?php } else {?>
  <img src="<?=$hpage_data['Basic2SponserURL']?>" >
  <?php  } ?>
</div>
<a href="https://vimeo.com/showcase/7826384/embed" class="venobox video-pro mb-4" data-vbtype="iframe"><img src="assets/img/video-pro.gif"></a>
<a href="<?=$hpage_data['Video1URL']?>" class="venobox video-pro mb-4" data-vbtype="iframe"><img src="assets/img/video-pro.gif"></a> 
<iframe src="https://vimeo.com/showcase/7826384/embed" frameborder="0" allow="autoplay; fullscreen" allowfullscreen class="venobox video-pro mb-4"></iframe>
<iframe src="<?=$hpage_data['Video1URL']?>" frameborder="0" allow="autoplay; fullscreen" allowfullscreen class="video-pro"></iframe>
</div>
--> 

<!-- ======= End Main Section ======= --> 
<script>
 function login_chat_user()
    {
      chatusername="<?=$_SESSION['userdata']['username']?>";
      chatusername=chatusername.substring(0,chatusername.indexOf('@'));
      chatpassword="<?=$_SESSION['userdata']['_a']?>";
      $.ajax({
              type:'POST',
              url:'../blabax/account.php',
              data:"username="+chatusername+"&password="+chatpassword,
              success:function(res){
                    //location.href="blabax/blabax.php"
                    
                  }            
              });      
      }



      //login_chat_user();
</script>
<!--
<div class="ticker">
  <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
  <b>Scientific Program</b>: <a href="agenda.php">
  <?=$agenda_ticker1 ?>
  |
  <?=$agenda_ticker2 ?>
  |
  <?=$agenda_ticker3 ?>
  </a>
  </marquee>
</div>
-->
<?php include('inc/footer.php');?>