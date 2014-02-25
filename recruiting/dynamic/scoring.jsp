<%@ page import="PuzzleDealer" %>

<html>
<head>
<title>index</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<% session.removeAttribute("loginSuccess");
   String attempt = (String) session.getAttribute("answerAttempt");
   session.removeAttribute("answerAttempt");
   if(attempt != null)
   {
	PuzzleDealer dealer = (PuzzleDealer) application.getAttribute("dealer");
	if(dealer.isCorrectAnswer(attempt))
	{ %><jsp:forward page="../static/correct.html"/><%
	}
	else
	{ %><jsp:forward page="../static/incorrect.html"/><%
	}
   }
   else
   { %><jsp:forward page="index.jsp"/><%
   }
%>
<body>
</body>
</html>

