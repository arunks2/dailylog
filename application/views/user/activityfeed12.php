<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Activity Details</title>
    <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/foundation.css" />
    <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/app.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">  <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/foundation-datepicker.min.css">
    <script src="<? echo base_url(); ?>assets/js/vendor/modernizr.js"></script>
     <script src="<? echo base_url(); ?>assets/js/vendor/jquery.js"></script>
  </head>
  <body>
	
      <div class="row activity">
      <? $this->view('common/left'); ?>
     <div class="large-6 columns activity-list">
        
        <ul class="activities">
          <? 
          global $var;
          global $temp;
          $temp=0;
          $var =$_SESSION['id']; 
          $c=0;         
        foreach($activities as $activity) {
          
          if($c==0)
            {$temp=$activity->id;
            }
            $c++;
          ?>
           
          <li>
           <ul class="actions">
            <?
            if($activity->is_approved):
               if($_SESSION['is_admin']==1)
              {
                ?>
              <li class="approved"><a href='<? echo site_url(); ?>/home/approve/<?echo $activity->id; echo "/".$activity->user_id?>'><span>Approved</span><i class="fa fa-check-circle"></i></a></li>
              <?
            }
              else
              {
                ?>
            <li class="approved"><span>approved</span><i class="fa fa-check-circle"></i></li>
              <?
            }
            else:
              if($_SESSION['is_admin']==1)
              {
                ?>
                 <li class="unapproved"><a href='<? echo site_url(); ?>/home/approve/<?echo $activity->id; echo "/".$activity->user_id?>'> <span>Unapproved</span><i class="fa fa-check-circle"></i></li>
                <?
              }
              else
              {
                ?>
                  <li class="unapproved"><span>Unapproved</span><i class="fa fa-check-circle"></i></li>
              <?}
            endif;
            
            if($activity->comments!=0) {
              ?>
              <li class="comments"><a href='<? echo site_url(); ?>/home/activityDetails/<? echo $activity->id; ?>'><span><? echo $activity->comments; ?> Comments</span><i class="fa fa-comments"></i><span class="number"><? echo $activity->comments; ?></span></a></li>
              <?
              }
            else
              {
              ?>
              <li class="comments none"><a href='<? echo site_url(); ?>/home/activityDetails/<? echo $activity->id; ?>'><span>No Comments</span><i class="fa fa-comments"></i></a></li>
              <?  
              }
            ?>
            
          </ul>
          <span class="activity-text"><a href='<? echo site_url(); ?>/home/activityDetails/<? echo $activity->id ?>'><? echo $activity->activity_text ?></a></span>
          <span class="activity-time"><? echo $activity->firstname; ?></span>
        
          <span class="activity-time"><? $x=strtotime($activity->activity_date); echo date('h:i a', $x) ?></span>
           
        </li>
          <?
          }
        
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
	$('#dp1').fdatepicker({
					format: 'mm-dd-yyyy',
					disableDblClickSelection: true
				});
	</script>
  <script>
  $('#dp1').fdatepicker()
  .on('changeDate', function(ev){
      var aa = $("#dp1").val();
<?global $var;
          $var=$_SESSION['id'];?>
      
    window.location.replace("<? echo site_url(); ?>/home/getDateActivities/<? echo $var;?>/"+aa);
  });
  </script>
  <script>
 $(document).ready(function(){

    funInterval=setInterval(fun,10000);
    last_id=<? echo $temp ;?>;
    function fun(){
      clearInterval(funInterval);
       //alert("yeah, it works");
       $.ajax({
            url: '<? echo site_url(); ?>/home/newfeed/'+last_id,           
            type: "POST",
       //data: { 'id' : selectedId, 'comments' : comments },
            dataType: 'json',
           success: function(data){
             console.log(data);
              if(data.error!=true) {
              count = data.activities.length;
              console.log('newitems-'+count);
              console.log('last-id-'+last_id);
              if(count>0) {
                for(i=0;i<count;i++) {
                  ac=data.activities[i];
                  console.log(ac);
                  var as="";
                  as+='<li class=" newAc">';
as+='<ul class="actions">';
var temp=ac['id'];
if(ac['approved']==1) 
  {
    if(ac['is_admin']==1)
    {
      var relink='';
  relink=temp+'/'+ac['user_id'];
    as+='<li class="approved"><a href="<? echo site_url(); ?>/home/unapprove/+relink"><span>Approved';
    as+='</span></li>';
  }
  else{
    as+='<li class="approved"><span>Approved</span><i class="fa fa-check-circle"></i>';
    as+='</li>';
  }
  }
else 
  {
     if(ac['is_admin']==1)
    {
      var link='';
      link=temp+'/'+ac['user_id'];
    as+='<li class="unapproved"><a href="<? echo site_url(); ?>/home/approve/+link"><span>Unapproved';
    as+='</span></li>';
  }
  else
  {
    as+='<li class="unapproved"><span>Unapproved</span><i class="fa fa-check-circle"></i>';
    as+='</li>';
  }
  }
 if(ac['comments']!=0) 
{

as+='<li class="comments"><a href="<? echo site_url(); ?>/home/activityDetails/+temp"><span>';
as+=ac["comments"];
as+=' Comments';
as+='</span><i class="fa fa-comments">';
as+='</i>';
as+='<span class="number">';
as+=ac["comments"];
as+='</span>';
as+='</a>';
as+='</li>';
}           
  
   else
 {
  var temp1=ac['id'];
as+='<li class="comments none">';
as+='<a href="<? echo site_url(); ?>/home/activityDetails/"+temp1>';
as+='<span>No Comments</span>';
as+='<i class="fa fa-comments"></i>';
as+='</a>';
as+='</li>';
 }
    as+='</ul>';
 as+='<span class="activity-text">';
 as+='<a href="<? echo site_url(); ?>/home/activityDetails/"+ac["id"]>';
 as+=ac["activity_text"];
 as+='</a></span>';
 as+='<span class="activity-time">';
 as+=ac["firstname"];
 as+='</span>';
 as+='<span class="activity-time">';
 as+=ac["activity_date"];
 as+='</span>';
as+='</li>';
                  $('.activities').prepend(as);
          
          last_id=ac['id'];
                }
                //last_id=data.activities[count-1]['id'];
                console.log('new last id-'+last_id);
                funInterval=setInterval(fun,10000);
                }
              }
              }
            });
        }
      });</script>
  </body>
</html>

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


