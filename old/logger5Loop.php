<?php

// This page is the target of the link from the email we sent
// to the user.  It should have in the URL username=whatever
// and confirmationNumber=42 (or whatever their number is).
// They should also do it the same day as when they started 
// registration.

   session_start();
   include("includeInAll.php");
   include("openDB.php");
   openDBlevel(1);
   // no upCheck() ... user is trying to log in.
   include("leftmenu.php");


$customerID = @$_GET[customerID];
$confirmationNumber = @$_GET[confirmationNumber];
   
   $now = time(); // this is a timestamp for right now
   $nowstring = date("Y-m-d", $now );

   $query=stripSlashes(
       "SELECT COUNT(*) FROM Register WHERE customerID='$customerID'".
             " AND regCode='$confirmationNumber'"
            ." AND regDate='$nowstring'"
            .";"      );
   $result=mysql_query($query);

   if($result==0)
   {
      // echo "<b>Error ".mysql_errno().": ".mysql_error()."</b>";
      $shtats = "regfailed";
   }
   elseif (@mysql_num_rows($result)==0)
   {
      // echo "<b>Query completed.  Empty result.</b><br>";
      $shtats = "regfailed";
   }
   else
   {
      $row = mysql_fetch_row($result);
      if ( $row[0]==1 ) // one means this registration is good
      {
         // change confN in db to 0, tell user they're good
         // NEW - copy record to Customer table
         
         //$query="UPDATE Customer SET regCode=0, level=1 "
         //." WHERE customerID='$customerID';";
         
         $qget = "SELECT first, last, regDate, passWord, email "
                ." FROM Register WHERE customerID='$customerID';";
         $r1 = mysql_query($qget);
         
         $row = mysql_fetch_row( $r1 );
         $first = $row[0];
         $last = $row[1];
         $regDate = $row[2];
         $passWord = $row[3];
         $email = $row[4];
         
         $query =  "INSERT into Customer SET "
                  ." customerID='$customerID'"
                  .", first='$first'"
                  .", last='$last'"
                  .", regDate='$regDate'"
                  .", passWord='$passWord'"
                  .", email='$email'"
                  .", level=1 "
                  .", balance=0.0 "
                  .";";         
         $result=mysql_query($query);
         // Give click option back to login page.
         
         $querydel = "DELETE FROM Register WHERE email='$email';";
         mysql_query($querydel);
         
         $shtats = "regsuccessful";
         //header("Location: logger.php");
      }
      else { $shtats = "regfailed"; }
   }

?>

<html>
<body>
<h1>Gaia Conceptions </h1>
<h2> This is the registration confirmation page. </h2> 
<?php
if ( $shtats=="regsuccessful" )
{
   echo "Registration was successful. <br />";
}
else
{
   echo "Registration failed. <br /> ";
}

?>

<a href="logger1Start.php"> click here to login </a> 

</body>
</html>
