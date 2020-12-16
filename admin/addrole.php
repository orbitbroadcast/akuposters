<?php include('inc/header.php'); ?>

<?php

  $_roleid='';
  $_role='';
  $_status='';
  $_view='';
  if(isset($_GET['type']) && $_GET['type']=='edit')
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $user_data=select('select * from tbl_roles where roleid='.$id)[0];
    if(sizeof($user_data)>0)
    {
      $_roleid=$user_data['roleid'];
      $_role=$user_data['role'];
      $_status=$user_data['status'];
    }
  }
  elseif(isset($_GET['type']) && $_GET['type']=='del')
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $_dqry="delete from  tbl_roles where roleid=".$id;
    if ($conn->query($_dqry) === TRUE)
    {
      ?><script>location.href='users.php';</script><?php
    }
    
  }
  elseif(isset($_GET['id']))
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $user_data=select('select * from tbl_roles where roleid='.$id)[0];
    if(sizeof($user_data)>0)
    {
      $_roleid=$user_data['roleid'];
      $_role=$user_data['role'];
      $_status=$user_data['status'];
      $_view='disabled';
    }
  }



    if(isset($_POST['btn_submit'])){
        extract($_POST);
        $chk_status=isset($chk_status)?$chk_status:0;
        $txt_role_name=mysqli_escape_string($conn,$txt_role_name);
        $qry="insert into tbl_roles (role,status) values('$txt_role_name',$chk_status)";

        if ($conn->query($qry) === TRUE) {
            echo "New record created successfully";
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
                  <div class="box-body">
                    <div class="form-group">
                      <label for="txt_role_name">Role Name</label>
                      <input <?=$_view?> type="text" class="form-control" name="txt_role_name" placeholder="Enter role name">
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