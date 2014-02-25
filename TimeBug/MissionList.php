<?php
   // MissionList.php
   // This shows all of the Mission items.  Mission is the budget,
   // what we PLAN to spend time on.

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
   
   echo "<div>";
   showMish( $personID );
   sumFrac( $personID );
   echo "</div>";
?>
</body>
</html>

<?php

   function showMish( $personID )
   {
      $q5 = "SELECT * from Mission "
	       ." WHERE personID='$personID' "
		   ." ORDER BY mishOrder "
           .";";
      $r5 = mysql_query( $q5 ) ;
  
      if ( noerror( $r5 ) )
	  {
	     echo "<table border='2'>\n";
		 echo "<tr> <td colspan='6' style='text-align:center'> <b> Mission </b> </td> </tr>\n";
		 echo "<tr> <td> cat / subcat </td><td> frac </td><td> order  </td> ";
		 echo " <td> importance </td> <td> aim </td> <td> usually at </td> </tr>";
	     $nr = mysql_num_rows( $r5 );
		 $lastcat = "";
		 for ( $i=0; $i<$nr; $i++ )
		 {
		    $row = mysql_fetch_array($r5);
			$mishID = $row['mishID'];
			$category = $row['category'];
			$subcat = $row['subcat'];
			$importance = $row['importance'];
			$frac = $row['frac'];
			$aim = $row['aim'];
			$personID = $row['personID'];
			$mishOrder = $row['mishOrder'];
			$usuallyat = $row['usuallyat'];
			
			if ( $lastcat != $category )
			{
			   echo "<tr> <td colspan='6'>  $category </td> </tr>\n";
			   $lastcat = $category;
			}

			echo "<tr>\n";
			echo " <td> <a href='MishEdit.php?mishID=$mishID'> &nbsp; &nbsp; &nbsp; &nbsp; $subcat </a> </td> \n";
			echo "<td> $frac </td><td> $mishOrder </td>";
		    echo " <td> $importance </td> <td> $aim </td>";
			echo " <td> $usuallyat </td>\n";
			echo "</tr>\n";
		 }
		 //echo "<tr> <td> <a href='MishAdd.php'> add </a> </td></tr>\n";
		 echo "</table>\n";
	     //tabledump( $r5 );
	  }
   }
?>

</html>
<?php
   function sumFrac( $personID )
   {
      $qsum = "SELECT SUM(frac) as catsum, category from Mission WHERE personID='$personID' group by category; ";
	  $rsum = mysql_query( $qsum );
	  if ( noerror( $rsum ) )
	  {
		echo "<table border='2'>";
		echo "<tr> <td> category </td> <td> fraction </td> </tr>";
	    $nr = mysql_num_rows( $rsum );
		$sum = 0;
	    for ( $i=0; $i<$nr; $i++ )
		{
		   $row = mysql_fetch_array($rsum);
		   $category = $row['category'];
		   $catsum = $row['catsum'];
		   $sum += $catsum;
		   echo "<tr> <td> $category </td> <td> $catsum </td> </tr>";
		}
		echo "</table>";
		echo "total fraction of your time that is targeted = $sum <br /> ";
	  }
   }
?>
