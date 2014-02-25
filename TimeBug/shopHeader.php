<?php

   function shopHeader( $personID )
   {
      echo "<div>";
      echo " <div style=\"height:80;background-color:rgb(120,180,240)\"> ";
      echo " <h1 style='text-align:center'> TimeBug </h1> \n";
	  $nom = $_SESSION['nickName'];
	  echo " <h3 style='text-align:center'> for  $nom ($personID) </h3> \n";
      echo " </div>  ";  
      echo " </div>  ";  
   }
   
?>