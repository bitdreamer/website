<?php
   // MachineAdd.php
   // processes machine add, just need the name
   session_start();
   include("includeInAll.php");
   levelCheck(3);
   include( "openDB.php" );
   openDB(1);
   //include("leftMenu.php");
   //include("shopHeader.php");
   //include("tabledump.php");
   
   $bug = false;
   
	$name    = $_POST['name'] ;

    if ( $name!="" && $name == addslashes($name)
		 
	)
    {
	   $qused = "SELECT * from Machine WHERE name='$name'; ";
	   $rused = mysql_query( $qused );
	   if ( isEmpty( $rused ) )
	   {
	
          $q = "INSERT INTO Machine set name='$name';"	;   
		  if ( $bug ) { echo "about to do query = $q <br /> "; }
		  $r = mysql_query( $q );
	      errorFree($r);
	   }
	}
	
	header("Location: MachineList.php");
?>


