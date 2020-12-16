<?php include('inc/header.php');
$biographies=get_all_biographies('id='.$_GET['id']);

$bography=$biographies[0];

?>
</head>

<body>
<section id="speakers-details">
  <div class="container">
    <div class="section-header">
      <h2>Speaker Details</h2>
      <p>
        <?=$bography['position']?>
      </p>
    </div>
    <div class="row">
      <div class="col-md-6"> <img src="../<?=$bography['image']?>" alt="Speaker 1" class="img-fluid"> </div>
      <div class="col-md-6">
        <div class="details">
          <h2>
            <?=$bography['title']?>
          </h2>
          <div class="social">
            <?php if($bography['twitter']!=""){ ?>
            <a href="<?=$bography['twitter']?>" target="_blank"><i class="fa fa-twitter"></i></a>
            <?php }?>
            <?php if($bography['facebook']!=""){ ?>
            <a href="<?=$bography['facebook']?>" target="_blank"><i class="fa fa-facebook"></i></a>
            <?php }?>
            <?php if($bography['google']!=""){ ?>
            <a href="<?=$bography['google']?>" target="_blank"><i class="fa fa-google-plus"></i></a>
            <?php }?>
            <?php if($bography['linkedin']!=""){ ?>
            <a href="<?=$bography['linkedin']?>" target="_blank"><i class="fa fa-linkedin"></i></a>
            <?php }?>
          </div>
          <?=$bography['description']?>
        </div>
      </div>
    </div>
  </div>
</section>
</main>
</div>
<?php include('inc/footer.php');?>
