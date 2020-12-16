<?php include('inc/header.php'); 


$_id="";
$_company_name="";
$_userlogin="";
$_poster1="";
$_poster2="";
$_videourl="";
$_company_logo="";
$_simage="";
$_status="";
$_PDFURL1="";
$_PDFURL2="";
$_view="";


if(isset($_GET['type']) && $_GET['type']=='edit')
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $exhibitors=select('select * from  tbl_exhibitor where id='.$id);
    if(sizeof($exhibitors)>0)
    {        
        
      $_id=$id;
      $_company_name=$exhibitors[0]['company_name'];
      $_userlogin=$exhibitors[0]['userlogin'];
      $_poster1=$exhibitors[0]['poster1'];
      $_poster2=$exhibitors[0]['poster2'];
      $_videourl=$exhibitors[0]['videourl'];
      $_company_logo=$exhibitors[0]['company_logo'];
      $_simage=$exhibitors[0]['simage'];
      $_status=$exhibitors[0]['status'];
      $_PDFURL1=$exhibitors[0]['pdf1'];
      $_PDFURL2=$exhibitors[0]['pdf2'];
        
    }
  }
  elseif(isset($_GET['type']) && $_GET['type']=='del')
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $_dqry="delete from  tbl_exhibitor where id=".$id;
    if ($conn->query($_dqry) === TRUE)
    {
      ?><script>location.href='exhibitors.php';</script><?php
    }
    
  }
  elseif(isset($_GET['id']))
  {
    $id=isset($_GET['id'])?$_GET['id']:0;
    $exhibitors=select('select * from tbl_exhibitor where id='.$id);
    
    if(sizeof($exhibitors)>0)
    {
      $_id=$id;
      $_company_name=$exhibitors[0]['company_name'];
      $_userlogin=$exhibitors[0]['userlogin'];
      $_poster1=$exhibitors[0]['poster1'];
      $_poster2=$exhibitors[0]['poster2'];
      $_videourl=$exhibitors[0]['videourl'];
      $_company_logo=$exhibitors[0]['company_logo'];
      $_simage=$exhibitors[0]['simage'];
      $_status=$exhibitors[0]['status'];
      $_PDFURL1=$exhibitors[0]['pdf1'];
      $_PDFURL2=$exhibitors[0]['pdf2'];
      $_view='disabled';
    }
  }

?>

<?php

    if(isset($_POST['btn_submit'])){
        extract($_POST);
        $chk_status=isset($chk_status)?$chk_status:0;      
        $fileinfo = @getimagesize($_FILES["txt_poster1"]["tmp_name"]);
        
        $txt_company_name=mysqli_escape_string($conn,$txt_company_name);
        $txt_userlogin=mysqli_escape_string($conn,$txt_userlogin);
        $txt_videourl=mysqli_escape_string($conn,$txt_videourl);
        

        $width = $fileinfo[0];  
        $height = $fileinfo[1];
        
        $target_dir = "../uploads/ext/posters/";
        $target_file_txt_poster1 = $target_dir . basename($_FILES["txt_poster1"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file_txt_poster1,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["txt_poster1"]["tmp_name"]);
        if($check !== false) {         
          $uploadOk = 1;
          if(true){//if($width==352 && $height==458){
            if (move_uploaded_file($_FILES["txt_poster1"]["tmp_name"], $target_file_txt_poster1)) {
              echo "The file ". basename( $_FILES["txt_poster1"]["name"]). " has been uploaded.<br/>";
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
        $target_file_txt_poster1=str_replace("../","",$target_file_txt_poster1);

        $fileinfo = @getimagesize($_FILES["txt_PostPDF1"]["tmp_name"]);

        $width = $fileinfo[0];  
        $height = $fileinfo[1]; 

        
        $target_file2_pdf1 = $target_dir . basename($_FILES["txt_PostPDF1"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file2_pdf1,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["txt_PostPDF1"]["tmp_name"]);
        $pdfuploaded1=0;
        if(true)
        {         //if($check !== false) {         
          $uploadOk = 1;
          if(true)
          {//if($width==352 && $height==458){
            if (move_uploaded_file($_FILES["txt_PostPDF1"]["tmp_name"], $target_file2_pdf1))
            {
              echo "The file ". basename( $_FILES["txt_PostPDF1"]["name"]). " has been uploaded.<br/>";
              $pdfuploaded1=1;
            }
            else
            {
              

              if($hdn_poster_pdf1==""){
                $uploadOk = 1;  
              }
              else{
              $uploadOk = 0;
              echo "Sorry, there was an error uploading your file.";
              }
            }
          }
          else
          {
            echo "Sorry, there was an error uploading your file.Image file should be 352 x 458 pixels in size.";
            $uploadOk = 0;
          }
        }
        else
        {
          echo "Please upload Image File";
          $uploadOk = 0;
        }
        if($pdfuploaded1==0 && $hdn_poster_pdf1=="")
        {
          $target_file2_pdf1="";
        }
        else
        {
          $target_file2_pdf1=str_replace("../","",$target_file2_pdf1);
        }
        $target_file2_pdf2 = $target_dir . basename($_FILES["txt_PostPDF2"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file2_pdf2,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["txt_PostPDF2"]["tmp_name"]);
        $pdfuploaded2=0;
        if(true)
        {         //if($check !== false) {         
          $uploadOk = 1;
          if(true)
          {//if($width==352 && $height==458){
            if (move_uploaded_file($_FILES["txt_PostPDF2"]["tmp_name"], $target_file2_pdf2))
            {
              echo "The file ". basename( $_FILES["txt_PostPDF2"]["name"]). " has been uploaded.<br/>";
              $pdfuploaded2=1;
            }
            else
            {
              

              if($hdn_poster_pdf2==""){
                $uploadOk = 1;  
              }
              else{
              $uploadOk = 0;
              echo "Sorry, there was an error uploading your file.";
              }
            }
          }
          else
          {
            echo "Sorry, there was an error uploading your file.Image file should be 352 x 458 pixels in size.";
            $uploadOk = 0;
          }
        }
        else
        {
          echo "Please upload Image File";
          $uploadOk = 0;
        }

        if($pdfuploaded2==0 && $hdn_poster_pdf2=="")
        {
          $target_file2_pdf2="";
        }
        else
        {
          $target_file2_pdf2=str_replace("../","",$target_file2_pdf2);
        }

        $target_file_txt_poster2 = $target_dir . basename($_FILES["txt_poster2"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file_txt_poster2,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["txt_poster2"]["tmp_name"]);
        if($check !== false) {         
          $uploadOk = 1;
          if(true){//if($width==352 && $height==458){
            if (move_uploaded_file($_FILES["txt_poster2"]["tmp_name"], $target_file_txt_poster2)) {
              echo "The file ". basename( $_FILES["txt_poster2"]["name"]). " has been uploaded.<br/>";
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
        $target_file_txt_poster2=str_replace("../","",$target_file_txt_poster2);

        $target_dir = "../uploads/ext/logos/";
        $target_file_txt_company_logo = $target_dir . basename($_FILES["txt_company_logo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file_txt_company_logo,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["txt_company_logo"]["tmp_name"]);
        if($check !== false) {         
          $uploadOk = 1;
          if(true){//if($width==352 && $height==458){
            if (move_uploaded_file($_FILES["txt_company_logo"]["tmp_name"], $target_file_txt_company_logo)) {
              echo "The file ". basename( $_FILES["txt_company_logo"]["name"]). " has been uploaded.<br/>";
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
        $target_file_txt_company_logo=str_replace("../","",$target_file_txt_company_logo);

        if(isset($_GET['type']) && $_GET['type']=='edit'){

          if($_FILES["txt_poster1"]["error"]==4)
          {
            $poster1_img="";
          }
          else
          {
            $poster1_img= ((strlen($target_file_txt_poster1)>0)?"poster1='".$target_file_txt_poster1."',":"");
          }

          if($_FILES["txt_poster2"]["error"]==4)
          {
            $poster2_img="";
          }
          else
          {
            $poster2_img=((strlen($target_file_txt_poster2)>0)?"poster2='".$target_file_txt_poster2."',":"");
          }          

          if($_FILES["txt_company_logo"]["error"]==4){
            $company_logo_img='';
          }else{
            $company_logo_img=((strlen($target_file_txt_company_logo)>0)?"company_logo='".$target_file_txt_company_logo."',":"");
          }
         $qry="update tbl_exhibitor set 
                          company_name='$txt_company_name',
                          userlogin='$txt_userlogin',".
                          $poster1_img.
                          $poster2_img.
                          "videourl='$txt_videourl',".
                          $company_logo_img.
                          "simage='$simage',
                          status=$chk_status,
                          eventid=$hdn_event_top,
                          pdf1='$target_file2_pdf1',
                          pdf2='$target_file2_pdf2'
                          where id=$hdn_id";
  
            if ($conn->query($qry) === TRUE) {
                echo "New record created successfully";
              } else {
                echo "Error: " . $qry . "<br>" . $conn->error;
              } 
      


        }
        else
        {

          if($uploadOk==1){
            $qry="insert into tbl_exhibitor (company_name,userlogin,poster1,poster2,videourl,company_logo,simage,status,eventid,pdf1,pdf2) 
            values('$txt_company_name','$txt_userlogin','$target_file_txt_poster1','$target_file_txt_poster2','$txt_videourl','$txt_company_logo','$simage',$chk_status,$hdn_event_top,'$target_file2_pdf1','$target_file2_pdf2')";
  
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
    <input type="hidden" value="<?=$_id?>" name="hdn_id">
    <input type="hidden" name="hdn_event_top" id="hdn_event_top" value="<?=(isset($_SESSION['selected_event_id']))?$_SESSION['selected_event_id']:0?>"/>
                  <div class="box-body">
                    <div class="form-group">
                      <label for="txt_company_name">Company Name</label>                      
                      <input <?=$_view?> type="text" class="form-control" name="txt_company_name" placeholder="Enter company name" value="<?=$_company_name?>">
                    </div>                      
                    <div class="form-group">
                      <label for="txt_userlogin">User Login Email</label>                      
                      <input <?=$_view?> type="email" class="form-control" name="txt_userlogin" placeholder="Enter login email" value="<?=$_userlogin?>">
                    </div>      
                    <div class="form-group">
                      <label for="txt_poster1">Poster 1 (Size=200x300px)</label>
                      <input <?=$_view?> type="file" class="form-control" name="txt_poster1" >
                      <?php
                        if($_poster1!='')
                        {
                          ?>
                          <img src="../<?=$_poster1?>" width="100" height="150">
                          <?php
                        }
                      ?>
                    </div>    
                    
                    <div class="form-group">
                      <label for="txt_poster2">Poster 2  (Size=200x300px)</label>
                      <input <?=$_view?> type="file" class="form-control" name="txt_poster2" >
                      <?php
                        if($_poster2!='')
                        {
                          ?>
                          <img src="../<?=$_poster2?>" width="100" height="150">
                          <?php
                        }
                      ?>
                    </div>     
                    <div class="form-group">
                      <label for="txt_PostPDF">PDF File 1</label>
                      <input <?=$_view?> type="file" class="form-control" name="txt_PostPDF1">
                      <?php
                        if($_PDFURL1!='')
                        {
                          ?>
                          <div>
                            <button type="button"  class="removePdf1" name="btnremove" style="position: absolute;float: right;">X</button>
                            <img src="../uploads/poster/pdficon.png" width="100">
                            <input type="hidden" value="<?=$_PDFURL1?>" name="hdn_poster_pdf1" id="hdn_poster_pdf1"/>
                          </div>
                          <?php
                        }
                      ?>
                    </div>  
                    <div class="form-group">
                      <label for="txt_PostPDF">PDF File 2</label>
                      <input <?=$_view?> type="file" class="form-control" name="txt_PostPDF2">
                      <?php
                        if($_PDFURL2!='')
                        {
                          ?>
                          <div>
                            <button type="button"  class="removePdf2" name="btnremove" style="position: absolute;float: right;">X</button>
                            <img src="../uploads/poster/pdficon.png" width="100">
                            <input type="hidden" value="<?=$_PDFURL2?>" name="hdn_poster_pdf2" id="hdn_poster_pdf2"/>
                          </div>
                          <?php
                        }
                      ?>
                    </div> 
                    <div class="form-group">
                      <label for="txt_videourl">Video URL</label>
                      <input <?=$_view?> type="text" class="form-control" name="txt_videourl" placeholder="Enter Video URL" value="<?=$_videourl?>">
                    </div>     
                    <div class="form-group">
                      <label for="txt_company_logo">Company Logo (Size=200x200px)</label>
                      <input <?=$_view?> type="file" class="form-control" name="txt_company_logo" >
                      <?php
                        if($_company_logo!='')
                        {
                          ?>
                          <img src="../<?=$_company_logo?>" width="100" height="100">
                          <?php
                        }
                      ?>
                    </div> 
                    <div class="form-group">
                      <table style="width:100%;">
                          <tr>
                            <td style="padding:20px">
                            <label>
                              <input type="radio" name="simage" value="uploads/ext/stall001-t.png" <?=($_simage=='uploads/ext/stall001-t.png')?'checked':''?>/>
                              <img src="../uploads/ext/stall001-t.png" width="150" />
                            </label>
                            </td>
                            <td style="padding:20px">
                            <label>
                              <input type="radio" name="simage" value="uploads/ext/stall002-t.png" <?=($_simage=='uploads/ext/stall002-t.png')?'checked':''?>/>
                              <img src="../uploads/ext/stall002-t.png" width="150" />
                            </label>
                            </td>
                            <td style="padding:20px">
                            <label>
                              <input type="radio" name="simage" value="uploads/ext/stall003-t.png" <?=($_simage=='uploads/ext/stall003-t.png')?'checked':''?>/>
                              <img src="../uploads/ext/stall003-t.png" width="150" />
                            </label>
                            </td>
                            <td style="padding:20px">
                            <label>
                              <input type="radio" name="simage" value="uploads/ext/stall004-t.png" <?=($_simage=='uploads/ext/stall004-t.png')?'checked':''?>/>
                              <img src="../uploads/ext/stall004-t.png" width="150" />
                            </label>
                            </td>
                            <td style="padding:20px">
                            <label>
                              <input type="radio" name="simage" value="uploads/ext/stall005-t.png" <?=($_simage=='uploads/ext/stall005-t.png')?'checked':''?>/>
                              <img src="../uploads/ext/stall005-t.png" width="150" />
                                </label>
                            </td>
                            </tr>
                            <tr>
                            <td style="padding:20px">
                              <label>
                              <input type="radio" name="simage" value="uploads/ext/stall006-t.png" <?=($_simage=='uploads/ext/stall006-t.png')?'checked':''?>/>
                              <img src="../uploads/ext/stall006-t.png" width="150" />
                              </label>
                            </td>
                            <td style="padding:20px">
                              <label>
                              <input type="radio" name="simage" value="uploads/ext/stall007-t.png" <?=($_simage=='uploads/ext/stall007-t.png')?'checked':''?>/>
                              <img src="../uploads/ext/stall007-t.png" width="150" />
                              </label>
                            </td>
                            <td style="padding:20px">
                              <label>
                              <input type="radio" name="simage" value="uploads/ext/stall008-t.png" <?=($_simage=='uploads/ext/stall008-t.png')?'checked':''?>/>
                              <img src="../uploads/ext/stall008-t.png" width="150" />
                              </label>
                            </td>
                            <td style="padding:20px">
                              <label>
                              <input type="radio" name="simage" value="uploads/ext/stall009-t.png" <?=($_simage=='uploads/ext/stall008-t.png')?'checked':''?>/>
                              <img src="../uploads/ext/stall009-t.png" width="150" />
                              </label>
                            </td>
                            <td style="padding:20px">
                              <label>
                              <input type="radio" name="simage" value="uploads/ext/stall010-t.png" <?=($_simage=='uploads/ext/stall008-t.png')?'checked':''?>/>
                              <img src="../uploads/ext/stall010-t.png" width="150" />
                              </label>
                            </td>
                          </tr>
                      </table>

                    </div> 

                    <div class="checkbox">
                      <label>
                      <input <?=$_view?> type="checkbox" name="chk_status" value="1" <?=($_status==1)?'checked':''?>> Active
                      </label>
                    </div>
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button <?=$_view?> type="submit" class="btn btn-primary" name="btn_submit">Submit</button>
                  </div>
                </form>
    </div><!-- /.box -->

    </section><!-- /.content -->
<?php include('inc/footer.php');?>