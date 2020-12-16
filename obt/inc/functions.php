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

    function get_all_categories($where=''){
        global $conn;
        $_where='';
        if($where!='')
        {
            $_where="where $where ";
        }
        $qry="select *,(select catname from tbl_categories where catid=c.parentid) 'parent_cat',case when status=1 then 'Active' else 'In Active' end 'statusname' from tbl_categories c $_where order by catid asc,parentid asc";
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
        $deletelink=$deletelink.'?type=del&id='.$id;

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
    
    function get_all_events($where=''){
        global $conn;
        $_where='';
        if($where!='')
        {
            $_where="where $where ";
        }
        $qry="select * ,case when status=1 then 'Active' else 'In Active' end 'statusname' from tbl_events c $_where order by eventid desc";
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
        $qry="select * ,case when status=1 then 'Active' else 'In Active' end 'statusname' from tbl_biographies c $_where order by id desc";
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
        $qry="select * ,case when status=1 then 'Active' else 'In Active' end 'statusname' from tbl_exhibitor c $_where order by id asc";
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
        $qry="SELECT * FROM `tbl_eventsnew`  $_where order by 1 desc";
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


    function get_all_attendees($where='',$limit){
        global $conn;
        $_where='';
        if($where!='')
        {
            $_where=" and $where ";
        }
        
        if($limit!='')
        {
            $limit=" Limit $limit ";
        }
        
        $qry="select p.* from tbl_users U inner join tbl_profile p on p.userid=U.userid  where roleid=5 $_where $limit";
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


    function get_all_attendees2($where=''){
        global $conn;
        $_where='';
        if($where!='')
        {
            $_where=" $where ";
        }
        $qry="select * from tbl_users U inner join tbl_profile p on p.userid=U.userid inner join tbl_register r on r.userid=U.userid where fieldname <>'orbit_password' and roleid=5 and  $_where order by 1 desc";
        // $qry="select * from tbl_users U inner join tbl_profile p on p.userid=U.userid inner join tbl_register r on r.userid=U.userid where roleid=5 and  $_where order by 1 desc";
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

    function get_all_loggedin_users($where=''){
        global $conn;
        $_where='';
        if($where!='')
        {
            $_where=" and $where ";
        }
         $qry="select distinct * from tbl_users U inner join tbl_profile p on p.userid=U.userid  inner join tbl_loggedin_user tlu on tlu.userid=U.userid  where roleid=5 $_where order by 1 desc";
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
    function get_all_messages($where='')
    {
        global $conn;
        $_where='';
        if($where!='')
        {
            $_where="where $where ";
        }
        $qry="select * from tbl_messages $_where order by 1 asc";
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

    function get_homepage_banners()
    {
        global $conn;
        $qry="select * from tbl_homebanners order by 1 asc";
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
        
       $qry="select * from tbl_poster $_where order by 1 asc";
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
    function get_all_agendas($where=''){
        global $conn;
        $_where='';
        if($where!='')
        {
            $_where="where $where ";
        }
        
       $qry="select * from tbl_agenda $_where order by aday asc";
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
    function get_all_agendadetails($where=''){
        global $conn;
        $_where='';
        if($where!='')
        {
            $_where="where $where ";
        }
        
        $qry="select * from tbl_agenda_detail $_where order by atime asc";
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

    function get_eventdata($where=''){
        global $conn;
        $_where='';
        if($where!='')
        {
            $_where="where $where ";
        }
       $qry="SELECT * FROM `tbl_eventsnew`  $_where order by 1 desc";
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
    
    function get_new_formid()
    {
        global $conn;
        $qry="select IFNULL(sum(token),0)+1 'formid' from (SELECT IFNULL(count(distinct form_token),0) 'token',userid FROM `tbl_register` group by userid) as t";
        $result = mysqli_query($conn, $qry);

        $categories =array();
        if (mysqli_num_rows($result) > 0) {            
            while($row = mysqli_fetch_assoc($result)) {                 
                $category=$row;
                array_push($categories,$category);
            }
        }
        return $categories[0]['formid'];    
    }



    function get_sponsor_logo($where=''){
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

    function get_hall_url($where=''){
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
    
    function get_event_dates($where=''){
        global $conn;
        $_where='';
        if($where!='')
        {
            $_where="where $where ";
        }
       $qry="SELECT * FROM `tbl_eventdates`  $_where order by edate desc";
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