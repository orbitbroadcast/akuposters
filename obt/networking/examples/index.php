<?php
   session_start();
  ?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>phpFreeChat - default theme and default parameters</title>

  <meta name="viewport" content="width=device-width" />


  <script src="../client/lib/jquery-1.8.2.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../client/themes/default/jquery.phpfreechat.min.css" />
  <!-- <script src="../client/jquery.phpfreechat.min.js" type="text/javascript"></script> -->
  <script src="../client/chat.js" type="text/javascript"></script>


  
</head>
<body>
  <header>

  </header>
  <div role="main">
    <input type="hidden" id="hdnusername" name="hdnusername" value="<?=$_SESSION['userdata']['username']?>"/>
    <br>
    <br>
    <div class="pfc-hook"></div>
    <script type="text/javascript">
    $('.pfc-hook').phpfreechat();
    $('.popup-login').hide();
    $('.popup-login').find('[type=submit]')
    </script>

  </div>
  <footer>

  </footer>
</body>
</html>