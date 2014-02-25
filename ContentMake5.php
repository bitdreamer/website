<?php
   // ContentMake5.php
   // Barrett Koster .... 2011 Nov
   // Process  the form MakeContent4.php (for loading pictures)
   /*
      Picture: contentID, pictureName, sequence, caption, source 
   */
   
   // This is the top for an admin page
   $bug = false ; //true;
   session_start();
   include("includeInAll.php");
   levelCheck(2);
   include( "openDB.php" );
   openDB(1);
   //include("leftMenu.php");
   //include("shopHeader.php");
   //include("tabledump.php");
   
   $userID = $_SESSION['id'];
   
   if ($bug) { echo "<html> <body> \n"; }
   
   $contentID = $_POST['contentID'];
   $pictureName = $_FILES['pictureName']['name'];
   $caption = $_POST['caption'];
   $sequence = $_POST['sequence'];
   if ($bug) { echo "trying to process contentID=$contentID pictureName=$pictureName "
                    ." caption=$caption sequence=$sequence <br /> \n"; 
             }
   
   if ( $contentID!="" )
   {
      //mkdir("pix/$contentID");
  
      move_uploaded_file($_FILES['pictureName']['tmp_name'], 
          "pix/$contentID/$pictureName");

      $qstuff = "INSERT INTO Picture SET "
                ."  contentID='$contentID' "
                ." ,pictureName='$pictureName' "
                ." ,sequence='$sequence' "
                ." ,caption='$caption' "
                ." ,source='$userID' "
                .";";
                
      if ($bug) { echo "qstuff=$qstuff <br /> \n"; }
      $rstuff = mysql_query($qstuff);
      errorCheck($rstuff);
      
   }
   
   if (!$bug) { header("Location: ContentShow7.php?contentID=$contentID"); }
   else { echo "would have gone to <a href=\"ContentShow7.php?contentID=$contentID\"> "
               ." ContentShow7.php?contentID=$contentID </a> <br /> \n"; 
        }
?>
</body>
</html>

