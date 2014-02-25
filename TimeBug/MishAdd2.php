<?php
   // MishAdd2.php
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
   $category = $_POST['category'];
   $subcat   = $_POST['subcat'];
   
   if (   
           $personID!="" && $personID==addslashes($personID) 
        && $category!="" && $category==addslashes($category) 
        && $subcat  !="" && $subcat  ==addslashes($subcat) 
	   )
   {
      $mishID = maxMishID( $personID ) + 1;
      $qadd = "INSERT INTO Mission "
	         ." SET mishID='$mishID' "
			 ." ,category='$category' "
			 ." ,subcat='$subcat' "
			 ." ,importance='5' "
			 ." ,frac='0.01' "
			 ." ,aim='0' "
			 ." ,personID='$personID' "
			 ." ,mishOrder='1000' "
	         .";";
	  $radd = mysql_query( $qadd );
	  errorFree( $radd );
	  //header("Location: MissionList.php");
	  header("Location: MishEdit.php?mishID=$mishID");
   }
?>
<?php
   function maxMishID( $personID )
   {
      $q = "SELECT MAX(mishID) from Mission WHERE personID='$personID';";
	  $r = mysql_query( $q );
	  if ( errorFree($r) )
	  {
	     $row = mysql_fetch_array( $r );
		 $max = $row[0];
	  }
	  return $max;
   }
?>
