<?php
   // TopicMake3.php
   // Barrett Koster .... 2011 Nov
   // This has the update form for Topic
   // This takes $_GET['code'] and fills the form with current info.
   // Process in TopicMake3.php.
   
   // Topic: name, code, desc, level, active, dept 
   
   // This is the top for an admin page
   $bug = false;
   session_start();
   include("includeInAll.php");
   levelCheck(2);
   include( "openDB.php" );
   openDB(1);
   include("leftMenu.php");
   include("shopHeader.php");
   include("tabledump.php");
   
   $stillok = false;
   $code = $_GET['code'];
   if ( $code!=addslashes($code) ) { header("Location: /"); exit; }

   if ( $code!="" )
   {
      $qtop= "SELECT * from Topic WHERE code='$code';";
      $rtop = mysql_query( $qtop );
      if ( noerror( $rtop ) )
      {
         $stillok = true;
         $row = mysql_fetch_array( $rtop );
         $name = stripslashes( $row['name'] );
         $blurb = stripslashes( $row['blurb'] );
         $topicLevel = $row['level'];
         $active = $row['active'];
         $dept = $row['dept'];
      
      }
   }
?>
<html>
	<head>
	  <title> Bit Lab Update Topic </title> 
	  <link href="main.css" rel="stylesheet" type="text/css" />
	</head>
<body>
   <?php shopHeader(); leftMenu(); ?>
		
      <div id="main">
      <h2> update Topic with code = <?php echo "$code"; ?></h2>
<?php

   if ( $stillok )
   {
      echo "<form action=\"TopicMake3.php\" method=\"POST\" >";
      echo "<table border=\"2\" > \n";
      echo "<input name=\"code\" value=\"$code\" />";
      
      // name
      echo "<tr> <td>  name <td> <td> ";
      echo "<input name=\"name\" value=\"$name\" > ";
      echo " </td> <td> appears in the menu </td> </tr> \n";
      
      // blurb
      echo "<tr> <td>  blurb <td> <td> ";
      echo "<textarea name=\"blurb\" cols=\"50\" rows=\"10\">$blurb</textarea>";
      echo "</td> <td> shows at top of topic page "
           ." </td> </tr> \n";
           
      // level
      echo "<tr> <td>  level <td> <td> ";
         levelMenu( $topicLevel );
      echo "      </td> <td> who can see this topic? </td> </tr> \n";
      
      // active
      echo "<tr> <td> active  <td> <td> ";
         if ( $active==1 )            
         {
           echo " yes <input type='radio' name='active' value='1' checked /> | ";
           echo "  no <input type='radio' name='active' value='0' /> ";
         }
         else
         {
           echo " yes <input type='radio' name='active' value='1' /> | ";
           echo "  no <input type='radio' name='active' value='0' checked /> ";
         }
      echo "      </td> <td> 0 or 1 </td> </tr> \n";
      
      //dept
      echo "<tr> <td>  dept <td> <td> ";
      echo "<input name=\"dept\" value=\"$dept\">";
      echo " </td> <td> all caps </td> </tr> \n";
      
      echo "<tr><td colspan=\"3\"> <input type=\"submit\" value=\"submit changes\" >"
           ."      </td> </tr> \n";
      echo "</table> \n";
      echo "</form>";
   }
?>
      
		</div>   <!-- end main -->

</body>
</html>

<?php
   function levelMenu( $topicLevel )
   {
      $levelList = array(
      "1" => "sys admin",
      "2" => "dept admin",
      "3" => "dept major",
      "4" => "meredith student or alum",
      "5" => "prospect",
      "6" => "public",
      );
      
      echo "       <select name=\"level\"> \n";
      
      for ( $i=1; $i<=6; $i++ )
      {
         echo "         <option value='$i'";
         if ( $topicLevel == $i ) { echo " SELECTED "; }
         echo " > ".$levelList[$i]." </option> \n";
      }
      
      /*
      echo "         <option value=\"1\"> sys admin </option> \n";
      echo "         <option value=\"2\"> dept admin </option> \n";
      echo "         <option value=\"3\"> dept major </option> \n";
      echo "         <option value=\"4\"> meredith student or alum </option> \n";
      echo "         <option value=\"5\"> prospects </option> \n";
      echo "         <option value=\"6\"> public </option> \n";
      */
      echo "       </select > \n";
   }
?>
