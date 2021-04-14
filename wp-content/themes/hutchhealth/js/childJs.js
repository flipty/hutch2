window.onload = function() {

	var ie = getInternetExplorerVersion();
	var heightCheck = 30;
	
	if (ie == '8'){
		heightCheck = 31;
	}
	

	//Determine breadcrumb size
	if ( document.querySelector( '.breadcrumb' ) != null){
	 	if (document.querySelector( '.breadcrumb' ).clientHeight > heightCheck){

     		document.getElementsByTagName("body")[0].className += " breadcrumb-tall";
     
     	} 
   	}
   	
   	
   	window.onresize = function() {
  
	   	if ( document.querySelector( '.breadcrumb' ) != null){
		 	if (document.querySelector( '.breadcrumb' ).clientHeight > heightCheck){
	
	     		document.getElementsByTagName("body")[0].className += " breadcrumb-tall";
	     		
	     	} 
	     	
	     	else{
	     	
	     		document.getElementsByTagName("body")[0].className = document.getElementsByTagName("body")[0].className.replace(/\breadcrumb-tall\b/,'')
	     	}
	   	}

   	}
       
}





function getInternetExplorerVersion()
// Returns the version of Windows Internet Explorer or a -1
// (indicating the use of another browser).
{
   var rv = -1; // Return value assumes failure.
   if (navigator.appName == 'Microsoft Internet Explorer')
   {
      var ua = navigator.userAgent;
      var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
      if (re.exec(ua) != null)
         rv = parseFloat( RegExp.$1 );
   }
   return rv;
}