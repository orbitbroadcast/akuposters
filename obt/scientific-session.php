<?php include('inc/header.php');

$homepage_data=get_homepage_banners("eventid=".$_SESSION['eventdata'][0]['id']);
for($j=0;$j<sizeof($homepage_data);$j++){
  $hpage_data=$homepage_data[$j];
}

?>

</head>

<body class="scientific-session" style="overflow:hidden;">

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

<a class="main-scientific-session" href="main-plenary.php"></a> 
<!-- <a class="free-papers" href="session.php?id=11&hid=179"></a> 
<a class="technologist-corner" href="session.php?id=11&hid=180"></a> --> 
<!--<a class="poster-gat" href="session.php?id=13&hid=181"></a> --> 
<a class="poster-gat" href="main-plenary.php"></a> 

<!-- ======= End Main Section ======= --> 

<?php include('inc/footer.php');?>