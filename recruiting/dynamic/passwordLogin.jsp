<%@ page import="GateKeeper" %>

<script>
function closeWindow()
{
	window.opener.location = "puzzle.jsp";
	window.close();
}
</script>

<html>
<head><title>Verifying Password</title></head>

<% GateKeeper gateKeep = (GateKeeper) application.getAttribute("gateKeep"); %>

<%	response.setHeader("pragma","no-cache");
   	response.setHeader("cache-control","no-cache");

	String password = request.getParameter("passwordField");
	String userName = request.getParameter("usernameField"); 

	if( userName != null )
	{	
		if( gateKeep.grantAccessPW( userName , password ) )
		{ 
			session.setAttribute("loginSuccess", "true");%>
			<body onLoad = "closeWindow();"></body>
<%		} else 
		{
			Integer loginAttempts = (Integer) session.getAttribute("loginAttempts");
			int attemptsInt = loginAttempts.intValue();

			if( attemptsInt < 5 )
			{
				attemptsInt++;
				loginAttempts = new Integer(attemptsInt);
				session.setAttribute("loginSuccess", "false");
				session.setAttribute("loginAttempts", loginAttempts ); %>

				<body>
				<h2> <b> Sorry -</b></h2>
                <p><font size="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				Your password does not match our stored data.  </font>
				<p> <a href="passwordLogin.jsp"> Try Again </a>&nbsp;&nbsp;&nbsp;
				<a href="forgotPassword.jsp"> Forgot Password </a>&nbsp;&nbsp;&nbsp;
				<a href="newAccount.jsp"> Create a New Account </a>
				</body>			
<%			} else 
			{ %>	<body onLoad = "closeWindow();"></body>		<% }
		} 
	} else
	{ %>	
			<body>
			<h2><b>Puzzle Login</b></h2>
			<form action=passwordLogin.jsp method=post>
			<table border="1" width="100%" cellspacing="1" cellpadding="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" height="44">
  			<tr>
    		<td width="12%" height="19"><font size="4">User ID:</font></td>
    		<td width="90%" height="19"><input type=text name=usernameField></td>
  			</tr>	<tr>
    		<td width="12%" height="17"><font size="4">Password:</font></td>
    		<td width="90%" height="17"><input type=password name=passwordField></td>
  			</tr>	<tr>
			<td width="12%" height="17"></td>
			<td width="90%" height="17"><input type=submit value=Submit></td>	
			</tr>	</table>	</form>
			<p> <a href="forgotPassword.jsp"> Forgot Password </a>&nbsp;&nbsp;&nbsp;
			<a href="newAccount.jsp"> Create a New Account </a>			
			</body>	
<%	} %>
	
</html>	