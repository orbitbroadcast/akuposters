<?php
   session_start();

     $servername = "localhost";
     $username = "akuposters_danxkan";
    $password = '5D5;glg$45_s';
    $dbname = "akuposters_almubdi";
    // Create connection
    $conn = mysqli_connect($servername, $username, $password,$dbname);

$event_on_off=@$_SESSION['eventdata'][0]['onoff'];
    if($event_on_off==0)
    {
        if($_SESSION['userdata']['username']!="admin" || $_SESSION['userdata']['roleid']!=1)
        {
           // session_destroy();
        }
    }
    // Check connection
    if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    }
    //echo "Connected successfully";
    
?>