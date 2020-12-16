<?php include('inc/header.php');?>
    <script language="javascript" type="text/javascript">
        function OpenPopupCenter(pageURL, title, w, h) {

            var left = (screen.width - w) / 2;

            var top = (screen.height - h) / 4;  // for 25% - devide by 4  |  for 33% - devide by 3

            var targetWin = window.open(pageURL, title, 'toolbar=no, location=no, directories=no, status=no, titlebar=no,  menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

        } 

    </script>
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

<!-- ======= Speaker Section ======= -->
<section id="speakers">
      <div class="container" data-aos="fade-up">
    <div class="section-header">
          <h2>Faculty</h2>
        </div>
    <div class="row" class="content">
    <?php 
         $biographies=get_all_biographies("eventid=".$_SESSION['eventdata'][0]['id']." and status=1");
         for($i=0;$i<sizeof($biographies);$i++){
    
    ?>
    <div class="col-lg-4 col-md-6">
          <div class="speaker" data-aos="fade-up" data-aos-delay="100"> <a href="speaker-details.php?id=<?=$biographies[$i]['id']?>" class="venobox mb-4" data-vbtype="iframe" ><img src="../<?=$biographies[$i]['image']?>" alt="Speaker 1" class="img-fluid" height="260"></a>
        <div class="details">
              <h3> <a href="speaker-details.php?id=<?=$biographies[$i]['id']?>" class="venobox mb-4" data-vbtype="iframe" >
                <?=$biographies[$i]['title']?>
                </a> </h3>
              <p>
            <?=$biographies[$i]['position']?>
          </p>
              <div class="social"> <a href=""><i class="fa fa-twitter"></i></a> <a href=""><i class="fa fa-facebook"></i></a> <a href=""><i class="fa fa-google-plus"></i></a> <a href=""><i class="fa fa-linkedin"></i></a> </div>
            </div>
      </div>
        </div>
    <?php }?>
  </div>
      </div>
    </section>
<!-- End Speakers Section --> 

<?php include('inc/footer.php');?>