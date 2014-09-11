<?php

        
    if(isset($_REQUEST['query'])) {

	$query = $_REQUEST['query'];
	//$query = 'pa';
	$suggestions = get_search_suggestions($query);
        
	echo json_encode ($suggestions); //Return the JSON Array

    }	

  
   function get_search_suggestions($query){

	$con=mysqli_connect("localhost","recfilm_admin","q1forever101","recfilm_scartopl");
	
	$sql="SELECT * FROM brands
	JOIN models ON models.model_brand_id = brands.brand_id 
	WHERE brand_name LIKE '%{$query}%' 
	OR model_name LIKE '%{$query}%'";

	$data = mysqli_query($con,$sql);
	// Execute query
	if ($data){
	$sug_array = array();
		while($row = mysqli_fetch_array($data)) {
    	$joined_name = $row['brand_name'] .' ' . $row['model_name'];
    	array_push($sug_array, $joined_name);	
	}

    if(!empty($sug_array)){
    return $sug_array;        
    } else {
    return false;        
    }
    	
	}

	}
	
?>