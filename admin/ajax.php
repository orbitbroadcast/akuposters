<?php
include('inc/database.php'); 
include('inc/functions.php'); 

if(!isset($_SESSION['userdata'])){
    die("Please login first");
}
if(isset($_POST['action']) && $_POST['action']=='setevent'){
    set_selected_event($_POST['eventid']);
}


if(isset($_POST['action']) && $_POST['action']=='setstatus'){
    $table=$_POST['p'];
    $ids=explode('|',$_POST['id']);
    $vs=explode('|',$_POST['v']);
    
    for($i=0;$i<sizeof($ids);$i++)
    {
        $id=$ids[$i];
        $v=$vs[$i];
        set_status($table,$id,$v);   
    }
}

if(isset($_POST['action']) && $_POST['action']=='loadtemplate'){
    $templateid=$_POST['templateid'];
    $result=load_templates($templateid);
    if(sizeof($result)>0){
        header('Content-Type: application/json');
        echo json_encode($result);
    }else{
        echo "No data found.";
    }
}

if(isset($_POST['action']) && $_POST['action']=='onoffevent'){
    onOffEvent();
}

if(isset($_POST['action']) && $_POST['action']=='aprjposter'){
 
    $pids=explode('|',$_POST['id']);
    $turns=explode('|',$_POST['turn']);
    for($i=0;$i<sizeof($pids);$i++){
        $pid=$pids[$i];
        $turn=$turns[$i];
        approvePoster($turn,$pid);
    }
}

if(isset($_REQUEST['action']) && $_REQUEST['action']=='getposters'){
      
    $result=getPosters();
    
    if(sizeof($result)>0){
        header('Content-Type: application/json');
        echo json_encode($result);
    }else{
        echo "No data found.";
    }
    
}
function set_status($table,$id,$val){
    global $conn;
    $tables=array(
        "user"=>"update tbl_users set status=$val where userid=$id",
        "event"=>"update tbl_events set status=$val where eventid=$id",
        "agenda"=>"update tbl_agenda set status=$val where id=$id",
        "exhibitor"=>"update tbl_exhibitor set status=$val where id=$id",
        "poster"=>"update tbl_poster set status=$val where id=$id",
        "biographies"=>"update tbl_biographies set status=$val where id=$id"
   );

   $qry=$tables[$table];
   if ($conn->query($qry) === TRUE) {
    echo "Record updated successfully";  
  } else {
    echo "Error: " . $qry . "<br>" . $conn->error;
  }  
}
function set_selected_event($eventid){
    $_SESSION['selected_event_id']=$eventid;
    echo get_selected_event();
}

function get_selected_event(){
    return $_SESSION['selected_event_id'];
}
function onOffEvent(){
    global $conn;
    $onoffevent=$_POST["action"];
    $eid=$_POST["eventid"];
    $turn=$_POST['turn'];
    
    $qry="update tbl_eventsnew set onoff=$turn where id=$eid";
    if ($conn->query($qry) === TRUE) {
    echo "Record updated successfully";  
  } else {
    echo "Error turning ".($turn>0)?'on':'off'." the event";
  }  
    
    
}

function approvePoster($turn,$pid){
    global $conn;
    $aprjposter=$_POST["action"];
    $userid=$_SESSION['userdata']['userid'];
    
    $qry="update  tbl_poster set isapproved=$turn,approvedby=$userid where id=$pid";
    if ($conn->query($qry) === TRUE) {
    echo "Record updated successfully";  
  } else {
    echo "Error turning ".($turn>0)?'approving':'rejecting'." the poster";
  }  
    
    
}


function getPosters(){
    
     $_top_event_id=(isset($_SESSION['selected_event_id']))?$_SESSION['selected_event_id']:0;
                       
    $userid=$_SESSION['userdata']['userid'];
    $roleid=$_SESSION['userdata']['roleid'];
    $isapprover=$_SESSION['userdata']['isapprover'];
    
    if($roleid==1 || $roleid==2)
    {
        $categories=get_all_posters("p.eventid=$_top_event_id");
    }
    else
    {
        $categories=get_all_posters("p.eventid=$_top_event_id and p.createdby=$userid");
    }
  
    return  $categories;
}
?>