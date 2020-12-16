<?php 
    if(basename($_SERVER['PHP_SELF'])=='helpdesk.php'){ ?>
    
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
       
        <!-- DataTables -->
        <script src="plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
        <!-- SlimScroll -->
        <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="plugins/fastclick/fastclick.min.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/app.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="dist/js/demo.js"></script>
        <!-- page script -->
        
        


<script type="text/javascript">
  

  $(document).ready(function(){
    fetch_user();
    setInterval(function(){
      update_last_activity();
      fetch_user();
      update_chat_history_data();
    },5000);

    function fetch_user() {
      $.ajax({
        url:"../chat_app/fetch_user.php",
        type: "POST",
        success:function(data){
          $('#user_details').html(data);
        }
      });
    }

    function update_last_activity() {
      $.ajax({
        url:"../chat_app/update_last_activity.php",
        success:function(){
          
        }
      });
    }

    function make_chat_dialog_box(to_user_id,to_user_name){
      var model_conetnt = '<div id="user_dialog_'+to_user_id+'" class="user_dialog" title="You have chat with '+to_user_name+'">';

      model_conetnt+='<div style="height:350px;border:1px solid #cccccc;overflow-y:scroll;margin-bottom:24px;padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
      model_conetnt+=fetch_user_chat_history(to_user_id);
      model_conetnt+='</div>';
      model_conetnt+='<div class="form-group">';
      model_conetnt+='<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control"></textarea>';
      model_conetnt+='</div><div class="form-group" align="right">';
      model_conetnt+='<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat">Send</button></div></div>';
      $('#user_model_details').html(model_conetnt);
    }

    $(document).on('click','#start_chat',function(){
      //alert("test");
      var to_user_id = $(this).data('touserid');
      var to_user_name = $(this).data('tousername');
      make_chat_dialog_box(to_user_id,to_user_name);
      $('#user_dialog_'+to_user_id).dialog({
        autoOpen:false,
        width:400
      });
      $('#user_dialog_'+to_user_id).dialog('open');
    });

    
    $(document).on('click','.send_chat',function(){
      var to_user_id = $(this).attr('id');
      var chat_message = $('#chat_message_'+to_user_id).val();
      $.ajax({
        url:"../chat_app/insert_chat.php",
        type: "POST",
        data:{to_user_id:to_user_id,chat_message:chat_message},
        success:function(data){
          $('#chat_message_'+to_user_id).val('');
          $('#chat_history_'+to_user_id).html(data);
        }
      });
    });

    function fetch_user_chat_history(to_user_id)
     {
      $.ajax({
       url:"../chat_app/fetch_user_chat_history.php",
       method:"POST",
       data:{to_user_id:to_user_id},
       success:function(data){
        $('#chat_history_'+to_user_id).html(data);
       }
      });
     }

     function update_chat_history_data() {
      $('.chat_history').each(function(){
       var to_user_id = $(this).data('touserid');
       fetch_user_chat_history(to_user_id);
      });
     }
  });

</script>
        
        
        <script>
        $(function () {
            //$("#example1").DataTable();
            $('#example1').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": true,
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                    {
                        extend: 'excelHtml5',
                        title: 'helpdesk',
                        messageTop: 'Help desk',
                        oSelectorOpts: { "filter": "applied" },
                        exportOptions: {
                            columns: ':visible'
                        }
                    },,
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
            });
        });
        </script>
<?php }?>