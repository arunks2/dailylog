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
    <div>
    <p>Report by Name</p>
    <select id="users">
    <option value="empty">Select User</option>
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
   <div class="Ureport">
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
         </div>

    	<p>Report by date</p>
          <div class="dReport"><input type="text" class="span2" value="<?if(isset($date)) {echo date('d-m-Y', strtotime($date));} else {echo date('d-m-Y', time());} ?>" data-date-format="mm/dd/yy" id="dp3" style="width:20%;">
         <a href='<? echo site_url(); ?>/home/printit/<? if(isset($date)) {echo date('d-m-Y', strtotime($date));} else {echo date('d-m-Y', time());} ?>' class="button tiny pos-chng">Print</a>
         <a href='<? echo site_url(); ?>/home/emailer/<? if(isset($date)) {echo date('d-m-Y', strtotime($date));} else {echo date('d-m-Y', time());} ?>' class="button tiny">Email to manager</a>
         </div>
         
        <ul class="activity-report">
        <? 
        if(count($temp_u)==0) :
        ?>
        	<li class="no-activity nolist">No Users!</li>
        <?
        else :
        	foreach($temp_u as $use) {
				?>
				<li class="nolist">
					<div class="report-user"> <? echo ucwords($use->firstname)." " .ucwords($use->lastname);?></div>
				<?
        		if(count($use->activity)==0)
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
					foreach($use->activity as $act)
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
					
					<? } ?>
                    </ul>
                    <?
				}
				?>
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
         //   alert("Selected Text: " + selectedText + " Value: " + selectedValue);
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
            function store()
            {
              return s;
            }
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
      temp+=selectedValue;
      console.log(temp);
     // alert(temp);
    window.location.replace("<? echo site_url(); ?>/home/userreport/"+temp);
  });
  </script>
  </body>
  
</html>
