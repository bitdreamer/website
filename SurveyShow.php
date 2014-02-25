<?php
   session_start();
   include("includeInAll.php");
   //levelCheck(2); // must be at least alum-admin level to see other alums
   include( "openDB.php" );
   openDB(1);
   //upCheck();
   include("leftMenu.php");
   include("shopHeader.php");
   include("tabledump.php");
   
   $eventCode = $_GET['eventCode'];
   if ( $eventCode != addslashes($eventCode) || $eventCode=="" ) { $eventCode = "dk"; }

?>
<script type="text/javascript" src="errorHandler.js"> </script>

<html>
	<head>
	  <title> Survey results  </title> 
	  <link href="main.css" rel="stylesheet" type="text/css" /> 
	</head>
<body>
   <?php shopHeader(); leftMenu(); ?>
		
   <div id="main" >
      <p>
        <h3>  Survey results for <?php echo "$eventCode"; ?> </h3>
<?php
   $qall = "SELECT * FROM Survey WHERE eventCode='$eventCode' ORDER BY reply DESC;";
   $rall = mysql_query( $qall );
   if ( noerror( $rall ) )
   {
      //echo "<table border='1'>\n";
	  $yesCount = 0;
	  $maybeCount = 0;
	  $noCount = 0;
      $nr = mysql_num_rows( $rall );
	  for ( $i=0; $i<$nr; $i++ )
	  {
	     $row = mysql_fetch_array( $rall );
		 $reply = $row['reply'];
		 if ( $reply=="yes" ) { $yesCount++; } 
		 else if ( $reply=="no" ) { $noCount++; }
		 else if ( $reply=="maybe" ) { $maybeCount++; }
	  }
	  echo "yes=$yesCount no=$noCount maybe=$maybeCount";
	  //echo "</table>\n";
      tabledump( $rall );
   }
?>
      </p>
   </div>   <!-- end main -->

</body>
</html>
