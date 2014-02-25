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
            $name    = $row['name'];
            $ip      = $row['ip'];
            $status  = $row['status'];
            $comment = $row['comment'];
            $parts   = $row['parts'];
            $os      = $row['os']; 
            $createDate    = $row['createDate'];
            $hd      = $row['hd'];
            $ram     = $row['ram'];
            echo " $name $ip $status $comment $parts $os $year $hd $ram <br /> \n";
		
          echo "<table border='1' >\n";		
		  echo "  <form action='MachineEdit2.php' method='POST' >";
		  echo "name: $name <br />\n";
		  echo "ip : <input name='ip' value='$ip' /> <br /> \n";
		  echo "status : <input name='status' value='$status' /> <br /> \n";
		  echo "comment : <input name='comment' value='$comment' /> <br /> \n";
		  echo "parts : <input name='parts' value='$parts' /> <br /> \n";
		  echo "os : <input name='os' value='$os' /> <br /> \n";
		  echo "createDate : <input name='createDate' value='$createDate' /> <br /> \n";
		  echo "hd : <input name='hd' value='$hd' /> <br /> \n";
		  echo "ram : <input name='ram' value='$ram' /> <br /> \n";
		  echo "<input type='submit' value='submit' />\n";
		  echo "  </form>";
          echo "</table> \n";
      }
   }
?>