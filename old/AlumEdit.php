<?php
   // AlumEdit.php
   // $_GET['alumID'] should be set to person to edit.
   // Else go back to alumni list.
   // This page: allows editing of the specified 'alum''s info.
   
   session_start();
   include("includeInAll.php");
   $alumID = $_GET['alumID'];
   if ( $alumID=="" || $alumID != addslashes( $alumID ) ) 
   { header("Location: AlumList.php"); }
   if ( $_SESSION['alumID']!=$alumID )
   { levelCheck(1); }
   include( "openDB.php" );
   openDB(1);
   //upCheck();
   include("leftMenu.php");
   include("shopHeader.php");
   include("tabledump.php");

?>

<html>
	<head>
	  <title> User Edit </title> 
	  <link href="main.css" rel="stylesheet" type="text/css" /> 
	</head>
<body>
   <?php shopHeader(); leftMenu(); ?>
   
   <div id="main" >
      <p>
        <h3> User Edit </h3>
<?php
   $qalum = "SELECT * FROM Alum WHERE alumID='$alumID'; ";
   $ralum = mysql_query( $qalum );
   if ( noerror( $ralum ) )
   {
      echo "     <form action=\"AlumEdit2.php\" method=\"POST\"> \n";
      echo "        <input type='hidden' name='alumID' value='$alumID' /> \n";
      $nf = mysql_num_fields($ralum);
      $row = mysql_fetch_array( $ralum );
      for( $i=0; $i<$nf; $i++ )
      {
         $fieldName = mysql_field_name( $ralum, $i );
         $fieldValue = $row[$i];
         echo "          $fieldName: ";
         if ( ($fieldName=="userLevel" && $fieldValue>1) || $fieldName=="alumID" )
         {
            echo "$fieldValue <br /> \n";
            echo "<input type='hidden' name='$fieldName' value='$fieldValue' > \n";            
         }
         else
         {
            echo "<input name='$fieldName' value='$fieldValue' /> <br /> \n"; 
         }
      }
      echo "<input type='submit' value='submit'><br />\n";
      echo "</form> <br /> \n";
   }
?>                 

      </p>
      <h2> Notes </h2>
      <p> 
        <ol>
          <li> Passwords are not that secure.  Don't use one of your favorites. </li>
          <li> Major - use the official 3 or 4-letter code.  Faculty use "FAC".</li>
        </ol>
      </p>
   </div>   <!-- end main -->

</body>
</html>
