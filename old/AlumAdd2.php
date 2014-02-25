<?php
   // AlumAdd2.php
   // $_POST should have firstName and lastName.
   // Add this person to the database if they are not already there.
   // 
   
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
?>
<?php
   $newAlumID = maxAlumID() + 1;
   $qalum = "SELECT * FROM Alum WHERE firstName='$firstName' AND lastName='$lastName'; ";
   $ralum = mysql_query( $qalum );
   if ( $ralum==0 ) { echo "<b>Error ".mysql_errno().": ".mysql_error()."</b>"; }
   else if ( mysql_num_rows( $ralum )==0 ) // not already there, good, add them
   {
      $qadd = "INSERT INTO Alum SET "
                  ."  firstName='$firstName' "
                  ." ,lastName='$lastName' "
                  ." ,alumID='$newAlumID'"
                  .";";
      $radd = mysql_query( $qadd );
      errorFree($radd);
   }
   header("Location: AlumEdit.php?alumID=$newAlumID");
?>      
<?php
   // return the maximum value for alumID
   function maxAlumID()
   {
      $ret = 0;
      $q = "SELECT max(alumID) from Alum;";
      $r = mysql_query( $q );
      if ( noerror( $r ) )
      {
         $row = mysql_fetch_row( $r );
         $ret = $row[0];
      }
      return $ret;
   }
?>           
     