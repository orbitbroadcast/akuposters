<?php include('inc/header.php');?>
<?php 
$msg='';

if(isset($_POST['btn_submit'])){
extract($_POST);
$pid=$_GET['pid'];
 $qry="insert into tbl_helpdesk (cname,email,subject,message,pid) values('$name','$email','$subject','$message',$pid)";
  if ($conn->query($qry) === TRUE) {
      
      
      $msg= "Your message has been sent. Thank you!";
      
      $posters=get_all_posters("Id=$pid");
      $posters=$posters[0];
      $_uid=$posters['createdby'];
      $_ptitle=$posters['title'];
      $users=select("select u.*,e.firstname,e.lastname from tbl_users u inner join tbl_exhibitor_new e on u.username=e.email where userid=$_uid");
      $users=$users[0];
      $to=$users['username'];
      $_name=$users['firstname'].' '.$users['lastname'];
      $emsg="Dear $_name,<br><br>";
      $emsg.=$message."<br/><br/>";
      $emsg.="Regards<br>$name";
      
      $emsg=htmlentities($emsg);
      $emsg=html_entity_decode($emsg);
      $fromName="Information request from $name for Poster $_ptitle";
      $from=$email;
    
      // Set content-type header for sending HTML email 
      $headers = "MIME-Version: 1.0" . "\r\n"; 
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
    
      // Additional headers 
      $headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n"; 
      $headers .= "Reply-To: $email \r\n";
      $headers .= 'Cc: ' . "\r\n"; 
      $headers .= 'Bcc: ' . "\r\n"; 
    
   
      @mail($to,$subject,$emsg,$headers);
      
      
    } else {
      $msg= "Error: " . $qry . "<br>" . $conn->error;
    } 
}


?>

</head>

<body>
<!-- End Header --> 

<!-- ======= Intro Section ======= -->
<section id="contact" class="section-bg">
  <div class="container" data-aos="fade-up">
    <div class="section-header">
      <h2>Help Desk</h2>
      <p>
        <?=$msg?>
      </p>
    </div>
    <div class="form">
      <form action="help-desk2.php?pid=<?=$_GET['pid']?>" method="POST" role="form" class="">
        <div class="form-row">
          <div class="form-group col-md-6">
            <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
            <div class="validate"></div>
          </div>
          <div class="form-group col-md-6">
            <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" />
            <div class="validate"></div>
          </div>
        </div>
        <div class="form-group">
          <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
          <div class="validate"></div>
        </div>
        <div class="form-group">
          <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Message"></textarea>
          <div class="validate"></div>
        </div>
        <div class="mb-3">
          <div class="loading"></div>
          <div class="error-message"></div>
          <div class="sent-message">
          </div>
        </div>
        <div class="text-center">
          <button type="submit" name="btn_submit">Send Message</button>
        </div>
      </form>
    </div>
  </div>
</section>

<?php include('inc/footer.php');?>