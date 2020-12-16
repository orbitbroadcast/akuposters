<?php include('inc/header.php'); ?>
    <!-- Main content -->
    <section class="content">

    <!-- Default box -->
    <div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?=get_page_name("formurl='".basename($_SERVER['PHP_SELF'])."'")[0]['formname'];?></h3>
        <div class="box-tools pull-right">
        <!--
        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
        -->
        </div>
    </div>
    <div class="box-body">
    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                      <th>Title</th>
                      <th>Event Date</th>
                      <th>Main Plenary</th>                      
                      <th>Access</th>
                      <th>Sponsors</th>
                      <th>Status</th>
                      <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php

                        if($_SESSION['userdata']['roleid']==1){
                            $categories=get_all_events();
                        }else
                        {
                            $_user_id=$_SESSION['userdata']['userid'];
                            $categories=get_all_events("id in (select eventid from tbl_user_event where userid=$_user_id)");
                        }                        

                        for($i=0;$i<sizeof($categories);$i++){

                    ?>
                        <tr>
                            <td>
                              <?=$categories[$i]['etitle']?> <br/> 
                              <?php if($categories[$i]['form_token']!="") { ?>
                              <strong>Registration Form URL:</strong>
                              
                              <a href="https://<?=$_SERVER['SERVER_NAME']?>/register.php?t=<?=$categories[$i]['form_token']?>">
                              https://<?=$_SERVER['SERVER_NAME']?>/register.php?t=<?=$categories[$i]['form_token']?>
                              </a><br/>
                              <strong>Login URL:</strong>
                              <a href="https://<?=$_SERVER['SERVER_NAME']?>/index.php?t=<?=$categories[$i]['form_token']?>">
                              https://<?=$_SERVER['SERVER_NAME']?>/index.php?t=<?=$categories[$i]['form_token']?>
                              </a>
                        <?php } ?>                            
                            </td>
                            <td>
                                <?php
                                      $dates=get_event_dates('eventid='.$categories[$i]['id']);
                                      for($j=0;$j<sizeof($dates);$j++){
                                ?>
                                      <?=$dates[$j]['edate']?><br/>
                                <?php 
                                      }
                                ?>
                            </td>
                            <td><?=($categories[$i]['hasmain']==1)?'Yes':''?></td>
                            <td>
                                <?=($categories[$i]['poster']==1)?'Poster :Yes':''?> | 
                                <?=($categories[$i]['abstract']==1)?'Abstract :Yes':''?> | 
                                <?=($categories[$i]['exhibitor']==1)?'Exhibitor :Yes':''?> | 
                                <?=($categories[$i]['biography']==1)?'Biography :Yes':''?> | 
                                <?=($categories[$i]['networking']==1)?'Networking :Yes':''?> | 
                                <?=($categories[$i]['help_desk']==1)?'Help Desk :Yes':''?> | 
                                <?=($categories[$i]['attendees']==1)?'Attendees :Yes':''?>
                            </td>
                            <td><?=($categories[$i]['sponsors']==1)?'Yes':''?></td>
                            <td><?=$categories[$i]['statusname']?></td>
                            <td>
                                <?=action_buttons('addevent.php','addevent.php','addevent.php',$categories[$i]['id'])?>
                             <hr/>
                                <input onchange="turnEventOnOff(this)" type="radio" value="<?=$categories[$i]['id']?>" name="on_off_<?=$categories[$i]['id']?>" <?=($categories[$i]['onoff']==1)?'checked':''?>/> ON 
                                <input onchange="turnEventOnOff(this)" type="radio" value="<?=($categories[$i]['id']*-1)?>" name="on_off_<?=$categories[$i]['id']?>" <?=($categories[$i]['onoff']==0)?'checked':''?>/> OFF 
                            </td>
                        </tr>      
                        
                        
                    <?php
                        }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>Title</th>
                      <th>Event Date</th>
                      <th>Main Plenary</th>                      
                      <th>Access</th>
                      <th>Sponsors</th>
                      <th>Status</th>
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
<?php include('inc/footer.php');?>