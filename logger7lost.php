<?php
   session_start();
   include("includeInAll.php");
   include("openDB.php");
   openDB(0);   
?>
<!--
   logger1Start.php  
   This page has a form, you enter your email and next page mails you
   your password.  
-->

<html>
<head><title>Email password</title></head>
<body>
	<h2>Email password  </h2> <br /><br />
	
<!-- LogIn Form -->
<form action="logger8sendPW.php" method="POST">
	<fieldset> <!-- Fields and buttons -->
		  <p2><label for="email">email</label> 
		  <input type="text" name="email" maxlength="40" /> <br /></p2>
		
		  <p class="submit"> <input type="submit" value="submit" />   </p>
		  <br />
		
	 </fieldset>     
</form>

</body>
</html>
