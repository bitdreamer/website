<?php

/* logger8sendPW.php
   email address is in $_POST['email'].  Send this user their
   password.
*/
   $bug = false;

   session_start();
   include("includeInAll.php");
   include("openDB.php");
   openDB(0);
   
	$em = @$_POST[email]; // raw email address, may have bad stuff
	$emas = addslashes( $em ); // slashes version 

	$mailsent = "no"; // did we send the mail yet?

	if($em!="" && $em==$emas ) // no funny stuff
	{
	   // the user is trying to log in, so check db for name and password.
	   $query="SELECT password FROM Person WHERE email='$em'"
		   ." ;";
	   // echo "query=".$query."<br />";
	   $result=mysql_query($query);

	   if($result==0)
	   {
		  $stat="MySQL Error ".mysql_errno().": ".mysql_error()."<br /> \n"
		  ."This is a programming or network error, please report it.<br /> \n";
		  // header("Location: logger1Start.php"); 
	   }
	   elseif (@mysql_num_rows($result)==0)
	   {
		  $stat = "email not found, can't help you. <br /> \n";
		  // header("Location: logger1Start.php");
	   }
	   elseif ( mysql_num_rows( $result ) >= 1 ) // one match in DB, woohoo!
	   {
		  //$bug = true;
		  if ($bug) { echo "name and password are valid, set up session ... <br /> \n"; }
				
		  $row = mysql_fetch_array($result);
		  $password = $row['password'];
		  
		  $to = $em;
		  $subj = "use this to get into the Bit Lab ";
		  $msg = " Your Bit Lab website password is '$password'.";
		  mail($to, $subj, $msg, "" );
		  $mailsent = "yes";
	   }
	}


   echo "<html><body> \n";

   echo "Was mail sent? $mailsent   <br /> \n"; 
   
   echo "<a href='logger1Start.php'> click here to return to login page </a>\n";

?>
</body>
</html>
