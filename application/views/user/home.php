<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
    <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/foundation.css" />
    <link rel="stylesheet" href="<? echo base_url(); ?>assets/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/app.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/foundation-datepicker.min.css">
     <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="<? echo base_url(); ?>assets/js/vendor/modernizr.js"></script>

      <script src="<? echo base_url(); ?>assets/js/vendor/jquery.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="<? echo base_url(); ?>assets/dist/js/select2.min.js"></script>
  

  </head>
  <body>
	
      <div class="row activity">
      <? $this->view('common/left'); 
       $i=0;
       foreach($user as $use)
           {
      $availableNames[$i++]="@".$use->firstname.$use->lastname;;
            }?>
      <div class="large-6 columns activity-list">
      	<? echo form_open('home/addActivity') ?>
        <div class="row">
          <div class="large-12 columns">
          		<?
				if(validation_errors()) {
					?>
					<div data-alert class="alert-box alert radius">
					  <? echo validation_errors(); ?>
					  <a href="#" class="close">&times;</a>
					</div>
					<?
					}
				?>
              <div class="row collapse postfix-radius activity-form">
                <div class="small-10 columns">
                  <input type="text" name="activity" placeholder="Add activity & press enter" tabindex="1" autofocus>
                </div>
                <div class="small-2 columns">
                  <input type="submit" class="button secondary postfix" value="Add" />
                </div>
                <div class="small-4 columns sel">
                  <select name ="user[]"class="js-example-basic-multiple search" multiple="multiple" id="search">
                  <?
                  foreach($availableNames as $avail)
                  {?>
  
                     <option value="<?echo $avail;?>"><?echo $avail;?></option>
  

                    <?
                  }
                    ?>
                   </select>

                </div>
                
              </div>
            </div>
            </div>
         <? echo form_close(); ?>
      	<ul class="activities">
        	<? 
         
         
        	global $var;
					$var=$_SESSION['id'];
					
			if(count($activities)==0) :
				?>
                	<li class="no-activity">No activities added yet. Let's get some work done!</li>
                <?
			else :
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
            
						?>
						<?
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
});
</script>

<script>
        $(document).ready(function() { 
        $(".js-example-basic-multiple").select2();
       
        });
    
</script>

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
     // alert(a);
   window.location.replace("<? echo site_url(); ?>/home/getDateActivities/<? echo $var;?>/"+aa);
});
  </script>
 
  
  </body>
</html>
