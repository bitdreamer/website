
   function fillTaskID( tid )
   {
      // alert("how about slot.value .... "+tid+"?");  
	  
	  var slock = document.getElementById("taskID");
	  slock.value = tid; // doesn't work
   }
   
   function fillTagById( id, val )
   {
      // alert("fillTagById: id="+id+" val="+val);
      var slock = document.getElementById( id );
	  slock.value = val;
   }

