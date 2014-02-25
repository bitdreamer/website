<%@ page import="PuzzleDealer" %>

<html>

<head>
<title>Meredith CS/CIS Puzzle Contest</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<% response.setHeader("pragma","no-cache");
   response.setHeader("cache-control","no-cache");

   String listsInitialized = (String) application.getAttribute("listsInitialized");
   if(listsInitialized == null)
   {
    %><body>
         <p>The lists have not been initialized.</p>
         <form id="initForm" name="initForm" method="post" action="index.jsp">
	 <input type=hidden value="true" name="forProofread">
	 <input type=submit value="Click here to initialize lists." name="initButton">
	 </form> 
      </body><%
   } 
   else
   {
      	PuzzleDealer dealer = (PuzzleDealer) application.getAttribute("dealer");
      	if(dealer == null)
      	{    
      	   %><body>
           	<p>The PuzzleDealer object is null.  Please
           	<a href="webmasterMail.jsp"> notify the webmaster </a>
           	that this error has occurred in proofread.jsp.</p>
      	   </body><%
      	}
	else
	{  
	   %><body>
	   <h1>Proofread Puzzles</h1>
	   <p>Drawing date: <%= dealer.getDrawingDateString()%></p>
	   <%
	   int i = 0;
	   int max = dealer.howManyPuzzles();
	   while(i < max)
	   {
	   	%><p><h3>Puzzle ID: <%= dealer.getID(i) %></h3></p>
	   	<p><em>Label for web site: </em><%= dealer.getLabel(i) %></p>
	   	<p><em>Statement: </em><%= dealer.getStatement(i) %></p>
		<p><em>Sample Answer: </em><%= dealer.getSampleAnswer(i)%></p>
	   	<p><em>Correct Answers: </em><br>
	   	
	   	<% String answers[] = dealer.getCorrectAnswers(i);
	   	   for(int j=0; j<answers.length; j++)
	   	   {
			%><%= (j+1) + ") " + answers[j] %><br><%
	   	   }	   	
	   	%>	   	
	   	</p><p></p>
	   	<%
	   	
	   	i++;
	   }
%>	
	<p><a href="puzzle.jsp">Go to external puzzle page</a></p>
	</body><%
    }
    }
%>
</html>
