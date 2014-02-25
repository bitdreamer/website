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
   $qall = "SELECT * FROM Survey WHERE eventCode='$eventCode';";
   $rall = mysql_query( $qall );
   if ( noerror( $rall ) )
   {
      tabledump( $rall );
   }
?>
      </p>
   </div>   <!-- end main -->

</body>
</html>
