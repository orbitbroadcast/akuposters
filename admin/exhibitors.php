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
                        <th>Company Name</th>
                        <th>User Login Email</th>
                        <th>Stall Image</th>                     
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        $_top_event_id=(isset($_SESSION['selected_event_id']))?$_SESSION['selected_event_id']:0;
                        $categories=get_all_exhibitors("eventid=$_top_event_id");
                        for($i=0;$i<sizeof($categories);$i++){
                    ?>
                        <tr>
                            <td><?=$categories[$i]['company_name']?></td>
                            <td><?=$categories[$i]['userlogin']?></td>
                            <td><?=$categories[$i]['simage']?></td>
                            <td><?=$categories[$i]['statusname']?></td>
                            <td><?=action_buttons('addexhibitor.php','addexhibitor.php','addexhibitor.php',$categories[$i]['id'])?></td>
                        </tr>                      
                    <?php
                        }
                    ?>
                    </tbody>
                    <tfoot>
                      <tr>
                      <th>Company Name</th>
                        <th>User Login Email</th>
                        <th>Stall Image</th>                     
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