	window.onerror = errorHandler;
	function errorHandler( msg, url, ln )
   {
      alert( "error: " + msg 
            + "\nURL:"+url
            + " at line: "+ln
           );
      return true;
   }
