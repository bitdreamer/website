<?php
   // MachineEdit.php
   // This page lets us enter information about machines.
   session_start();
   include("includeInAll.php");
   levelCheck(3);
   include( "openDB.php" );
   openDB(1);
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
         <?php machineForm(); ?>  
      </p>
		</div>   <!-- end main -->

</body>
</html>
<?php
   function machineForm()
   {
      $name = $_GET['name'];
      $query = "SELECT * from Machine where name='$name'; ";
      $result = mysql_query( $query );
      if ( noerror( $result ) )
      {
            $row = mysql_fetch_array( $result );
            //$name    = $row['name'];
            $ip      = $row['ip'];
            $status  = $row['status'];
            $comment = $row['comment'];
            $parts   = $row['parts'];
            $os      = $row['os']; 
            $createDate    = $row['createDate'];
			$retireDate    = $row['retireDate'];
            $hd      = $row['hd'];
            $ram     = $row['ram'];
			$builtBy = $row['builtBy'];
			$onNow   = $row['onNow'];
            //echo " $name $ip $status $comment $parts $os $year $hd $ram <br /> \n";
		
          echo "<table border='1' >\n";		
		  echo "  <form action='MachineEdit2.php' method='POST' >";
		  echo "name: $name <br />\n";
		  echo "<input type='hidden' name='mname' id='mname' value='$name' />";
		  echo "ip : <input name='ip' value='$ip' /> <br /> \n";
		  echo "status : <input name='status' value='$status' /> "
		     ." 0=non-existent 1=exists but hardware no power up, 2=power but no boot, "
			 ." 3=boot but flakey, 4=boot os solid,        5=with software<br /> \n";
		  echo "comment : <input name='comment' value='$comment' /> <br /> \n";
		  echo "parts : <input name='parts' value='$parts' /> <br /> \n";
		  echo "os : <input name='os' value='$os' /> <br /> \n";
		  echo "createDate : <input name='createDate' value='$createDate' /> <br /> \n";
		  echo "retireDate : <input name='retireDate' value='$retireDate' /> <br /> \n";
		  echo "hd : <input name='hd' value='$hd' /> <br /> \n";
		  echo "ram : <input name='ram' value='$ram' /> <br /> \n";
		  echo "builtBy : <input name='builtBy' value='$builtBy' /> <br /> \n";
		  echo "<input type='submit' value='submit' />\n";
		  echo "  </form>";
          echo "</table> \n";
      }
   }
?>