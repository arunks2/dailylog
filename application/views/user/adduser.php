<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Activity Details</title>
    <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/foundation.css" />
    <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/app.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"> <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/foundation-datepicker.min.css">
    <script src="<? echo base_url(); ?>assets/js/vendor/modernizr.js"></script>
    <script src="<? echo base_url(); ?>assets/js/vendor/jquery.js"></script>
  </head>
  <body>
	
      <div class="row activity">
      <? $this->view('common/left'); ?>
   <div class="large-6 columns activity-list">
      
                <? echo form_open('home/adduser') ?>
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
                  <input type="text" name="Fname" placeholder="First Name" style="width:100%;">
                  </label>
                
                <label for="Last Name"> Last Name<input type="text" name="Lname" placeholder="Last Name" style="width:100%;">
                </label>
              
                 <label for="Email">Email <input type="email" name="Email" placeholder="Email" style="width:100%;">
                 </label>
               
                 
               
                <label for="New Password">New Password
                  <input type="password" name="newpass" placeholder="Password" style="width:100%;">
                </label>
                   <label for="Confirm Password"> Confirm Password<input type="password" name="confpass" placeholder="Confirm password" style="width:100%;">
                </label>
                  <input type="submit" class="button secondary postfix" value="Add">
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
          format: 'mm-dd-yyyy',
          disableDblClickSelection: true
        })
  .on('changeDate', function(ev){
      var aa = $("#dp1").val();
<?global $var;
          $var=$_SESSION['id'];?>
      
   window.location.replace("<? echo site_url(); ?>/home/getDateActivities/<?echo $var;?>/"+aa);
});
  </script>
  
  </body>
</html>
