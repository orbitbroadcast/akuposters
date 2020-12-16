<?php include('inc/header.php'); ?>

<?php

  $_id='';
  $_title='';
  $_content='';
  $_status='';
  $_view='';
  if(isset($_GET['type']) && $_GET['type']=='edit')
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $user_data=select('select * from tbl_email_templates where id='.$id)[0];
    if(sizeof($user_data)>0)
    {
      $_id=$user_data['id'];
      $_title=$user_data['title'];
      $_content=$user_data['content'];
      $_status=$user_data['status'];
    }
  }
  elseif(isset($_GET['type']) && $_GET['type']=='del')
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $_dqry="delete from  tbl_email_templates where id=".$id;
    if ($conn->query($_dqry) === TRUE)
    {
      ?><script>location.href='users.php';</script><?php
    }
    
  }
  elseif(isset($_GET['id']))
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $user_data=select('select * from tbl_email_templates where id='.$id)[0];
    if(sizeof($user_data)>0)
    {
      $_id=$user_data['id'];
      $_title=$user_data['title'];
      $_content=$user_data['content'];
      $_status=$user_data['status'];
      $_view='disabled';
    }
  }



    if(isset($_POST['btn_submit'])){
        extract($_POST);
        $chk_status=isset($chk_status)?$chk_status:0;
        $txt_title=mysqli_escape_string($conn,$txt_title);
        $txt_content=mysqli_escape_string($conn,$txt_content);
        
        $msg="";
        if(isset($_GET['type']) && $_GET['type']=='edit')
        {
            $qry="update tbl_email_templates set title='$txt_title',content='$txt_content',status=$chk_status where id=$hdnid";
            $msg="Record updated successfully";
        }
        else
        {
            $qry="insert into tbl_email_templates (title,content,status,eventid) values('$txt_title','$txt_content',$chk_status,$hdn_event_top)";
             $msg="New record created successfully";
        }
        if ($conn->query($qry) === TRUE) {
           echo $msg;
          } else {
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
        <!-- <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
        </div>
    </div>
    <!-- form start -->
    <form role="form" method="post">
        <input type="hidden" name="hdnid" value="<?=$_id?>"/>
         <input type="hidden" name="hdn_event_top" id="hdn_event_top" value="<?=(isset($_SESSION['selected_event_id']))?$_SESSION['selected_event_id']:0?>"/>
                  <div class="box-body">
                    <div class="form-group">
                      <label for="txt_role_name">Subject</label>
                      <input <?=$_view?> type="text" class="form-control" name="txt_title" placeholder="Enter Subject" value="<?=$_title?>">
                    </div>     
                    <div class="form-group">
                      <label for="txt_role_name">Content</label>
                      <textarea <?=$_view?>  class="form-control email_content" name="txt_content" placeholder="Enter Content" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?=$_content?></textarea>
                    </div>  
                    <div class="checkbox">
                      <label>
                        <input <?=$_view?> type="checkbox" name="chk_status" value="1" <?=($_status==1)?'checked':''?>> Active
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