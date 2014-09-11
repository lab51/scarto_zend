function getNr(){
	var counter;  
	
	try{
		// Opera 8.0+, Firefox, Safari
		counter = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			counter = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				counter = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	counter.onreadystatechange = function(){
		if(counter.readyState === 4){
			document.getElementById("number_of_ads").innerHTML = counter.responseText;
		 }
		
	};
	var brand = document.getElementById('brand').value;
	var model = document.getElementById('model').value;
	var rok_od = document.getElementById('rok_od').value;
	var cena_od = document.getElementById('cena_od').value;
	var cena_do = document.getElementById('cena_do').value;
	var paliwo = document.getElementById('paliwo').value;
	var przebieg_do = document.getElementById('przebieg_do').value;
	
  
  
  var myURL = window.location.protocol + "//" + window.location.host + "/ogloszenia/get_number_of_ads";
	var params = "brand=" + brand + "&model=" + model + "&rok_od=" + rok_od + "&cena_od=" + cena_od + "&cena_do=" + cena_do + "&paliwo=" + paliwo + "&przebieg_do=" + przebieg_do;
	counter.open("POST", myURL, true);
        //to musi być żeby działało z POST
        counter.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	counter.send(params); 
}


