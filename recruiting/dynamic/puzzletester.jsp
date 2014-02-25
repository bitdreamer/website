<html>
<head>
<title>puzzle tester</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<% response.setHeader("pragma","no-cache");
   response.setHeader("cache-control","no-cache");
%>
<body bgcolor="#FFFFFF" text="#000000">
<p>The submitted answer was <%= request.getParameter("answerAttempt")%>
</p>
</body>
</html>
