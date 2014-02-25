<?php
   // MishEdit2.php
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
   
   $personID     = $_POST['personID'];
   $mishID       = $_POST['mishID'];
   $category     = $_POST['category'];
   $subcat       = $_POST['subcat'];
   $importance   = $_POST['importance'];
   $frac         = $_POST['frac'];
   $aim          = $_POST['aim'];
   $mishOrder    = $_POST['mishOrder'];
   $usuallyat    = addslashes( $_POST['usuallyat']);
   
   if (   
           $personID!="" && $personID==addslashes($personID) 
        && $category!="" && $category==addslashes($category) 
        && $subcat  !="" && $subcat  ==addslashes($subcat) 
		&& 0 <= $importance && $importance <= 10
		&& -1 <= $aim && $aim <= +1
		&& -100000 <= $mishOrder && $mishOrder <= 100000

	   )
   {
      $qup = "UPDATE Mission "
	         ." SET category='$category' "
			 ." ,subcat='$subcat' "
			 ." ,importance='$importance' "
			 ." ,frac='$frac' "
			 ." ,aim='$aim' "
			 ." ,mishOrder='$mishOrder' "
			 ." ,usuallyat='$usuallyat' "
			 ." WHERE mishID='$mishID' AND personID='$personID' "
	         .";";
	  $rup = mysql_query( $qup );
	  errorFree( $rup );
	  header("Location: MissionList.php");
   }
?>

