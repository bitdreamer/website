<?php
   
   // if there's an error, head to ErrorReport with messages (and don't return)
   function mysqlErrorCheck( $result )
   {
      echo "inside mysqlErrorCheck ";
      //if ( $result.mysql_errno() != 0 )
      {
         $num = mysql_errno();
         $msg = addslashes( mysql_error());
         echo "num=$num msg=$msg";
         header("Location: ErrorReport.php?stat=mysqlerror&num=ack&msg=blork"); exit;
      }
   }

   
   // this is pure error check.  prints if there is one, not if not.
   // Note: empty is NOT an error here.
   function errorFree( $result )
   {
      if($result==0)
      {
          //echo "check1";
         echo "<b>Error ".mysql_errno().": ".mysql_error()."</b>";
         return false;
      }
      else { return true; }
   }
   // this is pure error check.  prints if there is one, not if not.
   // Note: empty is NOT an error here.
   function errorCheck( $result )
   {
      if($result==0)
      {
          //echo "check1";
         echo "<b>Error ".mysql_errno().": ".mysql_error()."</b>";
         return false;
      }
      else { return true; }
   }


   // Returns true if $result has no errors and is not empty.
   // Will echo HTML if there IS an error.
   function noerror( $result )
   {
      if($result==0)
      {
          //echo "check1";
         echo "<b>Error ".mysql_errno().": ".mysql_error()."</b>";
         return false;
      }
      elseif (@mysql_num_rows($result)==0)
      {
         //echo "check2";
         echo "<b>Query completed.  Empty result.</b><br>\n";
         return false;
      }
      else
      { return true; }
   }
?>
<?php
   // Returns true if $result is empty (but no an error).  No echoes.
   function isEmpty( $result )
   {
      if($result==0)
      {
         //echo "<b>Error ".mysql_errno().": ".mysql_error()."</b>";
         return false;
      }
      elseif (@mysql_num_rows($result)==0)
      {
         //echo "<b>Query completed.  Empty result.</b><br>";
         return true;
      }
      else
      { return false; }
   }
?>
<?php
   // make sure we are logged in at target level (or above)
   // else header to ErrorReport.php
   // Note: must be called before any HTML in file.
   // Return status is not necessary.  If it returns at all, you're good.
   function levelCheck( $target )
   {
      if ( $_SESSION['loginok']!="yes" )
      {
         $_SESSION['level'] = 6; // public
      }
      if ( $_SESSION['level']>$target )
      {
         header("Location: ErrorReport.php?stat=NotLevel$target"); exit;
      }
   }
?>
<?php
   // create a link to $url that says $sez iff the user's $userLevel is at or below $lev.
   function linker( $url, $sez, $lev )
   {
      $userLevel = 6; // default is 5=public
      if ( $_SESSION['loginok']=="yes" ) { $userLevel = $_SESSION['userLevel']; }
      
      if ( $userLevel <= $lev )
      {
         echo "<a href=\"$url\"> $sez </a> <br /> \n";
      }
   }

?>
<?php
   // upCheck.  make sure the site is up.  If not, go to the 'down' page.
   // This expects the database to be open.
   // Note: if you are logged in as admin level 3, give a warning (or not), but 
   // let the person look at the page.
   // Note: level 2 should also get in (but won't be allowed on admin
   // pages presumably ... other code will determine this).  
   function upCheck()
   {
      if ( /* $_SESSION['loginok']=="yes" && */ $_SESSION['level']>=2 )
      {
         // warning if the site is closed .... or ... no warning, just go.
         // ... just pass through, staying on this page is ok
      }
      else
      {
         $query = "SELECT status FROM SiteStatus";
         $result = mysql_query( $query );
         if ( noerror($result) )
         {
            $row = mysql_fetch_row( $result );
            $up = $row[0];
            //echo "<h3> status:$row[0]:status </h3>";
            if ( $up==0 )
            {
               header("Location: Down.php"); exit;
            }
            // else just pass through, staying on this page is ok
         } 
         else
         {
            echo "status query screwed up ....";
            // If there is an error, should we be up or down?
         }
      }
   }
   if ( $_SESSION['debug']=="yes" ) { $bug = true; }
?>
<?php
   // noonObject takes a date string (YYYY-MM-DD format) and returns a time object (int) which is for
   // that date at noon.
   function noonObject( $dateString )
   {
   	   $parts = preg_split('[-]',$dateString ); // split the start date into 3 parts 
	   $dap = mktime( 12, 0, 0, $parts[1], $parts[2], $parts[0] );  // args: h, m, s, M, D, Y 
       return $dap;
   }
?>