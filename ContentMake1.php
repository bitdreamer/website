<?php
   // ContentMake1.php
   // Barrett Koster .... 2011 Nov
   // For updating Content items.
   // $_GET['contentID'] should be set.
   
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
	  <title> Bit Lab Update Content </title> 
	  <link href="main.css" rel="stylesheet" type="text/css" />
	</head>
<body>
   <?php shopHeader(); leftMenu(); ?>

<?php
   $contentID = $_GET['contentID'];
   if ( $contentID!="" && $contentID==addslashes($contentID) )
   {
      $querp = "SELECT * from Content WHERE contentID='$contentID';";
      $resp = mysql_query($querp);
      if ( noerror( $resp ) )
      {
         $roww = mysql_fetch_array( $resp );
         $title     = stripslashes($roww['title']);
         $theWords  = stripslashes($roww['theWords']);
         $active    = $roww['active'];
         $sequence  = $roww['sequence'];
         $topicCode = $roww['topicCode'];
      }
   }
?>

      <div id="main">
      <p>
         <table border="2">
         <form action="ContentMake3.php" method="POST">
         <?php echo "<input type=\"hidden\" name=\"contentID\" value=\"$contentID\" />"; ?>
            <tr> <td> title </td>
              <td> 
                 <?php echo "<input name=\"title\" value=\"$title\" /> \n"; ?>
              </td>
              <td> name of event or new item </td>
            </tr>
            <tr> <td> text of content item </td>
              <td> <textarea name="theWords" cols="50" rows="10" 
                     ><?php echo "$theWords"; ?></textarea> 
              </td>
              <td> can be whatever length </td>
            </tr>
            <tr> <td> active? </td>
              <td> 
<?php  
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
?>
              </td>
              <td> flag to include this content </td>
            </tr>
            <tr> <td> sequence number</td>
              <td> 
                <?php echo "<input name=\"sequence\" value=\"$sequence\" /> \n"; ?>
              </td>
              <td> low numbers go first </td>
            </tr>
            <tr> <td> topic </td>
              <td> 
                <?php topicChooser( $topicCode ); ?>
              </td>
              <td> hack DB if you need a new category </td>
            </tr>
            <tr>
              <td colspan="3"> <input type="submit" value="submit this content item" /> </td>
            </tr>
         </form>         
         </table>
      </p>
		</div>   <!-- end main -->

</body>
</html>
<?php
   // this function writes out a select thing for a form with options
   // being the topics.  Show the name, have the value be the code.
   function topicChooser( $currentTopicCode )
   {
      $dept = "CSC";
      $querence = "SELECT name, code FROM Topic WHERE dept='$dept';";
      $rerence = mysql_query( $querence );
      if ( noerror( $rerence ) )
      {
         echo "<select name=\"topicCode\" > \n";
         $nr = mysql_num_rows( $rerence );
         for ( $i=0; $i<$nr; $i++ )
         {
            $row = mysql_fetch_array( $rerence );
            $name = $row['name'];
            $code = $row['code'];
            echo "<option value=\"$code\" ";
            if ( $code == $currentTopicCode ) { echo " SELECTED "; }
            echo " > $name </option> \n";
         }
         echo "</select> \n";
      }
   }
?>