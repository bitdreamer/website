<?php
   // MishAdd.php
   // puts up a form to let you enter a new mission item

   $bug = false;
   session_start();
   include("../includeInAll.php");
   levelCheck(1); // only me while I'm coding
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
   $personID = $_SESSION['personID'];
   shopHeader( $personID );
   leftMenu();
?>  
   <h2> add a new mission item:  </h2>
   <div>
      <form method="POST" action="MishAdd2.php">
	    <?php echo "<input type='hidden' name='personID' value='$personID' /> \n"; ?> <br />
		category: <input name="category" /> <br />
		subcat: <input name="subcat"/> <br />
		<input type="submit" value="add this item" />
	  </form>
	  <br /> <br />
	  <a href="MissionList.php"> cancel </a> 
     
   </div>

</body>
</html>

