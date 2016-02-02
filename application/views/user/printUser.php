<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Report</title>
    <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/foundation.css" />
    <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/app.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">   <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/foundation-datepicker.min.css">
    <script src="<? echo base_url(); ?>assets/js/vendor/modernizr.js"></script>
     <script src="<? echo base_url(); ?>assets/js/vendor/jquery.js"></script>
  
    <script src="<? echo base_url(); ?>assets/js/foundation.min.js"></script>
  </head>
  <body>
	
      <div class="row activity">
  
	
    <div class="large-9 columns activity-list nolist">
    <div class="user-d clearfix">
          <img src="<? echo base_url().$user[0]->image ?>">
            <span class="content">
              <? echo $user[0]->firstname.' '.$user[0]->lastname; ?>
              <span class="email"><? echo $user[0]->email; ?></span>
              <span class="date">Showing activities for: <b><? if(isset($startdate)) {echo date('d-m-Y', strtotime($startdate));} else {echo date('d-m-Y', time());} ?> to <? if(isset($endate)) {echo date('d-m-Y', strtotime($endate));} else {echo date('d-m-Y', time());} ?></b></span>
            </span>
    </div>
   
   
        <ul class="activity-report">
        <?
        		if(count($activity)==0)
					{
						?>
                        <ul class="nolist">
                        <li>No activity :(</li></ul>
						<?
         }
        	else
				    {
					?>
              <ul class="ractivity">
                <?
			           foreach($activity as $act)
					       { ?>
					
						    <li <? if($act->is_approved==1) {echo 'class="done"';} ?>>
						    <? 
						    if($act->is_approved==1)
						    { 
						  	?>
							   <i class="fa fa-check"></i>
							 <? 
						    }
						  else
							{
							?>
                  <i class="fa fa-circle-o"></i>
                  <?	
							}
						echo($act->activity_text);
						
						?> 
						</li>
					
					<? 
          } 
          ?>
         </ul>
         <?
				  }
				  ?>
          </li>
          <?
        ?>
        </ul>  
        </div>

      </div>
     <script src="<? echo base_url(); ?>assets/js/foundation.min.js"></script>
     <script src="<? echo base_url(); ?>assets/js/app.js"></script>
     <script src="<? echo base_url(); ?>assets/js/foundation-datepicker.js"></script>
	   <script src="<? echo base_url(); ?>assets/js/locales/foundation-datepicker.vi.js"></script>
    
  </body>
  
</html>
