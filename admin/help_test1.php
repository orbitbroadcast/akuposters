<?php include('inc/header.php'); 

include('../chat_app/database_connection.php');
//print_r($_SESSION['userdata']);
?>

<?php

$user_id = $_SESSION['userdata']['userid'];
$username = $_SESSION['userdata']['username'];
$sub_query = "INSERT INTO login_details
          (user_id)
          values ('".$user_id."')";
           $statement = $connect->prepare($sub_query);
           $statement->execute();
           $_SESSION['login_details_id'] = $connect->lastInsertId();
?>
   
<div id="user_details"></div>
    <div id="user_model_details"></div>


 
    </section><!-- /.content -->




<?php include('inc/footer.php');?>