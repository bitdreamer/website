<?php
   // TopicMake3.php
   // Barrett Koster .... 2011 Nov
   // This processes the update for Topic
   // This takes $_POST['code'] and the rest
   
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
   
   $code = $_POST['code'];
   $name = addslashes( $_POST['name'] );
   $blurb = addslashes( $_POST['blurb'] );
   $topicLevel = $_POST['level'];
   $active = $_POST['active'];
   $dept = $_POST['dept'];
   
   if ( $bug ) { echo "<html><body> \n"; }

   if ( $code!="" )
   {
      if ($bug) 
      {
         echo "got from the form ... <br />";
         echo "code=$code <br /> \n";
         echo "name=$name <br /> \n";
         echo "blurb=$blurb <br /> \n";
         echo "topicLevel=$topicLevel <br /> \n";
         echo "active=$active <br /> \n";
         echo "dept=$dept <br /> \n";
      }
         $qi = "UPDATE Topic SET "
               ."  name='$name'"
               ." ,blurb='$blurb' "
               ." ,level='$topicLevel' "
               ." ,active='$active' "
               ." ,dept='$dept' "
               ." WHERE code='$code' "
               .";";
         $ri = mysql_query( $qi );
         errorCheck( $ri );
         header("Location: ContentShow.php?topicCode=$code");
      
   }
?>
	
      <?php   if ($bug) { echo " ... just did query=$qi <br />";} ?>

</body>
</html>
