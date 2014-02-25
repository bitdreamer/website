<?php
   // TopicMake.php
   // Barrett Koster .... 2011 Nov
   // For loading the topics, each of these shows up in the menu
   // Topic: name, code, desc, level, active, dept 
   // This page just gets a new name and then goes to the topic-edit page
   // to put in the rest of the stuff.
   
   // This is the top for an admin page
   session_start();
   include("includeInAll.php");
   levelCheck(2);
   include( "openDB.php" );
   openDB(1);
   include("leftMenu.php");
   include("shopHeader.php");
   include("tabledump.php");
?>
<html>
	<head>
	  <title> Bit Lab Make Topic </title> 
	  <link href="main.css" rel="stylesheet" type="text/css" />
	</head>
<body>
   <?php shopHeader(); leftMenu(); ?>
   
   
		
      <div id="main">
      <p>
         <form action="TopicMake2.php" method="POST">
         title
              <input name="name" /> <br />
              This name will show up in the left menu, so be careful with it.
              It should be for a whole category of content items
              you are going to add.
              <input type="submit" value="submit new topic" />
         </form>         
      </p>
      <p>
<?php
   $qlist = "SELECT * FROM Topic ;";
   $rlist = mysql_query( $qlist );
   if ( errorFree( $rlist ) )
   {
      echo "<table border=\"2\" > \n";
      echo "<tr> <td>name (click to edit) </td><td>code </td><td>description </td>"
           ." <td> level</td> "
           ."<td> active </td><td> dept </td>  </tr>";
      $nr = mysql_num_rows( $rlist );
      for ( $i=0; $i<$nr; $i++ )
      {
         $row = mysql_fetch_array( $rlist );
         $name = $row['name'];
         $code = $row['code'];
         $blurb = $row['blurb'];
         $topicLevel = $row['level'];
         $active = $row['active'];
         $dept = $row['dept'];
         
         
         echo "<tr> \n";
         echo "<td> <a href=\"TopicMake1.php?code=$code\"> "
              .stripslashes($name)." </a></td> \n";
         echo "<td> $code </td> \n";
         echo "<td> ".stripslashes($blurb)." </td> \n";
         echo "<td> $topicLevel </td> \n";
         echo "<td> $active </td> \n";
         echo "<td> $dept </td> \n";
         echo "</tr> \n";
      }
      echo "</table> \n";
   }
?>
      </p>
		</div>   <!-- end main -->

</body>
</html>
