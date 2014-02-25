<?php

   // Open the DB with appropriate level user and be ready for queries.
   function openDB( )
   {
      $host="localhost:/var/lib/mysql/mysql.sock";
      $user="TimeBugUser"; 
      $password="shmime9ug";
      
      mysql_connect($host,$user,$password);
      mysql_select_db("TimeBug");
   }

?>