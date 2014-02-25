<?php
   // BookingEdit2.php
   // processing for Booking Edit form

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
   
   $personID    = $_POST['personID'];
   $taskID      = $_POST['taskID'];
   $bookingID      = $_POST['bookingID'];
   $descripsh      = $_POST['descripsh'];
   $descripshas    = addslashes( $descripsh );
		 $startDate     = $_POST['startDate'];
		 $startTime     = $_POST['startTime'];
		 $endDate       = $_POST['endDate'];
		 $endTime       = $_POST['endTime'];
         $location      = addslashes( $_POST['location'] );

   if ( $personID!="" && $taskID!="" && $bookingID!="" )
   {
      $qup = "UPDATE Booking "
	         ." SET startDate='$startDate' "
			 ." ,startTime='$startTime' "
			 ." ,endDate='$endDate' "
			 ." ,endTime='$endTime' "
			 ." ,descripsh='$descripshas' "
			 ." ,location='$location' "
			 ." WHERE bookingID='$bookingID' AND personID='$personID' "
	         .";";
	  $rup = mysql_query( $qup );
	  errorFree( $rup );
	  header("Location: Calendar.php");
   }
?>

