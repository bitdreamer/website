<?php
   // DayFillM.php
   // 
   // $_GET['theDate'] can be set, default is today.
   // Show all events for this day, and create ONE form for all of the gaps.  
   // The form should allow the user to quickly fill in 
   //  1. new events, just pick mission and duration
   //  2. pick an existing task .
   //  It might also be good to have one click buttons for the most common fills,
   //  travel, food, getting organized, misc.  (in progress)
   // 

   global $bug, $sc; $sc=0; // $sc is slotCount, indexing down the form.
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
?>
<html>
<head>
<script type="text/javascript" src="errorHandler.js"> </script>
<script type="text/javascript" src="functions.js"> </script>
</head>
<body>
<?php
   $personID = $_SESSION['personID'];
   shopHeader( $personID );
   leftMenu();
   
   //echo " <a href='Calendar.php?startDate=2001-01-01'> show all </a> \n";
   echo "<div>";
   dayToFillM( $personID );
   echo "</div>";
?>
</body>
</html>

<?php

   function dayToFillM( $personID )
   {
      global $bug, $sc;
      date_default_timezone_set("America/New_York");	  
	  $now = getdate(); // associative array with date and time info
	  $nowdate = $now['year']."-".$now['mon']."-".$now['mday'];
      $whenstring = $nowdate;
	  // now do a $_GET for the startDate, and if there is one, use that instead.
	  $gotTheDate = $_GET['theDate'];
	  if ( $gotTheDate != "" && $gotTheDate == addslashes($gotTheDate) )
	  {
	     $whenstring = $gotTheDate;
	  }

      	  // set previous and next pointers
	  $previousDay = date("Y-m-d", noonObject( $whenstring ) - 3600*24 );
	  $nextDay =     date("Y-m-d", noonObject( $whenstring ) + 3600*24 );
	  
      $q5 = "SELECT * from Booking, Task "
	       ." WHERE Booking.taskID=Task.taskID AND Booking.personID='$personID' AND Task.personID='$personID' "
		   ." AND status<3 "
		   ." AND startDate='$whenstring' "
		   ." ORDER BY startDate, startTime  "
           .";";
      $r5 = mysql_query( $q5 ) ;
  
      if ( noerror( $r5 ) )
	  {
		 //echo "<form method='POST' action='CalReview2.php' >\n";
		 //echo "<input type='hidden' name='theDate' value='$gotTheDate' \>\n";
		 echo "<form method='POST' action='DayFillM2.php' >\n";
          echo "<input type='hidden' name='personID' value='$personID' />\n";
	     $lastDate = "";
	     echo "<table border='2'>\n";
		 echo "<tr> ";
		 echo "<tr> <td colspan='7' style='text-align:center'> <b> Day Fill ";
		 if ($gotTheDate!="" ) { echo " for day = $gotTheDate "; }
		 echo " </b> </td></tr>\n";
		 echo "<td> date/time </td>\n";
		 echo "<td> description (click to edit) </td>\n";
		 //echo "<td> status </td>\n";
		 echo "</tr>\n";
		 
		 $filled = 0; // As we go through the day, this is the hour to which
		              // we have filled.  If the current event starts AFTER
					  // this, then we want to generate some forms to add events
	     $nr = mysql_num_rows( $r5 );
		 for ( $i=0; $i<$nr; $i++ )
		 {
		    $row = mysql_fetch_array( $r5 );
			$description = $row['description'];
			$descripsh = $row['descripsh'];
			$startDate = $row['startDate'];
			$startTime = $row['startTime'];
			$duration = $row['duration'];
			$endTime = $row['endTime'];
			$taskID = $row['taskID'];
			$bookingID = $row['bookingID'];
			$status = $row['status'];
			$tstatus = $row['tstatus'];
			$recurs = $row['recurs'];
			$tied = $row['tied'];
			// if ($bug) { echo "recurs = $recurs <br /> \n"; }
			
			// fill dead time to next event with 1-hour blocks
		    while ( $filled < $startTime )
			 {
				if ( $filled+1 < $startTime ) {  $nextie = $filled+1; }
				else                          {  $nextie = $startTime;  }
				//$nextie = 72;
				slotFill( $filled, $nextie, $whenstring );
				$filled = $nextie;
			
			 }
             $filled = $endTime;  // as we proceed to write the following event, we will
			                      // have filled through the end of it.  This is just
								  // prep for the next loop
	
	        if ($startDate != $lastDate ) 
			{
			   echo "<tr> <td colspan='2'> $startDate ";  $lastDate=$startDate; 
			   echo "<a href='DayFillM.php?theDate=$previousDay'>previous day</a> / ";
	           echo "<a href='DayFillM.php?theDate=$nextDay'>next day</a> <br />";
               echo " </td></tr>\n";
			}
			echo "   <tr>\n";
			echo "      <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $startTime to $endTime </td>\n";
			echo "      <td> <a href='BookingEdit.php?bookingID=$bookingID'> $descripsh </a> </td>\n";
			//echo "      <td> ";
			

			//echo " </td>\n";
			echo "   </tr>\n";
		 }
	            // fill dead time to 2400 hrs with 1-hour blocks
		    while ( $filled < 24 )
			 {
				if ( $filled+1 < 24 ) {  $nextie = $filled+1; }
				else                          {  $nextie = 24;  }
				//$nextie = 72;
				slotFill( $filled, $nextie, $whenstring );
				$filled = $nextie;
			
			 }
             $filled = 24;  // as we proceed to write the following event, we will
			                      // have filled through the end of it.  This is just
								  // prep for the next loop

		 echo "<tr> <td colspan='3'> </td> </tr>\n";
		 echo "<table>\n";
		 //echo "</form>\n";
		 
		

		 echo "<input type='hidden' name='slotCount' value='$sc'/>\n";
		 //echo "<input type='submit'  />\n";
          echo "<input type='submit' value='book them' />";
		 echo "</form>\n";
	     //tabledump( $r5 );
       
	  }
   }
?>
<?php
   // echo a row in the table which is a form that allows the user to 
   // fill this time slot.
   // every field gets the slot number tacked on the end of the name and id.
   function slotFill( $startSlot, $endSlot, $whenstring )
   {
      global $sc; // slot count, number for THIS slot (all field add nubmer to name)
         $personID = $_SESSION['personID'];

      echo "<tr> <td> <input id='startTime$sc' name='startTime$sc' value='$startSlot' size='5' />  \n";
	  echo "<input type='button' value='+' onclick='bump(\"startTime$sc\",0.5);' />\n";
	  echo "<input type='button' value='-' onclick='bump(\"startTime$sc\",-0.5);' />\n";
	  echo " to <input id='endTime$sc' name='endTime$sc' value='$endSlot' size='5' />\n";
	  echo "<input type='button' value='+' onclick='bump(\"endTime$sc\",0.5);' />\n";
	  echo "<input type='button' value='-' onclick='bump(\"endTime$sc\",-0.5);' />\n";
	  echo " </td> \n";
	  echo " <td>   ";
	      echo "doit:<input id='doit$sc' name='doit$sc' type='checkbox' value='yes' />\n";
		  echo "<input type='hidden' name='sc' value='$sc'/>";
		  shorkcuts( $personID, $sc );
          echo "what: <input id='description$sc' name='description$sc' />,\n";
          echo " <input type='hidden' name='startDate$sc' value='$whenstring' />\n";
          echo " <input type='hidden' name='endDate$sc' value='$whenstring' />\n";
		  mtChoices( $personID, $sc );
		  echo "<input type='hidden' id='taskID$sc' name='taskID$sc' value='-1' />";
          echo " </td>  ";
	  echo "</tr> \n";
	  
	  $sc++;
   }
?>
<script>
   function bump( bumpeeid,amt )
   {
      var bumpee = document.getElementById( bumpeeid );
	  var v = bumpee.value;
	  v = v*1 + amt;
	  bumpee.value = v; 
   }
   
   // set endTime so duration is 0.5, fill in what and mish and check the checkbox
   function doEat( sc )
   {
      // set end time to start time + 0.5
      var stst = "startTime"+sc; 
	  var st = document.getElementById( stst ); // st is startTime object
      var etst = "endTime"+sc;
      var et = document.getElementById( etst ); // et is endTime object 	  
	  et.value = st.value * 1 + 0.5;
	  
	  // check the doit checkbox
	  var dist = "doit"+sc;
	  var di = document.getElementById( dist ); // di is doit checkbox object
	  di.checked = true; 
	  
	  // fill in the description to breakfast, lunch or dinner depending on time of day
	  var descst = "description"+sc; 
	  var desc = document.getElementById( descst ); // desc is description object
	  if      ( st.value<11 ) { desc.value = "breakfast"; }
	  else if ( st.value<16 ) { desc.value = "lunch"; }
	  else                    { desc.value = "dinner"; }
	  
	  // set mission id to 3
	  var mist = "mishID"+sc;
	  var mish = document.getElementById( mist ); // mish is the select object for mishID
	  mish.value = 3; // this is the mission for food, we just know that.
     
   }
</script>
<?php
   // echos a select menu  with all of the shortcuts.  tasks fill out the end
   // Call script to handle the shortcut
   global $taskResults; // list of shortcuts, re-use rather than refetch if possible
   function shorkcuts( $personID,  $sc )
   {
	  echo "<select name='shortcut$sc'>\n";
	  
	  echo "<option > shortcuts </option>\n";
	  echo "<option onclick='doEat($sc);' > eat a meal  </option>\n";

	  
	  
      global $taskResults;
      $q = "SELECT description, duration, mishID, taskID FROM Task WHERE personID='$personID' "
	  		   ." AND tstatus='0' " 
		   ." AND tied='0' "
		   ." ORDER BY mustdo desc, latest  "
           .";";

	  if ( $taskResults==0 ) { $r = mysql_query( $q ); /* echo "first"; */ $taskResults = $r; }
	  else { $r = $taskResults; mysql_data_seek($r,0); /* echo "next"; */ }
	  if ( noerror( $r ) )
	  {
	     $nr = mysql_num_rows( $r );
		 for ( $i=0; $i<$nr; $i++ )
		 {
		    $row = mysql_fetch_array( $r );
			$description = $row['description'];
			$duration   = $row['duration'];
			$mishID   = $row['mishID'];
			$taskID   = $row['taskID'];
			echo "<option id='' value='$taskID' ";
			if ($taskID==$selected) { echo " SELECTED "; }
			echo " onclick='alert(\"click on $description\");' > $description  </option>\n";
		 }
		 echo "</select>\n";
	  }
   }
?>
<?php
   // echos a select box with all of the choices of mission (for this person),
   // The uncat/uncat mish should be the selected one.
   // All named/id fields have $sc tacked on the end
   global $mishResults; // list of missions, re-use rather than refetch if possible
   global $taskResults; // list of tasks, re-use if possible
   function mtChoices( $personID, $sc )
   {
      global $mishResults;
	  global $taskResults;
      $qmish = "SELECT category, subcat, importance, mishID FROM Mission "
	          ." WHERE personID='$personID' ORDER BY mishOrder; ";
	  if ( $mishResults==0 ) { $rmish = mysql_query( $qmish ); $mishResults = $rmish; }
	  else { $rmish = $mishResults; mysql_data_seek($rmish,0); }
	  if ( noerror( $rmish ) )
	  {
	     echo "<select name='mishID$sc' id='mishID$sc'>\n";
	     $nr = mysql_num_rows( $rmish );
		 for ( $i=0; $i<$nr; $i++ )
		 {
		    $row = mysql_fetch_array( $rmish );
			$category = $row['category'];
			$subcat   = $row['subcat'];
			$mishID   = $row['mishID'];
			$importance = $row['importance'];
			echo "<option value='$mishID'  ";
			if ($category=="uncat" && $subcat="uncat") { echo " SELECTED "; }
			echo " > $category / $subcat </option>\n";
		 }
		 // echo "</select>\n";
	  }
      /*
      $qtask = "SELECT description, duration, mishID, taskID FROM Task "
	       ." WHERE personID='$personID' "
	  	   ." AND tstatus='0' " 
		   ." AND tied='0' "
		   ." ORDER BY mustdo desc, latest  "
           .";";

	  if ( $taskResults==0 ) { $rtask = mysql_query( $qtask ); $taskResults = $rtask; }
	  else { $rtask = $taskResults; mysql_data_seek($rtask,0); }
	  if ( noerror( $rtask ) )
	  {
	     //echo "<select name='taskID'>\n";
	     $nr = mysql_num_rows( $rtask );
		 for ( $i=0; $i<$nr; $i++ )
		 {
		    $row = mysql_fetch_array( $rtask );
			$description = $row['description'];
			$duration   = $row['duration'];
			$mishID   = $row['mishID'];
			$taskID   = $row['taskID'];
			echo "<option  value='$mishID' "
			   //." onclick='fillTaskID($taskID); " 
			   ." onclick='"
			   ." fillTagById(\"taskID$sc\",\"$taskID\");"      // find these in functions.js
			   ." fillTagById(\"description$sc\",\"$description\");"
			   ." '";
			echo " > $description  </option>\n";
		 }
	  }
	 */
      echo "</select>\n";
   }
?>