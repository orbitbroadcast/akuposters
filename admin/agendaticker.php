<?php include('inc/header.php'); ?>

<?php

$Id =0;
$agenda_ticker1='';
$agenda_ticker2	='';
$agenda_ticker3	='';
$status='';
$_view='';

$_top_event_id=(isset($_SESSION['selected_event_id']))?$_SESSION['selected_event_id']:0;
$user_data=select("select * from  tbl_agenda_ticker where eventid=$_top_event_id");

    if(sizeof($user_data)>0)
    {
      
       $Id=$user_data[0]['id'];
        $agenda_ticker1=$user_data[0]['agenda_ticker1'];
        $agenda_ticker2=$user_data[0]['agenda_ticker2'];
        $agenda_ticker3=$user_data[0]['agenda_ticker3'];
        $status=$user_data[0]['status'];
    }

  if(isset($_POST['btn_submit'])){
    extract($_POST);
    $chk_status=isset($chk_status)?$chk_status:0;   
    $txt_agenda_ticker1=mysqli_escape_string($conn,$txt_agenda_ticker1);
    $txt_agenda_ticker2=mysqli_escape_string($conn,$txt_agenda_ticker2);
    $txt_agenda_ticker3=mysqli_escape_string($conn,$txt_agenda_ticker3);
    
    if($hdn_id>0)
    {
        $qry="update tbl_agenda_ticker set agenda_ticker1='$txt_agenda_ticker1',agenda_ticker2='$txt_agenda_ticker2',agenda_ticker3='$txt_agenda_ticker3',";     
        $qry.= "status=$chk_status, eventid=$hdn_event_top where Id=$hdn_id"; 
    }
    else
    {
        $qry="insert into tbl_agenda_ticker(agenda_ticker1,agenda_ticker2,agenda_ticker3,status,eventid)";
        $qry.="VALUES ('$txt_agenda_ticker1','$txt_agenda_ticker2','$txt_agenda_ticker3',$chk_status,$_top_event_id)";
    }
    //echo $qry;
    if ($conn->query($qry) === TRUE){
        
    }else{
        echo "Error: " . $qry . "<br>" . $conn->error;
    }
  }

?>
    <!-- Main content -->
    <section class="content">
    <!-- Default box -->
    <div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?=get_page_name("formurl='".basename($_SERVER['PHP_SELF'])."'")[0]['formname'];?></h3>
        <div class="box-tools pull-right">
        </div>
    </div>
    <!-- form start -->
    <form role="form" method="post"  enctype="multipart/form-data"> 
    <input type="hidden" value="<?=$Id?>" name="hdn_id">
    <input type="hidden" name="hdn_event_top" id="hdn_event_top" value="<?=(isset($_SESSION['selected_event_id']))?$_SESSION['selected_event_id']:0?>"/>
                  <div class="box-body">
                   <div class="form-group">
                      <label for="txt_agenda_ticker1">Ticker 1</label>
                      <input <?=$_view?> type="text" class="form-control" name="txt_agenda_ticker1" placeholder="Enter Ticker 1" value="<?=$agenda_ticker1?>">
                    </div>
					<div class="form-group">
                      <label for="txt_agenda_ticker2">Ticker 2</label>
                      <input <?=$_view?> type="text" class="form-control" name="txt_agenda_ticker2" placeholder="Enter Ticker 2" value="<?=$agenda_ticker2?>">
                    </div>
                     <div class="form-group">
                      <label for="txt_agenda_ticker3">Ticker 2</label>
                      <input <?=$_view?> type="text" class="form-control" name="txt_agenda_ticker3" placeholder="Enter Ticker 3" value="<?=$agenda_ticker3?>">
                    </div>
                     
                    <div class="checkbox">
                      <label>
                        <input <?=$_view?> type="checkbox" name="chk_status" value="1" <?=($status==1)?'checked':''?>> Active
                      </label>
                    </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="btn_submit">Submit</button>
                  </div>
                </form>
    </div><!-- /.box -->
    </section><!-- /.content -->
<?php include('inc/footer.php');?>