<?php
   // AlumEdit2.php
   // $_POST['alumID'] should be set to person to edit.
   // In fact, POST with ALL fields of Alum table should be set.
   // 
   // This page processes the edits.  First cut, just save the edits.
   
   $bug = false;
   session_start();
   include("includeInAll.php");
   $alumID = $_POST['alumID'];  
   if ( $_SESSION['alumID']!=$alumID )
   { levelCheck(1); }
   include( "openDB.php" );
   openDB(1);
   //upCheck();
   include("leftMenu.php");
   include("shopHeader.php");
   include("tabledump.php");

   $qalum = "SELECT * FROM Alum WHERE alumID='$alumID'; ";
   $ralum = mysql_query( $qalum );
   if ( noerror( $ralum ) )
   {
      $querrence = "UPDATE Alum SET ";
      $firsty = true;
      $nf = mysql_num_fields($ralum);
      $row = mysql_fetch_array( $ralum );
      for( $i=0; $i<$nf; $i++ )
      {
         if (!$firsty) { $querrence = $querrence . ","; }
         $fieldName = mysql_field_name( $ralum, $i );
         $fieldValueOld = $row[$i];
         $fieldValue = $_POST[$fieldName];
         if ( $fieldName!="alumID" )
         { $querrence = $querrence ."$fieldName='$fieldValue' "; $firsty=false; }
      }
      $querrence = $querrence ." WHERE alumID='$alumID';";
      
      if ( $bug ) { echo "would have done query=$querrence <br /> \n"; }
      else
      {
         $result = mysql_query( $querrence );
         //nobomb( $result );
      }
   }
   header("Location: AlumList.php");
?>                 
     