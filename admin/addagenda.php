<?php include('inc/header.php'); 

$_id='';
$txt_adate='';

$_adate='';
$_status='';
$_view='';

if(isset($_GET['type']) && $_GET['type']=='edit')
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $events=select('select * from tbl_agenda where id='.$id);
    if(sizeof($events)>0)
    {        
        $_id=$id;
        $_adate=$events[0]['adate'];      
        $_status=$events[0]['status'];      
    }
  }
  elseif(isset($_GET['type']) && $_GET['type']=='del')
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $_dqry="delete from tbl_agenda where id=".$id;
    if ($conn->query($_dqry) === TRUE)
    {
      $_d_qry="delete from tbl_agenda_detail where agendaid=".$id;
      if ($conn->query($_d_qry) === TRUE)
      {
      ?><script>location.href='agendas.php';</script><?php
      }
    }
    
  }
  elseif(isset($_GET['id']))
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $events=select('select * from tbl_agenda where id='.$id);
    if(sizeof($events)>0)
    {
      $_id=$id;
      $_adate=$events[0]['adate'];
      $_status=$events[0]['status'];      
      $_view='disabled';
    }
  }

?>

<?php

    $imagedit=1;
    if(isset($_POST['btn_submit']))
    {
      extract($_POST);
      $chk_status=isset($chk_status)?$chk_status:0;     
      if($_GET['type']=='edit')
      {
        $agenda_id=$_GET['id'];
        $qry="update tbl_agenda set adate='$txt_adate',status=$chk_status where id=".$agenda_id;
        if ($conn->query($qry) === TRUE)
        {
          echo "Record updated successfully";
          $dqry="delete from tbl_agenda_detail where agendaid=".$agenda_id;
          if ($conn->query($dqry) === TRUE){
            $imgindx=0;
            foreach ($_FILES["txt_image"]["error"] as $key => $error) 
            {          
              if ($error == UPLOAD_ERR_OK || $error == 4) {
  
                  $name='';
                  if($error == UPLOAD_ERR_OK)
                  {
                    $tmp_name = $_FILES["txt_image"]["tmp_name"][$key];              
                    $name = basename($_FILES["txt_image"]["name"][$key]);   
                    $target_dir = "../uploads/agendas/";
                    $target_file = $target_dir . basename($_FILES["txt_image"]["name"][$key]); 
                    $name=$target_file;
                    
                    if (move_uploaded_file($_FILES["txt_image"]["tmp_name"][$key], $target_file)) {
                      echo "The file ".  basename($_FILES["txt_image"]["name"][$key]). " has been uploaded.<br/>";
                    } else {
                      echo "Sorry, there was an error uploading your file.";
                      $uploadOk = 0;
                    }
                  }
                  $txt_ptitle[$imgindx]=mysqli_escape_string($conn,$txt_ptitle[$imgindx]);
                  $txt_position[$imgindx]=mysqli_escape_string($conn,$txt_position[$imgindx]);
                  $txt_description[$imgindx]=mysqli_escape_string($conn,$txt_description[$imgindx]);
                  $_aqry_vals="$agenda_id,'$txt_ptitle[$imgindx]','$txt_position[$imgindx]','$txt_description[$imgindx]','$name','$atime[$imgindx]','$ddlHall[$imgindx]'";
                  $_aqry="Insert Into tbl_agenda_detail (agendaid,title,position,description,image,atime,hallid) values($_aqry_vals);";
                  if ($conn->query($_aqry) === TRUE) {                
                    //echo "New record created successfully";
                  } else {
                    echo "Error: " . $qry . "<br>" . $conn->error;
                  }    
                  $imgindx++;
              }
            }
          }            
        }
      }
      else
      {
        
        $day=@get_row_count('tbl_agenda');
        $day=$day['count(*)']+1;
        $qry="insert into tbl_agenda(aday,adate,status,eventid) values($day,'$txt_adate',$chk_status,$hdn_event_top)";
        $agenda_id=0;

        if ($conn->query($qry) === TRUE) {
          $agenda_id=mysqli_insert_id($conn);
          echo "New record created successfully";

          $imgindx=0;
          foreach ($_FILES["txt_image"]["error"] as $key => $error) 
          {          
            if ($error == UPLOAD_ERR_OK || $error == 4) {

                $name='';
                if($error == UPLOAD_ERR_OK)
                {
                  $tmp_name = $_FILES["txt_image"]["tmp_name"][$key];              
                  $name = basename($_FILES["txt_image"]["name"][$key]);   
                  $target_dir = "../uploads/agendas/";
                  $target_file = $target_dir . basename($_FILES["txt_image"]["name"][$key]); 
                  $name=$target_file;
                  
                  if (move_uploaded_file($_FILES["txt_image"]["tmp_name"][$key], $target_file)) {
                    echo "The file ".  basename($_FILES["txt_image"]["name"][$key]). " has been uploaded.<br/>";
                  } else {
                    echo "Sorry, there was an error uploading your file.";
                    $uploadOk = 0;
                  }
                }
                $txt_ptitle[$imgindx]=mysqli_escape_string($conn,$txt_ptitle[$imgindx]);
                $txt_position[$imgindx]=mysqli_escape_string($conn,$txt_position[$imgindx]);
                $txt_description[$imgindx]=mysqli_escape_string($conn,$txt_description[$imgindx]);

                $_aqry_vals="$agenda_id,'$txt_ptitle[$imgindx]','$txt_position[$imgindx]','$txt_description[$imgindx]','$name','$atime[$imgindx]','$ddlHall[$imgindx]'";
                $_aqry="Insert Into tbl_agenda_detail (agendaid,title,position,description,image,atime,hallid) values($_aqry_vals);";
                if ($conn->query($_aqry) === TRUE) {                
                  echo "New record created successfully";
                } else {
                  echo "Error: " . $qry . "<br>" . $conn->error;
                }    
                $imgindx++;
            }
          }  
        } else {
          echo "Error: " . $qry . "<br>" . $conn->error;
        }
        $_aqry='';
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
        <!-- <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
        </div>
    </div>
    <!-- form start -->
    <form role="form" method="post" enctype="multipart/form-data">
    <input type="hidden" value="<?=$_id?>" name="hdn_id">
    <input type="hidden" name="hdn_event_top" id="hdn_event_top" value="<?=(isset($_SESSION['selected_event_id']))?$_SESSION['selected_event_id']:0?>"/>
                  <div class="box-body">
                    <div class="form-group">
                      <label for="txt_adate">Agenda Date</label>
                      <input <?=$_view?> type="date" class="form-control" name="txt_adate" placeholder="Enter Date" value="<?=$_adate?>">
                    </div> 
                    <div class="checkbox">
                      <label>
                        <input <?=$_view?> type="checkbox" name="chk_status" value="1" <?=($_status==1)?'checked':''?>> Active
                      </label>
                    </div>  
                    <div class="form-group">
                      <table id="tblTime">
                        <?php
                          $agenda_details=get_all_agenda_details('agendaid='.$_id);
                          for($i=0;$i<sizeof($agenda_details);$i++){
                            $agenda_detail=$agenda_details[$i];
                        ?>
                        <tr>
                          <td><input <?=$_view?> type="time" name="atime[]" value="<?=$agenda_detail['atime']?>"/></td>
                          <td><input <?=$_view?> type="file" class="form-control" name="txt_image[]"></td>
                          <td><input <?=$_view?> type="text" class="form-control" name="txt_ptitle[]" placeholder="Enter Title" value="<?=$agenda_detail['title']?>"></td>
                          <td><input <?=$_view?> type="text" class="form-control" name="txt_position[]" placeholder="Enter Position" value="<?=$agenda_detail['position']?>"></td>
                          <td><input <?=$_view?> type="text" class="form-control" name="txt_description[]" placeholder="Enter Description" value="<?=$agenda_detail['description']?>"></td>
                          <td>
                            <select <?=$_view?> name="ddlHall[]">                             
                            <option value="" <?=($agenda_detail['hallid']=='Main Plenary')?'selected':''?> >Select Hall</option>
                                  <option value="Main Plenary" <?=($agenda_detail['hallid']=='Main Plenary')?'selected':''?> >Main Plenary</option>
                                  <option value="Session 1" <?=($agenda_detail['hallid']=='Session 1')?'selected':''?>>Session 1</option>
                                  <option value="Session 2" <?=($agenda_detail['hallid']=='Session 2')?'selected':''?>>Session 2</option>
                                  <option value="Session 3" <?=($agenda_detail['hallid']=='Session 3')?'selected':''?>>Session 3</option>
                                  <option value="Session 4" <?=($agenda_detail['hallid']=='Session 4')?'selected':''?>>Session 4</option>
                                  <option value="Session 5" <?=($agenda_detail['hallid']=='Session 5')?'selected':''?>>Session 5</option>
                            </select>
                          </td>
                          <td><input <?=$_view?> type="button" onclick="removeRow(this)" name="btnDeleteTime" value="Delete" /></td>
                        </tr>
                            <?php
                          }
                            ?>
                      </table>
                      <input <?=$_view?> type="button" onclick="addRow()" name="btnAddTime" value="Add Time Slot" />
                    </div>     
                    
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button <?=$_view?> type="submit" class="btn btn-primary" name="btn_submit">Submit</button>
                  </div>
                </form>
    </div><!-- /.box -->
    
    </section><!-- /.content -->
<?php include('inc/footer.php');?>