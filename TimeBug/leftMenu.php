<?php
   // leftMenu.php
   // This creates the menu of pages that goes on the left side of just about
   // every page.  
   
   function leftMenu()
   {     
      echo "<div style='float:left'>";
	  echo "<a href='../logger1Start.php'> login </a> <br /> \n";
	  echo "<a href='MissionList.php'> Budget </a> <br />\n";
	  echo "<a href='MishAdd.php'> add a Goal </a> <br />\n";
	  echo "<a href='TaskList.php'> Tasks </a> <br />\n";
	  echo "<a href='TaskAdd.php'> add a Task </a> <br />\n";
	  
	  date_default_timezone_set("America/New_York");	  
	  $now = getdate(); // associative array with date and time info
	  $nowdate = $now['year']."-".$now['mon']."-".$now['mday'];
      echo "<a href='Calendar.php?startDate=$nowdate&endDate=$nowdate'> Today </a> <br />\n";
	  
	  echo "<a href='Calendar.php'> Calendar </a> <br />\n";
	  echo "<a href='BookingAdd.php'> add an event </a> <br />\n";
	  echo "<a href='CalReview.php'> review </a> <br />\n";
	  echo "<a href='DayFill.php'> Day Fill </a> <br />\n";

      echo "</div>";
   }

?>