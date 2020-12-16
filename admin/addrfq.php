<?php 
  include('inc/header.php'); 
  include('inc/SimpleImage.php'); 

  $_rfqid="";
	$_title="";
	$_description="";
	$_quantity="";
	$_unitid="";
	$_creationdate="";
	$_expirydate="";
	$_catid=0;
  $_rfqimage="";
  $_status=0;
  $_view='';
  if(isset($_GET['type']) && $_GET['type']=='edit')
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $rfqs=select('select * from tbl_rfqs where rfqid='.$id);
    if(sizeof($rfqs)>0)
    {
      $_rfqid=$rfqs[0]['rfqid'];
      $_title=$rfqs[0]['title'];
      $_description=$rfqs[0]['description'];
      $_quantity=$rfqs[0]['quantity'];
      $_unitid=$rfqs[0]['unitid'];
      $_creationdate=$rfqs[0]['creationdate'];
      $_expirydate=$rfqs[0]['expirydate'];
      $_catid=$rfqs[0]['catid'];
      $_rfqimage=$rfqs[0]['rfqimage'];
      $_status=$rfqs[0]['status'];
    }
  }
  elseif(isset($_GET['id']))
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $rfqs=select('select * from tbl_rfqs where rfqid='.$id);
    if(sizeof($rfqs)>0)
    {
      $_rfqid=$rfqs[0]['rfqid'];
      $_title=$rfqs[0]['title'];
      $_description=$rfqs[0]['description'];
      $_quantity=$rfqs[0]['quantity'];
      $_unitid=$rfqs[0]['unitid'];
      $_creationdate=$rfqs[0]['creationdate'];
      $_expirydate=$rfqs[0]['expirydate'];
      $_catid=$rfqs[0]['catid'];
      $_rfqimage=$rfqs[0]['rfqimage'];
      $_status=$rfqs[0]['status'];
      $_view='disabled';
    }
  }
  
?>

<?php

    if(isset($_POST['btn_submit'])){
        extract($_POST);
        $chk_status=isset($chk_status)?$chk_status:0;

        $fileinfo = @getimagesize($_FILES["txt_rfqimage"]["tmp_name"]);
        
        $width = $fileinfo[0];  
        $height = $fileinfo[1];
        $image_type = $fileinfo[2];
        if($image_type == IMAGETYPE_JPEG ) {
 
          $image = imagecreatefromjpeg($_FILES["txt_rfqimage"]["tmp_name"]);
       } elseif( image_type == IMAGETYPE_GIF ) {
  
          $image = imagecreatefromgif($_FILES["txt_rfqimage"]["tmp_name"]);
       } elseif( mage_type == IMAGETYPE_PNG ) {
  
          $image = imagecreatefrompng($_FILES["txt_rfqimage"]["tmp_name"]);
       }

        $target_dir = "../uploads/rfqs/";
        $target_file = $target_dir . basename($_FILES["txt_rfqimage"]["name"]);
        $target_file_thumb = $target_dir .'thumb_'. basename($_FILES["txt_rfqimage"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["txt_rfqimage"]["tmp_name"]);
        if($check !== false) {         
          $uploadOk = 1;
          if($width==407 && $height==402){
            if (move_uploaded_file($_FILES["txt_rfqimage"]["tmp_name"], $target_file)) {

              //$image = new SimpleImage();
              //@$image->load($_FILES["txt_rfqimage"]["tmp_name"]);
              //@$image->resize(100, 200);
              //@$image->save($target_file_thumb);
              $new_image = @imagecreatetruecolor(100, 200);
              @imagecopyresampled($new_image, $image, 0, 0, 0, 0, 100,200, $width, $height);
              $image = $new_image;
              
              if( $image_type == IMAGETYPE_JPEG ) {
                  imagejpeg($image,$target_file_thumb,75);
              } elseif( $image_type == IMAGETYPE_GIF ) {
          
                  imagegif($image,$target_file_thumb);
              } elseif( $image_type == IMAGETYPE_PNG ) {
          
                  imagepng($image,$target_file_thumb);
              }
              
              echo "The file ". basename( $_FILES["txt_rfqimage"]["name"]). " has been uploaded.<br/>";
            } else {
              echo "Sorry, there was an error uploading your file.";
              $uploadOk = 0;
            }
          }else
          {
            echo "Sorry, there was an error uploading your file.Image file should be 352 x 458 pixels in size.";
            $uploadOk = 0;
          }
        } else {
          echo "Please upload Image File";
          $uploadOk = 0;
        }
        $_target_file=str_replace("../","",$target_file);
        $_target_file_thumb=str_replace("../","",$target_file_thumb);
        if($uploadOk==1){
          $qry="insert into  tbl_rfqs (title,description,quantity,unitid,expirydate,catid,rfqimage,status) values('$txt_title','$txt_description','$txt_quantity','$ddl_units','$txt_expiry_date',$ddl_category,'$_target_file_thumb',$chk_status)";

          if ($conn->query($qry) === TRUE) {
            echo "New record created successfully";
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
        <!-- <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button> -->
        <!-- <button class="btn btn-box-tool" onclick="javascript:location.href='rfqs.php'" data-toggle="tooltip" title="Cancel"><i class="fa fa-times"></i></button> -->
        </div>
    </div>
    <!-- form start -->
    <form role="form" method="post" enctype="multipart/form-data">
                  <input type="hidden" value="<?=$_rfqid?>">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="txt_title">Title</label>
                      <input <?=$_view?> type="text" class="form-control" name="txt_title" placeholder="Enter title" value="<?=$_title?>">
                    </div>
                    <div class="form-group">
                      <label for="txt_description">Description</label>
                      <textarea <?=$_view?> class="form-control" style="width: 100%;" name="txt_description"><?=$_description?></textarea>
                    </div>
                    <div class="form-group">
                      <label for="txt_quantity">Quantity</label>
                      <input <?=$_view?> type="text" class="form-control" name="txt_quantity" placeholder="Enter quantity" value="<?=$_quantity?>">
                    </div>
                    <div class="form-group">
                    <label>Unit</label>
                        <select <?=$_view?> class="form-control select2" style="width: 100%;" name="ddl_units">
                        <option selected="selected" value="0">None</option>
                        <?php
                            $units=get_all_units();
                            for($i=0;$i<sizeof($units);$i++){
                                if($units[$i]['status']==1){
                                    ?>
                                        <option value="<?=$units[$i]['unitid']?>" <?=($_unitid==$units[$i]['unitid'])?'selected':''?>><?=$units[$i]['unit']?></option>
                                    <?php
                                }
                            }
                        ?>
                        </select>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                      <label for="txt_expiry_date">Due Date</label>
                      <input <?=$_view?> type="date" class="form-control" name="txt_expiry_date" placeholder="Enter date" value="<?=$_expirydate?>">
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                    <label>Category</label>
                        <select <?=$_view?> class="form-control select2" style="width: 100%;" name="ddl_category">
                        <option selected="selected" value="0">None</option>
                        <?php
                            $categories=get_all_categories();
                            for($i=0;$i<sizeof($categories);$i++){
                                if($categories[$i]['status']==1){
                                    ?>
                                        <option value="<?=$categories[$i]['catid']?>" <?=($_catid==$categories[$i]['catid'])?'selected':''?>><?=$categories[$i]['catname']?></option>
                                    <?php
                                }
                            }
                        ?>
                        </select>
                    </div><!-- /.form-group -->
                    <div class="form-group">
                      <label for="txt_catimage">Image</label>
                      <input <?=$_view?> type="file" class="form-control" name="txt_rfqimage">
                      <?php
                        if($_rfqimage!='')
                        {
                          ?>
                          <img src="../<?=$_rfqimage?>" width="100" height="200">
                          <?php
                        }
                      ?>
                    </div>
                    <div class="checkbox">
                      <label>
                        <input <?=$_view?> type="checkbox" name="chk_status" value="1" <?=($_status==1)?'checked':''?>> Active
                      </label>
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button <?=$_view?> type="submit" class="btn btn-primary" name="btn_submit">Submit</button>
                    <?php if($_view=='disabled'):?>

                    <h3>Quotes</h3>
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Vendor</th>
                          <th>Remarks</th>
                          <th>Cost</th>                      
                          <th>Date</th>                          
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                    <?php
                        $categories=get_all_quotes();
                        for($i=0;$i<sizeof($categories);$i++){
                    ?>
                        <tr>
                            <td><?=$categories[$i]['firstname']?> <?=$categories[$i]['lastname']?></td>
                            <td><?=$categories[$i]['remarks']?></td>
                            <td><?=$categories[$i]['cost']?></td>
                            <td><?=$categories[$i]['creationdate']?></td>
                            <td><?=action_buttons('','','quote.php',$categories[$i]['id'])?></td>
                        </tr>                      
                    <?php
                        }
                    ?>
                    </tbody>
                      <tfoot>
                      <tr>
                          <th>Vendor</th>
                          <th>Remarks</th>
                          <th>Cost</th>                      
                          <th>Date</th>                          
                          <th>Action</th>
                      </tr>
                    </tfoot>
                    </table>
                      <?php endif;?>
                  </div>
                </form>
    </div><!-- /.box -->

    </section><!-- /.content -->
<?php include('inc/footer.php');?>