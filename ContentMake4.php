<?php
   // ContentMake4.php
   // Barrett Koster .... 2011 Nov
   // For loading the picture part of content.
   // Must be called with contentID in POST
   
   // This is the top for an admin page
   $bug = true;
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
	  <title> Bit Lab Load Picture </title> 
	  <link href="main.css" rel="stylesheet" type="text/css" />
	</head>
<body>
   <?php shopHeader(); leftMenu(); ?>
		
   <?php
      $contentID = $_GET['contentID'];
      if ($bug) { echo "contentID=$contentID <br /> \n"; }
      if ( $contentID!="" && $contentID==addslashes($contentID) )
      {
         $qtitle = "SELECT title FROM Content WHERE contentID='$contentID';";
         $rtitle = mysql_query( $qtitle );
         if ( noerror( $rtitle ) )
         {
            $row = mysql_fetch_array( $rtitle );
            $title = $row['title'];
         }
      }
   ?>
      
      <div id="main">
      <p>
         <table border="2">
         <form enctype="multipart/form-data" action="ContentMake5.php" method="POST">
         <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
         <?php 
            echo "<input type=\"hidden\" name=\"contentID\" value=\"$contentID\" /> \n";
         ?>
            <tr> <td> picture file </td>
              <td> <input type="file" name="pictureName" /> </td>
              <td> for content: <?php echo "$title"; ?> </td>
            </tr>

             <tr> <td> caption</td>
              <td> <input name="caption" /> </td>
              <td> not required </td>
            </tr>
             <tr> <td> sequence number</td>
              <td> <input name="sequence" /> </td>
              <td> low numbers go first </td>
            </tr>
            <tr>
              <td colspan="3"> <input type="submit" value="load this picture" /> </td>
            </tr>
         </form>         
         </table>
      </p>
		</div>   <!-- end main -->

</body>
</html>