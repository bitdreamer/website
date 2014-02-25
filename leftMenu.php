<?php
   // leftMenu.php
   // Barrett Koster 2011 Nov
   // This creates the menu of pages that goes on the left side of just about
   // every page.  
   
   function leftMenu()
   {
      $dept = "csc";
      
      echo "<div style=\"background-color:rgb(200,200,200);float:left;padding:20\">";
      
      linker("logger1Start.php","login",6);
      
      $qt = "SELECT name, code, level FROM Topic WHERE dept='CSC' "
            ." AND active='1' ORDER BY sequence
            ;";
      $rt = mysql_query( $qt );
      if ( noerror ( $rt ) )
      {
         $nr = mysql_num_rows( $rt );
         for ( $i=0; $i<$nr; $i++ )
         {
            $row = mysql_fetch_array( $rt );
            $name = $row['name'];
            $code = $row['code'];
            $level = $row['level'];
            linker("ContentShow.php?topicCode=$code","$name",$level);
         }
      }
      linker("http://www.meredith.edu","Meredith College",6 );
      linker("http://www.meredith.edu/math","Math & CS ",6 );
      echo "<br />";
      linker("PersonList.php","Person List",1);
      //linker("AlumList.php","List of Alums",3);
	  linker("ProbeList.php","List of Surveys",4);
      linker("ContentMake.php","Make Content",2);
      linker("TopicMake.php","Make Topic",2);
      linker("SurveyShow.php?eventCode=recep2012nov6","show nov 7 survey",1);
      linker("SurveyShow.php?eventCode=EOYP2013May4","show 2013 eoy party",1);
      linker("MajorList.php","majors",3);
	  linker("TimeBug/Calendar.php","TimeBug",1);
      echo "</div>";
   }

?>