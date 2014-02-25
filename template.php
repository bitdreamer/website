<?php
   // This is the top for a customer page
   session_start();
   include("includeInAll.php");
   include( "openDB.php" );
   openDBlevel(1);
   include("leftMenu.php");
   include("shopHeader.php");
   include("tabledump.php");
?>

<?php
   // This is the top for an admin page
   session_start();
   include("includeInAll.php");
   levelCheck(3);
   include( "openDB.php" );
   openDBlevel(3);
   include("leftMenu.php");
   include("shopHeader.php");
   include("tabledump.php");
?>
<html>
	<head>
	  <title> Bit Lab  </title> 
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