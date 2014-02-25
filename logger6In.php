<?php
   //  
   session_start();
   include("includeInAll.php");
   //levelCheck(1);
   include( "openDB.php" );
   openDB(1);
   include("leftMenu.php");   
   include("shopHeader.php");
   include("tabledump.php");
?>
<html>
	<head>
	  <title> Bit Lab - Login Success </title> 
	  <link href="main.css" rel="stylesheet" type="text/css" />
	</head>
<body>
   <?php shopHeader(); leftMenu(); ?>
		
      <div id="main">
      <p>
       <h2> Login confirmation  </h2> 
              If you see this, you have successfully logged in.
              Welcome back  
              <?php echo  $_SESSION['firstName'] ." <br /> \n"; ?>
              If you were in the middle of something, sorry, we didn't catch it,
              just use the pointers <br /> at the left to get back to it.  Thanks.
      </p>
<?php
   if ($_SESSION['debug']=="yes")
   {
      echo "Your login level is set to ".$_SESSION['level']." <br />";
      echo "dollar bug is set to $bug <br />";
   }
?>
		</div>   <!-- end main -->

</body>
</html>
