<?php
   session_start();
   include("includeInAll.php");
   levelCheck(4); // must be at least alum level to see other alums
   include( "openDB.php" );
   openDB(1);
   //upCheck();
   include("leftMenu.php");
   include("shopHeader.php");
   include("tabledump.php");
?>


<html>
	<head>
	  <title> Alumnae  </title> 
	  <link href="main.css" rel="stylesheet" type="text/css" /> 
	</head>
<body>
   <?php shopHeader(); leftMenu(); ?>
		
   <div id="main" >
      <p>
        <h3> Alumnae</h3>
         <?php  listAlums();  ?>         
      </p>
   </div>   <!-- end main -->

</body>
</html>
<?php
   function listAlums()
   {

      $query = "SELECT firstName, lastName, gradDateN , majmin "
              ." from Person WHERE gradActual='1' "
              ." ORDER BY lastName "
              .";";
      $result = mysql_query( $query );
      if ( noerror( $result ) )
      {
      /*
echo "   <table border='1' style='float:left'> \n";
echo "      <tr> <td> name </td> <td> graduated? </td> <td> grad date </td> </tr> \n";
         $nr = mysql_num_rows( $result );
         for ( $i=0; $i<$nr; $i++ )
         {
            $row = mysql_fetch_array( $result );
            $firstName  = $row['firstName'];
            $lastName   = $row['lastName'];
            $alumID     = $row['alumID'];
            $gradActual = $row['gradActual'];
            $gradDate   = $row['gradDate'];
echo "      <tr> <td> ";
            if ( $userLevel <= 2 )
            {echo " <a href='AlumEdit.php?alumID=$alumID'> $firstName $lastName </a> "; }
            else
            { echo " $firstName $lastName ";}
echo "      </td>\n";
echo "      <td> $gradActual </td><td> $gradDate </td> \n";
echo "      </tr>\n";
         }
echo "   </table> \n";
      */
         tabledump( $result );   
      }
     
   }
?>