<?php
    include('inc/database.php');
    session_destroy();    
    header('location:index.php');
?>