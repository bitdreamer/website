<?php
   // DayFill.php
   // under construction
   // $_GET['theDate'] can be set, default is today.
   // Show all events for this day, and create forms for all of the gaps.  
   // The forms should allow the user to quickly fill in 
   //  1. new events, just pick mission and duration
   //  2. pick an existing task.
   //  It might also be good to have one click buttons for the most common fills,
   //  travel, food, getting organized, misc.  
   // 

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
   
   //echo " <a href='Calendar.php?startDate=2001-01-01'> show all </a> \n";
   echo "<div>";
   dayToFill( $personID );
   echo "</div>";
?>
</body>
</html>

<?php

   function dayToFill( $personID )
   {
      global $bug;
      date_default_timezone_set("America/New_York");	  
	  $now = getdate(); // associative array with date and time info
	  $nowdate = $now['year']."-".$now['mon']."-".$now['mday'];
      $whenstring = $nowdate;
	  // now do a $_GET for the startDate, and if there is one, use that instead.
	  $gotTheDate = $_GET['theDate'];
	  if ( $gotTheDate != "" && $gotTheDate == addslashes($gotTheDate) )
	  {
	     $whenstring = $gotTheDate;
	  }

      	  // set previous and next pointers
	  $previousDay = date("Y-m-d", noonObject( $whenstring ) - 3600*24 );
	  $nextDay =     date("Y-m-d", noonObject( $whenstring ) + 3600*24 );
	  
	  echo "<a href='DayFill.php?theDate=$previousDay'>previous day</a> ";
	  echo "<a href='DayFill.php?theDate=$nextDay'>next day</a> <br />";

	  
      $q5 = "SELECT * from Booking, Task "
	       ." WHERE Booking.taskID=Task.taskID AND Booking.personID='$personID' AND Task.personID='$personID' "
		   ." AND startDate='$whenstring' "
		   ." ORDER BY startDate, startTime  "
           .";";
      $r5 = mysql_query( $q5 ) ;
  
      if ( noerror( $r5 ) )
	  {
		 //echo "<form method='POST' action='CalReview2.php' >\n";
		 //echo "<input type='hidden' name='theDate' value='$gotTheDate' \>\n";
	     $lastDate = "";
	     echo "<table border='2'>\n";
		 echo "<tr> ";
		 echo "<tr> <td colspan='7' style='text-align:center'> <b> Day Fill ";
		 if ($gotTheDate!="" ) { echo " for day = $gotTheDate "; }
		 echo " </b> </td></tr>\n";
		 echo "<td> date/time </td>\n";
		 echo "<td> description (click to edit) </td>\n";
		 //echo "<td> status </td>\n";
		 echo "</tr>\n";
		 
		 $filled = 0; // As we go through the day, this is the hour to which
		              // we have filled.  If the current event starts AFTER
					  // this, then we want to generate some forms to add events
	     $nr = mysql_num_rows( $r5 );
		 for ( $i=0; $i<$nr; $i++ )
		 {
		    $row = mysql_fetch_array( $r5 );
			$description = $row['description'];
			$descripsh = $row['descripsh'];
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
			
			// fill dead time to next event with 1-hour blocks
		    while ( $filled < $startTime )
			 {
				if ( $filled+1 < $startTime ) {  $nextie = $filled+1; }
				else                          {  $nextie = $startTime;  }
				//$nextie = 72;
				slotFill( $filled, $nextie, $whenstring );
				$filled = $nextie;
			
			 }
             $filled = $endTime;  // as we proceed to write the following event, we will
			                      // have filled through the end of it.  This is just
								  // prep for the next loop
	
	        if ($startDate != $lastDate ) 
			{ echo "<tr> <td colspan='2'> $startDate </td> </tr>\n";  $lastDate=$startDate; }
			echo "   <tr>\n";
			echo "      <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $startTime to $endTime </td>\n";
			echo "      <td> <a href='BookingEdit.php?bookingID=$bookingID'> $descripsh </a> </td>\n";
			//echo "      <td> ";
			
/*
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
*/
			//echo " </td>\n";
			echo "   </tr>\n";
		 }
	            // fill dead time to 2400 hrs with 1-hour blocks
		    while ( $filled < 24 )
			 {
				if ( $filled+1 < 24 ) {  $nextie = $filled+1; }
				else                          {  $nextie = 24;  }
				//$nextie = 72;
				slotFill( $filled, $nextie, $whenstring );
				$filled = $nextie;
			
			 }
             $filled = 24;  // as we proceed to write the following event, we will
			                      // have filled through the end of it.  This is just
								  // prep for the next loop

		 echo "<tr> <td colspan='3'> </td> </tr>\n";
		 echo "<table>\n";
		 //echo "</form>\n";

		 
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
<?php
   // echo a row in the table which is a form that allows the user to 
   // fill this time slot
   function slotFill( $startSlot, $endSlot, $whenstring )
   {
         $personID = $_SESSION['personID'];

      echo "<tr> <td> $startSlot to $endSlot </td>  ";
	  echo " <td>   ";
          echo "<form method='POST' action='BookingAdd2.php' >\n";
          echo "<input type='hidden' name='personID' value='$personID' />\n";
          echo "what: <input name='description' />,\n";
          echo " <input type='hidden' name='startDate' value='$whenstring' />\n";
          echo " <input type='hidden' name='endDate' value='$whenstring' />\n";
          echo "startTme: <input name='startTime' value='$startSlot' size='5' />,\n";
          echo "endTime: <input name='endTime' value='$endSlot' size='5' />,\n";
          mishChoices($personID, 0 );
          echo "<input type='submit' value='book it' />";
          echo "</form>";
          echo " </td>  ";
	  echo "</tr> \n";
   }
?>
