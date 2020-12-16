function setActiveMenu(_menu){
    $('.sidebar-menu').find('li').each(function(){
        if($(this).text()==_menu){
            $(this).parents('.treeview').addClass('active');
            $(this).parents('.treeview-menu').addClass('menu-open');
            $(this).parents('.treeview-menu').css('display','block');
            $(this).addClass('active');
        }
    });
  }

  

  function deleteItem(item){
      if(confirm('Are you sure, you want to delete this item?')){
          location.href=item;
      }
  }

  function selectTopEvent(obj){
      top_event_id=$(obj).val();
      $.ajax({
          type:'POST',
          url:'ajax.php',
          data:'action=setevent&eventid='+top_event_id,
          success:function(res){
              if(res!="Please login first"){
                $('#hdn_event_top').val(res);
                location.reload();
              }            
          }
      });      
  }

  function change_status(page,id,v){
    $.ajax({
        type:'POST',
        url:'ajax.php',
        data:'action=setstatus&p='+page+'&id='+id+'&v='+v,
        success:function(res){
            if(res!="Please login first"){
              alert(res);
              location.reload();       
            }            
        }
    });   
  }

  function change_role(obj){
    if($(obj).val()==2)
    {
        $('#event_div').show();
    }    
    else
    {
        $('#event_div').hide();
    }
    
    if($(obj).val()==2 || $(obj).val()==1)
    {
        $('#appr_div').show();
    }    
    else
    {
        $('#appr_div').hide();
    }
    
}

       
        
  function turnEventOnOff(obj){
      eid=$(obj).val();
      turn='0';
      if(eid<=0){
          turn='0';
      }else{
          turn='1';
      }
      eid=Math.abs(eid);
       $.ajax({
          type:'POST',
          url:'ajax.php',
          data:'action=onoffevent&eventid='+eid+'&turn='+turn,
          success:function(res){
              if(res!="Please login first"){
               alert(res);
              }            
          }
      });      
  }

function selectTemplate(obj){
      templateid=$(obj).val();
      $.ajax({
          type:'POST',
          url:'ajax.php',
          data:'action=loadtemplate&templateid='+templateid,
          success:function(res){
              if(res!="Please login first"){
                $('#txt_title').val(res[0].title);
                $('#txt_content').text(res[0].content);
              }            
          }
      });      
  }
  
  
  function posterApproveReject(obj){
      button=obj;
      pid=$(obj).attr('data-id');
      turn=$(obj).attr('value');

       $.ajax({
          type:'POST',
          url:'ajax.php',
          data:'action=aprjposter&id='+pid+'&turn='+turn,
          success:function(res){
              if(res!="Please login first"){
               alert(res);
               $(button).parent().find('button').removeClass('active');
               $(button).addClass('active');
               $(button).blur();
              }            
          }
      });      
  }
  
  
  
  
  function bulkselect(obj){
    
    $('[name=chk_all]').each(function(){
        $(this)[0].checked=obj.checked;
    });
    if(obj.checked){
        $('#sp_chk_all').find('a').text('Uncheck All');
      }
      else
      {
        $('#sp_chk_all').find('a').text('Check All');
      }
  }
  
  
  function bulkselect_link(obj){
      
      chk=$('[name=chk_all]:eq(0)')[0];
      chk.checked=!chk.checked;
      if(chk.checked){
        $(obj).find('a').text('Uncheck All');
      }
      else
      {
        $(obj).find('a').text('Check All');
      }
      bulkselect(chk);
  }
  
  function bulk_operations(obj){
      val=$(obj).val();
      text=obj[obj.selectedIndex].text;
      isSuccess=false;
      if($('[name=chk_all]:checked').length<=0){
          alert('Please select item(s) to '+text);
      }else{
          
          if(val==1 || val==2){
              cntr=0;
              ids="";
              vs="";
              $('[name=chk_all]:checked').each(function(){
                 id=$(this).val();
                 v=(val==1)?1:0;
                 
                 ids+=id+"|";
                 vs+=v+"|";
              });
              
              ids=ids.substring(0,ids.length-1);
              vs=vs.substring(0,vs.length-1);
              $.ajax({
                    type:'POST',
                    url:'ajax.php',
                    data:'action=setstatus&p=poster&id='+ids+'&v='+vs,
                    success:function(res){
                        if(res!="Please login first"){
                         // alert(res);
                         items=$('[name=chk_all]:checked').length;
                         alert(items+" item(s) updated successfully!");
                        }            
                    }
                }); 
          }
          else if(val==4 || val==5 || val==6){
              if(val==4) btnid=0;
              else if(val==5) btnid=1;
              else if(val==6) btnid=2;
              pids="";
              turns="";
              $('[name=chk_all]:checked').each(function(){
                  id=$(this).val();
                  button=$('.btn-group-vertical').find('[data-id='+id+']')[btnid];
                  pid=$(button).attr('data-id');
                  turn=$(button).attr('value');
                  
                  pids+=pid+"|";
                  turns+=turn+"|";
                  
                  $(button).parent().find('button').removeClass('active');
                  $(button).addClass('active');
                  $(button).blur();
              });
              
              pids=pids.substring(0,pids.length-1);
              turns=turns.substring(0,turns.length-1);
        
               $.ajax({
                  type:'POST',
                  url:'ajax.php',
                  data:'action=aprjposter&id='+pids+'&turn='+turns,
                  success:function(res){
                      if(res!="Please login first"){
                       //alert(res);
                        items=$('[name=chk_all]:checked').length;
                        alert(items+" item(s) updated successfully!");
                      }            
                  }
              });      
          }
      }
  }
  