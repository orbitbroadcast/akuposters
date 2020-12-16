<?php include('inc/header.php');?>
<script src='https://unpkg.com/nprogress@0.2.0/nprogress.js'></script>
<link rel='stylesheet' href='https://unpkg.com/nprogress@0.2.0/nprogress.css'/>
</head>

<body>

<!-- ======= Header ======= -->
<header id="header">
  <div class="container">
    <div id="logo" class="pull-left"> </div>
    <?php include('inc/nav.php');?>
    
    <!-- #nav-menu-container --> 
  </div>
</header>

<!-- End Header --> 

<!-- ======= Attendees Section ======= -->

<div class="container" style="margin-top:150px;">
  <div class="row bootstrap snippets bootdeys">
    <div class="col-md-9 col-sm-7">
      <h2>Attendees</h2>
    </div>
    <div class="col-md-3 col-sm-5">
      <form method="get" role="form" class="search-form-full" onsubmit="return false;">
        <div class="form-group">
          <input type="text" class="form-control" name="s" id="search-input" placeholder="Search...">
          <i class="entypo-search"></i> </div>
      </form>
    </div>
  </div>
  <div id="attendee"> 
    <!--<img src="ajax-loader.gif" />--> 
    
  </div>
  <div class="form">
    <button type="button" id="btn_load_more" name="btn_load_more" style="display:none">LOAD MORE</button>
  </div>
</div>

<!-- End Attendees Section --> 

<script>
$(document).ready(function(){
    
    load_attendees(function(){
        NProgress.done();
        $('#btn_load_more').fadeIn();
    });
        
    $('#search-input').on('keyup',function(e) {
        if(e.which==13){
        txt=$('#search-input').val();
            search_attendee(txt);
        }else if(e.which==8){
             load_attendees(function(){NProgress.done();});
        }
    });
    
    $('#btn_load_more').click(function(){
        load_more_attendees(function(){
            NProgress.done();
        });
    });
});
function load_attendees(callback){
    NProgress.start();
    var total_attendees=$('.member-entry').length;
    total_attendees=total_attendees+10
    start_cnt=0;
    $.ajax({
            url:'https://rspvirtualmeet.com/obt/attendee_ajax.php?action=fetchall&start='+start_cnt+'&cnt='+total_attendees,
            type:'GET',
            async:true,
            success:function(res){
                $('#attendee').append(res);
                callback();
            }
        }); 
}

function load_more_attendees(callback){
    var total_attendees=10;
    var start_cnt=$('.member-entry').length;
  
    
    $.ajax({
            url:'https://rspvirtualmeet.com/obt/attendee_ajax.php?action=fetchall&start='+start_cnt+'&cnt='+total_attendees,
            type:'GET',
            async:true,
            success:function(res){
                $('#attendee').append(res);
                callback();
            }
        }); 
}


function search_attendee(txt){
    NProgress.start();
      $.ajax({
            url:'https://rspvirtualmeet.com/obt/attendee_ajax.php?action=search&txt='+txt,
            type:'GET',
            async:true,
            success:function(res){
                $('#attendee').empty();
                $('#attendee').append(res);
                NProgress.done();
            }
        }); 
}
</script> 

<?php include('inc/footer.php');?>