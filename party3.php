<?php
   // party3.php
   // processing page from party2 form, records user in survey database.

   $bug = false;
   session_start();
   include("includeInAll.php");
   //levelCheck(2); // must be at least alum level to see other alums
   include( "openDB.php" );
   openDB(1);
   //upCheck();
   include("leftMenu.php");
   include("shopHeader.php");
   include("tabledump.php");
?>
<script type="text/javascript" src="errorHandler.js"> </script>

<?php
   $firstName  = $_POST['firstName'];
   $lastName   = $_POST['lastName'];
   $replyEmail = $_POST['replyEmail'];
   $yesno      = $_POST['yesno'];
   $eventCode  = $_POST['eventCode'];
   
   // if this email is in the Alum table, use the id there; if not, add to
   // table and use the auto-id.
   
  // then add the reply to the survey table.
  
  if (    $firstName == addslashes($firstName) 
       && $lastName == addslashes($lastName) 
       && $replyEmail == addslashes($replyEmail) 
       && $eventCode == addslashes($eventCode) 
     )
  {
  /*
      $q1 = "SELECT * from Alum WHERE email='replyEmail'; ";
      $r1 = mysql_query( $q1 );
      if ( nobomb( $r1 ) )
      {
         if ( mysql_num_rows( $r1 ) ==0 )
         {
            $q2 = "INSERT INTO Alum Set "
                 ." "
                 .";";
         }
      }
      */
      $now = time(); // this is a timestamp for right now
      $nowstring = date("Y-m-d", $now );
      
      $q5 = "INSERT INTO Survey SET "
           ." date='$nowstring' "
           .",alumID='0' "
           .",eventCode='$eventCode' "
           .",reply='$yesno' "
           .",email='$replyEmail' "
           .",firstName='$firstName'"
           .",lastName='$lastName'"
            .";";
      $r5 = mysql_query( $q5 ) ;
  
      if ($bug ) { noerror( $r5 ); }
   }
?>


<html>
	<head>
	  <title> RSVP done  </title> 
	  <link href="main.css" rel="stylesheet" type="text/css" /> 
	</head>
<body>
   <?php shopHeader(); leftMenu(); ?>
		
   <div id="main" >
      <p>
        <h3>  RSVP done</h3>
        Thank you for your reply.
<?php
   if ( $bug ) 
   {
      echo "q5=$q5 <br /> \n";
      echo "replyEmail=$replyEmail <br /> \n";
   }
?>

      </p>
   </div>   <!-- end main -->

</body>
</html>
