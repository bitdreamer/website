<?php
   // ContentShow.php
   // Barrett Koster .... 2011 Nov
   // Shows all items in Content for one topic.  $_GET['topicCode'] will have
   // the topicCode.
   // Content: contentID, title, theWords, active, sequence, topicCode 
   
   // This is the top for an admin page
   session_start();
   include("includeInAll.php");
   levelCheck(6); // will want to set this to the level for this topic
   include( "openDB.php" );
   openDB(1);
   include("leftMenu.php");
   include("shopHeader.php");
   include("tabledump.php");
   
   
   
   $act=1;
   if ( $_GET['active']=="no" ) { $act = 0; }
   
   $topicCode = $_GET['topicCode'];
   $topicCodeas = addSlashes($topicCode);
   if ( $topicCode!="" && $topicCode==$topicCodeas )
   {
      $qtn = "SELECT name, blurb, level FROM Topic WHERE code='$topicCode';";
      $rtn = mysql_query($qtn);
      if ( noerror( $rtn ) )
      {
         $rname = mysql_fetch_array( $rtn );
         $name = $rname['name'];
         $blurb = $rname['blurb'];
         $topicLevel = $rname['level'];
         //levelCheck( $topicLevel );
      }
   }
?>
<html>
	<head>
	  <title> Bit Lab Show Content </title> 
	  <link href="main.css" rel="stylesheet" type="text/css" />
	</head>
<body>
   <?php shopHeader(); leftMenu(); ?>
		
      <div id="main">
      <h2> <?php echo "$name "; ?> </h2>
      <p> 
      <?php 
         echo " $blurb <br />\n"; 
		 //if ( isset( $_SESSION['level'] ) ) { $sessionLevel = $_SESSION['level']; }
		// else { $sessionLevel = 6; }
		 //echo "level=$sessionLevel <br />";
         if ( $_SESSION['level']<=2 )
         { echo "<a href=\"TopicMake1.php?code=$topicCode\">(edit)</a>"; }
      ?>  
      </p>
<?php
   if ($topicCode!="" && $topicCode==$topicCodeas )
   {
      $query = "SELECT contentID, title, theWords FROM Content "
              ." WHERE topicCode='$topicCode' "
              ." AND active=$act "
              ." ORDER BY sequence;";
      $result = mysql_query( $query );
      if ( noerror( $result ) )
      {
         echo "<table border=\"2\" padding=\"10\" cellpadding=\"10\"> \n";
         $nr = mysql_num_rows( $result );
         for ( $i=0; $i<$nr; $i++ )
         {
            $row = mysql_fetch_array($result);
            $contentID = $row['contentID'];
            $title = stripslashes( $row['title'] );
            $theWords = stripslashes( $row['theWords'] ); 
            
            if ( $i%3==0) {  echo "<tr> \n"; }
            echo "<div> \n";
            
            // show the first picture
            echo "<td> \n";
            $qpic = "SELECT pictureName FROM Picture WHERE "
                   ." contentID='$contentID' "
                   ." ORDER BY sequence;";
            $rpic = mysql_query( $qpic );
            if ( errorFree( $rpic ) ) 
            {
               $npix = mysql_num_rows( $rpic );
               if ( $npix>0 )
               {
                  $rpic1 = mysql_fetch_array( $rpic );
                  $pictureName = $rpic1['pictureName'];
                  echo "<img src=\"pix/$contentID/$pictureName\" width=\"200\" "
                      ."  />";
               }
            }
            //echo "</td> \n";
            
            //echo "<td>\n";
            //echo "<br /><b> $title </b> <br /> \n";
            echo "<br /><a href=\"ContentShow7.php?contentID=$contentID\"> $title </a>\n";
            echo "</td> \n ";

            if ( $i%3==2) { echo "</tr> \n"; }

         }
         if ( $i%3!=0 ) { echo "</tr> \n"; }
         echo "</table> \n";
      }
   }
   if ( $_SESSION['level'] <=2 && $act==1 )
   { echo "<a href=\"ContentShow.php?topicCode=$topicCode&active=no\">show inactives</a>"; }
?>     
		</div>   <!-- end main -->


</body>
</html>