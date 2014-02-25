<?php
   // ProbeAdd2.php
   // $_POST should have probeName and subject.
   // Determine next id , probeDate is today, available is 0.

   $bug = false;
   session_start();
   include("includeInAll.php");
   levelCheck(2); 
   include( "openDB.php" );
   openDB(1);
   //upCheck();
   include("leftMenu.php");
   include("shopHeader.php");
   include("tabledump.php");
?>
<?php    
   $personID = $_SESSION['personID'];
   $probeName = $_POST['probeName'];  
   $subject  = $_POST['subject'];
?>
<?php
   $probeID = 1 + maxID( "Probe", "probeID" );
   
   date_default_timezone_set('America/New_York');
   $now = time(); // this is a timestamp for right now
   $nowstring = date("Y-m-d", $now );

   if ($probeName!="" ) 
   {
      $qadd = "INSERT INTO Probe SET "
                  ."  probeName='$probeName' "
                  ." ,probeID='$probeID' "
				  ." ,subject='$subject' "
				  ." ,available='0' "
				  ." ,probeDate='$nowstring' "
                  ." ,creator='$personID'"
                  .";";
      if (!$bug) { $radd = mysql_query( $qadd ); errorFree($radd); }
      else
      { echo "would have done query=$qadd <br /> \n"; }
      
   }
   header("Location: ProbeList.php");
   echo "<a href='ProbeList.php' > back to the probe list </a> <br /> \n";
?>      
         
<?php
   function maxID( $table, $field)
   {
      $q = "SELECT MAX($field) from $table ;";
	  $r = mysql_query( $q );
	  if ( errorFree($r) )
	  {
	     $row = mysql_fetch_array( $r );
		 $max = $row[0];
	  }
	  return $max;
   }
?>
