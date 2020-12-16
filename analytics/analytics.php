<?php
/****************************************/
/*Author:Zia Haider                     */
/*Date:19th Nov, 2020 11:40 PM          */
/****************************************/


include('../obt/inc/top.php');

/*$id,
$userid,
$loggedin,
$loggedout,
$page,
$pagein,
$pageout,
$ip
$eventid*/

if(isset($_REQUEST['action']) && $_REQUEST['action']=='init'){    
    echo "Initialized";
}else if(isset($_REQUEST['action']) && $_REQUEST['action']=='track'){    
    
    $loggedout="";
    $pageout="";
    $loggedin="";        
    $pagein="";

    $userid=$_SESSION['userdata']['userid'];
    $page=$_GET['pagename'];
    $timestamp=$_GET['timestamp'];
    $eventid=$_SESSION['userdata']['eventid'];
    $ip=get_client_ip();
    if($_GET['ispagein']==1){
        $loggedin=$timestamp;
        $pagein=$timestamp;
        $qry="insert into tbl_analytics (userid,page,pagein,ip,eventid) VALUES($userid,'$page','$pagein','$ip',$eventid)";
    }else{
        $loggedout= $timestamp;
        $pageout= $timestamp;
        $qry="insert into tbl_analytics (userid,page,pageout,ip,eventid) VALUES($userid,'$page','$pageout','$ip',$eventid)";
    }
    $conn->query($qry);    
}else if(isset($_REQUEST['action']) && $_REQUEST['action']=='userpagehit'){    

    $userid=$_REQUEST['id'];
    $result=getUserReportPageHitReport($userid);
    if(sizeof($result)>0){
        header('Content-Type: application/json');
        echo json_encode($result);
    }else{
        echo "No data found.";
    }
    
}else if(isset($_REQUEST['action']) && $_REQUEST['action']=='totalusers'){    

    $userid=$_REQUEST['id'];
    $result=getTotalUsers($userid);
    if(sizeof($result)>0){
        header('Content-Type: application/json');
        echo json_encode($result);
    }else{
        echo "No data found.";
    }
    
}else if(isset($_REQUEST['action']) && $_REQUEST['action']=='totalloggedinusers'){    

    $userid=$_REQUEST['id'];
    $result=getTotalLoggedinUsers();
    if(sizeof($result)>0){
        header('Content-Type: application/json');
        echo json_encode($result);
    }else{
        echo "No data found.";
    }
    
}else if(isset($_REQUEST['action']) && $_REQUEST['action']=='ip'){    

    $userid=$_REQUEST['id'];
    $result=getIPData();
    if(sizeof($result)>0){
        header('Content-Type: application/json');
        echo json_encode($result);
    }else{
        echo "No data found.";
    }
    
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function getUserReportPageHitReport($userid)
{
   $results=select("select u.username,page,min(pagein) pdate1,max(pageout) pdate2,count(pagein) totalhits from tbl_analytics a inner join tbl_users u on u.userid=a.userid  group by u.username,page");
   return $results;
}

function getTotalUsers(){
    $results=select("select count(distinct userid) total from tbl_analytics where eventid=11");
   return $results;
    
}
function getTotalLoggedinUsers(){
    $results=select("select count(distinct a.userid) total from tbl_analytics a inner join tbl_loggedin_user lu on lu.userid=a.userid where a.eventid=11");
   return $results;
    
}

function getIPData(){

    $result=select("SELECT ip,count(*) total FROM `tbl_analytics` group by ip");
    return $result;
}

?>