<?php
   // PersonEdit2.php
   // $_POST['personID'] should be set to person to edit.
   // In fact, POST with ALL fields of Person table should be set.
   // 
   // This page processes the edits.  First cut, just save the edits.
   
   $bug = false;
   session_start();
   include("includeInAll.php");
   $personID = $_POST['personID'];  
   if ( $_SESSION['personID']!=$personID )
   { levelCheck(1); }
   include( "openDB.php" );
   openDB(1);
   //upCheck();
   include("leftMenu.php");
   include("shopHeader.php");
   include("tabledump.php");

   $qalum = "SELECT * FROM Person WHERE personID='$personID'; ";
   $ralum = mysql_query( $qalum );
   if ( noerror( $ralum ) )
   {
      $querrence = "UPDATE Person SET ";
      $firsty = true;
      $nf = mysql_num_fields($ralum);
      $row = mysql_fetch_array( $ralum );
      for( $i=0; $i<$nf; $i++ )
      {
         if (!$firsty) { $querrence = $querrence . ","; }
         $fieldName = mysql_field_name( $ralum, $i );
         $fieldValueOld = $row[$i];
         $fieldValue = $_POST[$fieldName];
         if ( $fieldName!="personID" )
         { $querrence = $querrence ."$fieldName='$fieldValue' "; $firsty=false; }
      }
      $querrence = $querrence ." WHERE personID='$personID';";
      
      if ( $bug ) { echo "would have done query=$querrence <br /> \n"; }
      else
      {
         $result = mysql_query( $querrence );
         errorFree( $result );
      }
   }
   header("Location: PersonList.php");
?>                 
     