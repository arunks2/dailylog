<div class="large-2 columns large-offset-1 user-details">
      	<a href='<? echo site_url(); ?>'>
        <img src="<? echo base_url().$_SESSION['pic']; ?>"><br>
        <? echo $_SESSION['firstname'].' '.$_SESSION['lastname']; ?>
        </a>
        <? if(!isset($use))
        {
          $use=$_SESSION['id'];
        }?>
        <div class="activity-datepicker">
        	My activities by date
           
          <?
			if($use!=$_SESSION['id'])
				{
				?>
					<input type="text" class="span2" value="<? echo date('d-m-Y', time()); ?>" id="dp1" style="position:relative" >
				<? 
				}
			else
				{
				?>
					<input type="text" class="span2" value="<? if(isset($date)) {echo date('d-m-Y', strtotime($date));} else {echo date('d-m-Y', time());} ?>" id="dp1" style="position:relative" >
				<? 
				}
			?>
       		 <span class="sub">Select a date to view your activities on that date.</span> 

        </div>
       <!-- <div id="result">
        To DO List:
        <script>

        if (typeof(Storage) !== "undefined")
         {
    
         var Todo={};
          <input type="text" name="Todo" placeholder="Save Todo" tabindex="1" autofocus>
               
           for(var i=0;i<5;i++)
           {

          localStorage.setItem(Todo[i], "123");
    // Retrieve
         document.getElementById("result").innerHTML = localStorage.getItem(Todo[i]);
         document.write(Todo[i]);
          } 
        }
        else 
        {
        document.getElementById("result").innerHTML = "Sorry, your browser does not support Web Storage...";
        }

        </script>
        </div>-->

      </div>

      	