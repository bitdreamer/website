<?php
   // ProbeList.php
   // Show existing probes.  Also give form to add new one.


   session_start();
   include("includeInAll.php");
   levelCheck(4); // must be at least alum level to see other alums
      $userLevel = 6; // default is 6=public
      if ( $_SESSION['loginok']=="yes" ) { $userLevel = $_SESSION['userLevel']; }
   include( "openDB.php" );
   openDB(1);
   //upCheck();
   include("leftMenu.php");
   include("shopHeader.php");
   include("tabledump.php");
   
?>


<html>
	<head>
	  <title> Probes  </title> 
	  <link href="main.css" rel="stylesheet" type="text/css" /> 
	</head>
<body>
   <?php shopHeader(); leftMenu(); ?>
		
   <div id="main" >
      <p>
        <h3>Probes </h3>
      <?php  
         listProbe( $userLevel ); 
		 
		 if ( $userLevel<=2 )
         { echo "<a href='ProbeAdd.php'> add a probe (survey)  </a> <br /> \n"; }

      ?>     
            
      </p>
   </div>   <!-- end main -->

</body>
</html>
<?php
   function listProbe( $userLevel )
   {
      $query = "SELECT * FROM Probe ORDER BY probeDate ; ";
      $result = mysql_query( $query );
      if ( noerror( $result ) )
      {
echo "   <table border='1' style='float:left'> \n";
echo "      <tr> <td> name (was) </td> <td> date</td> <td> subject </td>  </tr> \n";
         $nr = mysql_num_rows( $result );
         for ( $i=0; $i<$nr; $i++ )
         {
            $row = mysql_fetch_array( $result );
            $probeID   = $row['probeID'];
            $probeName = $row['probeName'];
            $probeDate = $row['probeDate'];
            $available = $row['available'];
            $subject = $row['subject'];

            echo "   <tr> \n    <td> ";
            echo "     <a href='ProbeShow.php?probeID=$probeID'> $probeName </a> ";
            echo "      </td>\n";
echo "      <td> $probeDate </td><td> $subject </td> \n";
echo "      <td> take? </td> \n";
echo "      </tr>\n";
         }
echo "   </table> \n";
      }
   }
?>
