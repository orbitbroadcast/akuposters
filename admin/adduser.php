<?php include('inc/header.php'); ?>

<?php

  $_userid='';
  $_username='';
  $_password='';
  $_roleid='';
  $_status='';
  $_isapprover='';
  $_view='';
  if(isset($_GET['type']) && $_GET['type']=='edit')
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $user_data=select('select * from tbl_users where userid='.$id)[0];
    if(sizeof($user_data)>0)
    {
      $_userid=$user_data['userid'];
      $_username=$user_data['username'];
      $_password=$user_data['password'];
      $_roleid=$user_data['roleid'];
      $_status=$user_data['status'];
      $_isapprover=$user_data['isapprover'];
    }
  }
  elseif(isset($_GET['type']) && $_GET['type']=='del')
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $_dqry="delete from  tbl_users where userid=".$id;
    if ($conn->query($_dqry) === TRUE)
    {
      ?><script>location.href='users.php';</script><?php
    }
    
  }
  elseif(isset($_GET['id']))
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $user_data=select('select * from tbl_users where userid='.$id)[0];
    if(sizeof($user_data)>0)
    {
      $_userid=$user_data['userid'];
      $_username=$user_data['username'];
      $_password=$user_data['password'];
      $_roleid=$user_data['roleid'];
      $_status=$user_data['status'];
      $_isapprover=$user_data['isapprover'];
      $_view='disabled';
    }
  }

    if(isset($_POST['btn_submit'])){
        extract($_POST);
        $txt_user_name=mysqli_escape_string($conn,$txt_user_name);
        $txt_password=mysqli_escape_string($conn,$txt_password);
        $chk_status=isset($chk_status)?$chk_status:0;
        $chk_isapprover=isset($chk_isapprover)?$chk_isapprover:0;
        $isapprover=($ddl_role==2 || $ddl_role==1)?$chk_isapprover:0;

        if(isset($_GET['type']) && $_GET['type']=='edit'){

          if(strlen($txt_password)>0){
            $qry="update tbl_users set username='$txt_user_name',
            password='$txt_password',
            roleid=$ddl_role,
            status=$chk_status,
            eventid=$hdn_event_top,
            isapprover=$isapprover
            where userid=$hdn_id";

          }else{
            $qry="update tbl_users set username='$txt_user_name',
            roleid=$ddl_role,
            status=$chk_status,
            eventid=$hdn_event_top,
            isapprover=$isapprover
            where userid=$hdn_id";
          }
          

          if ($conn->query($qry) === TRUE) {
              echo "Record updated successfully";  
              
              $qry_de="delete from tbl_user_event where userid=$hdn_id";
              $conn->query($qry_de);

              for($i=0;$i<sizeof($chk_events);$i++)
              {
                $qry_ue="insert into tbl_user_event (userid,eventid) VALUES($hdn_id,$chk_events[$i])";
                $conn->query($qry_ue);
              }
            } else {
              echo "Error: " . $qry . "<br>" . $conn->error;
            }  
        }
        else{
        $qry="insert into tbl_users (username,password,roleid,status,eventid,isapprover) values('$txt_user_name','$txt_password',$ddl_role,$chk_status,$hdn_event_top,$isapprover)";

        if ($conn->query($qry) === TRUE) {
            echo "New record created successfully";
            $_userid=mysqli_insert_id($conn);
            $qry="insert into tbl_profile (userid,firstname,status) values(".$_userid.",'$txt_user_name',$chk_status)";
            $conn->query($qry);

            for($i=0;$i<sizeof($chk_events);$i++)
            {
              $qry_ue="insert into tbl_user_event (userid,eventid) VALUES($_userid,$chk_events[$i])";
              $conn->query($qry_ue);
            }
            
            if(sizeof($chk_events)<=0)
            {
                $qry_ue="insert into tbl_user_event (userid,eventid) VALUES($_userid,$hdn_event_top)";
              $conn->query($qry_ue);
            }
          } else {
            echo "Error: " . $qry . "<br>" . $conn->error;
          }          
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
    <input type="hidden" value="<?=$_userid?>" name="hdn_id">
    <input type="hidden" name="hdn_event_top" id="hdn_event_top" value="<?=(isset($_SESSION['selected_event_id']))?$_SESSION['selected_event_id']:0?>"/>
                  <div class="box-body">
                    <div class="form-group">
                      <label for="txt_user_name">User Name</label>
                      <input value="<?=$_username?>" type="text" class="form-control" name="txt_user_name" placeholder="Enter user name">
                    </div>
                    <div class="form-group">
                      <label for="txt_password">Password</label>
                      <input type="password" class="form-control" name="txt_password" placeholder="Enter password">
                    </div>
                    <div class="form-group">
                    <label>Role</label>
                        <select onchange="change_role(this)" class="form-control select2" style="width: 100%;" name="ddl_role">
                        <option selected="selected" value="0">None</option>
                        <?php
                            $roles=get_all_roles();
                            for($i=0;$i<sizeof($roles);$i++){
                                if($roles[$i]['status']==1){
                                    ?>
                                        <option <?=($_roleid==$roles[$i]['roleid'])?'selected':''?> value="<?=$roles[$i]['roleid']?>"><?=$roles[$i]['role']?></option>
                                    <?php
                                }
                            }
                        ?>
                        </select>
                    </div><!-- /.form-group -->
                    <div class="form-group" id="event_div" style="<?=($_roleid==2)?'':'display:none'?>">
                            <label>Assign event</event>
                            <ul>
                              <?php
                                  $_user_id=$_SESSION['userdata']['userid'];
                                  $events=get_all_events();

                                  
                                  
                                  for($i=0;$i<sizeof($events);$i++){
                                    $event=$events[$i];
                                    $event_id=$event['id'];
                                    $user_events=get_all_userevents("userid=$_userid and eventid=$event_id")[0];
                                    $checked=($user_events['eventid']==$event['id'])?"checked":"";

                              ?>
                              <li>
                                <label>
                                <input type="checkbox" <?=$checked?> name="chk_events[]" value="<?=$event['id']?>"/> <?=$event['etitle']?>
                                </label>
                              </li>
                                  <?php }?>
                            </ul>
                    </div>
                    <div class="checkbox" id="appr_div" style="<?=($_roleid==2 || $_roleid==1)?'':'display:none'?>">
                        <label>
                        <input type="checkbox" name="chk_isapprover" value="1" <?=($_isapprover==1)?'checked':''?>> Can approve content?
                        </label>
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="chk_status" value="1" <?=($_status==1)?'checked':''?>> Active
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