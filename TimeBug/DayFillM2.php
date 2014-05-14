<?php
   //DayFillM2.php
   // processing for booking add form from DayFillM.php
   // $_POST has a bunch of stuff from the form ... persondID is regular. 
   // The other tag names are numbered descriptionSC, startDateSC, endDateSC,
   // startTimeSC, endTimeSC, mishIDSC, taskIDSC
   // where the 'SC' is numbers up to  $_POST['slotCount']-1.
   // We make the Bookings .
   // Also make the task if taskID==-1, else tie
   // Task to booking.  

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
   
   $slotCount = $_POST['slotCount'];
 	   $n1 = "personID";          $personID    =             $_POST[$n1];
   //echo "DayFillM2.php entering .... <br />\n";
   for ( $sc=0; $sc<$slotCount; $sc++ )
   {
       $n1 = "doit".$sc;   $doit = $_POST[$n1];
	   //echo "doit$sc = $doit <br /> \n";
	   if ( $doit=="yes" )
	   { 
		   //echo "just for testing, doit[$sc] = $doit <br /> \n";
		  //$sc = $_POST['sc']; // id number for THIS slot, all other names get this added
		   $n1 = "description".$sc;       $description = addslashes( $_POST[$n1] );
		   $n1 = "startDate".$sc;         $startDate   = addslashes( $_POST[$n1] );
		   $n1 = "startTime".$sc;         $startTime   = addslashes( $_POST[$n1] );
		   $n1 = "endDate".$sc;           $endDate     = addslashes( $_POST[$n1] );
		   $n1 = "endTime".$sc;           $endTime     = addslashes( $_POST[$n1] );
		   $n1 = "mishID".$sc;            $mishID      =             $_POST[$n1];
		   $n1 = "taskID".$sc;            $taskID      =             $_POST[$n1];
		   
		   if ($bug)
		   {
			  echo "DayFill2: hi there <br />\n"; 
			  echo "sc=$sc, ";
			  echo "personID=$personID, ";
			  echo "description=$description, ";
			  echo "startDate=$startDate, ";
			  echo "startTime=$startTime, ";
			  echo "endDate=$endDate, ";
			  echo "endTime=$endTime, ";
			  echo "mishID=$mishID, ";
			  echo "taskID=$taskID, ";
		   }
	   
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
			  if ( $taskID == -1 )
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
						 ." ,earliest='$startDate' "
						 ." ,latest='$endDate' "
						 ." ,mustdo='$mustdo' "
						 ." ,tied='1' "
						 ." ,tstatus='2' " // booked
						 .";";
				  if ($bug) { echo "would have done q=".$qadd;  }
				  else
				  { $radd = mysql_query( $qadd );
					errorFree( $radd );
				  }
			   }
			   else // task already exists, just mark it to show it's booked
			   {
				  $qmod = "UPDATE Task SET "
					   ."  tied='1' " // associated with a booking
					   ." ,tstatus='2' " // booked
					   ." WHERE personID='$personID' "
					   ." AND taskID='$taskID' "
					   .";";
				  if ($bug) { echo "would have done q=".$qmod;  }
				  else 
				  { $rmod = mysql_query( $qmod );
					 errorFree( $rmod );
				  }
					   
			   }
			  
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
			  if ($bug) { echo "would have done q=".$qbadd;  }
			  else
			  { $rbadd = mysql_query( $qbadd );
				  errorFree( $rbadd );
			  }
		   }

	   }
	}	  
    header("Location: DayFillM.php");

?>
