function filterAds(str){
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
//	var age = document.getElementById('age').value;
//	var wpm = document.getElementById('wpm').value;
//	var sex = document.getElementById('sex').value;
//	var myURL = window.location.protocol + "//" + window.location.host + "/ogloszenia/filter";
	var myURL = window.location.protocol + "//" + window.location.host + "/filter.php";
	var params = "price_to=" + str;
	var params = "price_from=" + str;
	http.open("POST", myURL, true);
        //to musi być żeby działało z POST
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.send(params); 
}


