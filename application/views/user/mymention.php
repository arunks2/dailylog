<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Mentions</title>
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
       <div>
    <p>Filter by Name</p>
    <select id="users">
    <? if(isset($username)):
    
       foreach($username as $name):
        $temp=$name->firstname;
      $temp=$temp." ".$name->lastname;
        ?>
      <option value='<? echo ucwords($name->id);?>'><? echo ucwords($name->firstname)." " .ucwords($name->lastname);?></option>
    <?
    endforeach;
    else:
     ?>
    <option value="empty">Select User</option>
    <?
    endif;
    foreach($alluser as $use)
    {
      ?>
    <option value='<? echo ucwords($use->id);?>'><? echo ucwords($use->firstname)." " .ucwords($use->lastname);?></option>
    <?
    }
    ?>
  </select> 
  </div> 
   
        
        <ul class="activities notifications">

          <? 
          global $var;
          $var =$_SESSION['id'];
          if(!isset($temp)):
            $temp="teammates";
          endif;
          if(count($mentions)==0) :
        ?>
                  <li class="no-activity">No Mentions by <? echo $temp;?></li>
                <?
      else :
        //foreach($user as $use)
        ?><li class="no-activity">Your Mentions by <? echo $temp;?></li>
             
        <?
       
        foreach($mentions as $mention) {
          
          ?>
           
          <li>
           
          <span class="activity-text">You were mentioned by <?echo $mention->firstname;?><a href='<? echo site_url(); ?>/home/activityDetails/<? echo $mention->ac_id ?>'><?echo "  in "; echo $mention->text ?></a></span>
           
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
 $(function () {
        $("#users").change(function () {
             selectedText = $(this).find("option:selected").text();
             selectedValue = $(this).val();
           // $(".Ureport").show();
            //$(".dReport").hide();
             window.location.replace("<? echo site_url(); ?>/home/getmymentions/"+selectedValue);

         //   alert("Selected Text: " + selectedText + " Value: " + selectedValue);
        });
    });
    </script>

<style>
.newAc{background:rgba(0,255,0,.1);}
</style>

  </body>
</html>
