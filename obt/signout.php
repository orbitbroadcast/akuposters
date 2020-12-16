<?php
    include('inc/database.php');
        
    $qry="delete from tbl_loggedin_user where userid=".$_SESSION['userdata']["userid"];
    if ($conn->query($qry) === TRUE) {
    
    } else {
    
    } 
    session_destroy();
    header('location:../index.php?t='.$_GET['t']);
?>