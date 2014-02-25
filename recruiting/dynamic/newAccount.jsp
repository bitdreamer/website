<%@ page import="GateKeeper" %>
<%@ page import="LetterDesign" %>

<html>
<head><title>Create New Account</title></head>

<% GateKeeper gateKeep = (GateKeeper) application.getAttribute("gateKeep"); %>
<jsp:useBean id="letter" scope="session" class="LetterDesign" />

<%	response.setHeader("pragma","no-cache");
   	response.setHeader("cache-control","no-cache");

	String id = request.getParameter( "idField" );
	String password1 = request.getParameter( "passwordField1" );
	String password2 = request.getParameter( "passwordField2" );
	String question = request.getParameter( "questionField" );
	String answer = request.getParameter( "answerField" );
	String name = request.getParameter( "nameField" );
	String address = request.getParameter( "addressField" );
	String city = request.getParameter( "cityField" );
	String state = request.getParameter( "stateField" );
	String zipCode = request.getParameter( "zipField" );
	String grade = request.getParameter( "gradeField" );
	String phone = request.getParameter( "phone1") + request.getParameter("phone2") + request.getParameter("phone3") + request.getParameter( "phone4" );
	String eMail = request.getParameter( "emailField" );	
	String contact = request.getParameter( "R1" ); %>
<%
if(gateKeep == null){ %>
<body>gateKeep is null</body>
<% } else
if( id != null && password1 != null && password2 != null && question != null && answer != null && name != null && address != null && city != null && state != null && zipCode != null && grade != null)
{
	if( !gateKeep.emptyString(id) && !gateKeep.emptyString(password1) && !gateKeep.emptyString(password2) && !gateKeep.emptyString(question) && !gateKeep.emptyString(answer) && !gateKeep.emptyString(name) && !gateKeep.emptyString(address) && !gateKeep.emptyString(city) && !gateKeep.emptyString(state) && !gateKeep.emptyString(zipCode) && !gateKeep.emptyString(grade))
	{
		if( !gateKeep.userExist( id ) )
		{
			if( password1.length() > 7 )
			{
				if( password1.equals( password2 ) )
				{
					if( gateKeep.contactInfo( contact, eMail, phone ) )
					{
						gateKeep.addUser( id, password1, question, answer );
					
						letter.setTo( "profMail@TheButler.bitlab" );
						letter.setSubject( "New Account Created!" );		
						letter.setBody( name + " " + id + " " + address + " " + city + " " + state + " " + zipCode + " " + grade + " " + phone + " " + eMail );
						%>
						<%-- When mail server is set up on TheButler take out comment tags --%>
						<%-- letter.sendMsg(); --%>
					
						<body> <h2><b>Account Created</b></h2>
						<p> <font size="4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
						Your account has been created. Now please login using your password.</font>
						<a href="passwordLogin.jsp"> Login with Password </a> 
					<%}
					else
					{ %>
								<body>
			<h2><b>Please Create An Account</b></h2>
			<p><font size="3"><b>*** Missing Contact Information ***</b></font>
			<form action=newAccount.jsp method=post>
			<table border="1" width="100%" bordercolor="#FFFFFF">
        	<tr>
			<td width="16%"><font size="4">User Name:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=text name=idField>
		</font></td></tr>
		<tr>
			<td width="16%"><font size="4">Password:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=password name=passwordField1>
			</font></td></tr>
		<tr>
			<td width="16%"><font face="Verdana, Helvetica, Arial, sans-serif" size="1" color="#666666">
			8 character minimum </font></td></tr>
		<tr>
			<td width="16%"><font size="4">Verify Password:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=password name=passwordField2>
			</font></td></tr>
		<tr>
			<td width="16%"><font size="4">Secret Question:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=text name=questionField size=50>
			</font></td></tr>
		<tr>
			<td width="16%"><font size="4">Secret Answer:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=text name=answerField size=50>
			</font></td></tr>
		</table>
		<p>&nbsp;</p>
		<table border="1" width="100%" height="118" bordercolor="#FFFFFF">
		<tr>
                	<td width="35%" height="23"><font size="4">Full Name:</font></td>
			<td width="65%" height="23"><font size="4"> <input type=text name=nameField size=50>
			</font></td></tr>
		<tr>
                	<td width="35%" height="23"><p style="line-height: 100%"><font size="4">Mailing Address: </font></td>
			<td width="65%" height="23"><font size="4"> <input type=text name=addressField size=50>
			</font></td></tr>
	      	<tr>
		 	<td width="35%" height="23"><font size="4">City:</font></td>
			<td width="65%" height="23"><font size="4"><input type=text name=cityField size=10>
			</tr>
		<tr>
			<td width="35%" height="23"><font size="4">State:</font></td>
			<td width="65%" height="23"><font size="4"><input type=text name=stateField size=2 maxlength="2">
			</tr>
		<tr>
			<td width="35%" height="23"><font size="4">Zip Code:</font></td>
			<td width="65%" height="23"><font size="4"><input type=text name=zipField size=5 maxlength="5">
			</tr>
		<tr>
                	<td width="35%" height="23"><font size="4">Grade in School: </font></td>
			<td width="65%" height="23"><font size="4"> <input type=text name=gradeField size=2 maxlength="2">
			</font></td></tr>
		<tr>
			<td width="35%" height="25"><font size="4">Phone Number*:</font></td>
			<td width="65%" height="25"><font size="4">( <input name="phone1" type="text" size="3" maxlength="3"> ) <input name="phone2" type="text" size="3" maxlength="3"> - <input name="phone3" type="text" size="4" maxlength="4"></font><font size="2"> Extension</font><input name="phone4" type="text" size="7" maxlength="7"></font></td>
			</tr>
		<tr>
                	<td width="35%" height="25"><font size="4">E-mail Address*:</font></td>
			<td width="65%" height="25"><input type=text name=emailField></td>
			</tr>
		<tr>
                	<td width="35%" height="25"><font size="4">Best Way to Contact if you Win:</font></td>
			<td width="65%" height="25"><font size="4"><input type="radio" value="V1" checked name="R1">Snail
			Mail&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="R1" value="V2">Phone&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="R1" value="V3">E-mail</font></td>
			</tr>
		<tr>
                	<td width="35%" height="25"></td>	
			<td width="65%" height="25"><font size="4"><input type=submit value=Submit></form></font></td>
			</tr>
		<tr>
                	<td width="35%" height="25"></td>
			<td width="65%" height="25"><font size="3"><b>*Optional</b></font></td>
			</tr>  </table>
		</body>
		<%} }
			else
			{ %>
			<body>
			<h2><b>Please Create An Account</b></h2>
			<p><font size="3"><b>*** Passwords do not match. ***</b></font>
			<form action=newAccount.jsp method=post>
			<table border="1" width="100%" bordercolor="#FFFFFF">
        	<tr>
			<td width="16%"><font size="4">User Name:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=text name=idField>
		</font></td></tr>
		<tr>
			<td width="16%"><font size="4">Password:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=password name=passwordField1>
			</font></td></tr>
		<tr>
			<td width="16%"><font face="Verdana, Helvetica, Arial, sans-serif" size="1" color="#666666">
			8 character minimum </font></td></tr>
		<tr>
			<td width="16%"><font size="4">Verify Password:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=password name=passwordField2>
			</font></td></tr>
		<tr>
			<td width="16%"><font size="4">Secret Question:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=text name=questionField size=50>
			</font></td></tr>
		<tr>
			<td width="16%"><font size="4">Secret Answer:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=text name=answerField size=50>
			</font></td></tr>
		</table>
		<p>&nbsp;</p>
		<table border="1" width="100%" height="118" bordercolor="#FFFFFF">
		<tr>
                	<td width="35%" height="23"><font size="4">Full Name:</font></td>
			<td width="65%" height="23"><font size="4"> <input type=text name=nameField size=50>
			</font></td></tr>
		<tr>
                	<td width="35%" height="23"><p style="line-height: 100%"><font size="4">Mailing Address: </font></td>
			<td width="65%" height="23"><font size="4"> <input type=text name=addressField size=50>
			</font></td></tr>
	      	<tr>
		 	<td width="35%" height="23"><font size="4">City:</font></td>
			<td width="65%" height="23"><font size="4"><input type=text name=cityField size=10>
			</tr>
		<tr>
			<td width="35%" height="23"><font size="4">State:</font></td>
			<td width="65%" height="23"><font size="4"><input type=text name=stateField size=2 maxlength="2">
			</tr>
		<tr>
			<td width="35%" height="23"><font size="4">Zip Code:</font></td>
			<td width="65%" height="23"><font size="4"><input type=text name=zipField size=5 maxlength="5">
			</tr>
		<tr>
                	<td width="35%" height="23"><font size="4">Grade in School: </font></td>
			<td width="65%" height="23"><font size="4"> <input type=text name=gradeField size=2 maxlength="2">
			</font></td></tr>
		<tr>
			<td width="35%" height="25"><font size="4">Phone Number*:</font></td>
			<td width="65%" height="25"><font size="4">( <input name="phone1" type="text" size="3" maxlength="3"> ) <input name="phone2" type="text" size="3" maxlength="3"> - <input name="phone3" type="text" size="4" maxlength="4"></font><font size="2"> Extension</font><input name="phone4" type="text" size="7" maxlength="7"></font></td>
			</tr>
		<tr>
                	<td width="35%" height="25"><font size="4">E-mail Address*:</font></td>
			<td width="65%" height="25"><input type=text name=emailField></td>
			</tr>
		<tr>
                	<td width="35%" height="25"><font size="4">Best Way to Contact if you Win:</font></td>
			<td width="65%" height="25"><font size="4"><input type="radio" value="V1" checked name="R1">Snail
			Mail&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="R1" value="V2">Phone&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="R1" value="V3">E-mail</font></td>
			</tr>
		<tr>
                	<td width="35%" height="25"></td>	
			<td width="65%" height="25"><font size="4"><input type=submit value=Submit></form></font></td>
			</tr>
		<tr>
                	<td width="35%" height="25"></td>
			<td width="65%" height="25"><font size="3"><b>*Optional</b></font></td>
			</tr>  </table>
		</body>
<%		}
	}
	else
	{ %>	<body>
            	<h2><b>Please Create An Account</b></h2>
		<p><font size="3"><b>*** Invaild Password Length. Passwords must be 8 charaters or longer. ***</b></font>
		<form action=newAccount.jsp method=post>
		<table border="1" width="100%" bordercolor="#FFFFFF">
        	<tr>
			<td width="16%"><font size="4">User Name:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=text name=idField>
		</font></td></tr>
		<tr>
			<td width="16%"><font size="4">Password:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=password name=passwordField1>
			</font></td></tr>
		<tr>
			<td width="16%"><font face="Verdana, Helvetica, Arial, sans-serif" size="1" color="#666666">
			8 character minimum </font></td></tr>
		<tr>
			<td width="16%"><font size="4">Verify Password:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=password name=passwordField2>
			</font></td></tr>
		<tr>
			<td width="16%"><font size="4">Secret Question:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=text name=questionField size=50>
			</font></td></tr>
		<tr>
			<td width="16%"><font size="4">Secret Answer:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=text name=answerField size=50>
			</font></td></tr>
		</table>
		<p>&nbsp;</p>
		<table border="1" width="100%" height="118" bordercolor="#FFFFFF">
		<tr>
                	<td width="35%" height="23"><font size="4">Full Name:</font></td>
			<td width="65%" height="23"><font size="4"> <input type=text name=nameField size=50>
			</font></td></tr>
		<tr>
                	<td width="35%" height="23"><p style="line-height: 100%"><font size="4">Mailing Address: </font></td>
			<td width="65%" height="23"><font size="4"> <input type=text name=addressField size=50>
			</font></td></tr>
	      	<tr>
		 	<td width="35%" height="23"><font size="4">City:</font></td>
			<td width="65%" height="23"><font size="4"><input type=text name=cityField size=10>
			</tr>
		<tr>
			<td width="35%" height="23"><font size="4">State:</font></td>
			<td width="65%" height="23"><font size="4"><input type=text name=stateField size=2 maxlength="2">
			</tr>
		<tr>
			<td width="35%" height="23"><font size="4">Zip Code:</font></td>
			<td width="65%" height="23"><font size="4"><input type=text name=zipField size=5 maxlength="5">
			</tr>
		<tr>
                	<td width="35%" height="23"><font size="4">Grade in School: </font></td>
			<td width="65%" height="23"><font size="4"> <input type=text name=gradeField size=2 maxlength="2">
			</font></td></tr>
		<tr>
			<td width="35%" height="25"><font size="4">Phone Number*:</font></td>
			<td width="65%" height="25"><font size="4">( <input name="phone1" type="text" size="3" maxlength="3"> ) <input name="phone2" type="text" size="3" maxlength="3"> - <input name="phone3" type="text" size="4" maxlength="4"></font><font size="2"> Extension</font><input name="phone4" type="text" size="7" maxlength="7"></font></td>
			</tr>
		<tr>
                	<td width="35%" height="25"><font size="4">E-mail Address*:</font></td>
			<td width="65%" height="25"><input type=text name=emailField></td>
			</tr>
		<tr>
                	<td width="35%" height="25"><font size="4">Best Way to Contact if you Win:</font></td>
			<td width="65%" height="25"><font size="4"><input type="radio" value="V1" checked name="R1">Snail
			Mail&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="R1" value="V2">Phone&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="R1" value="V3">E-mail</font></td>
			</tr>
		<tr>
                	<td width="35%" height="25"></td>	
			<td width="65%" height="25"><font size="4"><input type=submit value=Submit></form></font></td>
			</tr>
		<tr>
                	<td width="35%" height="25"></td>
			<td width="65%" height="25"><font size="3"><b>*Optional</b></font></td>
			</tr>  </table>
		</body>
<%		}
	} else { %> <body>
            	<h2><b>Please Create An Account</b></h2>
		<p><font size="3"><b>*** User Account Already Exists ***</b></font>
		<form action=newAccount.jsp method=post>
		<table border="1" width="100%" bordercolor="#FFFFFF">
        	<tr>
			<td width="16%"><font size="4">User Name:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=text name=idField>
		</font></td></tr>
		<tr>
			<td width="16%"><font size="4">Password:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=password name=passwordField1>
			</font></td></tr>
		<tr>
			<td width="16%"><font face="Verdana, Helvetica, Arial, sans-serif" size="1" color="#666666">
			8 character minimum </font></td></tr>
		<tr>
			<td width="16%"><font size="4">Verify Password:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=password name=passwordField2>
			</font></td></tr>
		<tr>
			<td width="16%"><font size="4">Secret Question:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=text name=questionField size=50>
			</font></td></tr>
		<tr>
			<td width="16%"><font size="4">Secret Answer:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=text name=answerField size=50>
			</font></td></tr>
		</table>
		<p>&nbsp;</p>
		<table border="1" width="100%" height="118" bordercolor="#FFFFFF">
		<tr>
                	<td width="35%" height="23"><font size="4">Full Name:</font></td>
			<td width="65%" height="23"><font size="4"> <input type=text name=nameField size=50>
			</font></td></tr>
		<tr>
                	<td width="35%" height="23"><p style="line-height: 100%"><font size="4">Mailing Address: </font></td>
			<td width="65%" height="23"><font size="4"> <input type=text name=addressField size=50>
			</font></td></tr>
	      	<tr>
		 	<td width="35%" height="23"><font size="4">City:</font></td>
			<td width="65%" height="23"><font size="4"><input type=text name=cityField size=10>
			</tr>
		<tr>
			<td width="35%" height="23"><font size="4">State:</font></td>
			<td width="65%" height="23"><font size="4"><input type=text name=stateField size=2 maxlength="2">
			</tr>
		<tr>
			<td width="35%" height="23"><font size="4">Zip Code:</font></td>
			<td width="65%" height="23"><font size="4"><input type=text name=zipField size=5 maxlength="5">
			</tr>
		<tr>
                	<td width="35%" height="23"><font size="4">Grade in School: </font></td>
			<td width="65%" height="23"><font size="4"> <input type=text name=gradeField size=2 maxlength="2">
			</font></td></tr>
		<tr>
			<td width="35%" height="25"><font size="4">Phone Number*:</font></td>
			<td width="65%" height="25"><font size="4">( <input name="phone1" type="text" size="3" maxlength="3"> ) <input name="phone2" type="text" size="3" maxlength="3"> - <input name="phone3" type="text" size="4" maxlength="4"></font><font size="2"> Extension</font><input name="phone4" type="text" size="7" maxlength="7"></font></td>
			</tr>
		<tr>
                	<td width="35%" height="25"><font size="4">E-mail Address*:</font></td>
			<td width="65%" height="25"><input type=text name=emailField></td>
			</tr>
		<tr>
                	<td width="35%" height="25"><font size="4">Best Way to Contact if you Win:</font></td>
			<td width="65%" height="25"><font size="4"><input type="radio" value="V1" checked name="R1">Snail
			Mail&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="R1" value="V2">Phone&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="R1" value="V3">E-mail</font></td>
			</tr>
		<tr>
                	<td width="35%" height="25"></td>	
			<td width="65%" height="25"><font size="4"><input type=submit value=Submit></form></font></td>
			</tr>
		<tr>
                	<td width="35%" height="25"></td>
			<td width="65%" height="25"><font size="3"><b>*Optional</b></font></td>
			</tr>  </table>
		</body>

	<%}
	}
	else{ %><body>
        <h2><b>Please Create An Account</b></h2>
	<p><font size="3"><b>*** One or More Fields Were Left Blank ***</b></font>
	<form action=newAccount.jsp method=post>
        <table border="1" width="100%" bordercolor="#FFFFFF">
        	<tr>
			<td width="16%"><font size="4">User Name:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=text name=idField>
		</font></td></tr>
		<tr>
			<td width="16%"><font size="4">Password:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=password name=passwordField1>
			</font></td></tr>
		<tr>
			<td width="16%"><font face="Verdana, Helvetica, Arial, sans-serif" size="1" color="#666666">
			8 character minimum </font></td></tr>
		<tr>
			<td width="16%"><font size="4">Verify Password:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=password name=passwordField2>
			</font></td></tr>
		<tr>
			<td width="16%"><font size="4">Secret Question:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=text name=questionField size=50 value=question>
			</font></td></tr>
		<tr>
			<td width="16%"><font size="4">Secret Answer:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=text name=answerField size=50 value=answer>
			</font></td></tr>
		</table>
		<p>&nbsp;</p>
		<table border="1" width="100%" height="118" bordercolor="#FFFFFF">
		<tr>
                	<td width="35%" height="23"><font size="4">Full Name:</font></td>
			<td width="65%" height="23"><font size="4"> <input type=text name=nameField size=50>
			</font></td></tr>
		<tr>
                	<td width="35%" height="23"><p style="line-height: 100%"><font size="4">Mailing Address: </font></td>
			<td width="65%" height="23"><font size="4"> <input type=text name=addressField size=50>
			</font></td></tr>
	      	<tr>
		 	<td width="35%" height="23"><font size="4">City:</font></td>
			<td width="65%" height="23"><font size="4"><input type=text name=cityField size=10>
			</tr>
		<tr>
			<td width="35%" height="23"><font size="4">State:</font></td>
			<td width="65%" height="23"><font size="4"><input type=text name=stateField size=2 maxlength="2">
			</tr>
		<tr>
			<td width="35%" height="23"><font size="4">Zip Code:</font></td>
			<td width="65%" height="23"><font size="4"><input type=text name=zipField size=5 maxlength="5">
			</tr>
		<tr>
                	<td width="35%" height="23"><font size="4">Grade in School: </font></td>
			<td width="65%" height="23"><font size="4"> <input type=text name=gradeField size=2 maxlength="2">
			</font></td></tr>
		<tr>
			<td width="35%" height="25"><font size="4">Phone Number*:</font></td>
			<td width="65%" height="25"><font size="4">( <input name="phone1" type="text" size="3" maxlength="3"> ) <input name="phone2" type="text" size="3" maxlength="3"> - <input name="phone3" type="text" size="4" maxlength="4"></font><font size="2"> Extension</font><input name="phone4" type="text" size="7" maxlength="7"></font></td>
			</tr>
		<tr>
                	<td width="35%" height="25"><font size="4">E-mail Address*:</font></td>
			<td width="65%" height="25"><input type=text name=emailField></td>
			</tr>
		<tr>
                	<td width="35%" height="25"><font size="4">Best Way to Contact if you Win:</font></td>
			<td width="65%" height="25"><font size="4"><input type="radio" value="V1" checked name="R1">Snail
			Mail&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="R1" value="V2">Phone&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="R1" value="V3">E-mail</font></td>
			</tr>
		<tr>
                	<td width="35%" height="25"></td>	
			<td width="65%" height="25"><font size="4"><input type=submit value=Submit></form></font></td>
			</tr>
		<tr>
                	<td width="35%" height="25"></td>
			<td width="65%" height="25"><font size="3"><b>*Optional</b></font></td>
			</tr>  </table>
		</body>
<%	 }
} 
else
{ %>	<body>
	<form action=newAccount.jsp method=post>
        <h2><b>Please Create An Account</b></h2>
        <table border="1" width="100%" bordercolor="#FFFFFF">
        	<tr>
			<td width="16%"><font size="4">User Name:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=text name=idField>
		</font></td></tr>
		<tr>
			<td width="16%"><font size="4">Password:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=password name=passwordField1>
			</font></td></tr>
		<tr>
			<td width="16%"><font face="Verdana, Helvetica, Arial, sans-serif" size="1" color="#666666">
			8 character minimum </font></td></tr>
		<tr>
			<td width="16%"><font size="4">Verify Password:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=password name=passwordField2>
			</font></td></tr>
		<tr>
			<td width="16%"><font size="4">Secret Question:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=text name=questionField size=50>
			</font></td></tr>
		<tr>
			<td width="16%"><font size="4">Secret Answer:&nbsp;</font></td>
			<td width="84%"><font size="4"> <input type=text name=answerField size=50>
			</font></td></tr>
		</table>
		<p>&nbsp;</p>
		<table border="1" width="100%" height="118" bordercolor="#FFFFFF">
		<tr>
                	<td width="35%" height="23"><font size="4">Full Name:</font></td>
			<td width="65%" height="23"><font size="4"> <input type=text name=nameField size=50>
			</font></td></tr>
		<tr>
                	<td width="35%" height="23"><p style="line-height: 100%"><font size="4">Mailing Address: </font></td>
			<td width="65%" height="23"><font size="4"> <input type=text name=addressField size=50>
			</font></td></tr>
	      	<tr>
		 	<td width="35%" height="23"><font size="4">City:</font></td>
			<td width="65%" height="23"><font size="4"><input type=text name=cityField size=10>
			</tr>
		<tr>
			<td width="35%" height="23"><font size="4">State:</font></td>
			<td width="65%" height="23"><font size="4"><input type=text name=stateField size=2 maxlength="2">
			</tr>
		<tr>
			<td width="35%" height="23"><font size="4">Zip Code:</font></td>
			<td width="65%" height="23"><font size="4"><input type=text name=zipField size=5 maxlength="5">
			</tr>
		<tr>
                	<td width="35%" height="23"><font size="4">Grade in School: </font></td>
			<td width="65%" height="23"><font size="4"> <input type=text name=gradeField size=2 maxlength="2">
			</font></td></tr>
		<tr>
			<td width="35%" height="25"><font size="4">Phone Number*:</font></td>
			<td width="65%" height="25"><font size="4">( <input name="phone1" type="text" size="3" maxlength="3"> ) <input name="phone2" type="text" size="3" maxlength="3"> - <input name="phone3" type="text" size="4" maxlength="4"></font><font size="2"> Extension</font><input name="phone4" type="text" size="7" maxlength="7"></font></td>
			</tr>
		<tr>
                	<td width="35%" height="25"><font size="4">E-mail Address*:</font></td>
			<td width="65%" height="25"><input type=text name=emailField></td>
			</tr>
		<tr>
                	<td width="35%" height="25"><font size="4">Best Way to Contact if you Win:</font></td>
			<td width="65%" height="25"><font size="4"><input type="radio" value="V1" checked name="R1">Snail
			Mail&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="R1" value="V2">Phone&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="R1" value="V3">E-mail</font></td>
			</tr>
		<tr>
                	<td width="35%" height="25"></td>	
			<td width="65%" height="25"><font size="4"><input type=submit value=Submit></form></font></td>
			</tr>
		<tr>
                	<td width="35%" height="25"></td>
			<td width="65%" height="25"><font size="3"><b>*Optional</b></font></td>
			</tr>  </table>
		</body>
<% } %>
</html>