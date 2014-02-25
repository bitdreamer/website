<?php

/* logger2CheckPW.php
   This page is sent the email address and password, to be checked
   for logging this person in.  They are in POST: email4log, password4log.
   They have been checked for length but not funny stuff.
   If you log in correctly, you will go to logger6In that says you are
   logged in.  Ultimately, this should have a session variable that
   remembers what you were doing and send you back there.
   IF you don't log in, $stat will contain a message why not and be printed.
*/
   $bug = false;

   session_start();
   include("includeInAll.php");
   include("openDB.php");
   openDB(0);
   
$em = @$_POST[email4log]; // raw email address, may have bad stuff
$emas = addslashes( $em ); // slashes version 
$pw = @$_POST[password4log];
$pwas = addSlashes( $pw );

if($em!="" && $em==$emas && $pw!="" && $pw==$pwas ) // no funny stuff
{
   // the user is trying to log in, so check db for name and password.
   $query="SELECT alumID,nickName,userLevel FROM Alum WHERE email='$em'"
       ." AND password='$pw'"
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
      $stat = "name/password not found, no loggy inny, sorry <br /> \n";
      // header("Location: logger1Start.php");
   }
   elseif ( mysql_num_rows( $result ) == 1 ) // one match in DB, woohoo!
   {
      //$bug = true;
      if ($bug) { echo "name and password are valid, set up session ... <br /> \n"; }
            
      $row = mysql_fetch_array($result);
      //echo "login successful"; 
      $stat = "login successful";
      $_SESSION['loginok']="yes";
      $_SESSION['nickName']=$row['nickName'];
      $_SESSION['level']=$row['userLevel'];
      $_SESSION['userLevel']=$row['userLevel'];
      $_SESSION['alumID']=$row['alumID'];
      
      if ($bug){echo"level=".$_SESSION['level']." <br /> \n";}
       
      if (!$bug) { header("Location: logger6In.php"); exit; }
      else { echo "bug pause, click <a href=\"logger6In.php\">here</a> to continue. <br />\n";}
   }
   else
   {
      $stat="Some weird error occurred.  <br /> \n";
      // header("Location: logger1Start.php"); exit;
   }
   
}
else // there was funny typing, don't even check database, just reject
{
   $stat="your name or password had spaces or funny characters.  Oops.  <br /> \n";
   // header("Location: logger1Start.php"); exit;
}

   echo "<html><body> \n";

   echo "Login failed (or you are debugging).  reason: <br /> \n"; 

   echo $stat;   

   // echo "sessionID=".session_id();
   if ($bug && $stat="login successful" )
   {
      echo "<a href=\"logger6In.php\"> success page </a> ";
   }
   echo "<br /> Just backup or go to the home page if you want to try again.";
?>
</body>
</html>
