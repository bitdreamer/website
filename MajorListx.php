<?php
   // MajorList.php
   global $bug;
   $bug = false;
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
	  <title> Majors  </title> 
	  <link href="main.css" rel="stylesheet" type="text/css" /> 
	</head>
<body>
   <?php shopHeader(); leftMenu(); ?>
		
   <div id="main" >
      <p>
        <h3> Majors</h3>
         <?php  listAlums();  ?>         
      </p>
   </div>   <!-- end main -->

</body>
</html>
<?php
   function listAlums()
   {
      
      $majmin = $_SESSION['majmin'];
      global $bug;
      $query = "SELECT personID, firstName, lastName, gradDateN, BS  "
              ." from Person WHERE gradActual!='1' "
			  ." AND majmin='$majmin' "
			  ." AND inactive='0' "
              ." ORDER BY gradDateN "
              .";";
      if ($bug) { echo "about to do query=$query <br /> \n"; }
      $result = mysql_query( $query );
      if ( noerror( $result ) )
      {
	     echo "Current $majmin majors: <br />\n";
      
echo "   <table border='1' style='float:left'> \n";
echo "      <tr> <td> name </td> <td> graduation target </td> <td> BS/BA </td>  </tr> \n";
         $nr = mysql_num_rows( $result );
         for ( $i=0; $i<$nr; $i++ )
         {
            $row = mysql_fetch_array( $result );
            $personID   = $row['personID'];
            $firstName  = $row['firstName'];
            $lastName   = $row['lastName'];
            $gradDateN  = $row['gradDateN'];
            $BS         = $row['BS'];
echo "      <tr> <td> ";
            if ( $userLevel <= 2 )
            {echo " <a href='PersonEdit.php?personID=$personID'> $firstName $lastName </a> "; }
            else
            { echo " $firstName $lastName ";}
echo "      </td>\n";
echo "      <td> $gradDateN </td> \n";
echo "      <td> ";
            if ($BS==1) { echo "BS"; } else { echo "BA";} 
echo " </td> \n";
echo "      </tr>\n";
         }
echo "   </table> \n";
      
         //tabledump( $result );   
      }
     
   }
?>