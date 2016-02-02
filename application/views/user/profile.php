<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Profile</title>
    <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/foundation.css" />
    <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/app.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">   <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/foundation-datepicker.min.css">
    <script src="<? echo base_url(); ?>assets/js/vendor/modernizr.js"></script>
     <script src="<? echo base_url(); ?>assets/js/vendor/jquery.js"></script>
  
    <script src="<? echo base_url(); ?>assets/js/foundation.min.js"></script>
  </head>
  <body>
	
      <div class="row activity">
      <? $this->view('common/left'); ?>
   <div class="large-6 columns activity-list">
      
                <? echo form_open('home/editProfile') ?>
        <div>        <?
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
                <div class="small-12 columns">
                <label for ="First Name">First Name:
                  <input type="text" name="Fname" placeholder="<? echo $_SESSION['firstname'] ?>" value="<? echo $_SESSION['firstname'] ?>" style="width:100%;">
                  </label>
                
                <label for="Last Name"> Last Name<input type="text" name="Lname" placeholder="<? echo $_SESSION['lastname'] ?>" value="<? echo $_SESSION['lastname'] ?>" style="width:100%;">
                </label>
              
                                  <label>
                  <input type="submit" class="button secondary postfix" value="update">
                  </label>
               </div></div></div><?  
               echo form_close(); ?>

               <? echo form_open('home/password') ?>
        <div>        <?
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
                <div class="small-12 columns">

                 <label for="Old Password">Old Password <input type="password" name="oldpass" placeholder="Old Passwords" style="width:100%;">
                 </label>
               
                <label for="New Password">New Password
                  <input type="password" name="newpass" placeholder="New password" style="width:100%;">
                </label>
                   <label for="Confirm Password"> Confirm Password<input type="password" name="confpass" placeholder="Confirm password" style="width:100%;">
                </label>
                  <input type="submit" class="button secondary postfix" value="update">
                </div>
              </div></div>
               <?  
               echo form_close(); ?></div>
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
