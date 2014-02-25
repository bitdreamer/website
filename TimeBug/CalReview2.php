<?php
   // CalReview2.php
   // Process calendar review for one day.   
   // POST has a whole list of stuff in it, potentially, starting with 'theDate'. ??
   // This thing is supposed to pull ALL un-reviewed bookings up until now.

   global $bug;
   $bug = false;
   session_start();
   include("../includeInAll.php");
   levelCheck(1); // only me while I'm coding
   include( "openDB.php" );
   openDB();
   //upCheck();
   //include("leftMenu.php");
  // include("shopHeader.php");
  // include("../tabledump.php");

   if ( $bug) 
   {
      echo "<html>\n";
	  echo "<head>\n";
	  echo "<script type='text/javascript' scr='errorHandler.js' > </script>\n";
	  echo "</head>\n";
	  echo "<body>";
   }

   if ($bug) { echo "entering the CalReview2 processing page .... <br /> \n";}
   $personID = $_SESSION['personID'];
   //shopHeader( $personID );
   //leftMenu();
   
   //echo " <a href='Calendar.php?startDate=2001-01-01'> show all </a> \n";
   if ($bug) { echo "<div>"; }
   dayForReview( $personID );
   if ($bug) { echo "</div>"; }

   header("Location: Calendar.php");
   
   if ($bug)
   {
      echo "<a href='Calendar.php'> back to Calendar .... </a>\n";
      echo "</body>\n";
      echo "</html>\n";
   }
   

   function dayForReview( $personID )
   {
      global $bug;
	  
      date_default_timezone_set("America/New_York");	  
	  $now = getdate(); // associative array with date and time info
	  $nowdate = $now['year']."-".$now['mon']."-".$now['mday'];
      $whenstring = ""; // " AND startDate>='$nowdate' ";
	  // now do a $_GET for the startDate, and if there is one, use that instead.
	  
	  $gotTheDate = $_POST['theDate'];
	  //$gotTheDate = $_GET['theDate'];
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
	     // go through the bookings of the day, see if the incoming POST set
		 // has changes to status (that's all we're looking for on this one).
		 // If so, do SQL to update.
	     $nr = mysql_num_rows( $r5 );
		 for ( $i=0; $i<$nr; $i++ )
		 {
		    $row = mysql_fetch_array( $r5 );
			$bookingID = $row['bookingID'];
			$status = $row['status'];
			$recurs = $row['recurs'];
			$inputName = "status".$bookingID;
			$newStatus = $_POST[$inputName];
			$t4bname = "t4b".$bookingID;
			$taskID = $_POST[$t4bname];
			$tiedname = "tied".$bookingID;
			$tied = $_POST[tiedname];
			
			
			if ($bug) { echo "t4bname=$t4bname, POST value for same = $taskID (should be taskID) <br /> \n"; }
			if ($bug) { echo "tiedname=$tiedname, POST value for same = $tied (should be Task.tied) <br /> \n"; }
			if ( $status != $newStatus )
			{
			   $qfix2 = "";
			   if ( $newStatus==0 || $newStatus==2 ) // "no info", or "logged"
			   {
			      $qfix = "UPDATE Booking SET status='$newStatus' WHERE personID='$personID' AND bookingID='$bookingID'; ";
			   }
			   else if ( $newStatus==1 ) // "done", also mark task done
			   {
			      $qfix = "UPDATE Booking SET status='$newStatus' WHERE personID='$personID' AND bookingID='$bookingID'; ";
				  $qfix2 = " UPDATE Task SET tstatus='1' WHERE personID='$personID' AND taskID='$taskID'; ";
			   }
			   else if ( $newStatus==3 ) // awol, just record for now, but may want to delete in the future
			   {
			      $qfix = "UPDATE Booking SET status='$newStatus' WHERE personID='$personID' AND bookingID='$bookingID'; ";
			   }
			   else if ( $newStatus==4 ) // delete, delete the booking.  Also, if the task is
			   // 'tied' to this booking (was made for the booking), then delete it too.
			   // AND finally, if the task is marked booked and not recurring (and not tied),
			   // then set the task status back to unbooked/not done.  We can't do this for
               // recurring tasks because we don't know that this was the only booking for
               // getting it done.  Also note that if the task is already done, then this
               // booking is extra and should just be deleted without affecting the task 
			   // status.			   
			   {
			      $qfix = "DELETE FROM Booking WHERE personID='$personID' AND bookingID='$bookingID'; ";
				  if ( $tied == 1 )
				  {
				     $qfix2 = " DELETE FROM Task WHERE personID='$personID' AND taskID='$taskID'; ";
				  }
				  else if ( $recurs==0 && $status=='2' ) // not tied
				  {
				     $qfix2 = " UPDATE Task SET status='0' WHERE personID='$personID' AND taskID='$taskID'; ";
				  }
			   }
			   if ($bug) { echo "SQL: $qfix  / $qfix2 <br />\n"; }	
               $rfix = mysql_query( $qfix );
               errorFree( $rfix );	
               if ($qfix2!="")
               {			   
                  $rfix2 = mysql_query( $qfix2 );
                  errorFree( $rfix2 );	
               }			   
			}
		 }
	  }
   }
?>
