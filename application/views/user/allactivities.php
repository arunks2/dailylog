<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
    <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/foundation.css" />
    <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/app.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/foundation-datepicker.min.css">
    <script src="<? echo base_url(); ?>assets/js/vendor/modernizr.js"></script>
    <script src="<? echo base_url(); ?>assets/js/vendor/jquery.js"></script>
  </head>
  <body>
	
      <div class="row activity">
      <? $this->view('common/left'); ?>
      <div class="large-6 columns activity-list">
      	<div class="user-d clearfix">
        	<img src="<? echo base_url().$user[0]->image ?>">
            <span class="content">
			<? echo $user[0]->firstname.' '.$user[0]->lastname; ?>
            <span class="email"><? echo $user[0]->email; ?></span>
            <span class="date">Showing activities for: <b><? if(isset($date)) {echo date('d-m-Y', strtotime($date));} else {echo date('d-m-Y', time());} ?></b></span>
            </span>
            <input type="text" class="span2" value="<? if(isset($date)) {echo date('d-m-Y', strtotime($date));} else {echo date('d-m-Y', time());} ?>" id="dp2" >
        </div>
      	<ul class="activities">
        	<? 
        	global $var;
        	$var =$user[0]->id;
        	
			if(count($activities)==0) :
				?>
                	<li class="no-activity" id="noact">No activities were added by <? echo ucwords($user[0]->firstname);echo " "; ?>on<? if(isset($date)) {echo date('d-m-Y', strtotime($date));} else {echo date('d-m-Y', time());} ?></li>
                	</li>
                <?
			else :
				//foreach($user as $use)
				?><li class="no-activity" id="noact">Activities added by <? echo ucwords($user[0]->firstname);echo " "; ?>on<? if(isset($date)) {echo " "; echo date('d-m-Y', strtotime($date));} else {echo " ";echo date('d-m-Y', time());} ?>
             </li>
				<?
				//print_r($activities);
				foreach($activities as $activity) {
					
					?>
				   
					<li>
					 <ul class="actions">
						<?
						if($activity->is_approved):
							if($_SESSION['is_admin']==1)
							{
							?>
							<li class="approved "><span >Approved</span><a href='<? echo site_url(); ?>/home/unapprove/<?echo $activity->id; echo "/".$activity->user_id?>' class="link"><i  data-tooltip title="Marked as done!" class="fa fa-check-circle tip-right"></i></li>
							<?}
							
							else
							{?>
							<li class="approved"><span >Approved</span><i data-tooltip title="Marked as done!"class="fa fa-check-circle"></i></a></li>				
							<?
							}
						else:
							if($_SESSION['is_admin']==1)
							{?>
							<li class="unapproved"><span>Unapproved</span><a href='<? echo site_url(); ?>/home/approve/<?echo $activity->id; echo "/".$activity->user_id?>' class="link"> <i class="fa fa-check-circle"></i></a></li>
							<?
							}
							else
							{
								?>
							<li class="unapproved"><span >Unapproved</span><i class="fa fa-check-circle"></i></li>
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
					<span class="activity-time"><? $x=strtotime($activity->activity_date); echo date('h:i a', $x) ?></span>
				   
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
      //<? global $var;?>
      var a=<?echo $_SESSION['id'];?>;
      //alert(a);
      
   window.location.replace("<? echo site_url(); ?>/home/getDateActivities/<? echo $_SESSION['id'];?>/"+aa);
});
  </script>
  <script>
	$('#dp2').fdatepicker({
					format: 'dd-mm-yyyy',
					disableDblClickSelection: true
				});
	</script>
	<script>
  $('#dp2').fdatepicker()
  .on('changeDate', function(ev){
      var aa = $("#dp2").val();
      <? global $var;?>
      var a=<?echo $var;?>;
      //alert(a);
      
   window.location.replace("<? echo site_url(); ?>/home/getDateActivities/<? echo $var;?>/"+aa);
});
  </script>
  
  </body>
</html>
