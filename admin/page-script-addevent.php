<?php 
    if(basename($_SERVER['PHP_SELF'])=='addevent.php'){ ?>
        <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- Select2 -->
    <script src="plugins/select2/select2.full.min.js"></script>
    <!-- InputMask -->
    <script src="plugins/input-mask/jquery.inputmask.js"></script>
    <script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <!-- date-range-picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
    <!-- bootstrap time picker -->
    <script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>


    <!-- Page script -->
  <!-- handlebars -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.5/handlebars.js"></script>
   
  <!-- ACE editor -->
  <script src="alpaca/ace.js" type="text/javascript" charset="utf-8"></script>

  
        <!-- jQuery UI for draggable support -->
        <script src="alpaca/jquery-ui.js" type="text/javascript" charset="utf-8"></script>

  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/alpaca@1.5.27/dist/alpaca/bootstrap/alpaca.min.js"></script>

<script type="text/javascript" src="alpaca/form-builder.js"></script>
    <script>
      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2();

        //Datemask dd/mm/yyyy
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
        //Datemask2 mm/dd/yyyy
        $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
        //Money Euro
        $("[data-mask]").inputmask();

        //Date range picker
        $('#reservation').daterangepicker();
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
              ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
              },
              startDate: moment().subtract(29, 'days'),
              endDate: moment()
            },
        function (start, end) {
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        );

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
          checkboxClass: 'icheckbox_minimal-red',
          radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_flat-green'
        });

        //Colorpicker
        $(".my-colorpicker1").colorpicker();
        //color picker with addon
        $(".my-colorpicker2").colorpicker();

        //Timepicker
        $(".timepicker").timepicker({
          showInputs: false
        });
      });


      function addDate(obj){
        var _date='<input type="date" class="form-control" name="txt_edatetime[]" placeholder="Enter event datetime">';
        $(obj).prev().append(_date);
      }

      function enableURLField(obj){    
          $('#txt_webinarurl').attr('disabled',!$(obj)[0].checked);        
      }
      function enableHallField(obj){    
          $('#ddlNoOfHalls').attr('disabled',!$(obj)[0].checked);        
      }
      function enableSponsorField(obj){    
          $('#ddlNoOfSponsors').attr('disabled',!$(obj)[0].checked);        
      }      
      
      function addSponsorImage(obj){
        var textbox='<input type="file" class="form-control" name="txt_sponsorImage[]" placeholder="Select Sponsor Logo">';
        var noOfSponsors=$(obj).val();

        if(noOfSponsors>$('#divSponsorImage').find('input').length){
          noOfSponsors=noOfSponsors-$('#divSponsorImage').find('input').length;
          for(i=0;i<noOfSponsors;i++){
            $('#divSponsorImage').append(textbox);
          }     
          $('#divSponsorImage').find('input').focus(function(){
            $(this).css('border','');
            $(this).css('background','');
          });   
        }
        else if(noOfSponsors<$('#divSponsorImage').find('input').length){
          noOfSponsors=$('#divSponsorImage').find('input').length-noOfSponsors;        
          for(i=0;i<noOfSponsors;i++){
            _text=$('#divSponsorImage').find('input').last().val();
            if(_text.trim().length<=0){
              $('#divSponsorImage').find('input').last().remove();
            }else{              
              $('#divSponsorImage').find('input').last().css('border','1px solid #ff0000');
              $('#divSponsorImage').find('input').last().css('background','#ffebf6');
              $(obj).val(0);
              alert('Field is not empty');
              return;
            }
          }
        }
      }
      function addHallURL(obj){
        var textbox='<strong>Session {0}</strong><input type="text" class="form-control" name="txt_hallUrl[]" placeholder="Enter video url">';
        var noOfHalls=$(obj).val();

        if(noOfHalls>$('#divHallURL').find('input').length){
          noOfHalls=noOfHalls-$('#divHallURL').find('input').length;
          for(i=0;i<noOfHalls;i++){
            _textbox=textbox.replace("{0}",$('#divHallURL').find('input').length+1);
            $('#divHallURL').append(_textbox);
          }     
          $('#divHallURL').find('input').focus(function(){
            $(this).css('border','');
            $(this).css('background','');
          });   
        }
        else if(noOfHalls<$('#divHallURL').find('input').length){
          noOfHalls=$('#divHallURL').find('input').length-noOfHalls;        
          for(i=0;i<noOfHalls;i++){
            _text=$('#divHallURL').find('input').last().val();
            if(_text.trim().length<=0){
              $('#divHallURL').find('strong').last().remove();
              $('#divHallURL').find('input').last().remove();
            }else{              
              $('#divHallURL').find('input').last().css('border','1px solid #ff0000');
              $('#divHallURL').find('input').last().css('background','#ffebf6');
              $(obj).val(0);
              alert('Field is not empty');
              return;
            }
          }
        }
      }

     
    </script>
<?php }?>