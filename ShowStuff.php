<?php
   /* This page is to show groups of information snipets.  $_GET['topic'] 
   has the topic to go with.  
   */
   session_start();
   include("includeInAll.php");
   include( "openDB.php" );
   openDBlevel(1);
   include("leftMenu.php");
   include("shopHeader.php");
   include("tabledump.php");
?>

<html>
	<head>
	  <title> Bit Lab show stuff </title> 
	  <link href="main.css" rel="stylesheet" type="text/css" />
	</head>
<body>
   <?php shopHeader(); leftMenu(); ?>
		
      <div id="main">
      <p>
         Put stuff in here.  
      </p>
		</div>   <!-- end main -->

</body>
</html>

<?php
   function showThem()
   {
      $topic = "about"; // default
   }
?>