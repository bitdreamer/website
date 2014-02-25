<?php
   // BookingAdd5.php
   // processing for BookingAdd3 add form
   // We only have to add the booking, not the task, so this is less than BookingAdd2
   // (which is what we are working from).
   // $_POST has descripsh, startDate, endDate,
   // startTime, endTime, and taskID and mustdo from Task

   $bug = false;
   session_start();
   include("../includeInAll.php");
   levelCheck(1); // only me while I'm coding
   include( "openDB.php" );
   openDB();
   //upCheck();
   //include("leftMenu.php");
   //include("shopHeader.php");
   //include("../tabledump.php");
   include("functions.php");
   $personID = $_SESSION['personID'];
   
   
?>
<?php
   
   //$personID = $_POST['personID'];
   $descripsh = addslashes( $_POST['descripsh'] );
   $startDate = addslashes( $_POST['startDate'] );
   $startTime = addslashes( $_POST['startTime'] );
   $endDate   = addslashes( $_POST['endDate'] );
   $endTime   = addslashes( $_POST['endTime'] );
   $mishID    = $_POST['mishID'];
   $mustdo    = $_POST['mustdo'];
   $taskID    = $_POST['taskID'];
   if ($bug) { echo "personID=$personID, taskID=$taskID <br />\n";}

   if ( $personID!="" && $descripsh!="" )
   {   
      $qut = "UPDATE Task "
	         ." SET  "
			 ." tied='1' "
	         ." WHERE personID='$personID' "
			 ." AND taskID='$taskID' ;";
	  if ($bug) { echo "would have done query=$qut";}
	  else 
	  { $rut = mysql_query( $qut ); 
	    errorFree( $rut );
	  }
	  
	  $bookingID = maxBookingID( $personID ) + 1;
	  $qbadd = "INSERT INTO Booking SET "
	          ."  bookingID='$bookingID' "
	          ." ,personID='$personID' "
			  ." ,descripsh='$descripsh' "
			  ." ,taskID='$taskID' "
			  ." ,startDate='$startDate' "
			  ." ,startTime='$startTime' "
			  ." ,endDate='$endDate' "
			  ." ,endTime='$endTime' "
	          .";";
	  if ($bug) { echo "would have done query=$qbadd";}
	  else 
      { $rbadd = mysql_query( $qbadd );
	    errorFree( $rbadd );
	  }
	  if ($bug)
	  { echo "<a href='Calendar.php?startDate=$startDate&endDate=$endDate'> to verify </a>\n";
	  }
	  else { header("Location: Calendar.php?startDate=$startDate&endDate=$endDate"); }

   }
?>
