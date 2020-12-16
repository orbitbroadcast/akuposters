<?php
    function get_forms($userid){
        global $conn;
        $qry="select u.username,p.firstname,p.lastname,p.email,r.role,f.formname,f.formurl,f.isheader,f.formorder from tbl_users u 
              inner join tbl_profile p on p.userid=u.userid
              inner join tbl_roles r on r.roleid=u.roleid
              inner join tbl_role_description rd on rd.roleid=r.roleid
              inner join tbl_form f on f.formid=rd.formid
              where u.userid=$userid and rd.canview=1 order by f.formorder";
        $result = mysqli_query($conn, $qry);

        $menu =array();
        if (mysqli_num_rows($result) > 0) {            
            $key='';
            while($row = mysqli_fetch_assoc($result)) { 
                $formname=$row['formname'];
                $formurl=$row['formurl'];
                if($row['isheader']==1){
                    $key=$formname;
                    $menu[$key]=array();                    
                }else{
                    array_push($menu[$key],array('formname'=>$formname,
                                                 'formurl'=>$formurl));
                }                
            }
        }
        return $menu;    
    }

    function get_all_categories(){
        global $conn;
        $qry="select *,(select catname from tbl_categories where catid=c.parentid) 'parent_cat',case when status=1 then 'Active' else 'In Active' end 'statusname' from tbl_categories c order by catid asc,parentid asc";
        $result = mysqli_query($conn, $qry);

        $categories =array();
        if (mysqli_num_rows($result) > 0) {            
            while($row = mysqli_fetch_assoc($result)) {                 
                $category=$row;
                array_push($categories,$category);
            }
        }
        return $categories;    
    }

    function get_all_rfqs(){
        global $conn;
        $qry="select *,case when r.status=1 then 'Active' else 'In Active' end 'statusname',u.unit,(select count(*) from tbl_quotes where rfqid=r.rfqid) 'total_quotes'  from tbl_rfqs r inner join tbl_units u on u.unitid=r.unitid order by rfqid desc";
        $result = mysqli_query($conn, $qry);

        $rfqs =array();
        if (mysqli_num_rows($result) > 0) {            
            while($row = mysqli_fetch_assoc($result)) {                 
                $rfq=$row;
                array_push($rfqs,$rfq);
            }
        }
        return $rfqs;    
    }

    function get_all_units(){
        global $conn;
        $qry="select *,case when status=1 then 'Active' else 'In Active' end 'statusname' from tbl_units u order by unitid asc";
        $result = mysqli_query($conn, $qry);

        $units =array();
        if (mysqli_num_rows($result) > 0) {            
            while($row = mysqli_fetch_assoc($result)) {                 
                $unit=$row;
                array_push($units,$unit);
            }
        }
        return $units;    
    }

    function get_all_roles(){
        global $conn;
        $qry="select *,case when status=1 then 'Active' else 'In Active' end 'statusname' from tbl_roles r order by roleid asc";
        $result = mysqli_query($conn, $qry);

        $roles =array();
        if (mysqli_num_rows($result) > 0) {            
            while($row = mysqli_fetch_assoc($result)) {                 
                $role=$row;
                array_push($roles,$role);
            }
        }
        return $roles;    
    }

    function get_all_users(){
        global $conn;
        $qry="select *,(select role from tbl_roles where roleid=u.roleid) 'role',case when status=1 then 'Active' else 'In Active' end 'statusname' from tbl_users u order by userid asc";
        $result = mysqli_query($conn, $qry);

        $users =array();
        if (mysqli_num_rows($result) > 0) {            
            while($row = mysqli_fetch_assoc($result)) {                 
                $user=$row;
                array_push($users,$user);
            }
        }
        return $users;    
    }

    function get_permissions($roleid){
        global $conn;
        $qry="select f.formid,f.formname,rd.roleid,r.role,rd.canadd,rd.canedit,rd.candelete,rd.canview,f.isheader from tbl_roles r 
        inner join tbl_role_description rd on rd.roleid=r.roleid
        inner join tbl_form f on f.formid=rd.formid
        where r.roleid=$roleid
        union all
        select formid,formname,0 as roleid,'' as role,0 as canadd,0 as canedit,0 as candelete,0 as canview,isheader from tbl_form where
        formid not in 
        (
            select f.formid from tbl_roles r 
            inner join tbl_role_description rd on rd.roleid=r.roleid
            inner join tbl_form f on f.formid=rd.formid
            where r.roleid=$roleid
        )
        order by 1";
        $result = mysqli_query($conn, $qry);

        $permissions =array();
        if (mysqli_num_rows($result) > 0) {            
            while($row = mysqli_fetch_assoc($result)) {                 
                $permission=$row;
                array_push($permissions,$permission);
            }
        }
       
        return $permissions;    
    }

    function action_buttons($editlink,$deletelink,$viewlink,$id)
    {
        if($editlink!='')
        $editlink=$editlink.'?type=edit&id='.$id;

        if($deletelink!='')
        $deletelink="javascript:deleteItem('".$deletelink.'?type=del&id='.$id."');";

        if($viewlink!='')
        $viewlink=$viewlink.'?id='.$id;

        $editlink=($editlink=='')?'':'<a href="'.$editlink.'">Edit</a>';
        $deletelink=($deletelink=='')?'':' | <a href="'.$deletelink.'">Delete</a> | ';
        $viewlink=($viewlink=='')?'':'<a href="'.$viewlink.'">View</a>';
        return $editlink.$deletelink.$viewlink;
    }

    function select($qry){        
        global $conn;
        $result = mysqli_query($conn, $qry);
        $records =array();
        if (mysqli_num_rows($result) > 0) {            
            while($row = mysqli_fetch_assoc($result)) {                 
                $record=$row;
                array_push($records,$record);
            }
        }
        return $records;
    }

    function get_all_quotes($where=''){
        global $conn;
        $_where='';
        if($where!='')
        {
            $_where="where $where ";
        }
        $qry="SELECT q.id,q.rfqid,q.remarks,q.cost,q.creationdate,u.userid,p.firstname,p.lastname FROM `tbl_quotes` as q inner join tbl_users as u on u.userid=q.vendorid inner join tbl_profile as p on p.userid=u.userid $_where order by q.creationdate desc";
        $result = mysqli_query($conn, $qry);

        $categories =array();
        if (mysqli_num_rows($result) > 0) {            
            while($row = mysqli_fetch_assoc($result)) {                 
                $category=$row;
                array_push($categories,$category);
            }
        }
        return $categories;    
    }
    
    function get_all_events(){
        global $conn;
        $qry="select * ,case when status=1 then 'Active' else 'In Active' end 'statusname' from tbl_eventsnew c order by id desc";
        $result = mysqli_query($conn, $qry);

        $categories =array();
        if (mysqli_num_rows($result) > 0) {            
            while($row = mysqli_fetch_assoc($result)) {                 
                $category=$row;
                array_push($categories,$category);
            }
        }
        return $categories;    
    }

    function get_all_helpdesks(){
        global $conn;
        $qry="select *  from tbl_helpdesk c order by id desc";
        $result = mysqli_query($conn, $qry);

        $categories =array();
        if (mysqli_num_rows($result) > 0) {            
            while($row = mysqli_fetch_assoc($result)) {                 
                $category=$row;
                array_push($categories,$category);
            }
        }
        return $categories;    
    }

    function get_all_regforms($where=''){
        global $conn;
        $_where='';
        if($where!='')
        {
            $_where="where $where ";
        }
        $qry="SELECT * FROM `tbl_events`  $_where order by 1 desc";
        $result = mysqli_query($conn, $qry);

        $categories =array();
        if (mysqli_num_rows($result) > 0) {            
            while($row = mysqli_fetch_assoc($result)) {                 
                $category=$row;
                array_push($categories,$category);
            }
        }
        return $categories;    
    }

    function get_all_biographies($where=''){
        global $conn;
        $_where='';
        if($where!='')
        {
            $_where="where $where ";
        }
        $qry="SELECT *,case when status=1 then 'Active' else 'In Active' end 'statusname' FROM `tbl_biographies`  $_where order by 1 desc";
        $result = mysqli_query($conn, $qry);

        $categories =array();
        if (mysqli_num_rows($result) > 0) {            
            while($row = mysqli_fetch_assoc($result)) {                 
                $category=$row;
                array_push($categories,$category);
            }
        }
        return $categories;    
    }
    
    function get_all_posters($where=''){
        global $conn;
        $_where='';
        if($where!='')
        {
            $_where="where $where ";
        }
        $qry="SELECT *,case when status=1 then 'Active' else 'In Active' end 'statusname' FROM `tbl_poster`  $_where order by 1 desc";
        $result = mysqli_query($conn, $qry);

        $categories =array();
        if (mysqli_num_rows($result) > 0) {            
            while($row = mysqli_fetch_assoc($result)) {                 
                $category=$row;
                array_push($categories,$category);
            }
        }
        return $categories;    
    }

    function get_row_count($table){
        global $conn;
        $_where='';
        if($where!='')
        {
            $_where="where $where ";
        }
        $qry="SELECT count(*) from $table";
        $result = mysqli_query($conn, $qry);

        $categories =array();
        if (mysqli_num_rows($result) > 0) {            
            while($row = mysqli_fetch_assoc($result)) {                 
                $category=$row;
                array_push($categories,$category);
            }
        }
        return $categories[0];    
    }


    function get_all_agendas($where=''){
        global $conn;
        $_where='';
        if($where!='')
        {
            $_where="where $where ";
        }
       $qry="SELECT a.*,case when a.status=1 then 'Active' else 'In Active' end 'statusname',e.etitle 'event' FROM `tbl_agenda` a  inner join tbl_eventsnew e on e.id=a.eventid $_where order by 1 desc";
        $result = mysqli_query($conn, $qry);

        $categories =array();
        if (mysqli_num_rows($result) > 0) {            
            while($row = mysqli_fetch_assoc($result)) {                 
                $category=$row;
                array_push($categories,$category);
            }
        }
        return $categories;    
    }

    function get_all_agenda_details($where=''){
        global $conn;
        $_where='';
        if($where!='')
        {
            $_where="where $where ";
        }
        $qry="SELECT * FROM `tbl_agenda_detail`  $_where order by 1 desc";
        $result = mysqli_query($conn, $qry);

        $categories =array();
        if (mysqli_num_rows($result) > 0) {            
            while($row = mysqli_fetch_assoc($result)) {                 
                $category=$row;
                array_push($categories,$category);
            }
        }
        return $categories;    
    }

    function get_page_name($where=''){
        global $conn;
        $_where='';
        if($where!='')
        {
            $_where="where $where ";
        }
        $qry="SELECT * FROM `tbl_form`  $_where order by 1 desc";
        $result = mysqli_query($conn, $qry);

        $categories =array();
        if (mysqli_num_rows($result) > 0) {            
            while($row = mysqli_fetch_assoc($result)) {                 
                $category=$row;
                array_push($categories,$category);
            }
        }
        return $categories;    
    }

    function get_event_dates($where=''){
        global $conn;
        $_where='';
        if($where!='')
        {
            $_where="where $where ";
        }
        $qry="SELECT * FROM `tbl_eventdates`  $_where order by 1 desc";
        $result = mysqli_query($conn, $qry);

        $categories =array();
        if (mysqli_num_rows($result) > 0) {            
            while($row = mysqli_fetch_assoc($result)) {                 
                $category=$row;
                array_push($categories,$category);
            }
        }
        return $categories;    
    }
    
    function get_event_halls($where=''){
        global $conn;
        $_where='';
        if($where!='')
        {
            $_where="where $where ";
        }
        $qry="SELECT * FROM `tbl_eventhalls`  $_where order by 1 desc";
        $result = mysqli_query($conn, $qry);

        $categories =array();
        if (mysqli_num_rows($result) > 0) {            
            while($row = mysqli_fetch_assoc($result)) {                 
                $category=$row;
                array_push($categories,$category);
            }
        }
        return $categories;    
    }


    function get_event_sponsors($where=''){
        global $conn;
        $_where='';
        if($where!='')
        {
            $_where="where $where ";
        }
        $qry="SELECT * FROM `tbl_eventsponsors`  $_where order by 1 desc";
        $result = mysqli_query($conn, $qry);

        $categories =array();
        if (mysqli_num_rows($result) > 0) {            
            while($row = mysqli_fetch_assoc($result)) {                 
                $category=$row;
                array_push($categories,$category);
            }
        }
        return $categories;    
    }

    function get_all_exhibitors($where=''){
        global $conn;
        $_where='';
        if($where!='')
        {
            $_where="where $where ";
        }
        $qry="SELECT *,case when status=1 then 'Active' else 'In Active' end 'statusname' FROM `tbl_exhibitor`  $_where order by 1 desc";
        $result = mysqli_query($conn, $qry);

        $categories =array();
        if (mysqli_num_rows($result) > 0) {            
            while($row = mysqli_fetch_assoc($result)) {                 
                $category=$row;
                array_push($categories,$category);
            }
        }
        return $categories;    
    }
?>