<?php
    session_start();

     $servername = "localhost";
     $username = "akuposters_danxkan";
    $password = '5D5;glg$45_s';
    $dbname = "akuposters_almubdi";
    // Create connection
    $conn = mysqli_connect($servername, $username, $password,$dbname);

    // Check connection
    if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    }
    //echo "Connected successfully";
?>