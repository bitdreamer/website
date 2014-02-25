<?php
   session_start();
   include("includeInAll.php");
   include("openDB.php");
   openDB(0);   
   include("leftMenu.php");
   include("shopHeader.php");
   include("tabledump.php");

?>
<!--
   logger1Start.php  
   This page has a 2 forms, one to let you log in (goes to logger2CheckPW.php
   to check name and password), the other form to let
   you register (goes to logger3Reg.php to process registration).  
   logger1Start.php accepts $_GET email and goto, so a person can shortcut
   the login process.  
-->

<html>
<head><title>Login-Reg</title></head>
<body>
<?php shopHeader(); leftMenu(); ?>
   <div id="main"> 
	<h2>Login  </h2> <br /><br />
	
<?php
   $gotemail = $_GET['email'];
   $gotgoto  = $_GET['goto'];
   if ( $gotemail != addslashes( $gotemail ) ) { $gotemail = ""; } // no funny stuff
   if ( $gotgoto  != addslashes( $gotgoto  ) ) { $gotgoto  = ""; }
?>
	
<!-- LogIn Form -->
<form action="logger2CheckPW.php" method="POST">
	<fieldset> <!-- Fields and buttons -->
		<legend><h3>   Already reqisterd? Login Here </h3>  </legend><br />
		  <p2><label for="email">email</label> 
<?php
		  echo "<input name='email4log' maxlength='40' value='$gotemail' /> \n";
		  echo "<input type='hidden' name='goto' value='$gotgoto'  >\n";
?>
		  <br /></p2>
		  <p2><label for="password" class="password">password</label>
		  <input type="password" name="password4log" maxlength="20" /> <br /><br /></p2>
		  <p class="submit"> <input type="submit" value="submit" />   </p>
		  <br />
		  <a href="logger7lost.php"> forgot password? </a> <br />
	 </fieldset>     
</form>

<!-- Registration Form 
<form action="logger3Reg.php" method="POST">
	
	<p1>Registering lets us fill in your sizes automatically, speed
	up shipping information.  We don't sell or give this information
	to anyone.  
	<br /><br /></p1>

	   <fieldset> 
		   <legend><h3>  Register Here </h3>  </legend><br/>
				<p2><label for="email">email</label> 
				 <input type="text" name="email4reg" maxlength="40" /> <br/></p2>
			  
				 <p2><label for"first">first name </label>
				  <input type="text" name="firstname4reg"  maxlength="20" /> <br/></p2>
			  
				 <p2><label for="last"> last name </label>
				  <input type="text" name="lastname4reg" maxlength="30" /><br/></p2>
			  
				 <p2><label for="password"> password</label>
				  <input type="password" name="password4reg" maxlength="20" /><br/></p2>
			  
				 <p2><label for="password"> pw again :-) </label>
				  <input type="password" name="password4reg2" maxlength="20" /> <br/></p2>
			 
			 
		<script type="text/javascript">
		   document.writeln("<input type=\"hidden\" value=\""
							+Math.ceil(Math.random()*1000000)
							+"\" name=\"regnum\" />"
						   );
		</script>
			  
				 <p class="submit"> <input type="submit" value="submit" /> <br />  </p> 
			 
	   </fieldset>
</form>
-->

    </div> 
</body>
</html>
