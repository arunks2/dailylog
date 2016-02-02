<div class="large-2 columns end menu">
      	<ul class="menu-c">
        	<li><a href='<? echo site_url(); ?>/home/alluser'><i class="fa fa-users"></i>View Users</a>
            <li><a href='<? echo site_url(); ?>/home/edit'><i class="fa fa-pencil"></i>Edit Profile</a>
           	<li><a href='<? echo site_url(); ?>/home/activityfeed'><i class="fa fa-th-list"></i></i>Activity Feed</a>
            <li><a href='<? echo site_url(); ?>/home/notification'><i class="fa fa-star"></i>Notification</a><span class="addhere"></span></li>
            <li><a href='<?echo site_url();?>/home/mymentions'><i class="fa fa-tags"></i>My Mentions</a></li>
           <li><a href='<?echo site_url();?>/home/report'><i class="fa fa-file"></i>Report</a></li>
          
           <? if($_SESSION['is_admin']==1){
           	?><li><a href='<? echo site_url(); ?>/home/adduser'><i class="fa fa-user-plus"></i>Add User</a>
     
           <?}?>
            <li><a href='<? echo site_url(); ?>/home/logout'><i class="fa fa-sign-out"></i>Logout</a>
        </ul>
      </div>
      <?	
      if(!isset($notified)):
     ?> <script>
       $(document).ready(function(){

setInterval(notify,10000);
    
    function notify(){
      
       //alert("yeah, it works");
       $.ajax({
            url: '<? echo site_url(); ?>/home/getme',           
            type: "POST",
       //data: { 'id' : selectedId, 'comments' : comments },
            dataType: 'json',
           success: function(data){
            //alert(data);
            if(data['error']!=true)
            {
            count = data.notification.length;
           // alert(count);
            if(count!=0)
            {
              $(".addhere").empty();
              //$("span").addClass(".addhere");
            $(".addhere").prepend('<span class="inn">'+count+'</span>');
            $("title").empty();
            var r=count;
           
            
            $('title').prepend('['+r+' notifications]');
            console.log(data);
            
          }
           }
         }
           });
     }
   });
 </script>
 <?
 endif;
 ?>