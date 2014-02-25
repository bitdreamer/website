<?php
   // PersonList.php
   // Show Person records.  Use various filters.
   // Allow edit.

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
	  <title> People  </title> 
	  <link href="main.css" rel="stylesheet" type="text/css" /> 
	</head>
<body>
   <?php shopHeader(); leftMenu(); ?>
		
   <div id="main" >
      <p>
        <h3> People </h3>
      <?php  
         listPerson(); 
         
         if ( $_SESSION['userLevel']<=2 )
         { echo "<a href='PersonAdd.php'> add a person  </a> <br /> \n"; }
         
      ?>     
         <a href="PersonList.php?orderBy=date"> order by date </a> <br />     
      </p>
   </div>   <!-- end main -->

</body>
</html>
<?php
   function listPerson()
   {
      $orderBy = " ORDER BY lastName ";
      if ( $_GET['orderBy']=="date" ) { $orderBy = "ORDER BY gradDateN "; }

      $userLevel = 6; // default is 6=public
      if ( $_SESSION['loginok']=="yes" ) { $userLevel = $_SESSION['userLevel']; }

      $query = "SELECT personID, firstName, lastName, gradDateN, gradActual, oldLast "
              ." ,majmin, BS "
              ." from Person "
              .$orderBy
              .";";
      $result = mysql_query( $query );
      if ( noerror( $result ) )
      {
echo "   <table border='1' style='float:left'> \n";
echo "      <tr> <td> name (was) </td> <td> graduated? </td> <td> grad date </td> "
           ." <td> major/minor )1=BS)</td> </tr> \n";
         $nr = mysql_num_rows( $result );
         for ( $i=0; $i<$nr; $i++ )
         {
            $row = mysql_fetch_array( $result );
            $firstName  = $row['firstName'];
            $lastName   = $row['lastName'];
            $oldLast    = $row['oldLast'];
            $personID     = $row['personID'];
            $gradActual = $row['gradActual'];
            $gradDateN   = $row['gradDateN'];
            $majmin     = $row['majmin'];
            $bs = $row['BS'];

echo "      <tr> <td> ";
            if ( $userLevel <= 2 )
            {echo " <a href='PersonEdit.php?personID=$personID'> $firstName $lastName </a> "; }
            else
            { echo " $firstName $lastName ";}
            if ($lastName!=$oldLast) { echo " ($oldLast) "; }
echo "      </td>\n";
echo "      <td> $gradActual </td><td> $gradDateN </td> \n";
echo "      <td> $majmin  $bs</td> \n";
echo "      </tr>\n";
         }
echo "   </table> \n";
      }
      // tabledump( $result );
     
   }
?>
