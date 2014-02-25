<?php
   // Callendar.php

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
   
   echo " <a href='Calendar.php?startDate=2001-01-01'> show all </a> \n";
   echo "<div>";
   showBookings( $personID );
   echo "</div>";
?>
</body>
</html>

<?php

   function showBookings( $personID )
   {
      date_default_timezone_set("America/New_York");	  
	  $now = getdate(); // associative array with date and time info
	  $nowdate = $now['year']."-".$now['mon']."-".$now['mday'];
      $whenstring = " AND startDate>='$nowdate' ";
	  // now do a $_GET for the startDate, and if there is one, use that instead.
	  $gotStartDate = $_GET['startDate'];
	  if ( $gotStartDate != "" && $gotStartDate == addslashes($gotStartDate) )
	  {
	     $whenstring = " AND startDate>='$gotStartDate'";
	  }
	  $gotEndDate = $_GET['endDate'];
	  if ( $gotEndDate != "" && $gotEndDate == addslashes($gotEndDate) )
	  {
	     $whenstring .= " AND startDate<='$gotEndDate'";
	  }
	  
	  if ($gotStartDate!="")
	  {
	     $todayObj = noonObject( $gotStartDate );
		 $tomorrowObj = $todayObj + 24 * 3600; 
		 $tom = getdate($tomorrowObj); // associative array with date and time info
	     $tomString = $tom['year']."-".$tom['mon']."-".$tom['mday'];
         echo " <a href='Calendar.php?startDate=$tomString&endDate=$tomString'> next day </a >, \n";
		 $yesterObj = $todayObj - 24 * 3600; 
		 $yest = getdate($yesterObj); // associative array with date and time info
	     $yestString = $yest['year']."-".$yest['mon']."-".$yest['mday'];
         echo " <a href='Calendar.php?startDate=$yestString&endDate=$yestString'> previous day </a >, \n";
	  }
	  
      $q5 = "SELECT * from Booking, Task "
	       ." WHERE Booking.taskID=Task.taskID AND Booking.personID='$personID' AND Task.personID='$personID' "
		   ." AND status<'3' "
		   .$whenstring 
		   ." ORDER BY startDate, startTime  "
           .";";
      $r5 = mysql_query( $q5 ) ;
  
      if ( noerror( $r5 ) )
	  {
	     $lastDate = "";
	     echo "<table border='2'>\n";
		 echo "<tr> ";
		 echo "<tr> <td colspan='7' style='text-align:center'> <b> Calendar </b> </td></tr>\n";
		 echo "<td> date/time </td>\n";
		 echo "<td> description (click to edit) </td>\n";
		 echo "</tr>\n";
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
	
	        if ($startDate != $lastDate )
			{
			   echo "<tr> <td colspan='2'> $startDate ";
	           $parts = preg_split('[-]',$startDate); // split the start date into 3 parts 
	           $dap = mktime( 12, 0, 0, $parts[1], $parts[2], $parts[0] );  // make time object (int)
			   $dinfo = getdate($dap);
			   $weekday = $dinfo['weekday'];
	           echo " $weekday ";

			   echo " </td> </tr>\n";  $lastDate=$startDate;
			   
			}
			echo "   <tr>\n";
			echo "      <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $startTime to $endTime </td>\n";
			echo "      <td> <a href='BookingEdit.php?bookingID=$bookingID'> $descripsh </a> </td>\n";
			echo "<td>\n";
			if ( $status==1 ) { echo "done";  }
			else if ( $status==2 ) { echo "logged";}
			else if ( $status==3 ) { echo "awol";}
			echo "</td>\n";

			echo "   </tr>\n";
		 }
		 echo " </table>\n ";
	  }
   }
?>
