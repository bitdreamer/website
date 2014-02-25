<?php
   // TaskList.php

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
   showTasks( $personID );
   menuTaskByCat( $personID );
   echo "</div>";
?>
</body>
</html>

<?php

   function showTasks( $personID )
   {
      $category = $_GET['category'];
	  $filter = "";
	  if ( $category!="" && $category==addslashes($category) )
	  {
	     $filter = " AND category='$category' ";
	  }
   
      $q5 = "SELECT * from Task, Mission "
	       ." WHERE Task.personID='$personID' AND Mission.mishID=Task.mishID AND Mission.personID='$personID' "
		   ." AND tstatus='0' " 
		   ." AND tied='0' "
		   ." $filter " 
		   ." ORDER BY mustdo desc, latest  "
           .";";
      $r5 = mysql_query( $q5 ) ;
  
      if ( noerror( $r5 ) )
	  {
	     echo "<table border='2'>\n";
		 echo "<tr> ";
		 echo "<tr> <td colspan='7' style='text-align:center'> <b> Tasks </b> </td></tr>\n";
		 echo "<td> description </td><td> duration </td>\n";
		 echo "<td> recurs </td><td> mustdo </td>\n";
		 echo "<td> earliest / latest </td>\n";
		 echo "<td> category / subcat </td>\n";
		 echo "<td> action </td>\n";
		 echo "</tr>\n";
	     $nr = mysql_num_rows( $r5 );
		 for ( $i=0; $i<$nr; $i++ )
		 {
		    $row = mysql_fetch_array( $r5 );
			$taskID = $row['taskID'];
			$description = stripslashes( $row['description'] );
			$duration = $row['duration'];
			$recurs = $row['recurs'];
			$earliest = $row['earliest'];
			$latest = $row['latest'];
            $mustdo = $row['mustdo'];
            $category = $row['category'];
			$subcat = $row['subcat'];
			$mishID = $row['mishID'];
			
			echo "   <tr>\n";
			echo "      <td> <a href='TaskEdit.php?taskID=$taskID'> $description </a> </td>\n";
			echo "      <td> $duration </td>\n";
		    echo "      <td> $recurs </td><td> $mustdo</td>\n";
		    echo "      <td> $earliest / $latest</td>\n";
		    echo "      <td> $category / $subcat </td>\n";
			echo " <td>";
			if ( $recurs==0)
			{      //echo "      <td> <a href='BookingAdd3.php?taskID=$taskID'> book it </a> </td>\n";
			       bookItButton( $taskID, "3" );
			}
			else { // echo "      <td> <a href='BookingAdd4.php?taskID=$taskID'> book it </a> </td>\n";
			       bookItButton( $taskID, "4" );
			}
			echo "</td>\n";
			echo "   </tr>\n";
		 }
		 echo "<table>\n";
	     //tabledump( $r5 );
	  }
   }
?>

<?php
   function menuTaskByCat( $personID )
   {
      $qcat = "SELECT distinct category FROM Mission WHERE personID='$personID'; ";
	  $rcat = mysql_query( $qcat );
	  if ( noerror( $rcat ) )
	  {
	     echo "<table border='2'>\n";
		 echo "<tr> <td> list tasks by ....</td> </tr>\n";
	     $nr = mysql_num_rows( $rcat );
		 for ( $i=0; $i<$nr; $i++ )
		 {
		    $row = mysql_fetch_array( $rcat );
			$category = $row['category'];
			echo "<tr> <td> <a href='TaskList.php?category=$category'> $category  </a> </td> </tr> \n";
			
		 }
		 echo "</table>\n";
	  }
   }
?>
<?php
   // create a button that links to BookingAdd$which.php (either 3 or 4, 3 for singles, 4 for multi)
   // Do it in a POST form.
   function bookItButton( $taskID, $which )
   {
      echo "<a href='BookingAdd$which.php?taskID=$taskID'> book it </a>\n";
      //echo "<form method='POST' action='BookingAdd$which.php'>\n";
      //echo "   <input type='hidden' name='taskID' value='$taskID' />\n";
	  //echo "   <input type='submit' value='book it' >\n";
      //echo "</form>\n";
   }
?>
