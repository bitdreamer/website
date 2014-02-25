<?php
   // oner.php
   // This one should copy Task.description to Booking.descripsh for 
   // matching bookings.

   global $bug;
   $bug = true;
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
   
   echo "<div>";
   converzhun( $personID );
   echo "</div>";
?>
</body>
</html>

<?php

   function converzhun( $personID )
   {
      global $bug;
	  echo "about to do copy from Task to Booking ..... <br /> \n";
      $q5 = "SELECT * from Booking, Task "
	       ." WHERE Booking.taskID=Task.taskID AND Booking.personID='$personID' AND Task.personID='$personID' "
		   ." ORDER BY startDate, startTime  "
           .";";
      $r5 = mysql_query( $q5 ) ;
  
      if ( noerror( $r5 ) )
	  {
	     $nr = mysql_num_rows( $r5 );
		 echo "number of records to do = $nr <br /> \n";
		 for ( $i=0; $i<$nr; $i++ )
		 {
		    $row = mysql_fetch_array( $r5 );
			$description = $row['description'];
			$bookingID = $row['bookingID'];
	
	        $q6 = "UPDATE Booking SET descripsh='$description' WHERE bookingID='$bookingID' && personID='$personID'; ";
			if ( $bug ) { echo "would have done query=$q6 <br />\n"; }
			else { $r6 = mysql_query( $q6 ); errorFree( $r6 ); }
		 }		 
	  }
   }
?>
