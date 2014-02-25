<?php
   // ContentShow7.php
   // Barrett Koster .... 2011 Nov
   // Show content for one item.  $_GET['contentID'] should be set.
   // Content: contentID, title, theWords, active, sequence, topicCode 
   
   session_start();
   include("includeInAll.php");
   levelCheck(6); // will want to set this to the level for this topic
   include( "openDB.php" );
   openDB(1);
   include("leftMenu.php");
   include("shopHeader.php");
   include("tabledump.php");
   
?>
<html>
	<head>
	  <title> Bit Lab Show Content </title> 
	  <link href="main.css" rel="stylesheet" type="text/css" />
	</head>
<body>
   <?php shopHeader(); leftMenu(); ?>
		
      <div id="main">
<?php

   $contentID = $_GET['contentID'];
   $contentIDas = addSlashes($contentID);

   if ( $contentID!="" && $contentID==$contentIDas )
   {
         if ( $_SESSION['level']<=2)
         {
            echo " <a href=\"ContentMake4.php?contentID=$contentID\"> add pix</a>, \n";
            echo "  <a href=\"ContentMake1.php?contentID=$contentID\">edit</a><br />\n";
         }
      $query = "SELECT  title, theWords FROM Content "
              ." WHERE contentID='$contentID' "
              ." AND active=1 "
              ."  ;";
      $result = mysql_query( $query );
      if ( noerror( $result ) )
      {
         $row = mysql_fetch_array($result);
         $title = stripslashes( $row['title'] );
         $theWords = stripslashes( $row['theWords'] ); 
         
         echo "<h2> $title </h2> \n";

         
         echo "$theWords <br /> \n";
         
         $qpic = "SELECT pictureName, caption FROM Picture WHERE "
                ." contentID='$contentID' "
                ." ORDER BY sequence;";
         $rpic = mysql_query( $qpic );
         if ( errorFree( $rpic ) ) 
         {
            $npix = mysql_num_rows( $rpic );
            for ( $j=0; $j<$npix; $j++ )
            {
               $rpic1 = mysql_fetch_array( $rpic );
               $pictureName = $rpic1['pictureName'];
               $caption = $rpic1['caption'];
               echo "<br />";
               echo "<img src=\"pix/$contentID/$pictureName\" width=\"650\"   />";
               echo "<br /> $caption <br /> \n";
            }
         }
      }
   }
?>     
		</div>   <!-- end main -->

</body>
</html>