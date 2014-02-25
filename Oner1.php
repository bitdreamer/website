<?php
   // Oner1.php
   // This is a one-user page;
   // The point of this code is to show all the agreements between my Person and
   // what I got from the Alum House.
   
   $bug = false;
   session_start();
   include("includeInAll.php");
   levelCheck(1); // for right now, this is just me.  we should also allow  
                  // alums to edit their own info
   include( "openDB.php" );
   openDB(1);
   //upCheck();
   include("leftMenu.php");
   include("shopHeader.php");
   include("tabledump.php");
   
?>

<html>
	<head>
	  <title> Oner1  </title> 
	  <link href="main.css" rel="stylesheet" type="text/css" /> 
	</head>
<body>
   <?php shopHeader(); leftMenu(); ?>
		
   <div id="main" >
      <p>
        <h3> Oner1 </h3>
<?php
   $query = "SELECT fullName, classOf,  Person.firstName as fn, Person.lastName as ln "
           ."  ,oldLast, gradDateN, personID, matches , alumID  "
           ." FROM Person, CS_Alumni_Eblast WHERE "
           ." Person.firstName=CS_Alumni_Eblast.firstName "
//           ." AND Person.oldLast=CS_Alumni_Eblast.maidenName"
           ." AND Person.lastName=CS_Alumni_Eblast.lastName "
           ." AND matches='0' "
           .";";
   $result = mysql_query( $query );
   if ( noerror( $result ) )
   {
      echo "<table border='1'> \n";
      echo "<tr>";
      echo "<td> full </td>";
      echo "<td> first </td>";
      echo "<td> old</td>";
      echo "<td> last  </td>";
      echo "<td> classof</td>";
      echo "<td> grad date </td>";
      echo "<td> matches</td>";
      echo "</tr>\n";
      //tabledump( $result );
      $nr = mysql_num_rows( $result );
      for ( $i=0; $i<$nr; $i++ )
      {
         $row = mysql_fetch_array($result);
         $fullName = $row['fullName'];
         $firstName = $row['fn'];
         $oldLast   = $row['oldLast'];
         $lastName = $row['ln'];
         $classOf  = $row['classOf'];
         $gradDateN = $row['gradDateN'];
         $personID = $row['personID'];
         $matches = $row['matches'];
         $alumID  = $row['alumID'];
         echo "<tr>";
         echo "<td> <a href='PersonEdit.php?personID=$personID'>$fullName </a></td>";
         echo "<td> $firstName </td>";
         echo "<td> $oldLast </td>";
         echo "<td> $lastName  </td>";
         echo "<td> $classOf </td>";
         echo "<td> $gradDateN </td>";
         echo "<td> $matches </td>";
         echo "</tr>\n";
         /*
         $qmatch = "UPDATE CS_Alumni_Eblast SET matching='1' WHERE alumID='$alumID';";
         if ( $bug ) 
         {
            echo "would have done query=$qmatch <br /> \n ";
         }
         else
         {
            $rmatch = mysql_query($qmatch);
            errorFree( $rmatch );
         }
         
         $qmatch = "UPDATE Person SET matches='1' WHERE personID='$personID';";
         if ( $bug ) 
         {
            echo "would have done query=$qmatch <br /> \n ";
         }
         else
         {
            $rmatch = mysql_query($qmatch);
            errorFree( $rmatch );
         }
         */
      }
      echo "</table> \n";
   }
?>        
      </p>
   </div>   <!-- end main -->

</body>
</html>
     