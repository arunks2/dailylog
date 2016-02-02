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
    
  </head>
  <body>
	<div class="row" style="margin-top:60px">
        <div class="large-12 columns activity-list nolist">
            <p style="font-size:24px">Activity Report by date : <? if(isset($date)) {echo date('d-m-Y', strtotime($date));} else {echo date('d-m-Y', time());} ?></p>
             
             
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
    </div>
    
  </body>
</html>
