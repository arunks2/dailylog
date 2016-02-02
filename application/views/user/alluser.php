<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>All user</title>
    <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/foundation.css" />
    <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/app.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">   <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/foundation-datepicker.min.css">
    <script src="<? echo base_url(); ?>assets/js/vendor/modernizr.js"></script>
    <script src="<? echo base_url(); ?>assets/js/vendor/jquery.js"></script>
  </head>
  <body>
	
      <div class="row activity">
      <? $this->view('common/left'); ?>
    <div class="large-6 columns activity-list">
    
        <ul class="users large-block-grid-2">
          <? 
      if(count($users)==0) :
        ?>
                  <li class="no-activity">No Users added yet!</li>
                <?
      else :
        //print_r($users);
        foreach($users as $user) {
          ?>
           <li>
            <div class="inner-user" style="position:relative">
              <div class="profile-box clearfix">
           <a href="<? echo site_url(); ?>/home/allactivities/<?echo $user->id ?>" class="clearfix" >
         
          <img src="<? echo base_url().$user->image; ?>" style="width:50px; float:left; margin-right:10px;">
           <span class="user"><? echo ucwords($user->firstname)." " .ucwords($user->lastname);?></span></a>
           <? 
          if($_SESSION['is_admin']==1)
          {
			  if($user->is_active==1)
			  { 
				?>
			  <a class="disable-btn button tiny alert" href="<? echo site_url(); ?>/home/disable/<? echo $user->id ?>" >Disable</a>
			  <? }
			  else
			  	{ ?>
				<a class="disable-btn button tiny success" href="<? echo site_url(); ?>/home/enable/<? echo $user->id ?>">Enable</a>
			  <? 
			  	}
			  } ?>
          </div>
          
			  </div>
			 </li>
	
			  <?
			  }
			endif;
		  ?>
        </ul>
      </div>
<? $this->view('common/right');
    ?>
      </div>
    
    <script src="<? echo base_url(); ?>assets/js/foundation.min.js"></script>
    <script src="<? echo base_url(); ?>assets/js/app.js"></script>
    <script src="<? echo base_url(); ?>assets/js/foundation-datepicker.js"></script>
	<script src="<? echo base_url(); ?>assets/js/locales/foundation-datepicker.vi.js"></script>
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
<?global $var;
          $var=$_SESSION['id'];?>
      
    window.location.replace("<? echo site_url(); ?>/home/getDateActivities/<? echo $var;?>/"+aa);
  });
  </script>
  
  </body>
</html>
