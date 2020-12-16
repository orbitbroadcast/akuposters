<?php include('inc/header.php'); ?>
<?php
    $role_id=0;
    $selected_role='';
    if(isset($_GET['roleid']))
    {
        $role_id=$_GET['roleid'];
        $qry="select * from tbl_roles where roleid=".$role_id;
        $result = mysqli_query($conn, $qry);
        if (mysqli_num_rows($result) > 0) {            
            while($row = mysqli_fetch_assoc($result)) {                 
                $selected_role=$row['role'];
            }
        }
    }
    if(isset($_POST['btn_load'])){
        extract($_POST);
        $ddl_role=isset($ddl_role)?$ddl_role:0;
        if($ddl_role>0)
        {
           
            echo "<script>location.href='permissions.php?roleid=$ddl_role'</script>";
        }
        else
        {
            echo "<script>location.href='permissions.php'</script>";
        }
    }

    if(isset($_POST['btn_save']))
    {
        extract($_POST); 

        $qry="insert into tbl_role_description (roleid,formid,canadd,canedit,candelete,canview)
        select $hdn_role,formid,0 as canadd,0 as canedit,0 as candelete,0 as canview from tbl_form where
        formid not in 
        (
            select f.formid from tbl_roles r 
            inner join tbl_role_description rd on rd.roleid=r.roleid
            inner join tbl_form f on f.formid=rd.formid
            where r.roleid=$hdn_role
        )
        order by 1";
        if ($conn->query($qry) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $qry . "<br>" . $conn->error;
        }

        $qry="update tbl_role_description set canadd=0,canedit=0,candelete=0,canview=0 where roleid=$hdn_role";
        if ($conn->query($qry) === TRUE) {
            //echo "New record created successfully";
        } else {
            echo "Error: " . $qry . "<br>" . $conn->error;
        }
        if(isset($canadd))
        {
            for($i=0;$i<sizeof($canadd);$i++)
            {
                $qry="update tbl_role_description set canadd=1 where formid=$canadd[$i] and roleid=$hdn_role";
                if ($conn->query($qry) === TRUE) {
                    //echo "New record created successfully";
                } else {
                    echo "Error: " . $qry . "<br>" . $conn->error;
                }
            }
        }

        if(isset($canedit))
        {
            for($i=0;$i<sizeof($canedit);$i++)
            {
                $qry="update tbl_role_description set canedit=1 where formid=$canedit[$i] and roleid=$hdn_role";
                if ($conn->query($qry) === TRUE) {
                    //echo "New record created successfully";
                } else {
                    echo "Error: " . $qry . "<br>" . $conn->error;
                }
            }
        }

        if(isset($candelete))
        {
            for($i=0;$i<sizeof($candelete);$i++)
            {
                $qry="update tbl_role_description set candelete=1 where formid=$candelete[$i] and roleid=$hdn_role";
                if ($conn->query($qry) === TRUE) {
                    //echo "New record created successfully";
                } else {
                    echo "Error: " . $qry . "<br>" . $conn->error;
                }
            }
        }

        if(isset($canview))
        {
            for($i=0;$i<sizeof($canview);$i++)
            {
                $qry="update tbl_role_description set canview=1 where formid=$canview[$i] and roleid=$hdn_role";
                if ($conn->query($qry) === TRUE) {
                    //echo "New record created successfully";
                } else {
                    echo "Error: " . $qry . "<br>" . $conn->error;
                }
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
                  <div class="box-body">
                    <div class="form-group">
                    <label>Role</label>
                        <select class="form-control select2" style="width: 100%;" name="ddl_role">
                        <option selected="selected" value="0">None</option>
                        <?php
                            $roles=get_all_roles();
                            for($i=0;$i<sizeof($roles);$i++){
                                if($roles[$i]['status']==1){
                                    ?>
                                        <option value="<?=$roles[$i]['roleid']?>"><?=$roles[$i]['role']?></option>
                                    <?php
                                }
                            }
                        ?>
                        </select>
                    </div><!-- /.form-group -->
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="btn_load">Load</button>
                  </div>
                </form>
    </div><!-- /.box -->
    <!-- Default box -->
    <form role="form" method="post">
    <div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?=get_page_name("formurl='".basename($_SERVER['PHP_SELF'])."'")[0]['formname'];?></h3>
        <div class="box-tools pull-right">
        <!-- <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button> -->
        </div>
    </div>
    <div class="box-body"> 
    <div class="form-group">
        <label>Selected Role:</label> <?=$selected_role?>
        <input type="hidden" name="hdn_role" value="<?=$role_id?>">
    </div><!-- /.form-group -->   
    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Page</th>
                        <th>Add</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>View</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php     
                        if($role_id>0){                   
                        $permissions=get_permissions($role_id);
                            for($i=0;$i<sizeof($permissions);$i++){
                    ?>
                            <tr style="<?=($permissions[$i]['isheader']==1)?'background:#999;':''?>">
                                <td><?=$permissions[$i]['formname']?></td>
                                <td><input type="checkbox" value="<?=$permissions[$i]['formid']?>" name="canadd[]" <?=($permissions[$i]['canadd']==1)?'checked':''?>></td>
                                <td><input type="checkbox" value="<?=$permissions[$i]['formid']?>" name="canedit[]" <?=($permissions[$i]['canedit']==1)?'checked':''?>></td>
                                <td><input type="checkbox" value="<?=$permissions[$i]['formid']?>" name="candelete[]" <?=($permissions[$i]['candelete']==1)?'checked':''?>></td>
                                <td><input type="checkbox" value="<?=$permissions[$i]['formid']?>" name="canview[]" <?=($permissions[$i]['canview']==1)?'checked':''?>></td>
                            </tr>                      
                    <?php
                            }
                        }
                    ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Page</th>
                        <th>Add</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>View</th>
                      </tr>                      
                    </tfoot>
                  </table>
           
    </div><!-- /.box-body -->
    <div class="box-footer">
        <button type="submit" class="btn btn-primary pull-right" name="btn_save">Save</button>
    </div><!-- /.box-footer-->
    </div><!-- /.box -->
    </form>

    </section><!-- /.content -->
<?php include('inc/footer.php');?>