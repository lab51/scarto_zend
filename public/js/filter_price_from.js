function sendValues(array){
	var http;  
	
	try{
		// Opera 8.0+, Firefox, Safari
		http = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			http = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				http = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	http.onreadystatechange = function(){
		if(http.readyState === 4){
			document.getElementById("ads_listing").innerHTML = http.responseText;
		 }		
	};
	var myURL = window.location.protocol + "//" + window.location.host + "/filter.php";
	var params = "price_from=" + array['price_from'] + "&price_to=" + array['price_to'] 
	+ "&year_from=" + array['year_from'] + "&year_to=" + array['year_to']
	+ "&engine_size_from=" + array['engine_size_from'] + "&engine_size_to=" + array['engine_size_to'] 
	 + "&engine_power_from=" + array['engine_power_from'] + "&engine_power_to=" + array['engine_power_to']
	  + "&km_to=" + array['km_to'] + "&fuel_type=" + array['fuel_type'] + "&exterior_type=" + array['exterior_type'] + "&brand=" + array['brand'] + "&model=" + array['model'];
	http.open("POST", myURL, true);
        //to musi być żeby działało z POST
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.send(params); 
}


