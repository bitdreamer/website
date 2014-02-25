<?php
   // ProbeAdd.php
   // Form to add a probe (survey) to the system.

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
	  <title> Probe (Survey) Add  </title> 
	  <link href="main.css" rel="stylesheet" type="text/css" /> 
	</head>
<body>
   <?php shopHeader(); leftMenu(); ?>
		
   <div id="main" >
      <p>
        <h3> Probe (Survey) Add </h3>
         <?php probeAddForm(); ?>         
      </p>
   </div>   <!-- end main -->

</body>
</html>

<?php
   function probeAddForm()
   {
echo "<h3> Add a probe .... </h3>";
echo "    <form method='POST' action='ProbeAdd2.php'>";   
echo "      probeName: <input name='probeName' /> <br /> \n";   
echo "      subject: <input name='subject' /> <br /> \n";   
echo "      <input type='submit' value='add this probe' /> <br /> \n";
echo "    </form> <br /> \n ";   
   }
?>