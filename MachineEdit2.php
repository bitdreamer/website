<?php
   // MachineEdit2.php
   // processes machine edits
   session_start();
   include("includeInAll.php");
   levelCheck(3);
   include( "openDB.php" );
   openDB(1);
   //include("leftMenu.php");
   //include("shopHeader.php");
   //include("tabledump.php");
   
   $bug = true;
   
	$name    = $_POST['mname'] ;
	$ip      = addslashes( $_POST['ip'] );
	$status  = addslashes( $_POST['status'] );
	$comment = addslashes( $_POST['comment'] );
	$parts   = addslashes( $_POST['parts'] );
	$os      = addslashes( $_POST['os'] ); 
	$createDate    = addslashes( $_POST['createDate']) ;
	$retireDate    = addslashes( $_POST['retireDate']);
	$hd      = $_POST['hd'];
	$ram     = $_POST['ram'];
	$builtBy = addslashes( $_POST['builtBy'] );

    if ( $name!="" && $name == addslashes($name)
	     && $ip>0 && $ip<255
		 
	)
	{
	   $q = "UPDATE Machine set "
	       ." ip='$ip' "
	       ." ,status='$status' "
	       ." ,comment='$comment' "
	       ." ,parts='$parts' "
	       ." ,os='$os' "
	       ." ,createDate='$createDate' "
	       ." ,retireDate='$retireDate' "
	       ." ,hd='$hd' "
	       ." ,ram='$ram' "
	       ." ,builtBy='$builtBy' "
		   ." WHERE name='$name' "
	       .";";
		   
		if ( $bug ) { echo "about to do query = $q <br /> "; }
		$r = mysql_query( $q );
		errorFree($r);
	}
	
	header("Location: MachineList.php");
?>


