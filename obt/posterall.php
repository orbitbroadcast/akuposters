<?php include('inc/header.php');?>
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
<div class="container" style="margin: 140px auto;">
  <div style="width: 100%; height: 450px;">
    <?php
            $catid=$_GET['id'];
			$posters=get_all_posters("eventid=".$_SESSION['eventdata'][0]['id']." and status=1 and category=$catid and isapproved=1");
			for($j=0;$j<sizeof($posters);$j++){
			  $poster=$posters[$j];
		?>
    <div class="poster">
      <h4>
        <?=$poster['Title']?>
      </h4>
      <?php
      
        $posterimg=str_replace("poster/","poster/thumb_",$poster['ImageURL']);
      ?>
      <a id="example6" href="../<?=$poster['ImageURL']?>" title="<?=$poster['Title']?>"><img alt="" src="../<?=$posterimg?>" /></a> 
       <a id="various3" href="<?=empty($poster['VideoURL'])?getYoutubeEmbedUrl('https://youtu.be/r2wOMfGIat4'):getYoutubeEmbedUrl($poster['VideoURL'])?>" class="various3 poster-btn" style="width: 100%;">Watch Presentation</a>
      <a href="../<?=$poster['PDFURL']?>" class="poster-btn" target="_blank"><i class="fa fa-download"></i>&nbsp; Download PDF &nbsp;</a>
         <a class="fancyframe poster-btn" href="help-desk2.php?pid=<?=$poster['Id']?>">Q & A</a>
      <!--<a id="various1" title="" href="#inline1" class="various1 poster-btn"> Q & A </a> --></div>
    <?php
			}
		?>
  </div>
</div>
<div style="display: none;">
  <div id="inline1" style="width:750px;height:400px;overflow:auto;">
    <h2>Question & Answers</h2>
    <?=$poster['FAQ']?>
  </div>
</div>

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
<!--<script src="fancybox/jquery-1.4.3.min.js"></script> -->
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script> 
<!--<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.4.pack.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous"></script>

<!--<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.4.css" media="screen" />-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css" integrity="sha512-nNlU0WK2QfKsuEmdcTwkeh+lhGs6uyOxuUs+n+0oXSYDok5qy0EI0lt01ZynHq6+p/tbgpZ7P+yUb+r71wqdXg==" crossorigin="anonymous" />
<link rel="stylesheet" href="style.css" />
<script src="../analytics/analytics.js"></script>
<script type="text/javascript">
		$(document).ready(function() {
			/*
			*   Examples - images
			*/

			$("a#example1").fancybox();

			$("a#example2").fancybox({
				'overlayShow'	: false,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});

			$("a#example3").fancybox({
				'transitionIn'	: 'none',
				'transitionOut'	: 'none'	
			});

			$("a#example4").fancybox({
				'opacity'		: true,
				'overlayShow'	: false,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'none'
			});

			$("a#example5").fancybox();

			$("a#example6").fancybox({
				'titlePosition'		: 'outside',
				'overlayColor'		: '#000',
				'overlayOpacity'	: 0.9
			});

			$("a#example7").fancybox({
				'titlePosition'	: 'inside'
			});

			$("a#example8").fancybox({
				'titlePosition'	: 'over'
			});

			$("a[rel=example_group]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				}
			});

			/*
			*   Examples - various
			*/

			$(".various1").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});

			$("#various2").fancybox();

			$(".various3").fancybox({
				'width'				: '100%',
				'height'			: '100%',
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'type'				: 'iframe'
			});

			$("#various4").fancybox({
				'padding'			: 0,
				'autoScale'			: false,
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
			
			$('.fancyframe').fancybox({
			    toolbar  : true,
             'type':'iframe',
             'width': 800, //or whatever you want
             'height': 600
            });
			
		});
	</script>
	
	<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5fb71853920fc91564c8cafc/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</body>
</html><?php function getYoutubeEmbedUrl($url){     $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';     $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';    if (preg_match($longUrlRegex, $url, $matches)) {        $youtube_id = $matches[count($matches) - 1];    }    if (preg_match($shortUrlRegex, $url, $matches)) {        $youtube_id = $matches[count($matches) - 1];    }    return 'https://www.youtube.com/embed/' . $youtube_id ;}?>