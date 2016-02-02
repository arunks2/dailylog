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
      <? $this->view('common/left'); ?>
	
    <div class="large-6 columns activity-list nolist">
    <div class="user-d clearfix">
          <img src="<? echo base_url().$user[0]->image ?>">
            <span class="content">
              <? echo $user[0]->firstname.' '.$user[0]->lastname; ?>
              <span class="email"><? echo $user[0]->email; ?></span>
              <span class="date">Showing activities for: <b><? if(isset($startdate)) {echo date('d-m-Y', strtotime($startdate));} else {echo date('d-m-Y', time());} ?> to <? if(isset($endate)) {echo date('d-m-Y', strtotime($endate));} else {echo date('d-m-Y', time());} ?></b></span>
            </span>
    </div>
    <div>
    <p>Report by Name</p>
    <select id="users">
    <option value="<? echo $user[0]->id;?>"><? echo ucwords($user[0]->firstname)." " .ucwords($user[0]->lastname);?></option>
    <?
    foreach($temp_u as $use)
    {
      ?>
    <option value='<? echo ucwords($use->id);?>'><? echo ucwords($use->firstname)." " .ucwords($use->lastname);?></option>
    <?
    }
    ?>
  </select> 
  </div> 
   <div>
   <table class="table">
            <thead>
              <tr>
                <th>Star Date:
                  <input type="text" class="span2" value="<? if(isset($startdate)) {echo date('d-m-Y', strtotime($startdate));} else {echo date('d-m-Y', time());} ?>" id="startdate">
                </th>
                <th>End Date:
                  <input type="text" class="span2" value="<? if(isset($endate)) {echo date('d-m-Y', strtotime($endate));} else {echo date('d-m-Y', time());} ?>" id="endate">
                </th>
              </tr>
            </thead>
          </table>
         <a href='<? echo site_url(); ?>/home/printUser/<? if(isset($startdate)) {echo date('d-m-Y', strtotime($startdate));} else {echo date('d-m-Y', time());} ?>/<? if(isset($endate)) {echo date('d-m-Y', strtotime($endate));} else {echo date('d-m-Y', time());} ?>/<? echo $user[0]->id;?>' class="button tiny pos-chng">Print</a>
         <a href='<? echo site_url(); ?>/home/emailUserReport/<? if(isset($startdate)) {echo date('d-m-Y', strtotime($startdate));} else {echo date('d-m-Y', time());} ?>/<? if(isset($endate)) {echo date('d-m-Y', strtotime($endate));} else {echo date('d-m-Y', time());} ?>/<? echo $user[0]->id;?>' class="button tiny">Email to manager</a>
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
                $cur_date="";$counter=1;$temp=0;
			           foreach($activity as $act)
					       { ?>
                        <?if($counter==1)
                        {
                          $cur_date=date('d-m-Y', strtotime($act->activity_date));
                          $counter++;
                        
                        }
                        if($temp==0):
                        ?>
                        <ul class="ractivity"><li><div class="report-date"><?  echo date('d-m-Y', strtotime($act->activity_date)); ?></div></li>
                        <ul class="nolistD">
                        <?endif;
                        if($cur_date===date('d-m-Y', strtotime($act->activity_date))):
                             $temp=1;
                            
                            ?>
					         
						    <li class=""<? if($act->is_approved==1) {echo 'class="done"';} ?>>
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
          else:
          $cur_date=date('d-m-Y', strtotime($act->activity_date));
          $temp=0;
        ?></ul></ul>
        <?
          endif;
          } 
          ?>
         
         <?
				  }
				  ?>
          </li>
          <?
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
$('#dp3').fdatepicker({
  format: 'dd-mm-yyyy',
          disableDblClickSelection: true,
          closeButton: true
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
  $('#dp3').fdatepicker()
  .on('changeDate', function(ev){
      var aa = $("#dp3").val();
      
    window.location.replace("<? echo site_url(); ?>/home/report/"+aa);
  });
  </script>
 
 <script>
 $(function () {
        $("#users").change(function () {
             selectedText = $(this).find("option:selected").text();
             selectedValue = $(this).val();
            $(".Ureport").show();
            $(".dReport").hide();
           // alert("Selected Text: " + selectedText + " Value: " + selectedValue);
        });
    });
    </script>
    <script>
    $('#startdate').fdatepicker({
          format: 'dd-mm-yyyy',
          disableDblClickSelection: true
        });
        $('#endate').fdatepicker({
           format: 'dd-mm-yyyy',
          closeButton: true
        });
      
        </script>
        <script>
         $('#startdate').fdatepicker()
            .on('changeDate', function(ev)
            {
             s=$("startdate").val();
            });
            
            </script>
        <script>
         $('#endate').fdatepicker()
  .on('changeDate', function(ev){
      //var s=$("startdate").val();
      var e = $("#endate").val();
      var temp="";
      var s=$("#startdate").val();
      temp+=s;
      temp+='/';
      temp+=e;
      temp+='/';
      if (typeof selectedValue === 'undefined')
       {
        var id=<? echo $user[0]->id;?>;
       // alert(id);
     temp+=id;
      }
      else
      {
        temp+=selectedValue;
      } 
     
      //console.log(temp);
     // alert(temp);
    window.location.replace("<? echo site_url(); ?>/home/userreport/"+temp);
  });
  </script>
  </body>
  
</html>
