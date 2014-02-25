<?php
   // TaskAdd2.php
   // processing for mission add form

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
   
   $personID = $_POST['personID'];
   $description = addslashes( $_POST['description'] );
   
   if ( $personID!="" && $description!="" )
   {
      $taskID = maxTaskID( $personID ) + 1;
      $qadd = "INSERT INTO Task "
	         ." SET taskID='$taskID' "
			 ." ,personID='$personID' "
			 ." ,description='$description' "
			 ." ,duration='1' "
			 ." ,recurs='0' "
			 ." ,mishID='0' "
			 ." ,earliest='' "
			 ." ,latest='' "
			 ." ,mustdo='5' "
			 ." ,details='' "
	         .";";
	  $radd = mysql_query( $qadd );
	  errorFree( $radd );
	  //header("Location: MissionList.php");
	  header("Location: TaskEdit.php?taskID=$taskID");
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
