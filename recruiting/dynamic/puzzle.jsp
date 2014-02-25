<%@ page import="PuzzleDealer" %>

<html>

<script language="JavaScript">
    function myLogin() 
    {
	window.open("passwordLogin.jsp");
    }
</script>

<% PuzzleDealer dealer = (PuzzleDealer) application.getAttribute("dealer"); %>

<head>
<title>Meredith CS/CIS Puzzle Contest</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<% response.setHeader("pragma","no-cache");
   response.setHeader("cache-control","no-cache");

   // if an answer attempt is in the request, then the form has been
   // submitted but the login process has not occurred yet
   String newAttempt = request.getParameter("answerAttempt");

   // if an answer attempt is stored in the session, then we are coming
   // into this page AFTER login process
   String readyToScore = (String) session.getAttribute("answerAttempt");
   
   // variable to repopulate the "answerAttempt" field in the form
   String attempt = "";
   
   if (newAttempt == null && readyToScore == null)
   {  // not in the middle of submission process, so start from 
      // beginning on all the login process stuff
      session.removeAttribute("loginSuccess");
      session.removeAttribute("answerAttempt");
      session.setAttribute("loginAttempts", new Integer(0));
      attempt = "";
   }
   else // submission process is going on
   {  if(readyToScore == null) // user has not logged in yet
      {
         session.setAttribute("answerAttempt", newAttempt);
         attempt = newAttempt;
      }
      else // login has either succeeded or failed
      {
         String loginOK = (String) session.getAttribute("loginSuccess");
         if(loginOK != null && loginOK.equalsIgnoreCase("true"))
         {   	attempt = readyToScore;

            %><jsp:forward  page="scoring.jsp"/><%
   
         }
      }
   }
%>
<body bgcolor="#FFFFFF" text="#000000">
<p><%= dealer.getStatement() %></p>
<p>Your answer should be of the form:</p>
<p><%= dealer.getSampleAnswer()%></p>	
<form id="puzzleForm" name="puzzleForm" method="post" action="puzzle.jsp">
	<label>Enter your answer here.</label>
	<input type="text" name="answerAttempt" size="100" value="<%= attempt %>">
	<input type=submit value="Submit" name="chkLogin" 
		onclick="javascript:myLogin();">
</form>
</body>
</html>
