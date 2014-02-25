<?php
   // TaskDel.php
   // processing for task delete, expects taskID in GET

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
   
   $personID = $_SESSION['personID'];
   $taskID = $_GET['taskID'];
   $description = addslashes( $_POST['description'] );
   
   if ( $personID!="" && $taskID==addslashes($taskID)  )
   {
      $qdel = "DELETE FROM Task WHERE personID='$personID' AND taskID='$taskID';  ";
	  $rdel = mysql_query( $qdel );
	  errorFree( $rdel );
	  //header("Location: MissionList.php");
	  header("Location: TaskList.php");
   }
?>
<html>
<body>
You should not be seeing this.

</body>
</html>