<?php
   // ContentMake3.php
   // Barrett Koster .... 2011 Nov
   // Process  the form MakeContent1.php to update Content
   // Content: contentID, title, theWords, active, sequence, topicCode 
   
   // This is the top for an admin page
   $bug = false; //true;
   session_start();
   include("includeInAll.php");
   levelCheck(2);
   include( "openDB.php" );
   openDB(1);
   //include("leftMenu.php");
   //include("shopHeader.php");
   //include("tabledump.php");

   $contentID = $_POST['contentID']; 
   $title = $_POST['title'];         $titleas     = addslashes($title);
   $theWords = $_POST['theWords'];   $theWordsas  = addslashes($theWords);
   $active = $_POST['active'];
   $sequence = $_POST['sequence'];   $sequenceas  = addslashes($sequence);
   $topicCode = $_POST['topicCode'];
   
   if ($bug) { echo "<html> <body> \n"; }

   if ( $contentID!="" && $sequence==$sequenceas )
   {
      if ($bug)
      {
         echo "working to update "
              ."  contentID=$contentID "
              ." ,title=$titleas "
              ." ,theWords=$theWordsas "
              ." ,active=$active "
              ." ,sequence=$sequence "
              ." ,topicCode=$topicCode "
              ." <br /> \n"
              ;
      }
      
      $qstuff = "UPDATE Content SET "
                 ." title='$titleas' "
                ." ,theWords='$theWordsas' "
                ." ,active='$active' "
                ." ,sequence=$sequence "
                ." ,topicCode='$topicCode' "
                ." WHERE contentID='$contentID' "
                .";";
                
      if ($bug) { echo "about to do qstuff=$qstuff <br /> \n"; }
      
      $rstuff = mysql_query($qstuff);
        errorCheck($rstuff); 
     
   }
   
   if (!$bug) { header("Location: ContentShow7.php?contentID=$contentID"); }
   else { echo "would have gone to <a href=\"ContentShow7.php?contentID=$contentID\"> "
               ." Show Content </a> <br /> \n"; 
        }
?>
</body>
</html>

