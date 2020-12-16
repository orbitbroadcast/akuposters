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
                        <th>Description</th>
                        <th>Quantity</th>                      
                        <th>Request Date</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        $categories=get_all_rfqs();
                        for($i=0;$i<sizeof($categories);$i++){
                    ?>
                        <tr>
                            <td>
                              <?=$categories[$i]['title']?> <br/>
                              <sup>
                                <?php if($categories[$i]['total_quotes']>0):?> 
                                  <a href="addrfq.php?id=<?=$categories[$i]['rfqid']?>"><?=$categories[$i]['total_quotes']?> quote(s) received</a>
                                <?php else:?>
                                  <?=$categories[$i]['total_quotes']?> quote(s) received
                                <?php endif;?>
                              </sup>
                            </td>
                            <td><?=$categories[$i]['description']?></td>
                            <td><?=$categories[$i]['quantity']?> - <?=$categories[$i]['unit']?></td>
                            <td><?=$categories[$i]['creationdate']?></td>
                            <td><?=$categories[$i]['expirydate']?></td>
                            <td><?=$categories[$i]['statusname']?></td>
                            <td><?=action_buttons('addrfq.php','addrfq.php','addrfq.php',$categories[$i]['rfqid'])?></td>
                        </tr>                      
                    <?php
                        }
                    ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Quantity</th>                      
                        <th>Request Date</th>
                        <th>Due Date</th>
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