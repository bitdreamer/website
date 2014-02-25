<?php
   session_start();
   include("includeInAll.php");
   include("openDB.php");
   openDBlevel(1);

?>


<html>
<head>
<title> Gaia Conceptions Registration Processsing 1</title>
</head>
<body>
<h1> Gaia Conceptions </h1> 
<h2>Registration Processing 1</h2>

<?php

/* logger3Reg.php
   This page is sent in POST the email4Reg, firstname4reg, lastname4reg,
   password4reg, password4reg2, regnum.   
   They have been checked for length but not funny stuff.
   We make sure the passwords match and that this email is new.
   Then record a temporary Customer record in the database and 
   then send them email for them to ping back with the number.
*/
   
$em  = @$_POST[email4reg]; // raw email address, may have bad stuff
$emas = addslashes( $em );
$pw  = @$_POST[password4reg];
$pw2 = @$_POST[password4reg2];

if ( $pw!=$pw2 )
{
   //header("Location: logger1Start.php?fun=pwmismatch");
   echo "Passwords don't match. Please go back and try again.  ";
}

if($em!="" && $em==$emas && $pw!="" && $pw==$pw2 ) // no funny stuff in email
{
   // user is trying to register.  see if email is already taken
   // If no match, go ahead and add.
   $query= "SELECT COUNT(*) FROM Customer WHERE email='$em';";
   //echo "query=".$query;
   $result=mysql_query($query);

   if($result==0)
   {
      echo "<b>Error ".mysql_errno().": ".mysql_error()."</b>";
      echo "This is a server error.  If it persists please tell tech support. ";
      $shtats = "queryerror1";
   }
   elseif (@mysql_num_rows($result)==0)
   {
      echo "<b>Query completed.  Empty result.</b><br>";
      echo "This is a server error.  If it persists please tell tech support. ";
      $shtats = "queryerror2";
   }
   else
   {
      $row = mysql_fetch_row($result);
      if ( $row[0]==0 ) // no match is good
      {
         // registration: email address is
         // not in the database, so add this person as temp and 
         // send email to confirm.

         $shtats = "ok2add";
         doRegister( $em, $pw, @$_POST[firstname4reg], @$_POST[lastname4reg], 
                      @$_POST[regnum]  ); 
      }
      else
      {
         $shtats = "EmailTaken"; 
         echo "An account with this email already exists.  Go back "
         ." and hit the 'forgot password' option if you need to.";
      }
   }
   
}


   // register with email, password, firstname, lastname, and regnum
   // Note: pw, firstname and lastname may need slashing
   function doRegister( $em, $pw, $first, $last, $regnum )
   {
      $shtats = "ok2add";
      
      // find max customerID and add one to get new one
      $query = "SELECT MAX(customerID) from Customer";
      $result = mysql_query( $query );
      if($result==0)
      {
         echo "<b>Error ".mysql_errno().": ".mysql_error()."</b>";
         echo "This is a server error.  If it persists please tell tech support. ";
         $shtats = "queryerror3";
      }
      elseif (@mysql_num_rows($result)==0)
      {
         echo "<b>Query completed.  Empty result.</b><br>";
         echo "This is a server error.  If it persists please tell tech support. ";
         $shtats = "queryerror4";
      }
      else
      {
         $row = mysql_fetch_row($result);
         $customerID = $row[0] + 1; // might want to check that this is not 1
         
         $querydel = "DELETE FROM Register WHERE email='$em';";
         mysql_query($querydel);
         
         $now = time(); // this is a timestamp for right now
         $nowstring = date("Y-m-d", $now );
         $query= "INSERT INTO Register " // was Customer, but now we 2-step this
         ." SET customerID=$customerID "
         ."    ,first='".addslashes($first)."' "
         ."    ,last='".addslashes($last)."' "
         ."    ,regCode=$regnum "
         ."    ,regDate='$nowstring' "
         //."    ,level=0 " // will be set to 1 when confirmed
         ."    ,passWord='".addslashes($pw)."' "
         //."    ,balance=0 "
         ."    ,email='$em' "
         ." ;";
         $result=mysql_query($query);
         
         // send email to user 
         $subj="Registration Confirmation";
         $msg="confirm registration by clicking on this link: <br />"
         //."<a href=\"http://gaiaconceptionscom.fatcow.com/logger5Loop.php"
         ."<a href=\"http://www.gaiaconceptions.com/logger5Loop.php"
         ."?customerID=$customerID&confirmationNumber="
         ."$regnum\" > confirm your email address </a> <br /> <br />"
         ." Thanks, Gaia Conceptions "
         ;
         $heads="";

         mail($em,$subj,$msg,$heads);
         //echo "message is ".$msg; // can't do this here, 

         // jump to the page that tells them to check their email
         
         //header("Location: logger4GoRead.php");
         
         echo "Go read your email and click on the link to confirm.  ";
      }
   }

?>

</body>
</html>
