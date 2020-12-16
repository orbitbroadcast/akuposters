<?php include('inc/header.php'); ?>
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
    <div class="box-body">
    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>User</th>
                        <th>Role</th>
                        <th>Status</th>
                        <td>Action</td>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        $users=get_all_users();
                        for($i=0;$i<sizeof($users);$i++){
                    ?>
                        <tr>
                            <td>
                                <?=$users[$i]['username']?>
                                <?=($users[$i]['roleid']==1)?'<br><span class="label label-success">All events</span>':''?>
                                <?php 
                                    if($users[$i]['roleid']==2){
                                    $res=select("select * from tbl_eventsnew where id in (select eventid from tbl_user_event where userid=".$users[$i]['userid'].")");
                                    if(sizeof($res)>0){
                                    echo '<br/>';    
                                    
                                            for($j=0;$j<sizeof($res);$j++){
                                ?>
                                                <span class="label label-success"><?=$res[$j]['etitle']?></span>
                                <?php       }
                                        
                                        }
                                    }
                                ?>
                                <?=($users[$i]['isapprover']==1)?'<span class="label label-info">Can approve content</span>':''?>
                            </td>
                            <td><?=$users[$i]['role']?></td>
                            <td>
                            <span id="spStatus">
                            <a href="javascript:change_status('user',<?=$users[$i]['userid']?>,<?=($users[$i]['status']==1)?0:1?>)">
                              <?=($users[$i]['status']==1)?'Deactivate':'Activate'?>
                            </a>
                            </span>
                            </td>
                            <td><?=action_buttons('adduser.php','adduser.php','adduser.php',$users[$i]['userid'])?></td>
                        </tr>                      
                    <?php
                        }
                    ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>User</th>
                        <th>Role</th>
                        <th>Status</th>
                        
                      </tr>
                    </tfoot>
                  </table>
    </div><!-- /.box-body -->
    <div class="box-footer">
        Footer
    </div><!-- /.box-footer-->
    </div><!-- /.box -->

    </section><!-- /.content -->
<?php include('inc/footer.php');?>