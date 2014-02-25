<?php
   // CalReview.php
   // Show all events up to and including today whose completion status
   // is unknown.   
   // $_GET['theDate'] can be set, but I'm not sure what it does when you
   // set it..

   global $bug;
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
   
   //echo " <a href='Calendar.php?startDate=2001-01-01'> show all </a> \n";
   echo "<div>";
   dayForReview( $personID );
   echo "</div>";
?>
</body>
</html>

<?php

   function dayForReview( $personID )
   {
      global $bug;
      date_default_timezone_set("America/New_York");	  
	  $now = getdate(); // associative array with date and time info
	  $nowdate = $now['year']."-".$now['mon']."-".$now['mday'];
      $whenstring = ""; // " AND startDate>='$nowdate' ";
	  // now do a $_GET for the startDate, and if there is one, use that instead.
	  $gotTheDate = $_GET['theDate'];
	  if ( $gotTheDate != "" && $gotTheDate == addslashes($gotTheDate) )
	  {
	     $whenstring = " AND startDate='$gotTheDate'";
	  }
	  
      $q5 = "SELECT * from Booking, Task "
	       ." WHERE Booking.taskID=Task.taskID AND Booking.personID='$personID' AND Task.personID='$personID' "
		   .$whenstring 
		   ." AND startDate<='$nowdate' "
		   ." AND status='0' "
		   ." ORDER BY startDate, startTime  "
           .";";
      $r5 = mysql_query( $q5 ) ;
  
      if ( noerror( $r5 ) )
	  {
		 echo "<form method='POST' action='CalReview2.php' >\n";
		 echo "<input type='hidden' name='theDate' value='$gotTheDate' \>\n";
	     $lastDate = "";
	     echo "<table border='2'>\n";
		 echo "<tr> ";
		 echo "<tr> <td colspan='7' style='text-align:center'> <b> Calendar Review ";
		 if ($gotTheDate!="" ) { echo " for day = $gotTheDate "; }
		 echo " </b> </td></tr>\n";
		 echo "<td> date/time </td>\n";
		 echo "<td> description (click to edit) </td>\n";
		 echo "<td> status </td>\n";
		 echo "</tr>\n";
	     $nr = mysql_num_rows( $r5 );
		 for ( $i=0; $i<$nr; $i++ )
		 {
		    $row = mysql_fetch_array( $r5 );
			$description = $row['description'];
			$startDate = $row['startDate'];
			$startTime = $row['startTime'];
			$duration = $row['duration'];
			$endTime = $row['endTime'];
			$taskID = $row['taskID'];
			$bookingID = $row['bookingID'];
			$status = $row['status'];
			$tstatus = $row['tstatus'];
			$recurs = $row['recurs'];
			$tied = $row['tied'];
			if ($bug) { echo "recurs = $recurs <br /> \n"; }
	
	        if ($startDate != $lastDate ) 
			{ echo "<tr> <td colspan='2'> $startDate </td> </tr>\n";  $lastDate=$startDate; }
			echo "   <tr>\n";
			echo "      <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $startTime to $endTime </td>\n";
			echo "      <td> <a href='BookingEdit.php?bookingID=$bookingID'> $description </a> </td>\n";
			echo "      <td> ";
			
			// put taskID for this booking in POST , also send info about whether this task is "tied" to Booking
			echo "<input type='hidden' name='t4b$bookingID' value='$taskID' > \n";
			echo "<input type='hidden' name='tied$bookingID' value='$tied' > \n";
			
			// only show status entry buttons below for bookings that are past and have status=0
			if ($bug) { echo "status=$status /";  }
			echo " no info: <input type='radio' name='status$bookingID' value='0' ";
			if ( $status==0 ) { echo "checked"; }
			echo " > | \n";
			if ( $recurs==0 )
			{  
			   echo " task done: <input type='radio' name='status$bookingID' value='1'  ";
			   if ( $status==1 ) { echo "checked"; }
			   echo " > | \n";
			}
			echo " logged: <input type='radio' name='status$bookingID' value='2'  ";
			if ( $status==2 ) { echo "checked"; }
			echo " > | \n";
			echo " awol: <input type='radio' name='status$bookingID' value='3'  ";
			if ( $status==3 ) { echo "checked"; }
			echo " > | \n";
			echo " delete: <input type='radio' name='status$bookingID'  value='4'  ";
			echo " > \n";
			echo " </td>\n";
			echo "   </tr>\n";
		 }
		 echo "<tr> <td colspan='3'> <input type='submit' /> </td> </tr>\n";
		 echo "<table>\n";
		 echo "</form>\n";

		 
		 // need a submit button here ... 
		 echo "</form>\n";
	     //tabledump( $r5 );
		 echo " <p> completion status for bookings, <br /> \n "
		     ." no info = 0 = don't know if time was spent this way <br /> \n "
		     ." task done = 1 = you spent the time on this task and it is done <br />\n "
		     ." logged =2 =  you spent the time on this task but the task is not done <br />\n "
			 ." awol = 3 = this booking does not describe how you spent this time.\n"
			 ." delete = 4 = delete this booking from the DB <br /> \n"
		     ." </p> ";
	  }
   }
?>
