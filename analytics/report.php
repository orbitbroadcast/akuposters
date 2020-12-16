<?php
/****************************************/
/*Author:Zia Haider                     */
/*Date:20th Nov, 2020 01:30 AM          */
/****************************************/


include('../obt/inc/top.php');

$results=select("SELECT a.id,u.username,a.loggedin,a.loggedout,a.page,a.pagein,a.pageout,a.ip,a.eventid,r.role,e.etitle FROM `tbl_analytics` a 
inner join tbl_users u on u.userid=a.userid
inner join tbl_roles r on r.roleid=u.roleid
inner join tbl_eventsnew e on e.id=a.eventid limit 0,10");

?>
<style>
    table{border:1px solid #000;}
    table td{border:1px solid #000;}
</style>
<h1>Raw data</h1>
<table >
<tr>
    <th>ID</th>
    <th>Role</th>
    <th>Username</th>
    <th>LoggedIn</th>
    <th>LoggedOut</th>
    <th>Page</th>
    <th>PageIn</th>
    <th>PageOut</th>
    <th>IP</th>
    <th>EventID</th>
</tr>
<?php
for($i=0;$i<sizeof($results);$i++){
    ?>
    <tr>
    <td><?=$results[$i]['id']?></th>
    <td><?=$results[$i]['role']?></th>
    <td><?=$results[$i]['username']?></th>
    <td><?=$results[$i]['loggedin']?></th>
    <td><?=$results[$i]['loggedout']?></th>
    <td><?=$results[$i]['page']?></th>
    <td><?=$results[$i]['pagein']?></th>
    <td><?=$results[$i]['pageout']?></th>
    <td><?=$results[$i]['ip']?></th>
    <td><?=$results[$i]['etitle']?></th>
</tr>
    <?php
}

?>
</table>

<h1>Duration </h1>
<?php
    $results=select("select u.username,page,min(pagein) pdate1,max(pageout) pdate2,count(pagein) totalhits from tbl_analytics a inner join tbl_users u on u.userid=a.userid group by u.username,page limit 0,10");
?>
<table >
<tr>
    <th>Username</th>
    <th>Page</th>
    <th>PageIn</th>
    <th>PageOut</th>
    <th>TotalPageHits</th>
</tr>
<?php
for($i=0;$i<sizeof($results);$i++){
    ?>
    <tr>
    <td><?=$results[$i]['username']?> | <?=$results[$i]['username']?></th>
    <td><?=$results[$i]['page']?></th>
    <td><?=$results[$i]['pdate1']?></th>
    <td><?=$results[$i]['pdate2']?></th>
    <td><?=$results[$i]['totalhits']?></th>
</tr>
    <?php
}

?>



</table>
<h1>Total Page Hits</h1>
<?php 
    $results=select("SELECT page,count(*) 'total' FROM `tbl_analytics` GROUP by page order by page");
    print_r($results);
?>
<table>
<tr>
    <th>Page</th>
    <th>Total Hits</th>
</tr>
<?php 
    for($i=0;$i<sizeof($results);$i++){
?>
<tr>
    <td><?=$results['page']?></td>
    <td><?=$results['total']?></td>
</tr>
<?php
}
?>

</table>