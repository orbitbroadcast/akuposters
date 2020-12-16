<?php include('inc/header.php'); 


$_catid='';
$_catname='';
$_parentid='';
$_ismain='';
$_isfooter='';
$_featured='';
$_catimage='';
$_ishot='';
$_status='';
$_view='';

if(isset($_GET['type']) && $_GET['type']=='edit')
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $events=select('select * from tbl_categories where catid='.$id);
    if(sizeof($events)>0)
    {        
        $_catid=$id;
        $_catname=$events[0]['catname'];
        $_parentid=$events[0]['parentid'];
        $_ismain=$events[0]['ismain'];
        $_isfooter=$events[0]['isfooter'];
        $_featured=$events[0]['featured'];
        $_catimage=$events[0]['catimage'];
        $_ishot=$events[0]['ishot'];
        $_status=$events[0]['status'];
        
    }
  }
  elseif(isset($_GET['type']) && $_GET['type']=='del')
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $_dqry="delete from  tbl_categories where catid=".$id;
    if ($conn->query($_dqry) === TRUE)
    {
      ?><script>location.href='categories.php';</script><?php
    }
    
  }
  elseif(isset($_GET['id']))
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $events=select('select * from tbl_categories where catid='.$id);
    if(sizeof($events)>0)
    {      
        $_catid=$id;
        $_catname=$events[0]['catname'];
        $_parentid=$events[0]['parentid'];
        $_ismain=$events[0]['ismain'];
        $_isfooter=$events[0]['isfooter'];
        $_featured=$events[0]['featured'];
        $_catimage=$events[0]['catimage'];
        $_ishot=$events[0]['ishot'];
        $_status=$events[0]['status'];        
        $_view='disabled';
    }
  }

?>

<?php

    if(isset($_POST['btn_submit'])){
        extract($_POST);
        $chk_status=isset($chk_status)?$chk_status:0;
        $chk_main=isset($chk_main)?$chk_main:0;
        $chk_footer=isset($chk_footer)?$chk_footer:0;
        $chk_featured=isset($chk_featured)?$chk_featured:0;
        $chk_ishot=isset($chk_ishot)?$chk_ishot:0;
        $fileinfo = @getimagesize($_FILES["txt_catimage"]["tmp_name"]);
        
        $width = $fileinfo[0];  
        $height = $fileinfo[1];
        
      /*  $target_dir = "../uploads/cats/";
        $target_file = $target_dir . basename($_FILES["txt_catimage"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["txt_catimage"]["tmp_name"]);
        if($check !== false) {         
          $uploadOk = 1;
          if(true){
              
              //$width==352 && $height==458
            if (move_uploaded_file($_FILES["txt_catimage"]["tmp_name"], $target_file)) {
              echo "The file ". basename( $_FILES["txt_catimage"]["name"]). " has been uploaded.<br/>";
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
         // echo "Please upload Image File";
          $uploadOk = 1;
        }
        $_target_file=str_replace("../","",$target_file);

       
          if($_FILES["txt_catimage"]["error"]==4){
            $uploadOk=1;          
          }
          */
 $uploadOk=1;   
        if($uploadOk==1){

          if($_GET['type']=='edit'){


            /*if($_FILES["txt_catimage"]["error"]==4)
            {
                $qry="update tbl_categories set catname='$txt_category_name',
                parentid=$ddl_parent_category,
                ismain=$chk_main,
                isfooter=$chk_footer,
                featured=$chk_featured,
                ishot=$chk_ishot,
                status=$chk_status
                where catid=$hdn_id";
            }
            else{*/
              $qry="update tbl_categories set catname='$txt_category_name',
                                            parentid=$ddl_parent_category,
                                            ismain=$chk_main,
                                            isfooter=$chk_footer,
                                            featured=$chk_featured,
                                            catimage='',
                                            ishot=$chk_ishot,
                                            status=$chk_status
                                            where catid=$hdn_id";
            //}



            if ($conn->query($qry) === TRUE) {
              echo "Record updated successfully";
            } else {
              echo "Error: " . $qry . "<br>" . $conn->error;
            }
          }
          else{

            if($_FILES["txt_catimage"]["error"]==4){
              $_target_file='';
            }
            $qry="insert into tbl_categories (catname,parentid,ismain,isfooter,featured,catimage,ishot,status,eventid) values('$txt_category_name',$ddl_parent_category,$chk_main,$chk_footer,$chk_featured,'',$chk_ishot,$chk_status,$hdn_event_top)";

            if ($conn->query($qry) === TRUE) {
              echo "New record created successfully";
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
    <form role="form" method="post" enctype="multipart/form-data">
    <input type="hidden" value="<?=$_catid?>" name="hdn_id">
    <input type="hidden" name="hdn_event_top" id="hdn_event_top" value="<?=(isset($_SESSION['selected_event_id']))?$_SESSION['selected_event_id']:0?>"/>
                  <div class="box-body">
                    <div class="form-group">
                      <label for="txt_category_name">Category Name</label>
                      <input <?=$_view?> type="text" class="form-control" name="txt_category_name" placeholder="Enter category name" value="<?=$_catname?>">
                    </div>
                    <div class="form-group">
                    <label>Parent Category</label>
                        <select <?=$_view?> class="form-control select2" style="width: 100%;" name="ddl_parent_category">
                        <option selected="selected" value="0">None</option>
                        <?php
                            $categories=get_all_categories();
                            for($i=0;$i<sizeof($categories);$i++){
                                if($categories[$i]['status']==1){
                                    ?>
                                        <option value="<?=$categories[$i]['catid']?>"   <?=($_parentid==$categories[$i]['catid'])?'checked':''?>><?=$categories[$i]['catname']?></option>
                                    <?php
                                }
                            }
                        ?>
                        </select>
                    </div>
                    <input type="hidden" name="chk_main" value="1"> 
                    <input type="hidden" name="chk_footer" value="1">
                    <input type="hidden" name="chk_featured" value="1">
                    <input type="hidden" name="chk_ishot" value="1">
                    <!-- /.form-group -->
                    <!-- <div class="checkbox">
                      <label>
                        <input type="checkbox" name="chk_main" value="1"> Display in Main Menu
                      </label>
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="chk_footer" value="1"> Display in Footer
                      </label>
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="chk_featured" value="1"> Featured
                      </label>
                    </div> -->
                    <!--<div class="form-group">
                      <label for="txt_catimage">Image</label>
                      <input <?=$_view?> type="file" class="form-control" name="txt_catimage">
                    </div>-->
                    <!-- <div class="checkbox">
                      <label>
                        <input type="checkbox" name="chk_ishot" value="1"> Hot Category
                      </label>
                    </div> -->
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