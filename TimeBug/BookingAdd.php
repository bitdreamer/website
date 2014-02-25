<?php
   // BookingAdd.php
   // puts up a form to let you enter a new booking
   // This is for a raw event, like a lecture I'm going to.  

   $bug = false;
   session_start();
   include("../includeInAll.php");
   levelCheck(1); // only me while I'm coding
   include( "openDB.php" );
   openDB();
   //upCheck();
   include("leftMenu.php");
   include("shopHeader.php");
   include("../tabledump.php");
   include("functions.php");
?>
<html>
<head>
<script type="text/javascript" src="errorHandler.js"> </script>
</head>
<body>
<?php
   $personID = $_SESSION['personID'];
   shopHeader( $personID );
   leftMenu();
?>  
   <div>
      <table border ="2" >
	  <tr> <td colspan="2"> <b>add this event: </b>  </td>  </tr>
      <form method="POST" action="BookingAdd2.php" name="theForm">
	    <?php echo "<input type='hidden' name='personID' value='$personID' /> \n"; ?> <br />
		<tr> <td> description: </td><td> <input name="description" /> </td> </tr>
		<tr> <td> start date: </td><td>  <input name="startDate"  maxlength="10" /> </td>  
		     <td> <input type="button" value="today" onclick="setToday();" /></td>
		     <td> <input type="button" value="tomorrow" onclick="setTomorrow();" /></td>
		
		</tr> 
		<tr> <td> end date: </td><td>  <input name="endDate"  maxlength="10" />  </td> 
		     <td> <input type="button" value="same" onclick="copyDate();" /> </td>
		</tr> 
		<tr> <td>start time (23.999): </td><td>  <input name="startTime"   maxlength="10" />  </td> </tr> 
		<tr> <td> end time: </td><td>  <input name="endTime"  maxlength="10" />  </td> 
		     <td>  <input type="button" value="same+1" onclick="copyTime(1);" /> </td>
		     <td>  <input type="button" value="+1" onclick="addTime(1);" /> </td>
		     <td>  <input type="button" value="-0.5" onclick="addTime(-0.5);" /> </td>
		</tr> 
        <tr> <td> category/subcat </td><td> <?php mishChoices( $personID, 0 ); ?>  </td> </tr> 
		<tr> <td colspan="2"> <input type="submit" value="add this event" /> 
          or <a href="Calendar.php"> cancel </a>
		</td> </tr> 
	  </form>
      </table>
	  
   </div>


</body>
</html>
<script>
   // set startDate to today.  note this is javascript, not PHP
   function setToday()
   {
	  var now = new Date();
	  var nowstring = now.getFullYear()+"-"+((now.getMonth())+1)+"-"+now.getDate();
	  theForm.startDate.value = nowstring;
   }
   function setTomorrow()
   {
	  var now = new Date();
	  var tomorrow = new Date( now.getTime() + (1000*3600*24) );
	  var tomorrowstring = tomorrow.getFullYear()+"-"+((tomorrow.getMonth())+1)+"-"+tomorrow.getDate();
	  theForm.startDate.value = tomorrowstring;
   }
   function copyDate()
   {
      theForm.endDate.value = theForm.startDate.value;
   }
   function copyTime( much )
   {
      $m = theForm.startTime.value;
	  $m = ( (1.0 * $m ) + much);
      theForm.endTime.value = $m;
   }
   function addTime( much )
   {
      $m = theForm.endTime.value;
	  $m = ( (1.0 * $m ) + much);
      theForm.endTime.value = $m;
   }
</script>
