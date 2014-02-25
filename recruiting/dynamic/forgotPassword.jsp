<%@ page import="GateKeeper" %>

<script>
function closeWindow()
{
	window.opener.location = "puzzle.jsp";
	window.close();
}
</script>

<html>
<head><title>Login with Personalized Question and Answer</title></head>

<% GateKeeper gateKeep = (GateKeeper) application.getAttribute("gateKeep"); %>

<%	response.setHeader("pragma","no-cache");
   	response.setHeader("cache-control","no-cache");

	String answer = request.getParameter("answerField");
	String userName = request.getParameter("usernameField");%>

<%if( userName != null || answer != null )
{
	if( answer != null ) 
	{
		if( !gateKeep.emptyString( answer ) ) 
		{
			if( gateKeep.grantAccessQ( answer ) )
			{ 
				session.setAttribute("loginSuccess", "true"); %>
				<body onLoad = "closeWindow();"></body>
		<%	} else
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
					<h2> Sorry - </h2>
					<p> <font size="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
					Your password does not match your account information.</font>
					<p> <a href="passwordLogin.jsp"> Try Again</a>&nbsp;&nbsp;&nbsp;
					<a href="forgotPassword.jsp"> Forgot Your Password </a>&nbsp;&nbsp;&nbsp;
					<a href="newAccount.jsp"> Create a New Account </a>
					</body>
			<%	} else 
				{ %>	<body onLoad = "closeWindow();"></body>		<% }
			}
		} else 
		{	String question = gateKeep.getQuestion( userName ); %>
				
			<body>
			<h2><b>Login Without Password</b></h2>
			<form action=forgotPassword.jsp method=post>
			<table border="1" width="100%" cellspacing="1" cellpadding="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" height="44">
			<tr> <td width="12%" height="19"><font size="4">Question:</font></td>
			<td width="90%" height="19"><%= question%> </td> </tr>
			<tr> <td width="12%" height="17"><font size="4">Answer:</font></td>
			<td width="90%" height="17"><input type=text name=answerField size=50></td>
			</tr>
			<tr> <td width="12%" height="17"> <input type=hidden name=userNameField value=userName></td>
			<td width="90%" height="17"><input type=submit value=Submit></td>	
			</tr>	</table>	</form>		
			<p> <a href="newAccount.jsp"> Create a New Account </a>&nbsp;&nbsp;&nbsp;
			<a href="passwordLogin.jsp"> Login with Password </a>		
			</body>
	<%	}
	} else 
	{
		if( !gateKeep.emptyString(userName) ) 
		{
			if( gateKeep.userExist(userName) ) 
			{	String question = gateKeep.getQuestion( userName ); %>
				
				<body>
				<h2><b>Login Without Password</b></h2>
				<form action=forgotPassword.jsp method=post>
				<table border="1" width="100%" cellspacing="1" cellpadding="0" bordercolorlight="#FFFFFF" bordercolordark="#FFFFFF" height="44">
				<tr> <td width="12%" height="19"><font size="4">Question:</font></td>
				<td width="90%" height="19"><%= question%> </td> </tr>
				<tr> <td width="12%" height="17"><font size="4">Answer:</font></td>
				<td width="90%" height="17"><input type=text name=answerField size=50></td>
				</tr>
				<tr> <td width="12%" height="17"> </td>
				<td width="90%" height="17"><input type=submit value=Submit></td>	
				</tr>	</table>	</form>		
				<p> <a href="newAccount.jsp"> Create a New Account </a>&nbsp;&nbsp;&nbsp;
				<a href="passwordLogin.jsp"> Login with Password </a>		
				</body>
		<%	} 
			else
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
					We were unable to locate this account.</font>
					<p> <a href="newAccount.jsp"> Create a New Account </a>&nbsp;&nbsp;&nbsp;
					<a href="passwordLogin.jsp"> Login with Password </a>		
					</body>
			<%	} else 
				{ %>	<body onLoad = "closeWindow();"></body>		<% }
			}
		} else
		{ %>	<body>	<form action=forgotPassword.jsp method=post>
			<h2><b>Login Without Password</b></h2>
			<table border="1" width="100%" cellspacing="1" cellpadding="0" bordercolor="#FFFFFF">
			<tr>	<td width="11%">User Name:</td>
			<td width="89%"><input type=text name=usernameField size="20">	</td>	</tr>
			<tr> <td width="11%"></td>
			<td width="89%"><input type=submit value=Submit>  </td>
			</tr>  </table>	</form>		
			<p> <a href="newAccount.jsp"> Create a New Account </a>&nbsp;&nbsp;&nbsp;
			<a href="passwordLogin.jsp"> Login with Password </a>		  
			</body>
<%		}
	}
} else 
{%>	<body>	<form action=forgotPassword.jsp method=post>
	<h2><b>Login Without Password</b></h2>
	<table border="1" width="100%" cellspacing="1" cellpadding="0" bordercolor="#FFFFFF">
	<tr>	<td width="11%">User Name:</td>
	<td width="89%"><input type=text name=usernameField size="20">	</td>	</tr>
	<tr> <td width="11%"></td>
	<td width="89%"><input type=submit value=Submit>  </td>
	</tr>  </table>	</form>		
	<p> <a href="newAccount.jsp"> Create a New Account </a>&nbsp;&nbsp;&nbsp;
	<a href="passwordLogin.jsp"> Login with Password </a>		  
	</body>
<%}%>

</html>
		