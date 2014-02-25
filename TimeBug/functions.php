<?php
   // echos a combo box with all of the choices of mission (for this person).  
   // It will init to $selected if that matches on of the valid $mishIDs.
   global $mishResults; // list of missions, re-use rather than refetch if possible
   function mishChoices( $personID, $selected )
   {
      global $mishResults;
      $q = "SELECT category, subcat, importance, mishID FROM Mission WHERE personID='$personID' ORDER BY mishOrder; ";
	  if ( $mishResults==0 ) { $r = mysql_query( $q ); /* echo "first"; */ $mishResults = $r; }
	  else { $r = $mishResults; mysql_data_seek($r,0); /* echo "next"; */ }
	  if ( noerror( $r ) )
	  {
	     echo "<select name='mishID'>\n";
	     $nr = mysql_num_rows( $r );
		 for ( $i=0; $i<$nr; $i++ )
		 {
		    $row = mysql_fetch_array( $r );
			$category = $row['category'];
			$subcat   = $row['subcat'];
			$mishID   = $row['mishID'];
			$importance = $row['importance'];
			echo "<option id='' value='$mishID' onclick='fillImp($importance)' ";
			if ($mishID==$selected) { echo " SELECTED "; }
			echo " > $category / $subcat </option>\n";
		 }
		 echo "</select>\n";
	  }
   }
?>
<?php
   function maxTaskID( $personID )
   {
      $q = "SELECT MAX(taskID) from Task WHERE personID='$personID';";
	  $r = mysql_query( $q );
	  if ( errorFree($r) )
	  {
	     $row = mysql_fetch_array( $r );
		 $max = $row[0];
	  }
	  return $max;
   }
?>
<?php
   function maxBookingID( $personID )
   {
      $q = "SELECT MAX(bookingID) from Booking WHERE personID='$personID';";
	  $r = mysql_query( $q );
	  if ( errorFree($r) )
	  {
	     $row = mysql_fetch_array( $r );
		 $max = $row[0];
	  }
	  return $max;
   }
?>
