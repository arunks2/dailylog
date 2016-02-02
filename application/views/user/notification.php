<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Notification</title>
    <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/foundation.css" />
    <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/app.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/foundation-datepicker.min.css">
    <script src="<? echo base_url(); ?>assets/js/vendor/jquery.js"></script>
    <script src="<? echo base_url(); ?>assets/js/vendor/modernizr.js"></script>
  </head>
  <body>
	
      <div class="row activity">
      
      <? $this->view('common/left'); ?>
      <div class="large-6 columns activity-list">
        
        <ul class="activities notifications">

          <? 
          global $var;
          $var =$_SESSION['id'];
          if(count($notification)==0) :
        ?>
                  <li class="no-activity">No notification</li>
                <?
      else :
        //foreach($user as $use)
        ?><li class="no-activity">Older Notification</li>
             
        <?
       
        foreach($notification as $notify) {
          
          ?>
           
          <li>
           
          <span class="activity-text"><a href='<? echo site_url(); ?>/home/activityDetails/<? echo $notify->ac_id ?>'><? echo $notify->text ?></a></span>
           
        </li>
          <?
          }
        endif;
      ?>
        </ul>
      </div>
      <?
      $this->view('common/right');
	  ?>
    </div>

    

    
    <script src="<? echo base_url(); ?>assets/js/foundation.min.js"></script>
    <script src="<? echo base_url(); ?>assets/js/app.js"></script>
    <script src="<? echo base_url(); ?>assets/js/foundation-datepicker.js"></script>
	<script src="<? echo base_url(); ?>assets/js/locales/foundation-datepicker.vi.js"></script>
    <script>
$(document).ready(function() {
    $(document).foundation();
})</script>
    <script>
	$('#dp1').fdatepicker({
					format: 'dd-mm-yyyy',
					disableDblClickSelection: true
				});
	</script>
	<script>
  $('#dp1').fdatepicker()
  .on('changeDate', function(ev){
      var aa = $("#dp1").val();
      <? global $var;?>
      var a=<?echo $var;?>;
      //alert(a);
      
   window.location.replace("<? echo site_url(); ?>/home/getDateActivities/<? echo $var;?>/"+aa);
});
  </script>
    <script>
 $(document).ready(function(){

    funInterval=setInterval(notifyme,10000);
    function notifyme(){
      //clearInterval(funInterval);
       //alert("yeah, it works");
       $.ajax({
            url: '<? echo site_url(); ?>/home/get',           
            type: "POST",
       //data: { 'id' : selectedId, 'comments' : comments },
            dataType: 'json',
           success: function(data){
             //gconsole.log(data);
              if(data.error!=true) {
              count = data.notification.length;
                 if(count>0) {
                for(i=0;i<count;i++) {
                  st=data.notification[i];
                  //console.log(st);
                 var str=""
 str+=    '<li class="newAc">';
           
  str+='<span class="activity-text">';
  var notifyid=st['ac_id'];
  var text=st['text'];
  str+='<a href="<? echo site_url(); ?>/home/activityDetails/';
  str+=notifyid;
  str+='"';
  str+='>';
 str+=text;
  str+='</a>';
  str+='</span>';        
    str+='</li>';
          
                 $('.activities').prepend(str);

          
          //last_id=ac['id'];
                }
                //last_id=data.activities[count-1]['id'];
                //console.log('new last id-'+last_id);
                //funInterval=setInterval(notifyme,10000);
                }
              }
              }
            });
        }
      });</script>
      <script>
$(window).on('focus', function() {
setTimeout(function() {
$('.newAc').removeClass('newAc');

},15000)

})
</script>
<style>
.newAc{background:rgba(0,255,0,.1);}
</style>

  </body>
</html>
