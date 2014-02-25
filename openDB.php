<?php

   // Open the DB with appropriate level user and be ready for queries.
   function openDB( $level )
   {
      $host="localhost:/var/lib/mysql/mysql.sock";
      
      if ( $level>=3 )
      {
         $user="uberonyx"; 
         $password="teawasat3";
      }
      else if ( $level<=2 )
      {
        $user="onyx"; 
        $password="crookie7";
      }
      mysql_connect($host,$user,$password);
      mysql_select_db("Alums");
   }

?>