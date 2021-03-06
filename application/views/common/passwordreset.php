<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/foundation.css" />
    <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/app.css" />
    <script src="<? echo base_url(); ?>assets/js/vendor/modernizr.js"></script>
  </head>
  <body>

    <div class="row">
      <div class="large-4 large-offset-4 columns login-form">
        <? echo form_open('home/updatedpassword') ?>
        	<fieldset>
            <legend>Login</legend>
        <?
		if(validation_errors()) 
    {
		?>
            <div data-alert class="alert-box alert radius">
              <? echo validation_errors(); ?>
              <a href="#" class="close">&times;</a>
            </div>
            <?
			}
		
	?>           
<label for="New Password">New Password
<input type="password" name="newpass" placeholder="New password" style="width:100%">
</label>
<label for="Confirm Password"> Confirm Password<input type="password" name="confpass"placeholder="Confirm password" style="width:100%;">
</label>
<input type="submit" value="Reset Password" class="button small radius">
</fieldset>
<? echo form_close(); ?>
</div>
</div>
<script src="<? echo base_url(); ?>assets/js/vendor/jquery.js"></script>
<script src="<? echo base_url(); ?>assets/js/foundation.min.js"></script>
<script src="<? echo base_url(); ?>assets/js/app.js"></script>    
</body>
</html>
