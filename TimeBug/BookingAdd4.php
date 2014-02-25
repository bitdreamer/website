<?php
   // BookingAdd4.php
   // $_GET has the taskID. 
   // This is for adding multiple events.
   // OK, so.  The earliest and latest (dates) should come from the task.  These will
   // be defaults for startDate and endDate, but user can modify in booking.
   // Form also includes spaces to set time.  Note: this assumes that each event occurs
   // on a single day, and so the endDate is used a little differently.  OK.
   // We will ask for day of the week, all 7 (numbered 0-6 to match PHP-time protocols).
   //  
   

   global $bug;
   $bug = true;
   session_start();
   include("../includeInAll.php");
   levelCheck(1); // only me while I'm coding
   include( "openDB.php" );
   openDB();
   //upCheck();
   include("leftMenu.php");
   include("shopHeader.php");
   include("../tabledump.php");
   include("functions.php");
   
   $personID = $_SESSION['personID'];
   $taskID = $_GET['taskID']; 
   
   // add anything you need from Task to the POST array 
      
?>
<html>
<head>
<script type="text/javascript" src="errorHandler.js"> </script>
</head>
<body>
   <?php shopHeader( $personID );  leftmenu(); ?> 
   <h2> book an existing task that repeats </h2>
   
   
   <?php  
      if ( $personID!="" && $taskID>=0 && $taskID<1000000 )
	  {
         showTask( $personID, $taskID ); 
      }
   
   ?>
</body>
</html>


<?php 

   function showTask( $personID, $taskID )
   {
      if ( $taskID=="" || $taskID<0 || $taskID>1000000 )
      { echo "invalid taskID "; exit; }
   
      // get the current values for this task
      $qfill = "SELECT * FROM Task WHERE personID='$personID' AND taskID='$taskID';";
	  $rfill = mysql_query( $qfill );
	  if ( noerror( $rfill ) )
	  {
	     $row = mysql_fetch_array( $rfill );
		 $description   = stripslashes( $row['description']);
		 $duration      = $row['duration'];
		 $mishID        = $row['mishID'];
		 $recurs        = $row['recurs'];
		 $earliest      = $row['earliest'];
		 $latest        = $row['latest'];
		 $mustdo        = $row['mustdo'];
		 $tstatus       = $row['tstatus'];
		 $tied          = $row['tied']; 
		 
		 echo "<table border='2'>\n";
		 echo "<tr> <td colspan='2'> Task information: <a href='TaskEdit.php?taskID=$taskID'> edit </a> </td> </tr> \n";
		 echo "<tr> <td> description</td> <td> $description </td> </tr> \n";
		 echo "<tr> <td> duration</td> <td> $duration </td> </tr> \n";
		 echo "<tr> <td> mishID</td> <td> $mishID </td> </tr> \n";
		 echo "<tr> <td> recurs </td> <td> $recurs </td> </tr> \n";
		 echo "<tr> <td> earliest</td> <td> $earliest ";
		 if ( $earliest=="0000-00-00") {echo "you really should go to task edit and fill this in."; }
		 echo " </td> </tr> \n";
		 echo "<tr> <td> latest </td> <td> $latest ";
		 if ( $latest=="0000-00-00") {echo "you really should go to task edit and fill this in."; }
		 echo " </td> </tr> \n";
		 echo "<tr> <td> mustdo </td> <td> $mustdo </td> </tr> \n";
		 echo "</table>\n";

		 echo "<table border='1'>\n";
		 echo "<form method='POST' action='BookingAdd6.php' >\n";
		 echo "<input type='hidden' name='taskID' value='$taskID' >\n";
		 echo "<tr> <td> descripsh</td> <td> "
		    ." <input name='descripsh' value='$description' /></td>  <td> </td> </tr>\n";
		 echo "<tr> <td> startDate </td> <td> <input name='startDate' value='$earliest' /> </td> <td> explanation </td> </tr>";
		 echo "<tr> <td> endDate </td> <td> <input name='endDate' value='$latest' /> </td> <td> explanation </td> </tr>";
		 echo "<tr> <td> startTime </td> <td> <input name='startTime' /> </td> <td> explanation </td> </tr>";
		 echo "<tr> <td> endTime </td> <td> <input name='endTime' /> </td> <td> explanation </td> </tr>";
		 echo "<tr> <td> days of the week </td> <td>";
		 echo " S <input type='checkbox' name='day0' > | ";
		 echo " M <input type='checkbox' name='day1' > | ";
		 echo " T <input type='checkbox' name='day2' > | ";
		 echo " W <input type='checkbox' name='day3' > | ";
		 echo " H <input type='checkbox' name='day4' > | ";
		 echo " F <input type='checkbox' name='day5' > | ";
		 echo " S <input type='checkbox' name='day6' > | ";
		 echo "</td> </tr>\n";
		 echo "<tr> <td colspan='3'> <input type='submit' value='submit' /> </td>  </tr>";
		 echo "</form>\n";
		 echo "</table>\n";
	  }
   }
?>
