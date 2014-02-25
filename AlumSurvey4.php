<?php
   session_start();
   include("includeInAll.php");
   levelCheck(2); // must be at least alum-admin level to see other alums
   include( "openDB.php" );
   openDB(1);
   //upCheck();
   include("leftMenu.php");
   include("shopHeader.php");
   include("tabledump.php");
   
?>
<script type="text/javascript" src="errorHandler.js"> </script>

<html>
	<head>
	  <title> Alum Survey results  </title> 
	  <link href="main.css" rel="stylesheet" type="text/css" /> 
	</head>
<body>
   <?php shopHeader(); leftMenu(); ?>
		
   <div id="main" >
      <p>
        <h3>  Alum Survey results</h3>
<?php
   $qall = "SELECT fullName, jobTitle, employer, skillUse, merePrep FROM AlumSurvey2013;";
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
