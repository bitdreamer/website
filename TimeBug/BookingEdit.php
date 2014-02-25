<?php
   // BookingEdit.php
   // puts up a form to let you edit booking
   // $_GET['bookingID'] should be set
   // Note: we need to make this interact properly with the associated Task, but I'm
   // not sure the first pass of this will do that.

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
      
   $bookingID = $_GET['bookingID'];
   if ( $bookingID != addslashes( $bookingID ) ) { $bookingID = ""; }
   
   if ( $personID!="" && $bookingID!="" )
   {
      /// fetch the Booking and Task information for this Booking 
	  
	  $q = "SELECT * FROM Task, Booking WHERE "
	      ." Booking.personID='$personID' "
		  ." AND Task.personID='$personID' "
	      ." AND Booking.taskID=Task.TaskID "
		  ." AND bookingID='$bookingID' "
		  .";";
	  $r = mysql_query( $q );
	  if ( errorFree( $r ) )
	  {
	     $row = mysql_fetch_array($r);
		 $description   = stripslashes( $row['description']);
		 $descripsh     = stripslashes( $row['descripsh']);
		 $duration      = $row['duration'];
		 $mishID        = $row['mishID'];
		 $recurs        = $row['recurs'];
		 $earliest      = $row['earliest'];
		 $latest        = $row['latest'];
		 $mustdo        = $row['mustdo'];
		 $taskID        = $row['taskID'];
		 $startDate     = $row['startDate'];
		 $startTime     = $row['startTime'];
		 $endDate       = $row['endDate'];
		 $endTime       = $row['endTime'];
		 $location      = $row['location'];

		 echo "<table border='2'>\n";
		 echo "<tr> <td colspan='2'> Task information: <a href='TaskEdit.php?taskID=$taskID'> edit </a> </td> </tr> \n";
		 echo "<tr> <td> description</td> <td> $description </td> </tr> \n";
		 echo "<tr> <td> duration</td> <td> $duration </td> </tr> \n";
		 echo "<tr> <td> mishID</td> <td> $mishID </td> </tr> \n";
		 echo "<tr> <td> recurs </td> <td> $recurs </td> </tr> \n";
		 echo "<tr> <td> earliest</td> <td> $earliest </td> </tr> \n";
		 echo "<tr> <td> latest </td> <td> $latest </td> </tr> \n";
		 echo "<tr> <td> mustdo </td> <td> $mustdo </td> </tr> \n";
		 echo "</table>\n";
		 
		 echo "<form method='POST' action='BookingEdit2.php' >\n";
		 echo "<table border='2'>\n";
		 echo "<tr> <td colspan='2'> Booking information </td></tr>\n";
		 echo "<input type='hidden' name='bookingID' value='$bookingID' />\n";
		 echo "<input type='hidden' name='personID' value='$personID' />\n";
		 echo "<input type='hidden' name='taskID' value='$taskID' />\n";
		 echo "<tr> <td> descripsh </td> <td> <input name='descripsh' value='$descripsh' /> </td> </tr>\n";
		 echo "<tr> <td>startDate </td> <td> <input name='startDate' value='$startDate' /> </td> </tr>\n";
		 echo "<tr> <td>startTime </td> <td> <input name='startTime' value='$startTime' /> </td> </tr>\n";
		 echo "<tr> <td>endDate </td> <td> <input name='endDate' value='$endDate' /> </td> </tr>\n";
		 echo "<tr> <td>endTime </td> <td> <input name='endTime' value='$endTime' /> </td> </tr>\n";
		 echo "<tr> <td>location </td> <td> <input name='location' value='$location' /> </td> </tr>\n";
		 echo "<tr> <td colspan='2'> <input type='submit' value='submit' /> </td> </tr>\n";
		 echo "</table>\n";
		 echo "</form>\n";
	  }
   }
?>


</body>
</html>
<script>
   function copyDate()
   {
      theForm.endDate.value = theForm.startDate.value;
   }
   function copyTime()
   {
      theForm.endTime.value = theForm.startTime.value + 1;
   }
</script>
