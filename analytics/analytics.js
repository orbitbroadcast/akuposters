/****************************************/
/*Author:Zia Haider                     */
/*Date:19th Nov, 2020 11:40 PM          */
/****************************************/
(function(JQ){
    var ajaxUrl="../analytics/analytics.php";        
    var pages=[];
    pages['https://rspvirtualmeet.com/obt/agenda.php']='Agenda';
    pages['https://rspvirtualmeet.com/obt/agenda2.php']='Agenda';
    pages['https://rspvirtualmeet.com/obt/attendees.php']='Attendees';
    pages['https://rspvirtualmeet.com/obt/biographies.php']='Biographies';
    pages['https://rspvirtualmeet.com/obt/exhibitors.php']='Exhibitors';
    pages['https://rspvirtualmeet.com/obt/help-desk.php']='Help Desk';
    pages['https://rspvirtualmeet.com/obt/index.php']='Main Page';
    pages['https://rspvirtualmeet.com/obt/main-plenary.php']='Main Plenary';
    pages['https://rspvirtualmeet.com/obt/networking.php']='Networking';
    pages['https://rspvirtualmeet.com/obt/poster-chest.php']='Poster Chest';
    pages['https://rspvirtualmeet.com/obt/poster-git.php']='Poster git';
    pages['https://rspvirtualmeet.com/obt/poster-msk.php']='Poster Msk';
    pages['https://rspvirtualmeet.com/obt/poster.php']='Posters';
    pages['https://rspvirtualmeet.com/obt/stall1.php']='Platinum - HIMMEL';
    pages['https://rspvirtualmeet.com/obt/stall2.php']='Gold - Canon';
    pages['https://rspvirtualmeet.com/obt/stall3.php']='Gold - Guerbet';
    pages['https://rspvirtualmeet.com/obt/stall4.php']='Gold - GE Healthcare';
    pages['https://rspvirtualmeet.com/obt/stall5.php']='Silver - Graton';
    pages['https://rspvirtualmeet.com/obt/stall6.php']='Basic - FujiFilm';
    pages['https://rspvirtualmeet.com/obt/stall7.php']='Gold - Mindray';
    pages['https://rspvirtualmeet.com/obt/stall8.php']='Societies - BIRSP';
    pages['https://rspvirtualmeet.com/obt/stall9.php']='Societies - BRSP';
    pages['https://rspvirtualmeet.com/obt/stall10.php']='Societies - IRSP';
    pages['https://rspvirtualmeet.com/obt/stall11.php']='Societies - NRSP';
    pages['https://rspvirtualmeet.com/obt/stall12.php']='Societies - PRSP';
    pages['https://rspvirtualmeet.com/obt/stall13.php']='Societies - ROS';
    pages['https://rspvirtualmeet.com/obt/stall14.php']='Societies - AGFA';
    pages['https://rspvirtualmeet.com/obt/stall15.php']='Societies - NMS';
    pages['https://rspvirtualmeet.com/obt/session.php']='Session';
    
    function request(url,rtype,data,callback){
        var _data=data;
        if(rtype.toLowerCase()=='get'){
            _data="?"+data;
        }else{
            _data="?"+data;
        }

        $.ajax({
            url:url+_data,
            type:rtype,
            data:_data,
            async:true,
            success:function(res){
                callback(res);
            }
        });
    }


    function init(){
        request(ajaxUrl,"GET","action=init",function(res){
            alert(res);
        });
    }

    function track_footprint(val){
        pagename=window.location.href;
        ispagein=val;        
        var d = new Date();
        var datetime = d.toMysqlFormat();
        console.log('AjaxURL:'+ajaxUrl,'ispagein:'+ispagein,'datetime:'+datetime);
        request(ajaxUrl,"POST","action=track&pagename="+pagename+"&ispagein="+ispagein+"&timestamp="+datetime,function(res){
            //console.log(res);
        });
    }
    function twoDigits(d) {
        if(0 <= d && d < 10) return "0" + d.toString();
        if(-10 < d && d < 0) return "-0" + (-1*d).toString();
        return d.toString();
    }
    Date.prototype.toMysqlFormat = function() {
        return this.getFullYear() + "-" + twoDigits(1 + this.getMonth()) + "-" + twoDigits(this.getDate()) + " " + twoDigits(this.getHours()) + ":" + twoDigits(this.getMinutes()) + ":" + twoDigits(this.getSeconds());
    };
    Date.prototype.getTimestamp = function() {
        var year = this.getFullYear(),
            month = this.getMonth(),
            day = this.getDate(),
            hours = this.getHours(),
            minutes = this.getMinutes(),
            seconds = this.getSeconds();
    
        month = month < 10 ? "0" + month : month;
        day = day < 10 ? "0" + day : day;
        hours = hours < 10 ? "0" + hours : hours;
        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds; 
    
        return year + "-" + month + "-" + day + " " + hours + ":" + minutes + ":" + seconds;
    }
    
    function loadUserPageHit(){
        var table='<table cellpadding="0" cellspacing="0">{0}{1}</table>';
        var headings=`<tr>
                        <th>Username</th>
                        <th>Page</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Total Hits</th>
                      </tr>`;
        request(ajaxUrl,"POST","action=userpagehit&id=5&eventid=11",function(res){
            var row='';
            for(a in res){
                pagename='';
                _page=(res[a].page==undefined)?res[a].page:res[a].page.split('?')[0];
                if(pages[_page]){
                    pagename=pages[_page];
                }else{
                    pagename='';
                }
                //console.log(res[a].page);
                from=(res[a].pdate1==null)?'':res[a].pdate1;
                to=(res[a].pdate2==null)?'':res[a].pdate2;
                row+=`<tr>
                <td>`+res[a].username+`</td>
                <td>`+pagename+`</td>
                <td>`+from+`</td>
                <td>`+to+`</td>
                <td>`+res[a].totalhits+`</td>
                </tr>`;
            }
            table=table.replace('{0}',headings);
            table=table.replace('{1}',row);
            $('.user-page-hit').html(table);
        });
    }
    
     function loadTotalUsers(){
        request(ajaxUrl,"POST","action=totalusers&id=5&eventid=11",function(res){
           for(a in res){
               totalusers=res[a].total;
            $('.totalusers').find('#title').html('<strong>Total Users</strong>');
            $('.totalusers').find('#value').html(totalusers);
           }
        });
    }
    
    function loadTotalLoggedInUsers(){
        request(ajaxUrl,"POST","action=totalloggedinusers&id=5&eventid=11",function(res){
           for(a in res){
               totalusers=res[a].total;
            $('.totalloggedinusers').find('#title').html('<strong>Total LoggedIn Users</strong>');
            $('.totalloggedinusers').find('#value').html(totalusers);
           }
        });
    }
    
    var li="";
    var locations=[];
    function requestLocationFromIp(ip,total){
        setTimeout(function(){
            var apiLocation="https://freegeoip.app/json/"+ip;
            
            request(apiLocation,"GET","",function(res){
               img='<img src="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/flags/1x1/'+res.country_code.toLowerCase()+'.svg" style="width:30px;height:15px;"/>';
               li='<tr><td><span>'+img+'</span>'+((res.city=="")?"":res.city+",")+res.country_name+"</td><td>"+total+'</td></tr>';
               $('.ip-location').find('table').append(li);
               
               
               if(locations[res.country_name]){
                   locations[res.country_name]=parseInt(locations[res.country_name])+parseInt(total);
               }else{
                   locations[res.country_name]=total;
               }
            });   
            
        },500);
        
    }
    
    function loadIPData(){
        
        request(ajaxUrl,"POST","action=ip&id=5&eventid=11",function(res){
           for(a in res){
               requestLocationFromIp(res[a].ip,res[a].total);
           }
           
        });
    }
    
    
    JQ(document).ready(function(){        
        page=window.location.pathname;
        if(page!='/admin/dashboard.php'){
            document.body.onload=function(){track_footprint(1);}
            document.body.onblur=function(){track_footprint(0);}       
        }else{
            setInterval(function(){
                
            },30000)
            
            loadUserPageHit();
             loadTotalUsers();
             loadTotalLoggedInUsers();
             
            //loadIPData();
            
        }
    });
})($);