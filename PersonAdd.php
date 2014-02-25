<?php
   // PersonAdd.php
   // Form to add a person to the system.

   session_start();
   include("includeInAll.php");
   levelCheck(2); 
   include( "openDB.php" );
   openDB(1);
   //upCheck();
   include("leftMenu.php");
   include("shopHeader.php");
   include("tabledump.php");
?>


<html>
	<head>
	  <title> Person Add  </title> 
	  <link href="main.css" rel="stylesheet" type="text/css" /> 
	</head>
<body>
   <?php shopHeader(); leftMenu(); ?>
		
   <div id="main" >
      <p>
        <h3> Person Add </h3>
         <?php personAddForm(); ?>         
      </p>
   </div>   <!-- end main -->

</body>
</html>

<?php
   function personAddForm()
   {
echo "<h3> Add a person .... </h3>";
echo "    <form method='POST' action='PersonAdd2.php'>";   
echo "      personID: <input name='personID' /> <br /> \n";   
echo "      firstName: <input name='firstName' /> <br /> \n";   
echo "      lastName: <input name='lastName' /> <br /> \n";   
echo "      override name match: <input type='checkbox' name='matchOverride' /> \n";
echo "      <input type='submit' value='add this person' /> <br /> \n";
echo "    </form> <br /> \n ";   
echo "Make up a personID.  If it's a duplicate, you'll get to try again. <br /> \n";
   }
?>