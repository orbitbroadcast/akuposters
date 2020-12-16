</div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.0.0
        </div>
        <!--<strong>Copyright &copy; <?=date("Y")?> <a href="http://murtajis.com/">Murtajis</a>.</strong> All rights reserved.-->
      </footer>

      <!-- Control Sidebar -->
      
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->    
    <?php include('page-script-dashboard.php'); ?>
    <?php include('page-script-addcategory.php');?>
    <?php include('page-script-categories.php');?>
    <?php include('page-script-addrfq.php');?>
    <?php include('page-script-rfqs.php');?>
    <?php include('page-script-addrole.php');?>
    <?php include('page-script-roles.php');?>
    <?php include('page-script-adduser.php');?>
    <?php include('page-script-users.php');?>
    <?php include('page-script-permissions.php');?>
    <?php include('page-script-addevent1.php');?>
    <?php include('page-script-events.php');?>
    <?php include('page-script-addbiography.php');?>
    <?php include('page-script-biographies.php');?>
    <?php include('page-script-helpdesk.php');?>
    <?php include('page-script-addexhibitor.php');?>
    <?php include('page-script-exhibitors.php');?>
    <?php include('page-script-addposter.php');?>
    <?php include('page-script-posters.php');?>
    <?php include('page-script-addagenda.php');?>
    <?php include('page-script-agendas.php');?>
    <?php include('page-script-addHomebanners.php');?>    
    <?php include('page-script-agendaticker.php');?>    
    <?php include('page-script-addtemplate.php');?>
    <?php include('page-script-templates.php');?>
    <?php include('page-script-email.php');?>
    <?php include('page-script-listexhibitors.php');?>
    <?php include('page-script-welcome.php');?>
    <script src="vcsadmin.js"></script>
    <script src="../analytics/analytics.js"></script>
     <script>
        var pagename='<?=basename($_SERVER['PHP_SELF'])?>';
        if(pagename!='dashboard.php' && pagename!='welcome.php') 
        {
          setActiveMenu('<?=isset(get_page_name("formurl='".basename($_SERVER['PHP_SELF'])."'")[0]['formname'])?get_page_name("formurl='".basename($_SERVER['PHP_SELF'])."'")[0]['formname']:'';?>');
        }
        
    </script>
    
  </body>
</html>
