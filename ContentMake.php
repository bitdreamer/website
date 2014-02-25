<?php
   // ContentMake.php
   // Barrett Koster .... 2011 Nov
   // For loading the blurbs that form much of the website content.
   // Content: contentID, title, theWords, active, sequence, topicCode 
   
   // This is the top for an admin page
   session_start();
   include("includeInAll.php");
   levelCheck(2);
   include( "openDB.php" );
   openDB(1);
   include("leftMenu.php");
   include("shopHeader.php");
   include("tabledump.php");
?>
<html>
	<head>
	  <title> Bit Lab Make Content </title> 
	  <link href="main.css" rel="stylesheet" type="text/css" />
	</head>
<body>
   <?php shopHeader(); leftMenu(); ?>
		
      <div id="main">
      <p>
         <table border="2">
         <form action="ContentMake2.php" method="POST">
            <tr> <td> title </td>
              <td> <input name="title" /> </td>
              <td> name of event or new item </td>
            </tr>
            <tr> <td> text of content item </td>
              <td> <textarea name="theWords" cols="50" rows="10" > </textarea> </td>
              <td> can be whatever length </td>
            </tr>
            <tr> <td> active? </td>
              <td> yes <input type="radio" name="active" value="1" checked /> |
                   no <input type="radio" name="active" value="0" /> 
              </td>
              <td> flag to include this content </td>
            </tr>
            <tr> <td> sequence number</td>
              <td> <input name="sequence" /> </td>
              <td> low numbers go first </td>
            </tr>
            <tr> <td> topic </td>
              <td> 
                <?php topicChooser(); ?>
              </td>
              <td> hack DB if you need a new category </td>
            </tr>
            <tr>
              <td colspan="3"> <input type="submit" value="submit this content item" /> </td>
            </tr>
         </form>         
         </table>
      </p>
		</div>   <!-- end main -->

</body>
</html>
<?php
   // this function writes out a select thing for a form with options
   // being the topics.  Show the name, have the value be the code.
   function topicChooser()
   {
      $dept = "CSC";
      $querence = "SELECT name, code FROM Topic WHERE dept='$dept';";
      $rerence = mysql_query( $querence );
      if ( noerror( $rerence ) )
      {
         echo "<select name=\"topicCode\" > \n";
         $nr = mysql_num_rows( $rerence );
         for ( $i=0; $i<$nr; $i++ )
         {
            $row = mysql_fetch_array( $rerence );
            $name = $row['name'];
            $code = $row['code'];
            echo "<option value=\"$code\"> $name </option> \n";
         }
         echo "</select> \n";
      }
   }
?>