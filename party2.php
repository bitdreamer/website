<?php
   session_start();
   include("includeInAll.php");
   //levelCheck(2); // must be at least alum level to see other alums
   include( "openDB.php" );
   openDB(1);
   //upCheck();
   include("leftMenu.php");
   include("shopHeader.php");
   include("tabledump.php");
   
   $eventCode = $_GET['eventCode'];
   if ( $eventCode != addslashes($eventCode) || $eventCode=="" ) { $eventCode = "dk"; }
?>
<script type="text/javascript" src="errorHandler.js"> </script>

<html>
	<head>
	  <title> RSVP form  </title> 
	  <link href="main.css" rel="stylesheet" type="text/css" /> 
	</head>
<body>
   <?php shopHeader(); leftMenu(); ?>
		
   <div id="main" style="background-color:lightyellow">
      <p>
	    <h1 style="text-align:center"> Meredith College <br />
		         Computer Studies Alumnae Reception <br /> 2013 Nov 6 
		</h1>
		<h3> RSVP below by 2013 Oct 30 </h3>
		<h2> Hey, we had a great time last year.  See your old classmates.  
		     Network with the high tech crowd.  Meet the new generation
			 of upcoming graduates.  
		</h2>
		
		<table border="1">
		  <tr> <td> date  </td><td>  2013 Nov 6</td>  </tr>
		  <tr> <td> time  </td><td>  5:30 PM - 7:00 PM </td>  </tr>
		  <tr> <td> location  </td><td>  SMB-265 (Computation Commons) </td>  </tr>
		  <tr> <td> food  </td><td>  heavy hors d'oeuvres </td>  </tr>
		</table>
        <br /> 
        <form method="POST" action="party3.php" >
		<?php echo "<input type='hidden' name='eventCode' value='$eventCode' />\n"; ?>
		
        first name: <input name="firstName" /> <br />
        last name: <input name="lastName" /> <br />
        email: <input name="replyEmail" /> <br />
        Will you attend?
        <select name="yesno">
          <option value="yes"> yes </option>
          <option value="no"> no </option>
          <option value="maybe"> maybe </option>
          
        </select> <br /> 
        <input type="submit" value="submit" />
        </form>
       
      </p>
	  <p> For more information, contact Barrett Koster ( kosterb ayat meredith dawt edu ) 919-760-2388.  
	  </p>
   </div>   <!-- end main -->

</body>
</html>
