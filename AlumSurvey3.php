<?php
   // AlumSurvey3.php
   // processing page from AlumSurvey2013.php form, records user in survey database.

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
   $employer = $_POST['employer'];
   $jobTitle  = $_POST['jobTitle'];
   $jobDescription   = $_POST['jobDescription'];
   $skillUse = $_POST['skillUse'];
   $merePrep      = $_POST['merePrep'];
   $mostValue  = $_POST['mostValue'];
   $improvements  = $_POST['improvements'];
   $general  = $_POST['general'];
   $degree  = $_POST['degree'];
   $grajYear  = $_POST['grajYear'];
   $fullName  = $_POST['fullName'];
   $email  = $_POST['email'];
   

  
          $employer         = addslashes($employer) ;
      $jobTitle         = addslashes($jobTitle);
       $jobDescription   = addslashes($jobDescription);
       $mostValue        = addslashes($mostValue);
       $improvements     = addslashes($improvements);
       $general          = addslashes($general);
       $grajYear         = addslashes($grajYear);
       $fullName         = addslashes($fullName);
       $email            = addslashes($email);
    
  {
      /*  use existing alum records ... not there yet
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
      
      $q5 = "INSERT INTO AlumSurvey2013 SET "
           ."  date='$nowstring' "
           ." ,employer='$employer' "
           ." ,jobTitle='$jobTitle' "
           ." ,jobDescription='$jobDescription' "
           ." ,skillUse='$skillUse' "
           ." ,merePrep='$merePrep' "
           ." ,mostValue='$mostValue' "
           ." ,improvements='$improvements' "
           ." ,general='$general' "
           ." ,degree='$degree' "
           ." ,grajYear='$grajYear' "
           ." ,email='$email' "
           ." ,fullName='$fullName'"
            .";";
      $r5 = mysql_query( $q5 ) ;
  
      if ($bug ) { noerror( $r5 ); }
   }
?>


<html>
	<head>
	  <title> Survey done  </title> 
	  <link href="main.css" rel="stylesheet" type="text/css" /> 
	</head>
<body>
   <?php shopHeader(); leftMenu(); ?>
		
   <div id="main" >
      <p>
        <h3>  Survey done</h3>
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
