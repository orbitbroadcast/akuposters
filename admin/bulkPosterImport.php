<?php 
  include('inc/header.php');
  include_once "simplexlsx/src/SimpleXLSX.php";

  function getCategoryIdByTitle($catName){
      $category=select("SELECT catid as id from tbl_categories where catname='{$catName}'");
      if(sizeof($category)>0)
      {
          return $category[0]['id'];
      }
      return null;
  }
    function getUserIdByEmail($email, $eventId){
        global $conn;
        $data=select("SELECT userid as id from tbl_users where username='{$email}'");
        if(sizeof($data)>0)
        {
            return $data[0]['id'];
        }
        else {
            $qry="insert into tbl_users (username, password, roleid, status, eventid, isapprover) values(
                                        '{$email}','1234','10','1','{$eventId}',0)";
            if ($conn->query($qry) === TRUE) {
                return $conn->insert_id;
            }
        }
        return null;
    }

if(isset($_POST["submit"]))
{
    $doneArray = [];
    $failedArray = [];
    $eventId = $_POST['event_id'];
    $file = $_FILES['file']['tmp_name'];
    if ( empty($eventId) ) {
        echo '<div class="alert alert-danger" >Sorry, you did not select any event!</div>';
    }
    if ( !empty($eventId) && $xlsx = SimpleXLSX::parse($file) ) {
        foreach( $xlsx->rows() as $key=>$arr ) {
            if ($key>0){
                $theme = $arr[0];
                $abstruct = $arr[1];
                $title = str_replace("'", "\'", $arr[2]);
                $email = $arr[3];

                $imageUrl = "uploads/poster/{$abstruct}.jpg";
                $pdfUrl = "uploads/poster/{$abstruct}.pdf";

                $categoryId = getCategoryIdByTitle($theme);
                $createdById = getUserIdByEmail($email, $eventId);


                $sql = "Insert Into tbl_poster (Title,ImageURL,PDFURL,eventid,category,createdby,STATUS) values
                                                ('{$title}','{$imageUrl}','{$pdfUrl}','{$eventId}','{$categoryId}','{$createdById}',0);";
//                echo $sql,'<br>'; exit;
                if ($conn->query($sql) === TRUE) {
                    $doneArray[] = [
                        'title'=>$title,
                        'imageUrl'=>$imageUrl,
                        'pdfUrl'=>$pdfUrl,
                        'eventId'=>$eventId,
                        'categoryId'=>$theme."({$categoryId})",
                        'createdBy'=>$email."({$createdById})"
                    ];
                } else {
                    $failedArray[] = [
                        'title'=>$title,
                        'imageUrl'=>$imageUrl,
                        'pdfUrl'=>$pdfUrl,
                        'eventId'=>$eventId,
                        'categoryId'=>$theme."({$categoryId})",
                        'createdBy'=>$email."({$createdById})"
                    ];
                }
            }
        }
    }
//    else {
//        echo '<div class="alert alert-danger" >'. SimpleXLSX::parseError().'</div>';
//    }

}

?>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Bulk Poster Upload</h3>
                <div class="box-tools pull-right">
                <!-- <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button> -->
                <!-- <button class="btn btn-box-tool" onclick="javascript:location.href='events.php'" data-toggle="tooltip" title="Cancel"><i class="fa fa-times"></i></button> -->
                </div>
            </div>
            <!-- form start -->
            <form enctype="multipart/form-data" method="post" role="form">
                <input type="hidden" id="event_id" name="event_id" value="">
                <div class="form-group">
                    <label for="exampleInputFile">File Upload</label>
                    <input type="file" name="file" id="file" size="150">
                    <p class="help-block">Only Excel/CSV File Import.</p>
                </div>
                <div class="form-group">
                <button type="submit" class="btn btn-primary" name="submit" value="submit">Upload</button>
                </div>
            </form>

            <br>
            <?php
            if ( !empty($doneArray) ) {
            echo '<br><br><h3>Imported Data List</h3>';
            echo '<table border="1" width="100%" cellpadding="3" style="border-collapse: collapse">';
                echo '<tr>';
                    echo "<td>ID</td>";
                    echo "<td>Title</td>";
                    echo "<td>Image</td>";
                    echo "<td>Pdf</td>";
                    echo "<td>EventID</td>";
                    echo "<td>Category</td>";
                    echo "<td>Created</td>";
                    echo '</tr>';
                foreach ($doneArray as $key=>$item) {
                echo '<tr>';
                    echo "<td>".($key+1)."</td>";
                    echo "<td>{$item['title']}</td>";
                    echo "<td>{$item['imageUrl']}</td>";
                    echo "<td>{$item['pdfUrl']}</td>";
                    echo "<td>{$item['eventId']}</td>";
                    echo "<td>{$item['categoryId']}</td>";
                    echo "<td>{$item['createdBy']}</td>";
                    echo '</tr>';
                }
                echo '</table>';
            }

            if ( !empty($failedArray) ) {
            echo '<br><br><h3>Failed Data List</h3>';
            echo '<table border="1" width="100%" cellpadding="3" style="border-collapse: collapse">';
                echo '<tr>';
                    echo "<td>Title</td>";
                    echo "<td>Image</td>";
                    echo "<td>Pdf</td>";
                    echo "<td>EventID</td>";
                    echo "<td>Category</td>";
                    echo "<td>Created</td>";
                    echo '</tr>';
                foreach ($failedArray as $item) {
                echo '<tr>';
                    echo "<td>{$item['title']}</td>";
                    echo "<td>{$item['imageUrl']}</td>";
                    echo "<td>{$item['pdfUrl']}</td>";
                    echo "<td>{$item['eventId']}</td>";
                    echo "<td>{$item['categoryId']}</td>";
                    echo "<td>{$item['createdBy']}</td>";
                    echo '</tr>';
                }
                echo '</table>';
            }
            ?>
        </div><!-- /.box -->

    </section><!-- /.content -->
<!-- jQuery 2.1.4 -->
<script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.5 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function(){
        var event_id = $('#ddl_event_top option:selected').val();
        $('#event_id').val(event_id);
        console.log(event_id);
    })
</script>
<?php include('inc/footer.php');?>
