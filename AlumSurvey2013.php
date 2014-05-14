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
   //hi
   $eventCode = $_GET['eventCode'];
   if ( $eventCode != addslashes($eventCode) || $eventCode=="" ) { $eventCode = "dk"; }
?>
<script type="text/javascript" src="errorHandler.js"> </script>

<html>
	<head>
	  <title> Survey for Meredith College Computer Systems/Studies/Science Alums Survey  </title> 
	  <link href="main.css" rel="stylesheet" type="text/css" /> 
	</head>
<body>
   <?php shopHeader(); leftMenu(); ?>
		
   <div id="main" >
      <p>
	  <h2> Computer Systems/Studies/Science <br /> Alumnae Survey  </h2> 
	  <h3> Meredith College </h3>
        <p>  Purpose: We are trying
			  to assess how well we are doing as a department.  Your answers are optional,
			  but hey, it's us (Barry + Kristin).  Any information you
			  give is for department use only, and will not be given or
			  sold to anyone for any reason.  Also, if you are in grad school
			  instead of employed, that's fine, just mash your answers into the
			  blanks ... we'll figure it out.  
		</p>
        
        <form method="POST" action="AlumSurvey3.php" >
		<?php echo "<input type='hidden' name='eventCode' value='$eventCode' />\n"; ?>
		
        employer (or school): <input name="employer" /> <br />
        job title: <input name="jobTitle" /> <br />
		job description: <textarea name="jobDescription" rows="4" cols="50"> </textarea> <br />
        How much do you feel you use your computer skills on the job? 
		<select name="skillUse">
          <option value="0"> none </option>
          <option value="1"> very little </option>
          <option value="2"> some  </option>
          <option value="3"> quite a lot </option>
          <option value="4"> extensively </option>
        </select> <br /> 

		<br />
        How well do you feel that Meredith prepared you for this position? 
		<select name="merePrep">
          <option value="0"> not at all </option>
          <option value="1"> very little </option>
          <option value="2"> in some ways  </option>
          <option value="3"> quite a lot </option>
          <option value="4"> totally </option>
        </select> <br /> 
       <br />
		What was most valuable about your experience at Meredith? 
		<textarea name="mostValue" rows="4" cols="50"> </textarea> <br />
		Can you suggest any improvements to our program? 
		<textarea name="improvements" rows="4" cols="50"> </textarea> <br />
		Please give us any other comments: 
		<textarea name="general" rows="4" cols="50"> </textarea> <br />
		What was your degree?
		
		
        <select name="degree">
          <option value="CBSB"> CSC BS major </option>
          <option value="CSBA"> CSC BA major </option>
          <option value="CIS"> CIS BA major </option>
          <option value="MCS"> MCS major (from the 90s) </option>
          <option value="minor"> one of the computer related minors </option>
          <option value="zip"> no official computer designation </option>          
        </select> <br /> 
        and year your graduated: <input name="grajYear" /> <br />
        name (add old name in parentheses if changed): <input name="fullName" /> <br />
        email: <input name="email" /> <br />
 		
        <input type="submit" value="submit" />
        </form>
		
      </p>
	  
   </div>   <!-- end main -->
        
</body>
</html>
