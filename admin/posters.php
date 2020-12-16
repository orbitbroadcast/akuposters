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
                        <th><input type="checkbox" name="chk_all" value="0" onchange="bulkselect(this)"/></th>
                        <th>Category</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Status</th>
                        <th style="width: 150px!important;text-align: center;">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
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
                        for($i=0;$i<sizeof($categories);$i++){
                    ?>
                        <tr>
                            <!--<td><?=$cats[$categories[$i]['category']]?></td>-->
                            <td><input type="checkbox" name="chk_all" value="<?=$categories[$i]['Id']?>"/></td>
                            <td><?=$categories[$i]['catname']?></td>
                            <td><?=$categories[$i]['Title']?></td>
                            <td>
                                 <?php
      
                                                        $posterimg=str_replace("poster/","poster/thumb_",$categories[$i]['ImageURL']);
                                                      ?>
                                <img src="../<?=$posterimg?>" width="100" height="100"><br/>
                                <span><strong>PDF:</strong><?=$categories[$i]['PDFURL']?></span><br/>
                                <span><strong>Video:</strong><?=$categories[$i]['VideoURL']?></span><br/>
                                <span><strong>FAQ:</strong></span><br/>
                                <p>
                                    <?=$categories[$i]['FAQ']?>
                                </p>
                            </td>
                            <td><?=$categories[$i]['statusname']?></td>
                            <td style="text-align: center;"><?=action_buttons('addposter.php','addposter.php','addposter.php',$categories[$i]['Id'])?>
                                <!--
                                <hr>
                                <input onchange="posterApproveReject(this)" type="radio" value="<?=$categories[$i]['Id']?>" name="ap_rj_<?=$categories[$i]['Id']?>" <?=($categories[$i]['isapproved']==1)?'checked':''?>/> APPROVE 
                                <input onchange="posterApproveReject(this)" type="radio" value="<?=($categories[$i]['Id']*-1)?>" name="ap_rj_<?=$categories[$i]['Id']?>" <?=($categories[$i]['isapproved']==0)?'checked':''?>/> DECLINE 
                                -->
                                <?php if($isapprover==1){?>
                                <div class="btn-group-vertical">
                                  <button type="button" class="btn btn-xs btn-success <?=($categories[$i]['isapproved']==0)?'active':''?>" onclick="posterApproveReject(this)" data-id="<?=$categories[$i]['Id']?>" value="0">Pending</button>
                                  <button type="button" class="btn btn-xs btn-success <?=($categories[$i]['isapproved']==1)?'active':''?>" onclick="posterApproveReject(this)" data-id="<?=$categories[$i]['Id']?>" value="1">Approve</button>
                                  <button type="button" class="btn btn-xs btn-success <?=($categories[$i]['isapproved']==2)?'active':''?>" onclick="posterApproveReject(this)" data-id="<?=$categories[$i]['Id']?>" value="2">Decline</button>
                                </div>
                                <?php }?>
                            </td>
                        </tr>                      
                    <?php
                        }
                    ?>
                    </tbody>
                    <tfoot>
                      <tr>
                          <th><input type="checkbox" name="chk_all" value="0" onchange="bulkselect(this)"/></th>
                      <th>Category</th>
                      <th>Title</th>
                        <th>Content</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                      <tr>
                          <th colspan="6">
                              <span id="sp_chk_all" onclick="bulkselect_link(this)"><a href="javascript:void(0)">Check All</a></span>&nbsp;|&nbsp;
                              <i>With Selected:</i>
                              <select id="ddlActions" onchange="bulk_operations(this)">
                                <option value="0">None</option>
                                <option value="0" disabled>-----------</option>
                                <option value="1">Activate</option>    
                                <option value="2">Deactivate</option>    
                                <option value="0" disabled>-----------</option>
                                <option value="3">Delete</option>    
                                
                                <?php if($isapprover==1){?>
                                <option value="0" disabled>-----------</option>
                                <option value="4">Pending</option>
                                <option value="5">Approve</option>
                                <option value="6">Decline</option>
                                <?php }?>
                              </select>
                          </th>
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