<?php
   // ContentMake2.php
   // Barrett Koster .... 2011 Nov
   // Process  the form MakeContent.php
   // for loading the blurbs that are much of the website content.
   /*
      Content: contentID, title, theWords, active, sequence, topicCode 
   */
   
   // This is the top for an admin page
   $bug = false;
   session_start();
   include("includeInAll.php");
   levelCheck(2);
   include( "openDB.php" );
   openDB(1);
   //include("leftMenu.php");
   //include("shopHeader.php");
   //include("tabledump.php");

   //$contentID = $_POST['contentID']; $contentIDas = addslashes($contentID);
   $title = $_POST['title'];         $titleas     = addslashes($title);
   $theWords = $_POST['theWords'];   $theWordsas  = addslashes($theWords);
   $active = $_POST['active'];
   $sequence = $_POST['sequence'];   $sequenceas  = addslashes($sequence);
   $topicCode = $_POST['topicCode'];
   
   // find new unique contentID
   $contentID = 0; // default
   $qmax = "SELECT MAX(contentID) FROM Content; ";
   $rmax = mysql_query( $qmax );
   if ( noerror( $rmax ) )
   {
      $rowwmax = mysql_fetch_array( $rmax );
      $contentID = $rowwmax[0] + 1;
   }

   
   if ($bug) { echo "<html> <body> \n"; }

	if ( $title!="" )
   {
      if ($bug)
      {
         echo "working to add "
              ."  contentID=$contentID "
              ." ,title=$titleas "
              ." ,theWords=$theWordsas "
              ." ,active=$active "
              ." ,sequence=$sequenceas "
              ." ,topicCode=$topicCode "
              ." <br /> \n"
              ;
      }
      
      $qstuff = "INSERT INTO Content SET "
                ."  contentID='$contentID' "
                ." ,title='$titleas' "
                ." ,theWords='$theWordsas' "
                ." ,active='$active' "
                ." ,sequence=$sequenceas "
                ." ,topicCode='$topicCode' "
                .";";
                
      if ($bug) { echo "qstuff=$qstuff <br /> \n"; }
      $rstuff = mysql_query($qstuff);
      errorCheck($rstuff);
      
      mkdir("pix/".$contentID);
   }
   
   if (!$bug) { header("Location: ContentShow.php?topic=$topicCode"); }
   else { echo "would have gone to <a href=\"ContentShow.php?topic=$topicCode\"> "
               ." ContentShow.php </a> <br /> \n"; 
        }
?>
</body>
</html>

