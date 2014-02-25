<?php
   // TaskEdit.php
   // puts up a form to let you edit a task
   // Expects $taskID in GET

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
   include("functions.php");
?>
<html>
<head>
<script type="text/javascript" src="../errorHandler.js"> </script>
</head>
<body>
<?php
   $personID = $_SESSION['personID'];
   shopHeader( $personID );
   leftMenu();
   
   
   $taskID = $_GET['taskID'];
   if ( $taskID != addslashes( $taskID ) ) { $taskID = 0; }
   
   if ( $personID != "" )
   {
      // get the current values for this task
      $qfill = "SELECT * FROM Task WHERE personID='$personID' AND taskID='$taskID';";
	  $rfill = mysql_query( $qfill );
	  if ( noerror( $rfill ) )
	  {
	     $row = mysql_fetch_array( $rfill );
		 $description   = stripslashes( $row['description']);
		 $duration      = $row['duration'];
		 $details       = $row['details'];
		 $mishID        = $row['mishID'];
		 $recurs        = $row['recurs'];
		 $earliest      = $row['earliest'];
		 $latest        = $row['latest'];
		 $mustdo        = $row['mustdo'];
		 $tstatus       = $row['tstatus'];
		 $tied          = $row['tied'];
	  }
	  // put up a form letting the user change anything except the taskID (and personID)
	  echo "<table border='2'>\n";
	  echo "<tr> <td colspan='3'> <b>edit values for task with taskID=$taskID </b> </td></tr> \n";
	  echo "<form method='POST' action='TaskEdit2.php' name='theform' id='theform'>\n";
	  echo "<input type='hidden' name='taskID' value='$taskID' />\n";
	  echo "<input type='hidden' name='personID' value='$personID' />\n";
	  
	  echo "<tr> <td>title</td><td> <input name='description'   value='$description'   /></td>\n";
	  echo "   <td> moniker for this task </td> </tr>\n";

	  echo "<tr> <td>details</td><td> ";
      echo " <textarea name='details'  rows='4'  cols='50'   /> $details </textarea> ";
	  echo " </td>\n";
	  echo "   <td> everything else about what this task entails </td> </tr>\n";


	  echo "<tr> <td> duration </td> <td><input name='duration'     value='$duration'     /> </td>\n";
	  echo "   <td> time in hours.  This is for ONE time if it's a reapeating task. </td> </tr>\n";
	  echo "<tr> <td>recurs </td> <td> <input name='recurs' value='$recurs' /> </td>\n";
	  echo "   <td> 0 if one time, interval in days if recurring </td> </tr>\n";
	  echo "<tr><td> earliest </td> <td> <input name='earliest'       value='$earliest'       /> </td>\n";
	  echo "   <td> starting date to do it, or start of series ";
	  echo "        <input type='button' onclick='setToday();' value='today' \> </td> </tr>\n";
	  echo "<tr><td> latest </td><td> <input name='latest'        value='$latest'        /></td>\n";
	  echo "   <td> deadline or last day to do it ";
	  echo "        <input type='button' value='tomorrow' onclick='setTomorrow();' \>";
	  echo "   </td> </tr>\n";
	  echo "<tr><td> mission </td><td> ";
	  mishChoices( $personID, $mishID );
	  echo " </td>\n";
	  echo "   <td> the mission this task is helping </td> </tr>\n";
	  echo "<tr><td> mustdo </td><td> <input name='mustdo'  value='$mustdo' id='mustdo'  /></td>\n";
	  echo "   <td> 0-10 with 10 must do </td> </tr>\n";
	  
	  echo "<tr><td> tstatus </td><td> <input name='tstatus'  value='$tstatus' id='tstatus'  /></td>\n";
	  echo "   <td> 0=not done, 1=done, 2=booked, 3=abandoned (as close as we get to delete), and note: "
           ." most of these should be done through booking review below	  </td> </tr>\n";

	  echo "<tr><td> tied </td><td> <input name='tied'  value='$tied' id='tied'  /></td>\n";
	  echo "   <td> 0=no, 1=yes tied to booking </td> </tr>\n";
	  
	  if ( $_SESSION['userLevel']=='1' )
	  {
	     echo "<tr> <td> debug </td> <td> <input type='checkbox' name='bugger' /> </td> "
		     ." <td> not connected yet </td> </tr>\n";
	  }
	  
	  echo "<tr> <td colspan='3'><input type='submit' value='submit' /> </td> </tr>\n";
	  echo "</form>\n";
	  echo "</table>\n";
	  
	  showBookings4( $personID, $taskID );
   }
?>  

</body>
</html>
<script>
   function fillImp( much )
   {
      //alert("how about slot.value .... "+much+"?"); verifies that the function is getting called 
	  //    and the number 'much' is coming through
	  
	  var slock = document.getElementById("mustdo");
	  slock.value = much; // doesn't work
   }
</script>
<?php
   // shows all of the bookings scheduled to perform the given task
   function showBookings4( $personID, $taskID )
   {
      $q = "SELECT * FROM Booking WHERE personID='$personID' AND taskID='$taskID'; ";
	  $r = mysql_query( $q );
	  if ( errorFree($r) )
	  {
	     echo "bookings: ";
	     $nr = mysql_num_rows($r);
		 for ( $i=0; $i<$nr; $i++ )
		 {
		    $row = mysql_fetch_array( $r );
			$bookingID = $row['bookingID'];
			$startDate = $row['startDate'];
			echo " <a href='CalReview.php?theDate=$startDate'> bookingID=$bookingID on $startDate  </a> , ";
		 }
	  }
   }
?>
<script>
   function setToday()
   {
	  var now = new Date();
	  var nowstring = now.getFullYear()+"-"+((now.getMonth())+1)+"-"+now.getDate();
	  theform.earliest.value = nowstring;
   }
   function setTomorrow()
   {
	  var now = new Date();
	  var tomorrow = new Date( now.getTime() + (1000*3600*24) );
	  var tomorrowstring = tomorrow.getFullYear()+"-"+((tomorrow.getMonth())+1)+"-"+tomorrow.getDate();
	  theform.latest.value = tomorrowstring;
   }

</script>