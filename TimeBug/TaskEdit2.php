<?php
   // TaskEdit2.php
   // processing for task add form

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
   
   $personID    = $_POST['personID'];
   $taskID      = $_POST['taskID'];
   $mishID      = $_POST['mishID'];
   $description = addslashes( $_POST['description'] );
   $details     = addslashes( $_POST['details'] );
   $duration    = $_POST['duration'];
   $recurs      = $_POST['recurs'];
   $earliest    = $_POST['earliest'];
   $latest      = $_POST['latest'];
   $mustdo      = $_POST['mustdo'];
   $tstatus     = $_POST['tstatus'];
   $tied        = $_POST['tied'];

   if ( 
           $personID!="" && $taskID!="" 
		&& 0 <= $duration && $duration <= 10000
		&& 0 <= $recurs && $recurs <= 10000
		&& -1 <= $mustdo && $mustdo <= 10
	  )
   {
      $qup = "UPDATE Task "
	         ." SET mishID='$mishID' "
			 ." ,description='$description' "
			 ." ,details='$details' "
			 ." ,duration='$duration' "
			 ." ,recurs='$recurs' "
			 ." ,earliest='$earliest' "
			 ." ,latest='$latest' "
			 ." ,mustdo='$mustdo' "
			 ." ,tstatus='$tstatus' "
			 ." ,tied='$tied' "
			 ." WHERE taskID='$taskID' AND personID='$personID' "
	         .";";
	  $rup = mysql_query( $qup );
	  errorFree( $rup );
	  header("Location: TaskList.php");
   }
?>

