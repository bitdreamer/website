<?php
   // PersonAdd2.php
   // $_POST should have firstName, lastName and personID.
   // Add this person to the database if the personID is new.
   // If existing personID, report the error, tell user to go back
   // and try again.
   // Give a warning if same firstName and lastName exist with different 
   // personID.
   
   $bug = false;
   session_start();
   include("includeInAll.php");
   levelCheck(2); // for right now, this is just me.  we should also allow  
                  // alums to edit their own info
   include( "openDB.php" );
   openDB(1);
   //upCheck();
   include("leftMenu.php");
   include("shopHeader.php");
   include("tabledump.php");
?>
<?php    
   $firstName = $_POST['firstName'];  
   $lastName  = $_POST['lastName'];
   $personID  = $_POST['personID'];
   if (isset($_POST['matchOverride'])) {$matchOverride = true;} else{$matchOverride=false;}
   if(!$matchOverride) { $whereString = " OR (firstName='$firstName' AND lastName='$lastName')"; }
   else { $whereString=""; }
?>
<?php
   $qalum = "SELECT * FROM Person WHERE personID='$personID' $whereString ; ";
   $ralum = mysql_query( $qalum );
   if ( $ralum==0 ) { echo "<b>Error ".mysql_errno().": ".mysql_error()."</b>"; }
   else if ( mysql_num_rows( $ralum )==0 ) // not already there, good, add them
   {
      $qadd = "INSERT INTO Person SET "
                  ."  firstName='$firstName' "
                  ." ,lastName='$lastName' "
                  ." ,personID='$personID'"
                  .";";
      if (!$bug) { $radd = mysql_query( $qadd ); errorFree($radd); }
      else
      { echo "would have done query=$qadd <br /> \n"; }
      echo "<a href='PersonEdit.php?personID=$personID'> edit this person more </a> <br /> \n";
   }
   else // existing record found
   {
      echo "Error: person not added.  The personID '$personID' or name "
           ." '$firstName $lastName' is already "
           ." in the database.  If the personID is the problem, make up a different one. "
           ." If there really IS a different student with this same name, check the "
           ." name override box on the person-add form.           ";
     
   }
   //header("Location: PersonEdit.php?personID=$personID");
   
   echo "<a href='PersonList.php' > back to the person list </a> <br /> \n";
?>      
         
     