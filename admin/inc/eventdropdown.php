<?php
    $createdby=$_SESSION['userdata']['userid'];

    if($_SESSION['userdata']['roleid']==1){
        $qry="select * from tbl_eventsnew";
    }else{
         $qry="select * from tbl_eventsnew where id in (select eventid from tbl_user_event where userid=$createdby)";
    }
    $result = mysqli_query($conn, $qry);

    $categories =array();
    if (mysqli_num_rows($result) > 0) {            
        while($row = mysqli_fetch_assoc($result)) {                 
            $category=$row;
            array_push($categories,$category);
        }
    }

    $disabled='';
    if(basename($_SERVER['PHP_SELF'])=='addevent.php'){
        $disabled='disabled';
    }

    $selected=(isset($_SESSION['selected_event_id']) && $_SESSION['selected_event_id']>0)?$_SESSION['selected_event_id']:0;
?>
<select onchange="selectTopEvent(this)" class="form-control select2" style="width: 100%;" id="ddl_event_top" name="ddl_event_top" <?=$disabled?>> 

<option <?=($selected==0)?'selected':''?> value="0">No event selected</option>
<?php    
    for($i=0;$i<sizeof($categories);$i++){
        if($categories[$i]['status']==1){            
            ?>
                <option <?=($selected==$categories[$i]['id'])?'selected':''?> value="<?=$categories[$i]['id']?>"><?=$categories[$i]['etitle']?></option>
            <?php
        }
    }


    
?>
</select>