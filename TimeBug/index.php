<?php
   // index.php

   $bug = false;
   session_start();
   include("../includeInAll.php");
   //levelCheck(1); // only me while I'm coding
   include( "openDB.php" );
   openDB();
   //upCheck();
   include("leftMenu.php");
   include("shopHeader.php");
   include("../tabledump.php");
?>
<html>
<head>
<script type="text/javascript" src="errorHandler.js"> </script>
</head>
<body>
<?php
  
   shopHeader( $personID );
   leftMenu();
   

?>
   <div>
      <p>  TimeBug is being developed by Barrett Koster as a calendar program.  Ask
	       Barrett for a login if you want to try it.
	  </p>
   </div>
</body>
</html>

