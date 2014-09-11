<?php

$query = $_POST['searchbox'];//zgarniam query z formularza
//$query = "volkswagen passat cc";
//jesli ktos wpisze np. 'volkswagen golf' to musze to rozbic na slowa zeby LIKE dzialal        
$exploded = explode(' ', $query);

$how_many_words = count($exploded); //licze ile jest slow
//nawet jak ktos wpisze wiecej to obchodza mnie pierwsze 3 slowa (marka+model+cos)


			if($how_many_words == 1){ //np. 'volkswagen', 'passat'
				$search_for = sprintf("
				SELECT * FROM ads 
                JOIN models ON ads.ad_model_id=models.model_id 
                JOIN brands ON models.model_brand_id=brands.brand_id
                WHERE (brands.brand_name LIKE '%%%s%%')   
				OR (models.model_name LIKE '%%%s%%')
                ", $exploded[0], $exploded[0]);
			} else if ($how_many_words == 2){//np. 'volkswagen passat', 'volkswagen golf'
				$search_for = sprintf("
				SELECT * FROM ads 
                JOIN models ON ads.ad_model_id=models.model_id 
                JOIN brands ON models.model_brand_id=brands.brand_id
                WHERE (brands.brand_name LIKE '%%%s%%' OR brands.brand_name LIKE '%%%s%%')   
				AND (models.model_name LIKE '%%%s%%' OR models.model_name LIKE '%%%s%%')
                ", $exploded[0], $exploded[1], $exploded[0], $exploded[1]);
                //z tymi nawiasami sie meczylem i %%%s%% - duzo procentow, ale wlasnie dopasowanie 
                //tego sprintf z LIKE bylo zabawą ;)
                
			} else if ($how_many_words == 3){
				//to jest opcja jakby ktos zapodal zapytanie 'vw passat cc' or sth
				//ogolnie do potestowania jeszcze
				$search_for = sprintf("
				SELECT * FROM ads 
                JOIN models ON ads.ad_model_id=models.model_id 
                JOIN brands ON models.model_brand_id=brands.brand_id
                WHERE (brands.brand_name LIKE '%%%s%%' OR brands.brand_name LIKE '%%%s%%' OR brands.brand_name LIKE '%%%s%%')   
				AND (models.model_name LIKE '%%%s%%' OR models.model_name LIKE '%%%s%%' OR models.model_name LIKE '%%%s%%')
                ", $exploded[0], $exploded[1], $exploded[2], $exploded[0], $exploded[1], $exploded[2]);	
			}

	$con=mysqli_connect("localhost","recfilm_admin","q1forever101","recfilm_scartopl");
	
	$data = mysqli_query($con,$search_for);
     if($data) {
            return $data;
        } else {
            return false;
        }
?>