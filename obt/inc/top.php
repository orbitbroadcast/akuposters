<?php 
    include('database.php');
    include('functions.php');
    if(!isset($_SESSION['userdata'])){
        header('location:../index.php');
    }
?>