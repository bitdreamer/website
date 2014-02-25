<%@ page import="PuzzleMaker" %>
<%@ page import="PuzzleUpdater" %>
<%@ page import="PuzzleDealer" %>
<%@ page import="GateKeeper" %>

<%! public void jspInit()
    {
    	PuzzleMaker pm = new PuzzleMaker(true);
    	getServletContext().setAttribute("dealer", pm.getPuzzleDealer());
    	getServletContext().setAttribute("updater", pm.getPuzzleUpdater());
    	getServletContext().setAttribute("listsInitialized", "true");
    	getServletContext().setAttribute("gateKeep", new GateKeeper());
    }
%>

<html>
<head>
<title>index</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<% response.setHeader("pragma","no-cache");
   response.setHeader("cache-control","no-cache");

   session.setAttribute("loginAttempts", new Integer(0));
   session.removeAttribute("answerAttempt");
   session.removeAttribute("loginSuccess");
   
   String listsInitialized = (String) application.getAttribute("listsInitialized");
   if(listsInitialized != null && listsInitialized.equalsIgnoreCase("true"))
   {
  	String forProofread = request.getParameter("forProofread");
  	String goToPuzzle = request.getParameter("goToPuzzle");
  	if(forProofread != null && forProofread.equalsIgnoreCase("true"))
	{ %><jsp:forward page="proofread.jsp"/><%
	}
	else
	{ %><jsp:forward page="welcome.jsp"/><%
	}
   }
   else
   { // I believe that this "else" should never have to execute
     %><jsp:forward page="listsNotInitialized.jsp"/><%
   }
%>
<body>
</body>
</html>


