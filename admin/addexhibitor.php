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
$_PDFURL5="";
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
      $_PDFURL5=$exhibitors[0]['pdf5'];
        
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
      $_PDFURL5=$exhibitors[0]['pdf5'];
      $_view='disabled';
    }
  }


  function upload_file($file_object)
  {

    $target_dir = "../uploads/ext/posters/";    
    $error=$_FILES[$file_object]["error"];
    $filename=basename($_FILES[$file_object]["name"]);
    $target_file = $target_dir .$filename;
    $uploadOk = "";    
    if($error==0)
    {
      $done=move_uploaded_file($_FILES[$file_object]["tmp_name"], $target_file);
      if($done){
        echo basename($_FILES[$file_object]["name"]);
        $uploadOk=$target_file;
      }
      else
      {
        $uploadOk = "";    
      }
    }
    return $uploadOk;    
  }
?>
<?php

    if(isset($_POST['btn_submit'])){
        extract($_POST);
        $chk_status=isset($chk_status)?$chk_status:0;      
       

        $pdf1_url=upload_file('txt_poster1');
        $pdf2_url=upload_file('txt_poster2');
        $pdf3_url=upload_file('txt_PostPDF1');
        $pdf4_url=upload_file('txt_PostPDF2');
        $pdf5_url=upload_file('txt_PostPDF5');
        $company_logo=upload_file('txt_company_logo');

        if(isset($_GET['type']) && $_GET['type']=='edit')
        {

          if($pdf1_url==""){$poster1_img="";}else{$poster1_img= "poster1='".$pdf1_url."',";}
          if($pdf2_url==""){$poster2_img="";}else{$poster2_img= "poster2='".$pdf2_url."',";}
          if($pdf3_url==""){$poster3_img="";}else{$poster3_img= "pdf1='".$pdf3_url."',";}
          if($pdf4_url==""){$poster4_img="";}else{$poster4_img= "pdf2='".$pdf3_url."',";}
          if($pdf5_url==""){$poster5_img="";}else{$poster5_img= "pdf5='".$pdf5_url."'";}
          if($company_logo==""){$company_logo_img="";}else{$company_logo_img= "company_logo='".$company_logo."',";}

      
          
        $qry="update tbl_exhibitor set 
                          company_name='$txt_company_name',
                          userlogin='$txt_userlogin',".
                          $poster1_img.
                          $poster2_img.
                          "videourl='$txt_videourl',".
                          $company_logo_img.
                          "simage='$simage',
                          status=$chk_status,
                          eventid=$hdn_event_top,".
                          $poster3_img.
                          $poster4_img.
                          $poster5_img.
                          "where id=$hdn_id";
            $qry=str_replace(",where", " where",$qry);
            if ($conn->query($qry) === TRUE) {
                echo "New record created successfully";
              } else {
                echo "Error: " . $qry . "<br>" . $conn->error;
              } 
      


        }
        else
        {

          
            $qry="insert into tbl_exhibitor (company_name,userlogin,poster1,poster2,videourl,company_logo,simage,status,eventid,pdf1,pdf2,pdf5) 
            values('$txt_company_name','$txt_userlogin','$pdf1_url','$pdf2_url','$txt_videourl','$company_logo','$simage',$chk_status,$hdn_event_top,'$pdf3_url','$pdf4_url','$pdf5_url')";
  
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
                      <label for="txt_poster1"><!--Poster 1 (Size=200x300px)--> PDF File 1</label>
                      <input <?=$_view?> type="file" class="form-control" name="txt_poster1" >
                      <?php
                        if($_poster1!='')
                        {
                          ?>
                         <div>
                          <button type="button"  class="removePoster1" name="btnremove" style="position: absolute;float: right;">X</button>
                          <img src="../uploads/poster/pdficon.png" width="100">
                          <input type="hidden" value="<?=$_poster1?>" name="hdn_poster_1" id="hdn_poster_1"/>
                          </div>
                          <?php
                        }
                      ?>
                    </div>    
                    
                    <div class="form-group">
                      <label for="txt_poster2">PDF File 2</label>
                      <input <?=$_view?> type="file" class="form-control" name="txt_poster2" >
                      <?php
                        if($_poster2!='')
                        {
                          ?>
                          <div>
                          <button type="button"  class="removePoster2" name="btnremove" style="position: absolute;float: right;">X</button>
                          <img src="../uploads/poster/pdficon.png" width="100">
                          <input type="hidden" value="<?=$_poster2?>" name="hdn_poster_2" id="hdn_poster_2"/>
                          </div>
                          <?php
                        }
                      ?>
                    </div>     
                    <div class="form-group">
                      <label for="txt_PostPDF">PDF File 3</label>
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
                      <label for="txt_PostPDF">PDF File 4</label>
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
                    <label for="txt_PostPDF">PDF File 5</label>
                    <input <?=$_view?> type="file" class="form-control" name="txt_PostPDF5">
                    <?php
                    if($_PDFURL5!='')
                    { 
                      ?>
                      <div>
                      <button type="button"  class="removePdf5" name="btnremove" style="position: absolute;float: right;">X</button>
                      <img src="../uploads/poster/pdficon.png" width="100">
                      <input type="hidden" value="<?=$_PDFURL5?>" name="hdn_poster_pdf5" id="hdn_poster_pdf5"/>
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
                          <img src="<?=$_company_logo?>" width="100" height="100">
                          <?php
                        }
                      ?>
                    </div> 
                    <div class="form-group">
                      <table style="width:100%;">
                          <tr>
                            <td style="padding:20px">
                            <label>
                              <input type="radio" name="simage" value="Platinum - HIMMEL" <?=($_simage=='Platinum - HIMMEL')?'checked':''?>/>Platinum - HIMMEL
                              <!-- <img src="../uploads/ext/stall001-t.png" width="150" /> -->
                            </label>
                            </td>
                            <td style="padding:20px">
                            <label>
                              <input type="radio" name="simage" value="Canon" <?=($_simage=='Canon')?'checked':''?>/> Canon (Gold)
                              <!-- <img src="../uploads/ext/stall002-t.png" width="150" /> -->
                            </label>
                            </td>
                            <td style="padding:20px">
                            <label>
                              <input type="radio" name="simage" value="Guerbet" <?=($_simage=='Guerbet')?'checked':''?>/>Guerbet (Gold)
                              <!-- <img src="../uploads/ext/stall003-t.png" width="150" /> -->
                            </label>
                            </td>
                            <td style="padding:20px">
                            <label>
                              <input type="radio" name="simage" value="GE Healthcare" <?=($_simage=='GE Healthcare')?'checked':''?>/>GE Healthcare
                              <!-- <img src="../uploads/ext/stall004-t.png" width="150" /> -->
                            </label>
                            </td>
                            <td style="padding:20px">
                            <label>
                              <input type="radio" name="simage" value="Graton" <?=($_simage=='Graton')?'checked':''?>/>Graton (Silver)
                              <!-- <img src="../uploads/ext/stall005-t.png" width="150" /> -->
                                </label>
                            </td>
                            </tr>
                            <tr>
                            <td style="padding:20px">
                              <label>
                              <input type="radio" name="simage" value="FujiFilm" <?=($_simage=='FujiFilm')?'checked':''?>/>FujiFilm (Basic)
                              <!-- <img src="../uploads/ext/stall006-t.png" width="150" /> -->
                              </label>
                            </td>
                            <td style="padding:20px">
                              <label>
                              <input type="radio" name="simage" value="Glob" <?=($_simage=='Glob')?'checked':''?>/>Glob (Basic)
                              <!-- <img src="../uploads/ext/stall007-t.png" width="150" /> -->
                              </label>
                            </td>
                            <td style="padding:20px">
                              <label>
	        
          
          
          
          
          
          
      
                              <input type="radio" name="simage" value="BIRSP" <?=($_simage=='BIRSP')?'checked':''?>/>BIRSP (Societies)
                              <!-- <img src="../uploads/ext/stall008-t.png" width="150" /> -->
                              </label>
                            </td>
                            <td style="padding:20px">
                              <label>
                              <input type="radio" name="simage" value="BRSP" <?=($_simage=='BRSP')?'checked':''?>/>BRSP (Societies)
                              <!-- <img src="../uploads/ext/stall009-t.png" width="150" /> -->
                              </label>
                            </td>
                            <td style="padding:20px">
                              <label>
                              <input type="radio" name="simage" value="IRSP" <?=($_simage=='IRSP')?'checked':''?>/>IRSP (Societies)
                              <!-- <img src="../uploads/ext/stall010-t.png" width="150" /> -->
                              </label>
                            </td>
                          </tr>
                          <tr>
                          <td style="padding:20px">
                              <label>
                              <input type="radio" name="simage" value="NRSP" <?=($_simage=='NRSP')?'checked':''?>/>NRSP (Societies)
                              <!-- <img src="../uploads/ext/stall010-t.png" width="150" /> -->
                              </label>
                            </td>
                            <td style="padding:20px">
                              <label>
                              <input type="radio" name="simage" value="PRSP" <?=($_simage=='PRSP')?'checked':''?>/>PRSP (Societies)
                              <!-- <img src="../uploads/ext/stall010-t.png" width="150" /> -->
                              </label>
                            </td>
                            <td style="padding:20px">
                              <label>
                              <input type="radio" name="simage" value="ROS" <?=($_simage=='ROS')?'checked':''?>/>ROS (Societies)
                              <!-- <img src="../uploads/ext/stall010-t.png" width="150" /> -->
                              </label>
                            </td>
                            <td style="padding:20px">
                              <label>
                              <input type="radio" name="simage" value="AGFA" <?=($_simage=='AGFA')?'checked':''?>/>AGFA (Societies)
                              <!-- <img src="../uploads/ext/stall010-t.png" width="150" /> -->
                              </label>
                            </td>
                            <td style="padding:20px">
                              <label>
                              <input type="radio" name="simage" value="NMS" <?=($_simage=='NMS')?'checked':''?>/>NMS (Societies)
                              <!-- <img src="../uploads/ext/stall010-t.png" width="150" /> -->
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