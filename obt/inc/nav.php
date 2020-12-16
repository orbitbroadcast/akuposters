<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-PPJWEBX0YR"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-PPJWEBX0YR');
</script>

  
<nav id="nav-menu-container">
      <ul class="nav-menu">
            <li <?=(basename($_SERVER['PHP_SELF'])=='home.php')?'class="menu-active"':'';?>><a href="index.php" title="Home"><i class="fas fa-home"></i></a></li>
<!--            <li <?=(basename($_SERVER['PHP_SELF'])=='profile.php')?'class="menu-active"':'';?>><a href="profile.php" title="Profile"><i class="fas fa-user-circle"></i></a></li>
        <li <?=(basename($_SERVER['PHP_SELF'])=='notification.php')?'class="menu-active"':'';?>><a href="notification.php" title="Notification"><i class="fas fa-bell"></i></a></li>
        <li <?=(basename($_SERVER['PHP_SELF'])=='agenda.php')?'class="menu-active"':'';?>><a href="agenda.php" title="Scientific Program">Scientific Program</a>
        <ul>
                <li><a href="meeting-at-a-glance.php">Program at A Glance</a></li>
                <li><a href="#">Scientific Program</a>
                <ul><li><a href="agenda.php">Main Scientific Session (Hall A)</a></li><li><a href="agenda2.php">Free papers  (Hall B)</a></li><li><a href="agenda3.php">Technologist Corner (Hall C)</a></li></ul></li>
        </ul>
        --></li>

<?php if($_SESSION['eventdata'][0]['hasmain']==1 || $_SESSION['eventdata'][0]['halls']==1){?>
        <!--<li><a href="scientific-session.php">Scientific Sessions</a>-->
        <li class="level-2"><a href="main-plenary.php">Scientific Sessions</a>
        <!--<li class="level-1"><a href="https://webinar.gomeet.com/337-326-997" target="_blank">Scientific Sessions</a>-->
        <li class="level-1"><a href="<?=$_SESSION['eventdata'][0]['main_url'] ?>" target="_blank">Scientific Sessions</a>
         
<!--        
          <ul>  
        <?php if($_SESSION['eventdata'][0]['hasmain']==1){?>
        <li <?=(basename($_SERVER['PHP_SELF'])=='main-plenary.php')?'class="menu-active"':'';?>><a <?=$target?> href="main-plenary.php">Main Scientific Session (Hall A)</a></li>
        <?php }?>

        <?php if($_SESSION['eventdata'][0]['halls']==1){?>
    <li <?=preg_match("/session/i",basename($_SERVER['PHP_SELF']))?'class="menu-active"':'';?>><a href="#">Sessions</a> 

          
           <?php
                $links=array("Free papers  (Hall B)","Technologist Corner (Hall C)");
                $categories=get_hall_url('eventid='.$_SESSION['eventdata'][0]['id']);
                for($i=0;$i<sizeof($categories);$i++){
            ?>
            <li><a <?=$target?> href="session.php?id=<?=$categories[$i]['eventid']?>&hid=<?=$categories[$i]['hallurl_id']?>"> <?=$links[$i]?></a></li>
            <?php } }?>
            
          </ul>-->
        </li>
                <?php 
                }?>
      <?php if($_SESSION['eventdata'][0]['poster']==1 || $_SESSION['eventdata'][0]['abstract']==1 ){?>
	   <li <?=(basename($_SERVER['PHP_SELF'])=='poster.php' || basename($_SERVER['PHP_SELF'])=='abstract.php')?'class="menu-active"':'';?>><a href="poster.php">Posters</a>
      <ul>
                <?php if($_SESSION['eventdata'][0]['poster']==1){?>
		           <?php
                            $_top_event_id=(isset($_SESSION['eventdata'][0]['id']))?$_SESSION['eventdata'][0]['id']:0;
                            $categories=get_all_categories("eventid=$_top_event_id and status=1");
                            for($i=0;$i<sizeof($categories);$i++){
                ?>
                <li><a href="posterall.php?id=<?=$categories[$i]['catid']?>"><?=$categories[$i]['catname']?></a></li>
                <?php
                            }
                ?>
                <?php }?>
                <?php if($_SESSION['eventdata'][0]['abstract']==1) { ?>
            	<li><a href="abstract.php">Abstract</a></li>
                <?php }?>
              </ul>
              </li>
      <?php }?>

      <?php if($_SESSION['eventdata'][0]['exhibitor']==1){?>
	 <li <?=(basename($_SERVER['PHP_SELF'])=='exhibitors.php')?'class="menu-active"':'';?>><a href="exhibitors.php">Exhibitors</a>
	    <ul>
	        <li><a href="stall1.php">Platinum - HIGH-Q</a></li>
	        <li><a href="#">Gold</a>
	            <ul>
	                   <li><a href="stall2.php">Hilton</a></li>
	                   <li><a href="stall3.php">Sami</a></li>
	                   <li><a href="stall4.php">Getz Pharma</a></li>
	                   <li><a href="stall5.php">AGP</a></li>
	                   <li><a href="stall6.php">Ferozsons</a></li>
	                   <li><a href="stall7.php">Metier Groupe</a></li>
	           </ul>
	       </li>
	    </ul>
	 </li>
      <?php }?>
      <?php if($_SESSION['eventdata'][0]['biography']==1){?>
        <li <?=(basename($_SERVER['PHP_SELF'])=='biographies.php')?'class="menu-active"':'';?>><a href="biographies.php">Faculty</a></li>
        <?php }?>
        <?php if($_SESSION['eventdata'][0]['networking']==1){?>
        <li <?=(basename($_SERVER['PHP_SELF'])=='networking.php')?'class="menu-active"':'';?>><a href="networking.php">Live Chat</a></li>
        <?php }?>
        <?php if($_SESSION['eventdata'][0]['attendees']==1){?>
        <li <?=(basename($_SERVER['PHP_SELF'])=='attendees.php')?'class="menu-active"':'';?>><a href="attendees.php">Attendees</a></li>
        <?php }?>
        <?php if($_SESSION['eventdata'][0]['help_desk']==1){?>
        <li class="buy-tickets"><a href="help-desk.php">May I Help You?</a></li>
        <?php }?>
        <li><a href="signout.php?t=<?=$_SESSION['eventdata'][0]['form_token']?>"><i class="fas fa-power-off"></i></a></li>
      </ul>

    </nav>