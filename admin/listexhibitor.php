<?php include('inc/header.php'); 


$_first_name='';
$_last_name='';
$_email_address='';
$_company_name='';
$_job_title='';
$_password='';
$_view='';
$_button_text='Add new user';

if(isset($_GET['type'],$_GET['id']) && $_GET['type']=='edit')
{
    $_id=$_GET['id'];
    $exhibitor=select("select * from tbl_exhibitor_new where id=$_id");
    if(sizeof($exhibitor)>0){
        
        $_first_name=$exhibitor[0]['firstname'];
        $_last_name=$exhibitor[0]['lastname'];
        $_email_address=$exhibitor[0]['email'];
        $_company_name=$exhibitor[0]['company'];
        $_job_title=$exhibitor[0]['job_title'];
        $user=select("select * from tbl_users where username='$_email_address'");
        $_password=$user[0]['password'];
        $_view='disabled';
        $_button_text='Update user';
    }
}
else if(isset($_GET['type'],$_GET['id']) && $_GET['type']=='del')
{
    $id=isset($_GET['id'])?$_GET['id']:0;
    $exhibitor=select("select * from tbl_exhibitor_new where id=$id");

    $_dqry="delete from  tbl_exhibitor_new where id=".$id;    

    if ($conn->query($_dqry) === TRUE)
    {
      $_email_address=$exhibitor[0]['email'];
      $user=select("select * from tbl_users where username='$_email_address'");
      $userid=$user[0]['userid'];
      $_duqry="delete from tbl_users where userid=".$userid;
      $conn->query($_duqry);

      $_dpqry="delete from tbl_profile where userid=".$userid;
      $conn->query($_dpqry);

      ?><script>location.href='listexhibitor.php';</script><?php
    }
}
?>


<?php

if(isset($_POST['btn_submit'])){
extract($_POST);

// firstname
// lastname
// email
// company
// job_title
//eventid

    if(isset($_GET['type'],$_GET['id']) && $_GET['type']=='edit')
    {
        $qry="update tbl_exhibitor_new set firstname='$txt_first_name',lastname='$txt_last_name',company='$txt_company_name',job_title='$txt_job_title'";
        if ($conn->query($qry) === TRUE) 
        {
            echo "Data saved successfully";
            if(strlen(trim($txt_password,''))>0){
                $_uqry="update tbl_users set password='$txt_password' where username='$txt_email_address'";
                $conn->query($qry_p);
            }            
        }
    }
    else
    {
        $qry="insert into tbl_exhibitor_new (firstname,lastname,email,company,job_title,eventid)
        values ('$txt_first_name','$txt_last_name','$txt_email_address','$txt_company_name','$txt_job_title',$hdn_event_top)";
        if ($conn->query($qry) === TRUE) 
        {
            echo "Data saved successfully";

            $_qry="insert into tbl_users (username,password,roleid,status,eventid) VALUES('$txt_email_address','$txt_password',10,1,$hdn_event_top)";
            if ($conn->query($_qry) === TRUE) {
                $_userid=mysqli_insert_id($conn);

                $qry_p="insert into tbl_profile (userid,firstname,status) values(".$_userid.",'$txt_email_address',1)";
                $conn->query($qry_p);

                $qry_ue="insert into tbl_user_event (userid,eventid) VALUES($_userid,$hdn_event_top)";
                $conn->query($qry_ue);
            }

        } else 
        {
            echo "Error: " . $qry . "<br>" . $conn->error;
        } 
    }
}
?>
<section class="content">
 <!-- Default box -->
 <div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">
        Add Exhibitor
        <!--<?=get_page_name("formurl='".basename($_SERVER['PHP_SELF'])."'")[0]['formname'];?>-->
        </h3>
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
                      <label for="txt_first_name">First Name</label>                      
                      <input type="text" class="form-control" name="txt_first_name" placeholder="First name" value="<?=$_first_name?>">
                    </div>
                    <div class="form-group">
                      <label for="txt_last_name">Last Name</label>                      
                      <input type="text" class="form-control" name="txt_last_name" placeholder="Last name" value="<?=$_last_name?>">
                    </div>         
                    <div class="form-group">
                      <label for="txt_email_address">Email address</label>                      
                      <input <?=$_view?> type="email" class="form-control" name="txt_email_address" placeholder="Email address" value="<?=$_email_address?>">
                    </div>         
                    <div class="form-group">
                      <label for="txt_company_name">Company Name</label>                      
                      <input type="text" class="form-control" name="txt_company_name" placeholder="Company name" value="<?=$_company_name?>">
                    </div>     
                    <div class="form-group">
                      <label for="txt_job_title">Job Title</label>                      
                      <input type="text" class="form-control" name="txt_job_title" placeholder="Job title" value="<?=$_job_title?>">
                    </div>  
                    <div class="form-group">
                      <label for="txt_password">Password</label>                      
                      <input type="text" class="form-control" name="txt_password" placeholder="Password" value="<?=$_password?>">
                    </div>                                                      
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="btn_submit"><?=$_button_text?></button>
                    <button type="button" class="btn btn-primary" name="btn_cancel" onclick="resetForm()">Cancel</button>
                  </div>
                </form>
    </div><!-- /.box -->

    <!-- Default box -->
    <div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?=get_page_name("formurl='".basename($_SERVER['PHP_SELF'])."'")[0]['formname'];?></h3>
        <div class="box-tools pull-right">
        <!-- <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
        </div>
    </div>
    <div class="box-body">
    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email address</th>                     
                        <th>Company</th>
                        <th>Job title</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        $_top_event_id=(isset($_SESSION['selected_event_id']))?$_SESSION['selected_event_id']:0;
                        $categories=get_all_exhibitors_new("eventid=$_top_event_id");
                        for($i=0;$i<sizeof($categories);$i++){
                    ?>
                        <tr>
                            <td><?=$categories[$i]['firstname']?></td>
                            <td><?=$categories[$i]['lastname']?></td>
                            <td><?=$categories[$i]['email']?></td>
                            <td><?=$categories[$i]['company']?></td>
                            <td><?=$categories[$i]['job_title']?></td>
                            <td><?=action_buttons('listexhibitor.php','listexhibitor.php','',$categories[$i]['id'])?></td>
                        </tr>                      
                    <?php
                        }
                    ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email address</th>                     
                        <th>Company</th>
                        <th>Job title</th>
                        <th>Action</th>
                      </tr>
                    </tfoot>
                  </table>
    </div><!-- /.box-body -->
    <div class="box-footer">
        Footer
    </div><!-- /.box-footer-->
    </div><!-- /.box -->

    </section><!-- /.content -->
    <script>
        function resetForm(){
            location.href='listexhibitor.php';
        }
    </script>
<?php include('inc/footer.php');?>