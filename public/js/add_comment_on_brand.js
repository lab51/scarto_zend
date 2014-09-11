function add_comment(){
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
			document.getElementById("new_comments").innerHTML = http.responseText;
		 }

	};
	var myURL = window.location.protocol + "//" + window.location.host + "/osobowe/add_comment";
	var name = document.getElementById('user_name').value;
	var comment = document.getElementById('new_comment').value;
	var brand = document.getElementById('current_brand').value;
	var params = "name=" + name + "&comment=" + comment + "&brand=" + brand;
	http.open("POST", myURL, true);
        //to musi być żeby działało z POST
        http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    	http.send(params);
}


