<?php

/* logger8Logout.php
This page logs the user out.  
*/
   session_start();
   global $bug;
   $_SESSION['loginok'] = "no";
   $_SESSION['level'] = 0;
   $_SESSION['customerID'] = "";
   $_SESSION['debug'] = "no";
   $_SESSION['tempid']="no";
   
   include("includeInAll.php");
   include("shopHeader.php");
   $bug = false;
?>
<html>
	<head>
	  <title> Gaia Conceptions - Logout </title> 
	  <link href="main2.css" rel="stylesheet" type="text/css" />
	</head>
<body>
   <div id="containerBlank">
   <div id="main">
      <?php shopHeader();  ?>
      <p> You have logged out of 
         <b><a href="http://www.gaiaconceptions.com"> GaiaConceptions.com </a> </b> .  <br />
         We hope you will return again soon.
      </p>
   </div> <!-- end main -->
   </div> <!-- end containerBlank -->
</body>
</html>
