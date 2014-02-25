<?php
   // MishEdit.php
   // puts up a form to let you edit a mission item
   // Expects $mishID in GET

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
   
   
   $mishID = $_GET['mishID'];
   if ( $mishID != addslashes( $mishID ) ) { $mishID = 0; }
   
   if ( $personID != "" )
   {
      // get the current values for this mission item
      $qfill = "SELECT * FROM Mission WHERE personID='$personID' AND mishID='$mishID';";
	  $rfill = mysql_query( $qfill );
	  if ( noerror( $rfill ) )
	  {
	     $row = mysql_fetch_array( $rfill );
		 $category   = $row['category'];
		 $subcat     = $row['subcat'];
		 $importance = $row['importance'];
		 $frac       = $row['frac'];
		 $aim        = $row['aim'];
		 $mishOrder  = $row['mishOrder'];
		 $usuallyat  = stripslashes( $row['usuallyat'] );
	  }
	  
	  // put up a form letting the user change anything except the mishID (and personID)
	  echo "<table border='2'>\n";
	  echo "<tr> <td colspan='3'> <b>edit values for mission item with mishID=$mishID </b> </td></tr> \n";
	  echo "<form method='POST' action='MishEdit2.php'>\n";
	  echo "<input type='hidden' name='mishID' value='$mishID' />\n";
	  echo "<input type='hidden' name='personID' value='$personID' />\n";
	  echo "<tr> <td>category</td><td> <input name='category'   value='$category'   /></td>\n";
	  echo "   <td> like work or people, no special characters </td> </tr>\n";
	  echo "<tr> <td> subcat </td> <td><input name='subcat'     value='$subcat'     /> </td>\n";
	  echo "   <td> sub category, but not to specific events, no special characters </td> </tr>\n";
	  echo "<tr> <td> importance</td> <td> <input name='importance' value='$importance' /> </td>\n";
	  echo "   <td> 0 to 10, 10 is a must </td> </tr>\n";
	  echo "<tr><td> frac </td> <td> <input name='frac'       value='$frac'       /> </td>\n";
	  echo "   <td> fraction of your time to spend on this  </td> </tr>\n";
	  echo "<tr><td> aim </td><td> <input name='aim'        value='$aim'        /></td>\n";
	  echo "   <td> 0=aim for this amount, +1=aim for this or more, -1=this or less </td> </tr>\n";
	  echo "<tr><td>mishOrder </td><td> <input name='mishOrder'  value='$mishOrder'  /></td>\n";
	  echo "   <td> low is first </td> </tr>\n";
	  echo "<tr><td>usually at </td><td> <input name='usuallyat'  value='$usuallyat'  /></td>\n";
	  echo "   <td> home, school, leave blank if none </td> </tr>\n";
	  echo "<tr> <td colspan='3'><input type='submit' value='submit' /> </td> </tr>\n";
	  echo "</form>\n";
	  echo "</table>\n";
   }
?>  

</body>
</html>

