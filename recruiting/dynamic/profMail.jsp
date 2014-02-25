<%@ page import="LetterDesign" %>

<html>
<head><title>Compose a Message</title></head>

<jsp:useBean id="letter" scope="session" class="LetterDesign" />

<%	String text = request.getParameter("body");	

if( text != null )
{
	if( !letter.emptyString( text ) )
	{
		letter.setSubject( "Question on Puzzle" );
		letter.setBody( text );
		letter.setTo( "profMail@Meredith.edu" ); %>
	
		<%-- letter.sendMsg(); --%>
	
		<body>	<h2> Message Sent  </h2>
		<p> <font size="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
		Expect a reply via the preferred method specfied in your account.</font>
		<p><a href="puzzlePage.jsp">Main Page</a>	</body>
<%	}
	else
	{ %>
		<body>
		<a href="welcome.jsp"> Main Page </a>
		<h2>Compose a message:</h2>
		<p><font size="3"><b>*** Remember to include your contact information so 
		that the professor can answer your message. ***</b></font>	
		<form action="profMail.jsp" method="post" >	
	    <table border="0" width="59%"> <tr>
	    <td width="100%"><font size="4">Enter Message Here:</font></td>
	    </tr>  <tr>   <td width="100%">
	    <p align="center"><textarea name="body" rows="20" cols="60">
		</textarea>  </td>  </tr>  <tr>
	    <td width="100%" bgcolor="#FFFFFF" bordercolor="#FFFFFF">
	    <p align="right">
		<input type="submit" value=Submit />	</td>  </tr>
	    </table>	</form>		</body>
<%	}
} 
else
{ %>
	<body>
	<a href="welcome.jsp"> Main Page </a>
	<h2>Compose a message:</h2>
	<p><font size="3"><b>*** Remember to include your contact information so 
	that the professor can answer your message. ***</b></font>	
	<form action="profMail.jsp" method="post" >	
    <table border="0" width="59%"> <tr>
    <td width="100%"><font size="4">Enter Message Here:</font></td>
    </tr>  <tr>   <td width="100%">
    <p align="center"><textarea name="body" rows="20" cols="60">
	</textarea>  </td>  </tr>  <tr>
    <td width="100%" bgcolor="#FFFFFF" bordercolor="#FFFFFF">
    <p align="right">
	<input type="submit" value=Submit />	</td>  </tr>
    </table>	</form>		</body>
<%}%>
</html>