<?php
   // BookingAdd3.php
   // Puts up a form for the user to say WHEN to accomplish a specific task.
   // $_GET has the taskID.  This should be for single time tasks ... multiple ones should
   // have gone to BookingAdd4.php .
   // $_GET can have a suggested  sugDate and sugTime .    Assume today/now if not included.
   // In the future we want to do a search for the first open slot that can take it.

   global $bug;
   $bug = true;
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
   
   $personID = $_SESSION['personID'];
   $taskID = $_GET['taskID']; 
   // add anything you need from Task to the POST array 
      
?>
<html>
<head>
<script type="text/javascript" src="errorHandler.js"> </script>
</head>
<body>
   <?php shopHeader( $personID );  leftmenu(); ?> 
   <h2> book an existing task </h2>
    
   <?php  showBookingForm( $personID, $taskID ); ?>
</body>
</html>


<?php 


   function showBookingForm( $personID, $taskID )
   {
      if ( $taskID=="" || $taskID<0 || $taskID>1000000 )
      { echo "invalid taskID "; return; }
   
      // get the current values for this task
      $qfill = "SELECT * FROM Task WHERE personID='$personID' AND taskID='$taskID';";
	  $rfill = mysql_query( $qfill );
	  if ( noerror( $rfill ) )
	  {
	     $row = mysql_fetch_array( $rfill );
		 $description   = stripslashes( $row['description']);
		 $duration      = $row['duration'];
		 $mishID        = $row['mishID'];
		 $recurs        = $row['recurs'];
		 $earliest      = $row['earliest'];
		 $latest        = $row['latest'];
		 $mustdo        = $row['mustdo'];
		 $tstatus       = $row['tstatus'];
		 $tied          = $row['tied']; 
		 
		 echo "<table border='2'>\n";
		 echo "<tr> <td colspan='2'> Task information: <a href='TaskEdit.php?taskID=$taskID'> edit </a> </td> </tr> \n";
		 echo "<tr> <td> description</td> <td> $description </td> </tr> \n";
		 echo "<tr> <td> duration</td> <td> $duration </td> </tr> \n";
		 echo "<tr> <td> mishID</td> <td> $mishID </td> </tr> \n";
		 echo "<tr> <td> recurs </td> <td> $recurs </td> </tr> \n";
		 echo "<tr> <td> earliest</td> <td> $earliest ";
		 if ( $earliest=="0000-00-00") {echo "you really should go to task edit and fill this in."; }
		 echo " </td> </tr> \n";
		 echo "<tr> <td> latest </td> <td> $latest ";
		 if ( $latest=="0000-00-00") {echo "you really should go to task edit and fill this in."; }
		 echo " </td> </tr> \n";
		 echo "<tr> <td> mustdo </td> <td> $mustdo </td> </tr> \n";
		 echo "</table>\n";

		 echo "<table border='1'>\n";
		 echo "<form method='POST' action='BookingAdd5.php' >\n";
		 echo "<input type='hidden' name='taskID' value='$taskID' >\n";
		 echo "<input type='hidden' name='mustdo' value='$mustdo' />\n";
		 echo "<input type='hidden' name='taskID' value='$taskID' />\n";
		 echo "<tr> <td> descripsh </td> <td> "
		      ." <input name='descripsh' value='$description' /> "
		      ."</td> <td> explanation </td> </tr>";
		 echo "<tr> <td> startDate </td> <td> <input name='startDate' /> </td> <td> explanation </td> </tr>";
		 echo "<tr> <td> endDate </td> <td> <input name='endDate' /> </td> <td> explanation </td> </tr>";
		 echo "<tr> <td> startTime </td> <td> <input name='startTime' /> </td> <td> explanation </td> </tr>";
		 echo "<tr> <td> endTime </td> <td> <input name='endTime' /> </td> <td> explanation </td> </tr>";
		 echo "<tr> <td colspan='3'> <input type='submit' value='submit' /> </td>  </tr>";
		 echo "</form>\n";
		 echo "</table>\n";
		 /*
		    OK, so.  Look at BookingAdd.php.  But basically, get a new bookingID.  
			phase 1. don't worry about conflicts.  Just open up some boxes to put
			in start date and end date and start time and end time, then book it.
			Note, BookingAdd5 just does Booking (doesn't need dummy task).  This
			will give us the ability to put existing tasks on the calendar.  Don't 
			forget to change the Task status.
			phase 2.  use the $earliest to get us a day.  And perhaps show the 
			calendar entry for that day, so we can see where to fit it.
			phase 3.  work from sugDate and sugTime in URL.  This will let us make
			buttons that jump to the next day and reload.  Note: we have to take POST
			variables with us ... doable, just don't forget.
			phase 4.  Have it do this automatically until it finds a slot.  Note:
			this can't work until we have the repeated fields stuff filled in,
			like sleep and eating.  
		 */
		 
	  }

   }
   

?>
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
</script>