<?php
   session_start();
   include("includeInAll.php");
   levelCheck(2); // must be at least alum-admin level to see other alums
   include( "openDB.php" );
   openDB(1);
   //upCheck();
   include("leftMenu.php");
   include("shopHeader.php");
   include("tabledump.php");
   
?>
<script type="text/javascript" src="errorHandler.js"> </script>

<html>
	<head>
	  <title> Alum Survey results  </title> 
	  <link href="main.css" rel="stylesheet" type="text/css" /> 
	</head>
<body>
   <?php shopHeader(); leftMenu(); ?>
		
   <div id="main" >
      <p>
        <h3>  Alum Survey results</h3>
<?php
   $qall = "SELECT fullName, jobTitle, employer, skillUse, merePrep FROM AlumSurvey2013;";
   $rall = mysql_query( $qall );
   if ( noerror( $rall ) )
   {
      echo "<table border='1'>\n";
	  echo "<tr> <td> fullName </td> <td>jobTitle </td>  <td> employer</td> "
	       ." <td>skillUse </td> <td> merePrep </td> </tr>\v";
      $nr = mysql_num_rows( $rall );
	  $sutot = 0;
	  $mptot = 0;
	  for ( $i=0; $i<$nr; $i++ )
	  {
	     $row = mysql_fetch_array( $rall );
		 $fullName = $row['fullName'];
		 $jobTitle = $row['jobTitle'];
		 $employer = $row['employer'];
		 $skillUse = $row['skillUse'];
		 $merePrep = $row['merePrep'];
		 
		 $sutot += $skillUse;
		 $mptot += $merePrep;
		 
		 echo "<tr>";
		 echo "<td> $fullName </td>";
		 echo "<td> $jobTitle </td>";
		 echo "<td> $employer </td>";
		 echo "<td> $skillUse </td>";
		 echo "<td> $merePrep </td>";
		 echo "</tr>\n";
	  }
	  echo "</table>\n";
	  
	  $suavg = $sutot / $nr;
	  $mpavg = $mptot / $nr; 
	  echo "total=$nr, skillUse avg = $suavg, Meredith Prep avg = $mpavg <br /> \n";
      //tabledump( $rall );
   }
?>
      </p>
   </div>   <!-- end main -->

</body>
</html>
