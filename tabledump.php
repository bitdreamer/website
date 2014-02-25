<?php
/* This file defines the tabledump function, which displays your basic SQL
   result table, with headers.
*/

function tabledump( $result )
{
   if($result==0)
   {
      echo "<b>Error ".mysql_errno().": ".mysql_error()."</b>";
   }
   elseif (@mysql_num_rows($result)==0)
   {
      echo "<b>Query completed.  Empty result.</b><br>";
   }
   else
   {
      mysql_data_seek( $result, 0 );
   $nf = mysql_num_fields($result);
   $nr = mysql_num_rows($result);
      //echo "the result:";
      echo "<table border='1'> <thead>";
	  echo "<caption>";
	  //BARRY
	  //echo " table name code goes here";
	  echo "</caption> \n";
         echo "<tr>";
            for($i=0; $i<$nf; $i++ )
            {
               echo "<th>".mysql_field_name($result,$i)."</th>";
            }
         echo "</tr>";
      echo "</thead><tbody>";
         for($i=0; $i<$nr; $i++ )
         {
            echo "<tr>";
               $row=mysql_fetch_row($result);
               for( $j=0; $j<$nf; $j++ )
               { echo "<td>".$row[$j]."</td>"; }
            echo "</tr>";
         }
      echo "</tbody></table>";
   }
   mysql_data_seek( $result, 0 );
   return $row;
}

function tabledump2( $result, $tableName )
{
   if($result==0)
   {
      echo "<b>Error ".mysql_errno().": ".mysql_error()."</b>";
   }
   elseif (@mysql_num_rows($result)==0)
   {
      echo "<b>Query completed.  Empty result.</b><br>";
   }
   else
   {
   $nf = mysql_num_fields($result);
   $nr = mysql_num_rows($result);
      //echo "the result:";
      echo "<table border='1'> <thead>";
	  echo "<caption>";
	  //BARRY
	  echo $tableName;
	  echo "</caption> \n";
         echo "<tr>";
            for($i=0; $i<$nf; $i++ )
            {
               echo "<th>".mysql_field_name($result,$i)."</th>";
            }
         echo "</tr>";
      echo "</thead><tbody>";
         for($i=0; $i<$nr; $i++ )
         {
            echo "<tr>";
               $row=mysql_fetch_row($result);
               for( $j=0; $j<$nf; $j++ )
               { echo "<td>".$row[$j]."</td>"; }
            echo "</tr>";
         }
      echo "</tbody></table>";
   }
   mysql_data_seek( $result, 0 );
   return $row;
}


   ?>