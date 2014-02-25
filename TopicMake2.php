<?php
   // TopicMake2.php
   // Barrett Koster .... 2011 Nov
   // This takes $_POST['name'] and creates a new Topic entry.
   // Then jump to TopicMake1.php for further edits.
   
   // Topic: name, code, desc, level, active, dept, sequence 
   
   // This is the top for an admin page
   $bug = false;
   session_start();
   include("includeInAll.php");
   levelCheck(2);
   include( "openDB.php" );
   openDB(1);
   include("leftMenu.php");
   include("shopHeader.php");
   include("tabledump.php");
   
   $name = addslashes( $_POST['name'] );
   if ( $name!="" )
   {
      $qmax = "SELECT MAX(code) from Topic;";
      $rmax = mysql_query( $qmax );
      if ( noerror( $rmax ) )
      {
         $row = mysql_fetch_array( $rmax );
         $code = $row[0] + 1;
      
         $qi = "INSERT INTO Topic SET "
               ."  name='$name'"
               ." ,code='$code' "
               ." ,blurb='' "
               ." ,level='5' "
               ." ,active='1' "
               ." ,dept='ALL' "
               ." ,sequence='10' "
               .";";
         $ri = mysql_query( $qi );
         errorCheck( $ri );
         header("Location: TopicMake1.php?code=$code");
      }
   }
?>
<html>
	<head>
	  <title> Bit Lab Make Topic 2 </title> 
	  <link href="main.css" rel="stylesheet" type="text/css" />
	</head>
<body>
   <?php shopHeader(); leftMenu(); ?>
		
      <div id="main">
      <p>  You are either debugging or something went wrong.  
      <?php   if ($bug) { echo " ... just did query=$qi <br />";} ?>
      </p>
		</div>   <!-- end main -->

</body>
</html>

