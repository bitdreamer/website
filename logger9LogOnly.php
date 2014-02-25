<?php
   session_start();
   include("includeInAll.php");
      include("shopHeader.php");
?>
<!--
   logger9LogOnly.php  
   This is just the login part of the logger1Start.php page.
-->
<html>
  <head>
    <title>Gaia Conceptions Login-only</title>
	 <link href="main2.css" rel="stylesheet" type="text/css" />
  </head>
<body>
   <div id="containerBlank"> 
   <?php shopHeader(); ?>
<p> 
  <ul>
    <li> You are seeing this page probably because the site is closed.  </li>
    <li> If you are an administator you can get in, of course. </li> 
    <li> And, if you want to test only what a shopper will see, check "shopper role". </li>
    <li> debug turns on extra output on pages, won't mean much unless you are a programmer </li>
    </ul> 
</p>
<h2> (Admin) Login: </h2>
<p>
<form action="logger2CheckPW.php" method="POST">
   <table>
      <tr>
         <td align="right"> email </td>
         <td> <input type="text" name="email4log" maxlength="40" /> </td>
         <td> If the site is closed you have to be admin to get in. </td>
      </tr>
      <tr>
         <td align="right"> password </td>
         <td> <input type="password" name="password4log" maxlength="20" /> </td>
         <td> You have to already have a password to use this page.  </td>
      </tr>
      <tr>
        <td align="right"> for testing: shopper role. 
        </td>
        <td> <input type="checkbox" id="shopperrole" name="shopperrole"  /> </td>
        <td> This sets user level down 
           from admin but still gives access to closed site. </td>
      </tr>
      <tr>
        <td align="right"> for testing: anonymous shopper. 
        </td>
        <td> <input type="checkbox" id="nolog" name="nolog"  /> </td>
        <td>  A flag will be set to get you into pages, but your login id
              is blank; for testing anonymous users with cart.        
        </td>
      </tr>
      <tr>
        <td align="right"> for testing: debug  </td>
        <td> <input type="checkbox" id="debug" name="debug"  /> </td>
      </tr>
      <tr>
         <td align="right"> login </td>
         <td> <input type="submit"  />   </td>
      </tr>
   </table>
</form>
</p>
   </div> <!-- end of containerBlank -->
</body>
</html>
