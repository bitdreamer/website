<?php
   // BookingAdd2.php
   // processing for mission add form
   // $_POST has a bunch of stuff from the form ... persondID, description, startDate, endDate,
   // startTime, endTime, mishID,
   // We make the Booking and a Task (dummy sort of) to go with it.

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
   
   $personID = $_POST['personID'];
   $description = addslashes( $_POST['description'] );
   $startDate = addslashes( $_POST['startDate'] );
   $startTime = addslashes( $_POST['startTime'] );
   $endDate   = addslashes( $_POST['endDate'] );
   $endTime   = addslashes( $_POST['endTime'] );
   $mishID    = $_POST['mishID'];
   
   // $mustdo = get the importance number that goes with this mission
   $mustdo = 9;
   $qgmv = "SELECT importance from Mission WHERE personID='$personID' AND mishID='$mishID';  ";
   $rgmv = mysql_query( $qgmv );
   if ( noerror( $rgmv ) )
   {
      $row = mysql_fetch_array( $rgmv );
	  $mustdo = $row['importance'];
   }
   
   if ( $personID!="" && $description!="" )
   {   
      $duration = $endTime - $startTime;
      $taskID = maxTaskID( $personID ) + 1;
      $qadd = "INSERT INTO Task "
	         ." SET taskID='$taskID' "
			 ." ,personID='$personID' "
			 ." ,description='$description' "
			 ." ,duration='$duration' "
			 ." ,recurs='0' "
			 ." ,mishID='$mishID' "
			 ." ,earliest='$startTime' "
			 ." ,latest='' "
			 ." ,mustdo='$mustdo' "
			 ." ,tied='1' "
			 ." ,tstatus='2' " // booked
	         .";";
	  $radd = mysql_query( $qadd );
	  errorFree( $radd );
	  
	  $bookingID = maxBookingID( $personID ) + 1;
	  $qbadd = "INSERT INTO Booking SET "
	          ."  bookingID='$bookingID' "
	          ."  ,personID='$personID' "
			  ." ,taskID='$taskID' "
			  ." ,startDate='$startDate' "
			  ." ,startTime='$startTime' "
			  ." ,endDate='$endDate' "
			  ." ,endTime='$endTime' "
			  ." ,descripsh='$description' "
	          .";";
      $rbadd = mysql_query( $qbadd );
	  errorFree( $rbadd );
	  
	  //header("Location: MissionList.php");
	  header("Location: Calendar.php");
   }
?>
