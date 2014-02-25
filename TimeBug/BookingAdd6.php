<?php
   // BookingAdd6.php
   // processing for BookingAdd4 add form
   // This is the one where we add multiple Bookings based on the day of the week
   // within  the given interval.
   // personID is in $_SESSION
   // $_POST has  startDate, endDate, startTime, endTime, taskID, 
   // also day0, day1,  ... day6 (Sun-Sat).  
   
  


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
   $taskID =   $_POST['taskID'];
   $descripsh = $_POST['descripsh'];
   $descripshas = addslashes( $descripsh );
   $startDate = addslashes( $_POST['startDate'] );
   $startTime = addslashes( $_POST['startTime'] );
   $endDate   = addslashes( $_POST['endDate'] );
   $endTime   = addslashes( $_POST['endTime'] );
   $dayto[0] = $_POST['day0'];  // etc
   $dayto[1] = $_POST['day1'];  // etc
   $dayto[2] = $_POST['day2'];  // etc
   $dayto[3] = $_POST['day3'];  // etc
   $dayto[4] = $_POST['day4'];  // etc
   $dayto[5] = $_POST['day5'];  // etc
   $dayto[6] = $_POST['day6'];  // etc
   
   if ($bug)
   {
      echo "<html><body> \n";
      echo "personID=$personID, ";
	  echo "taskID=$taskID, ";
	  echo "descripsh=$descripsh, ";
	  echo "startDate=$startDate, ";
	  echo "endDate=$endDate, ";
	  echo "startTime=$startTime, ";
	  echo "endTime=$endTime, ";
	  echo "dayto values ".($dayto[0])." ".($dayto[1])." ".($dayto[2])." ".($dayto[3])." "
	       .($dayto[4])." ".($dayto[5])." ".($dayto[6])."<br />\n";
   }
   
   // OK, so make a date object from the start date, do a loop advancing it
   // one day at a time until the end date.

   date_default_timezone_set("America/New_York");	 
   
   if ( $personID!="" && $taskID!="" )
   {
       $dap = noonObject( $startDate );
	   //$parts = preg_split('[-]',$startDate); // split the start date into 3 parts 
	   //$dap = mktime( 12, 0, 0, $parts[1], $parts[2], $parts[0] );  
	   $endObject = noonObject( $endDate );
	   $dapstring = date("Y-m-d", $dap);
	   $maxn = 50; // maximum number of bookings to make at a shot.  just to catch errors.
	   $atLeastOne = false; // true iff there is at least one booking made for this task
	   while (  $dap <= $endObject /* $dapstring != $endDate */ && $maxn > 0 )
	   {
		  $dayofweek = date("w",$dap );
		  if ( $dayto[$dayofweek] == "on" )
		  {
			 $maxn--;
			 $bookingID = maxBookingID( $personID ) + 1;
			 $qbadd = "INSERT INTO Booking SET "
					 ."  bookingID='$bookingID' "
				     ." ,personID='$personID' "
					 ." ,taskID='$taskID' "
					 ." ,startDate='$dapstring' "
					 ." ,startTime='$startTime' "
					 ." ,endDate='$dapstring' "
					 ." ,endTime='$endTime' "
					 ." ,descripsh='$descripshas' "
					 .";";
		     if ($bug) { echo "would have done query = $qbadd <br />"; }
			 else { $rbadd = mysql_query( $qbadd ); errorFree( $rbadd ); $atLeastOne = true; }
		  }
		  $dap = $dap + 24*3600;
		  $dapstring = date("Y-m-d", $dap);
	   }
	   // update the task to say that  it is now tied to bookings (if there was at least on Booking)
	   if ( $atLeastOne )
	   {
	      $qtu = "UPDATE Task SET tied='1' WHERE personID='$personID' AND taskID='$taskID';";
		  $rtu = mysql_query( $qtu );
		  errorFree( $rtu );
	   }
   }  
   header("Location: Calendar.php");
?>

<?php
   // noonObject takes a date string (YYYY-MM-DD format) and returns a time object (int) which is for
   // that date at noon.
   /*
   function noonObject( $dateString )
   {
   	   $parts = preg_split('[-]',$dateString ); // split the start date into 3 parts 
	   $dap = mktime( 12, 0, 0, $parts[1], $parts[2], $parts[0] );  // args: h, m, s, M, D, Y 
       return $dap;
   }
   */
?>