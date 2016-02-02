<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Activity Details</title>
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
      	<? echo form_open('home/addComment') ?>
        <div class="row">
        	<div class="large-6 columns activity-date">
            	<? echo date("G:i a (D) j/M/y",strtotime($activity->activity_date)); ?>
            </div>
            <div class="large-6 columns text-right activity-status">
            	<?
						if($activity->is_approved):
							
            if($_SESSION['is_admin']==1)
              {?>
                
                <a href='<? echo site_url(); ?>/home/unapprove/<?echo $activity->id; echo "/".$activity->user_id?>' style="color: inherit;
  text-decoration: inherit; "><span class="approved"><span>Approved</span><i class="fa fa-check-circle"></i></span></a>
                <?
              }
              else
              {?>
							<span class="approved"><span>Approved</span><i class="fa fa-check-circle"></i></span> </li>
							<?}
						else:
						if($_SESSION['is_admin']==1)
              {?>
                
                <a href='<? echo site_url(); ?>/home/approve/<?echo $activity->id; echo "/".$activity->user_id?>' style="color: inherit;
  text-decoration: inherit; "><span class="unapproved"><span>Unapproved</span><i class="fa fa-check-circle"></i></a></li>
                <?
              }else
              {?>
<span class="unapproved"><span>Unapproved</span><i class="fa fa-check-circle"></i></li>
              <?}
						endif;
						?>
            </div>
            <div class="large-12 columns activity-text-details">
                <p>
                	<? echo $activity->activity_text; ?>
                </p>
            </div>
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
                <? echo form_open('home/addComment') ?>
                
              <div class="row collapse postfix-radius activity-form">
                <div class="small-10 columns">
                  <input type="text" name="comment" placeholder="Add comment" tabindex="1" autofocus>
                </div>
                <div class="small-2 columns">
                  <input type="submit" class="button secondary postfix" value="Add" />
                </div>
              </div>
               <? echo form_close(); ?>
              <ul class="comments">
              <?
			  if(count($activity->comments)==0) {
				  ?>
                  <li class="no-activity">No comments yet.</li>
                  <?
				  }
			  else
			  	{
					foreach($activity->comments as $comment) :
				?>
                		<li>
                        	<ul class="comment">
                            	
                                <li><? echo $comment->comment_text ?></li>
                                <li class="name"> - <? echo $comment->firstname.' '.$comment->lastname ?> <span class="time"><? $c_date=date('j/m/y',strtotime($comment->comment_date));$today=date('j/m/y'); if($c_date!=$today) {echo date(' - g:i a, j/m/y', strtotime($comment->comment_date));} else {echo date(' - g:i a', strtotime($comment->comment_date)).' today';} ?></span></li>
                            </ul>
                        </li>
                <?	
					endforeach;
				}
			  ?>
              </ul>
            </div>
            </div>
         <? echo form_close(); ?>
      	
      </div>
      <?
      $this->view('common/right');
	  ?>	
    </div>

    

    
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

      //alert("hello!");
    //alert(aa);

   window.location.replace("<? echo site_url(); ?>/home/getDateActivities/<?echo $activity->user_id;?>/"+aa);
});
  </script>
  
  </body>
</html>
