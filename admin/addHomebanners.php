<?php include('inc/header.php'); ?>

<?php

$Id =0;
$Video1URL='';
$Video2URL='';
$InformtiondeskURL='';
$Gold1SponserURL='';
$Silver1SponserURL='';
$Gold2SponserURL='';
$Silver2SponserURL ='';
$Basic1SponserURL='';
$Basic2SponserURL='';
$PlatiniumSponserURL='';
$hall1_title='';
$hall2_title='';
$status='';
$_view='';
$_top_event_id=(isset($_SESSION['selected_event_id']))?$_SESSION['selected_event_id']:0;
$user_data=select("select * from tbl_homebanners where eventid=$_top_event_id");

    if(sizeof($user_data)>0)
    {
      
      $Id=$user_data[0]['Id'];
      $Video1URL=$user_data[0]['Video1URL'];
      $Video2URL=$user_data[0]['Video2URL'];
      $InformtiondeskURL=$user_data[0]['InformtiondeskURL'];
      $Gold1SponserURL=$user_data[0]['Gold1SponserURL'];
      $Silver1SponserURL=$user_data[0]['Silver1SponserURL'];
      $Gold2SponserURL=$user_data[0]['Gold2SponserURL'];
      $Silver2SponserURL=$user_data[0]['Silver2SponserURL'];
      $Basic1SponserURL=$user_data[0]['Basic1SponserURL'];
      $Basic2SponserURL=$user_data[0]['Basic2SponserURL'];
      $PlatiniumSponserURL=$user_data[0]['PlatiniumSponserURL'];
      $hall1_title=$user_data[0]['hall1_title'];
      $hall2_title=$user_data[0]['hall2_title'];
      $status=$user_data[0]['status'];
    }

  if(isset($_POST['btn_submit'])){
    extract($_POST);
    $chk_status=isset($chk_status)?$chk_status:0;   
    $txt_Video1URL=mysqli_escape_string($conn,$txt_Video1URL);
    $txt_Video2URL=mysqli_escape_string($conn,$txt_Video2URL);
    $txt_hall1_title=mysqli_escape_string($conn,$txt_hall1_title);
    $txt_hall2_title=mysqli_escape_string($conn,$txt_hall2_title);


    try{
          $fileinfo = @getimagesize($_FILES["txt_infodesk"]["tmp_name"]);
          $target_dir = "../uploads/HomeBanners/";
          $target_file1 = $target_dir . basename($_FILES["txt_infodesk"]["name"]);
          $uploadOk = 1;
          $imageFileType = strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));
          // Check if image file is a actual image or fake image
          $check = @getimagesize($_FILES["txt_infodesk"]["tmp_name"]);        
          
          if($check !== false) {         
            $uploadOk = 1;
            if(true){        
              //if($width==352 && $height==458){
              if (move_uploaded_file($_FILES["txt_infodesk"]["tmp_name"], $target_file1)) {
                echo "The file ". basename( $_FILES["txt_infodesk"]["name"]). " has been uploaded.<br/>";
              } else {
                echo "Sorry, there was an error uploading your file.";
                $uploadOk = 0;
                $target_file1='';
              }
            }else
            {
              echo "Sorry, there was an error uploading your file.Image file should be 352 x 458 pixels in size.";
              $uploadOk = 0;
              $target_file1='';
            }
          } 

    $fileinfo = @getimagesize($_FILES["txt_gold1sponser"]["tmp_name"]);
    $target_dir = "../uploads/HomeBanners/";
    $target_file2 = $target_dir . basename($_FILES["txt_gold1sponser"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    $check = @getimagesize($_FILES["txt_gold1sponser"]["tmp_name"]);        
    

    if($check !== false) {         
      $uploadOk = 1;
      if(true){//if($width==352 && $height==458){
        if (move_uploaded_file($_FILES["txt_gold1sponser"]["tmp_name"], $target_file2)) {
          echo "The file ". basename( $_FILES["txt_gold1sponser"]["name"]). " has been uploaded.<br/>";
        } else {
          echo "Sorry, there was an error uploading your file.";
          $uploadOk = 0;
          $target_file2='';
        }
      }else
      {
        echo "Sorry, there was an error uploading your file.Image file should be 352 x 458 pixels in size.";
        $uploadOk = 0;
        $target_file2='';
      }
    }

    $fileinfo = @getimagesize($_FILES["txt_gold2sponser"]["tmp_name"]);
    $target_dir = "../uploads/HomeBanners/";
    $target_file3 = $target_dir . basename($_FILES["txt_gold2sponser"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file3,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    $check = @getimagesize($_FILES["txt_gold2sponser"]["tmp_name"]);        
    

    if($check !== false) {         
      $uploadOk = 1;
      if(true){//if($width==352 && $height==458){
        if (move_uploaded_file($_FILES["txt_gold2sponser"]["tmp_name"], $target_file3)) {
          echo "The file ". basename( $_FILES["txt_gold2sponser"]["name"]). " has been uploaded.<br/>";
        } else {
          echo "Sorry, there was an error uploading your file.";
          $uploadOk = 0;
          $target_file3='';
        }
      }else
      {
        echo "Sorry, there was an error uploading your file.Image file should be 352 x 458 pixels in size.";
        $uploadOk = 0;
        $target_file3='';
      }
    }

    $fileinfo = @getimagesize($_FILES["txt_silver1sponser"]["tmp_name"]);
    $target_dir = "../uploads/HomeBanners/";
    $target_file4 = $target_dir . basename($_FILES["txt_silver1sponser"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file4,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    $check = @getimagesize($_FILES["txt_silver1sponser"]["tmp_name"]);        
    

    if($check !== false) {         
      $uploadOk = 1;
      if(true){//if($width==352 && $height==458){
        if (move_uploaded_file($_FILES["txt_silver1sponser"]["tmp_name"], $target_file4)) {
          echo "The file ". basename( $_FILES["txt_silver1sponser"]["name"]). " has been uploaded.<br/>";
        } else {
          echo "Sorry, there was an error uploading your file.";
          $uploadOk = 0;
          $target_file4='';
        }
      }else
      {
        echo "Sorry, there was an error uploading your file.Image file should be 352 x 458 pixels in size.";
        $uploadOk = 0;
        $target_file4='';
      }
    }

    $fileinfo = @getimagesize($_FILES["txt_silver2sponser"]["tmp_name"]);
    $target_dir = "../uploads/HomeBanners/";
    $target_file5 = $target_dir . basename($_FILES["txt_silver2sponser"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file5,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    $check = @getimagesize($_FILES["txt_silver2sponser"]["tmp_name"]);        
    

    if($check !== false) {         
      $uploadOk = 1;
      if(true){//if($width==352 && $height==458){
        if (move_uploaded_file($_FILES["txt_silver2sponser"]["tmp_name"], $target_file5)) {
          echo "The file ". basename( $_FILES["txt_silver2sponser"]["name"]). " has been uploaded.<br/>";
        } else {
          echo "Sorry, there was an error uploading your file.";
          $uploadOk = 0;
          $target_file5='';
        }
      }else
      {
        echo "Sorry, there was an error uploading your file.Image file should be 352 x 458 pixels in size.";
        $uploadOk = 0;
        $target_file5='';
      }
    }

    $fileinfo = @getimagesize($_FILES["txt_basic1sponser"]["tmp_name"]);
    $target_dir = "../uploads/HomeBanners/";
    $target_file6 = $target_dir . basename($_FILES["txt_basic1sponser"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file6,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    $check = @getimagesize($_FILES["txt_basic1sponser"]["tmp_name"]);        
    

    if($check !== false) {         
      $uploadOk = 1;
      if(true){//if($width==352 && $height==458){
        if (move_uploaded_file($_FILES["txt_basic1sponser"]["tmp_name"], $target_file6)) {
          echo "The file ". basename( $_FILES["txt_basic1sponser"]["name"]). " has been uploaded.<br/>";
        } else {
          echo "Sorry, there was an error uploading your file.";
          $uploadOk = 0;
          $target_file6='';
        }
      }else
      {
        echo "Sorry, there was an error uploading your file.Image file should be 352 x 458 pixels in size.";
        $uploadOk = 0;
        $target_file6='';
      }
    }

    $fileinfo = @getimagesize($_FILES["txt_basic2sponser"]["tmp_name"]);
    $target_dir = "../uploads/HomeBanners/";
    $target_file7 = $target_dir . basename($_FILES["txt_basic2sponser"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file7,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    $check = @getimagesize($_FILES["txt_basic2sponser"]["tmp_name"]);        
    

    if($check !== false) {         
      $uploadOk = 1;
      if(true){//if($width==352 && $height==458){
        if (move_uploaded_file($_FILES["txt_basic2sponser"]["tmp_name"], $target_file7)) {
          echo "The file ". basename( $_FILES["txt_basic2sponser"]["name"]). " has been uploaded.<br/>";
        } else {
          echo "Sorry, there was an error uploading your file.";
          $uploadOk = 0;
          $target_file7='';
        }
      }else
      {
        echo "Sorry, there was an error uploading your file.Image file should be 352 x 458 pixels in size.";
        $uploadOk = 0;
        $target_file7='';
      }
    }


    $fileinfo = @getimagesize($_FILES["txt_platiniumsponser"]["tmp_name"]);
    $target_dir = "../uploads/HomeBanners/";
    $target_file8 = $target_dir . basename($_FILES["txt_platiniumsponser"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file8,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    $check = @getimagesize($_FILES["txt_platiniumsponser"]["tmp_name"]);        
    

    if($check !== false) 
    {         
      $uploadOk = 1;
      if(true){//if($width==352 && $height==458){
        if (move_uploaded_file($_FILES["txt_platiniumsponser"]["tmp_name"], $target_file8)) {
          echo "The file ". basename( $_FILES["txt_platiniumsponser"]["name"]). " has been uploaded.<br/>";
        } else {
          echo "Sorry, there was an error uploading your file.";
          $uploadOk = 0;
          $target_file8='';
        }
      }
      else
      {
        echo "Sorry, there was an error uploading your file.Image file should be 352 x 458 pixels in size.";
        $uploadOk = 0;
        
      }
    }

  }catch(Exception $e){

  }

    if($Id<=0)
    {
      $qry="insert into tbl_homebanners(Video1URL,Video2URL,      InformtiondeskURL,Gold1SponserURL,Silver1SponserURL,Gold2SponserURL,Silver2SponserURL,Basic1SponserURL,Basic2SponserURL,PlatiniumSponserURL,hall1_title,hall2_title,status,eventid) 
                         values('$txt_Video1URL','$txt_Video2URL','$target_file1',  '$target_file2','$target_file4','$target_file3','$target_file5','$target_file6','$target_file7','$target_file8','$txt_hall1_title','$txt_hall2_title',$chk_status,$hdn_event_top)";
    }
    else
    {
      
    
     $qry="update tbl_homebanners set Video1URL='$txt_Video1URL',Video2URL='$txt_Video2URL',";     
     $qry.=(substr($target_file1,$target_file1-1,1)=='/')?"":"InformtiondeskURL='$target_file1',";
     $qry.=(substr($target_file2,$target_file2-1,1)=='/')?"":"Gold1SponserURL='$target_file2',";
     $qry.=(substr($target_file4,$target_file4-1,1)=='/')?"":"Silver1SponserURL='$target_file4',";
     $qry.=(substr($target_file3,$target_file3-1,1)=='/')?"":"Gold2SponserURL='$target_file3',";
     $qry.=(substr($target_file5,$target_file5-1,1)=='/')?"":"Silver2SponserURL='$target_file5',";
     $qry.=(substr($target_file6,$target_file6-1,1)=='/')?"":"Basic1SponserURL='$target_file6',";
     $qry.=(substr($target_file7,$target_file7-1,1)=='/')?"":"Basic2SponserURL='$target_file7',";
     $qry.=(substr($target_file8,$target_file8-1,1)=='/')?"":"PlatiniumSponserURL='$target_file8',";
     $qry.= "hall1_title='$txt_hall1_title',";
     $qry.= "hall2_title='$txt_hall2_title',";
     $qry.= "status=$chk_status, eventid=$hdn_event_top where Id=$Id"; 
    }

    if ($conn->query($qry) === TRUE)
    {
      $delimgs=explode(',',substr($hdn_del_img,0,strlen($hdn_del_img)-1));

        for($j=0;$j<sizeof($delimgs);$j++){
          $imgcol=str_replace('btn_','',$delimgs[$j]);
         $imgrqry="update tbl_homebanners set $imgcol='' where Id=$Id";
          $conn->query($imgrqry);
        }
        echo "New record created successfully";
        $user_data=select('select * from tbl_homebanners');

        if(sizeof($user_data)>0)
        {
          
          $Id=$user_data[0]['Id'];
          $Video1URL=$user_data[0]['Video1URL'];
          $Video2URL=$user_data[0]['Video2URL'];
          $InformtiondeskURL=$user_data[0]['InformtiondeskURL'];
          $Gold1SponserURL=$user_data[0]['Gold1SponserURL'];
          $Silver1SponserURL=$user_data[0]['Silver1SponserURL'];
          $Gold2SponserURL=$user_data[0]['Gold2SponserURL'];
          $Silver2SponserURL=$user_data[0]['Silver2SponserURL'];
          $Basic1SponserURL=$user_data[0]['Basic1SponserURL'];
          $Basic2SponserURL=$user_data[0]['Basic2SponserURL'];
          $PlatiniumSponserURL=$user_data[0]['PlatiniumSponserURL'];
          $hall1_title=$user_data[0]['hall1_title'];
          $hall2_title=$user_data[0]['hall2_title'];
          $status=$user_data[0]['status'];
        }
    }
    else
    {
        echo "Error: " . $qry . "<br>" . $conn->error;
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
        </div>
    </div>
    <!-- form start -->
    <form role="form" method="post"  enctype="multipart/form-data"> 
    <input type="hidden" value="<?=$Id?>" name="hdn_id">
    <input type="hidden" name="hdn_event_top" id="hdn_event_top" value="<?=(isset($_SESSION['selected_event_id']))?$_SESSION['selected_event_id']:0?>"/>
    <input type="hidden" value="" name="hdn_del_img" id="hdn_del_img">
                  <div class="box-body">
                   <div class="form-group">
                      <label for="txt_VideoURL">Video 1 URL</label>
                      <input <?=$_view?> type="text" class="form-control" name="txt_Video1URL" placeholder="Enter Video2 URL" value="<?=$Video1URL?>">
                    </div>
					<div class="form-group">
                      <label for="txt_VideoURL">Video 2 URL</label>
                      <input <?=$_view?> type="text" class="form-control" name="txt_Video2URL" placeholder="Enter Video1 URL" value="<?=$Video2URL?>">
                    </div>
                      <div class="form-group">
                      <table width="100%">
                        <tr>
                          <td>
                            <label for="txt_Postimage">Informtion Desk Image File (Size=67x90px)</label>
                            <input <?=$_view?> type="file" class="form-control" name="txt_infodesk">                                           
                          </td>
                          <td>
                          <?php
                            if($InformtiondeskURL!='')
                            {
                              ?>
                              <button type="button"  class="removeImg" name="btn_InformtiondeskURL" style="position: absolute;float: right;">X</button>
                              <img style="border:1px solid #000" src="<?=$InformtiondeskURL?>" width="67" height="90">
                              <?php
                            }
                          ?>
                          </td>
                        </tr>
                      </table>
                    </div>  
						<div class="form-group">
            <table width="100%">
                        <tr>
                          <td>
                          <label for="txt_Postimage">Gold Sponser Image1 File (Size=75x50px)</label>
                      <input <?=$_view?> type="file" class="form-control" name="txt_gold1sponser">                                          
                          </td>
                          <td>
                          <?php

                        if($Gold1SponserURL!='')
                        {

                          ?>
                          <button type="button" class="removeImg" name="btn_Gold1SponserURL" style="position: absolute;float: right;">X</button>
                          <img style="border:1px solid #000" src="<?=$Gold1SponserURL?>" width="75" height="50">

                          <?php

                        }

                      ?>
                          </td>
                        </tr>
                      </table>
                    </div>
                     <div class="form-group">
                     <table width="100%">
                        <tr>
                          <td>
                          <label for="txt_Postimage">Gold Sponser Image2 File  (Size=75x50px)</label>
                      <input <?=$_view?> type="file" class="form-control" name="txt_gold2sponser">                                           
                          </td>
                          <td>
                          <?php

                        if($Gold2SponserURL!='')

                        {

                          ?>
                          <button type="button"  class="removeImg"  name="btn_Gold2SponserURL" style="position: absolute;float: right;">X</button>
                          <img style="border:1px solid #000" src="<?=$Gold2SponserURL?>" width="75" height="50">

                          <?php

                        }

                      ?>
                          </td>
                        </tr>
                      </table>
                    </div>
					 <div class="form-group">
           <table width="100%">
                        <tr>
                          <td>
                          <label for="txt_Postimage">Silver Sponser Image1 File  (Size=75x50px)</label>
                      <input <?=$_view?> type="file" class="form-control" name="txt_silver1sponser">                                       
                          </td>
                          <td>
                          <?php

                              if($Silver1SponserURL!='')

                              {

                                ?>
                                <button type="button"  class="removeImg"  name="btn_Silver1SponserURL" style="position: absolute;float: right;">X</button>
                                <img style="border:1px solid #000" src="<?=$Silver1SponserURL?>" width="75" height="50">

                                <?php

                              }

                              ?>

                          </td>
                        </tr>
                      </table>
                    </div>
					 <div class="form-group">
                      <table width="100%">
                        <tr>
                          <td>
                          <label for="txt_Postimage">Silver Sponser Image2 File (Size=75x50px)</label>

<input <?=$_view?> type="file" class="form-control" name="txt_silver2sponser">                                    
                          </td>
                          <td>
                          <?php

                        if($Silver2SponserURL!='')

                        {

                          ?>
                                <button type="button"  class="removeImg"  name="btn_Silver2SponserURL" style="position: absolute;float: right;">X</button>
                          <img style="border:1px solid #000" src="<?=$Silver2SponserURL?>" width="75" height="50">

                          <?php

                        }

                      ?>
                          </td>
                        </tr>
                      </table>
                    </div>
					 <div class="form-group">
           <table width="100%">
                        <tr>
                          <td>
                          <label for="txt_Postimage">Basic Sponser Image1 File (Size=75x50px)</label>

<input <?=$_view?> type="file" class="form-control" name="txt_basic1sponser">                                         
                          </td>
                          <td>
                          <?php

                        if($Basic1SponserURL!='')

                        {

                          ?>
<button type="button"   class="removeImg"  name="btn_Basic1SponserURL" style="position: absolute;float: right;">X</button>
                          <img style="border:1px solid #000" src="<?=$Basic1SponserURL?>" width="75" height="50">

                          <?php

                        }

                      ?>
                          </td>
                        </tr>
                      </table>
                    </div>
					 <div class="form-group">
                      <table width="100%">
                        <tr>
                          <td>
                          <label for="txt_Postimage">Basic Sponser Image2 File  (Size=75x50px)</label>

<input <?=$_view?> type="file" class="form-control" name="txt_basic2sponser">                                        
                          </td>
                          <td>
                          <?php

                        if($Basic2SponserURL!='')

                        {

                          ?>
<button type="button"   class="removeImg"  name="btn_Basic2SponserURL" style="position: absolute;float: right;">X</button>
                          <img style="border:1px solid #000" src="<?=$Basic2SponserURL?>" width="75" height="50">

                          <?php

                        }

                      ?>
                          </td>
                        </tr>
                      </table>
                    </div>
					 <div class="form-group">
           <table width="100%">
                        <tr>
                          <td>
                          <label for="txt_Postimage">Platinium Sponser Image File  (Size=135x90px)</label>

<input <?=$_view?> type="file" class="form-control" name="txt_platiniumsponser">                                       
                          </td>
                          <td>
                          <?php

if($PlatiniumSponserURL!='')

{

  ?>
<button type="button"   class="removeImg"  name="txt_PlatiniumSponserURL" style="position: absolute;float: right;">X</button>
  <img style="border:1px solid #000" src="<?=$PlatiniumSponserURL?>" width="135" height="90">

  <?php

}

?>
                        </td>
                        </tr>
                      </table>
                    </div>
                    <div class="form-group">
                      <label for="txt_hall1_title">Hall 1 Title</label>
                      <input <?=$_view?> type="text" class="form-control" name="txt_hall1_title" placeholder="Enter title" value="<?=$hall1_title?>">
                    </div>
                    <div class="form-group">
                      <label for="txt_hall2_title">Hall 2 Title</label>
                      <input <?=$_view?> type="text" class="form-control" name="txt_hall2_title" placeholder="Enter title" value="<?=$hall2_title?>">
                    </div>
                    <div class="checkbox">
                      <label>
                        <input <?=$_view?> type="checkbox" name="chk_status" value="1" <?=($status==1)?'checked':''?>> Active
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