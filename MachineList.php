<?php
   // 
   // This is the top for an admin page
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
         <?php machineList(); ?>  
		 <?php machineAdd(); ?>
      </p>
		</div>   <!-- end main -->

</body>
</html>
<?php
   function machineList()
   {
      $query = "SELECT * from Machine; ";
      $result = mysql_query( $query );
      if ( noerror( $result ) )
      {
	     echo "<table border='1'>\n";
		 echo "<td> name </td><td> ip </td><td> status </td>\n";
         $nr = mysql_num_rows( $result );
         for ( $i=0; $i<$nr; $i++ )
         {
            $row = mysql_fetch_array( $result );
            $name    = $row['name'];
            $ip      = $row['ip'];
            $status  = $row['status'];
            $comment = $row['comment'];
            $parts   = $row['parts'];
            $os      = $row['os']; 
            $createDate    = $row['createDate'];
			$retireDate = $row['retireDate'];
            $hd      = $row['hd'];
            $ram     = $row['ram'];
			echo "<tr>\n";
			echo "<td> <a href='MachineEdit.php?name=$name'> $name </a>  </td>\n";
			echo "<td> $ip </td>\n";
			echo "<td> $status </td>\n";
            //echo " $name $ip $status $comment $parts $os $createDate $hd $ram <br /> \n";
			echo "</tr>\n";
         }
		 echo "</table>\n";
      }
   }
   
   // puts up a form that lets the (admin) user add a machine name.
   // We just add the name at this point, then go to the MachineEdit page 
   // to do everything else.
   function machineAdd()
   {
      echo "<form action='MachineAdd.php' method='POST'>\n";
	  echo "machine name to add, no spaces ";
	  echo "<input name='name' id='name' >";
	  echo "<input type='submit' /> \n";
	  echo "</form>\n";
   }
?>