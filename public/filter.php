<?php 
$con=mysqli_connect("localhost","recfilm_admin","q1forever101","recfilm_scartopl");

//default values for query
$price_to = 1000000;
$price_from = 0;
$year_from = 0;
$year_to = 2100;
$engine_size_from = 0;
$engine_size_to = 10000;
$engine_power_from = 0;
$engine_power_to = 10000;
$km_to = 100000000;
$fuel_benzin = NULL;
$fuel_diesel = NULL;
$fuel_gas = NULL;
$ext_kabriolet = NULL;
$ext_sedan = NULL;
$ext_sportowy = NULL;
$ext_kombi = NULL;
$ext_hatchback = NULL;
$ext_pickup = NULL;
$ext_terenowy = NULL;
$ext_van = NULL;
$ext_suv = NULL;
$ext_inny = NULL;
$brand_id = NULL;
$model_id = NULL;
//	 echo $_POST['model'];
	 
$exterior_type_values = $_POST['exterior_type'];
//if some fuel type was selected...
if(!empty($exterior_type_values)){

//make an array
$exterior_type = explode(",", $exterior_type_values);

	foreach($exterior_type as $ex){
		if($ex=='kabriolet'){
			$ext_kabriolet = $ex;
		} elseif($ex == 'sedan'){
			$ext_sedan = $ex;
		} elseif($ex == 'sportowy'){
			$ext_sportowy = $ex;
		} elseif($ex == 'kombi'){
			$ext_kombi = $ex;
		} elseif($ex == 'hatchback'){
			$ext_hatchback = $ex;
		} elseif($ex == 'pickup'){
			$ext_pickup = $ex;
		} elseif($ex == 'terenowy'){
			$ext_terenowy = $ex;
		} elseif($ex == 'van'){
			$ext_van = $ex;
		} elseif($ex == 'suv'){
			$ext_suv = $ex;
		} elseif($ex == 'inny'){
			$ext_inny = $ex;
		}
	}
	} else {
	//if nothing was selected, use default values
		$ext_kabriolet = 'kabriolet';
		$ext_sedan = 'sedan';
		$ext_sportowy = 'sportowy';
		$ext_kombi = 'kombi';
		$ext_hatchback = 'hatchback';
		$ext_pickup = 'pickup';
		$ext_terenowy = 'terenowy';
		$ext_van = 'van';
		$ext_suv = 'suv';
		$ext_inny = 'inny';
	}

	
//FUEL TYPE - MULTISELECT
$fuel_type_values = $_POST['fuel_type'];
//if some fuel type was selected...
if(!empty($fuel_type_values)){

//make an array
$fuel_type = explode(",", $fuel_type_values);

	foreach($fuel_type as $ss){
		if($ss=='benzyna'){
			$fuel_benzin = $ss;
		} elseif($ss == 'diesel'){
			$fuel_diesel = $ss;
		} elseif($ss == 'gaz'){
			$fuel_gas = $ss;
		}
	}
	} else {
	//if nothing was selected, use default values
		$fuel_benzin = 'benzyna';
		$fuel_diesel = 'diesel';
		$fuel_gas = 'gaz';
	}
	
if(!empty($_POST['price_to']) and ($_POST['price_to']) != 'undefined'){
$price_to = $_POST['price_to'];
} 
if(!empty($_POST['price_from']) and ($_POST['price_from']) != 'undefined'){
$price_from = $_POST['price_from'];
} 
if(!empty($_POST['year_from']) and ($_POST['year_from']) != 'undefined'){
$year_from = $_POST['year_from'];
} 
if(!empty($_POST['year_to']) and ($_POST['year_to']) != 'undefined'){
$year_to = $_POST['year_to'];
} 
if(!empty($_POST['engine_size_from']) and ($_POST['engine_size_from']) != 'undefined'){
$engine_size_from = $_POST['engine_size_from'];
} 
if(!empty($_POST['engine_size_to']) and ($_POST['engine_size_to']) != 'undefined'){
$engine_size_to = $_POST['engine_size_to'];
} 
if(!empty($_POST['engine_power_from']) and ($_POST['engine_power_from']) != 'undefined'){
$engine_power_from = $_POST['engine_power_from'];
} 
if(!empty($_POST['engine_power_to']) and ($_POST['engine_power_to']) != 'undefined'){
$engine_power_to = $_POST['engine_power_to'];
} 
if(!empty($_POST['km_to']) and ($_POST['km_to']) != 'undefined'){
$km_to = $_POST['km_to'];
} 
if(!empty($_POST['brand']) and ($_POST['brand']) != 'undefined'){
	$brand = $_POST['brand'];
	$get_brand_id = "SELECT brand_id FROM brands WHERE brand_name='$brand'";
	$brand_data = mysqli_query($con,$get_brand_id);
	while($row = $brand_data->fetch_assoc()){ 
		$brand_id = $row['brand_id'];
	}
} 
if(!empty($_POST['model']) and ($_POST['model']) != 'undefined'){
	$model = $_POST['model'];
	$get_model_id = "SELECT model_id FROM models 
					JOIN brands ON models.model_brand_id= brands.brand_id
					WHERE brands.brand_id=$brand_id
					and models.model_name = '$model'";
	$model_data = mysqli_query($con,$get_model_id);
	while($row = $model_data->fetch_assoc()){ 
		$model_id = $row['model_id'];
	}
} 

if(($exterior_type_values=='undefined') and ($fuel_type_values=='undefined')){

	if($model_id != NULL){
		$search_for = "	SELECT * FROM ads
	            JOIN models ON ads.ad_model_id=models.model_id 
                JOIN brands ON models.model_brand_id= brands.brand_id
                WHERE ad_price > $price_from 
                and ad_price < $price_to
                and ad_production_year >= $year_from
                and ad_production_year <= $year_to
                and ad_engine_size >= $engine_size_from
                and ad_engine_size <= $engine_size_to
                and ad_engine_power >= $engine_power_from
                and ad_engine_power <= $engine_power_to
                and ad_km <= $km_to
				and brands.brand_id = $brand_id
				and models.model_id = $model_id
				";
		} else {
		$search_for = "	SELECT * FROM ads
	            JOIN models ON ads.ad_model_id=models.model_id 
                JOIN brands ON models.model_brand_id= brands.brand_id
                WHERE ad_price > $price_from 
                and ad_price < $price_to
                and ad_production_year >= $year_from
                and ad_production_year <= $year_to
                and ad_engine_size >= $engine_size_from
                and ad_engine_size <= $engine_size_to
                and ad_engine_power >= $engine_power_from
                and ad_engine_power <= $engine_power_to
                and ad_km <= $km_to
				and brands.brand_id = $brand_id
				";		
		}
} elseif(($exterior_type_values=='undefined') and !($fuel_type_values=='undefined')){

		if($model_id != NULL){
		$search_for = "SELECT * FROM ads 
	            JOIN models ON ads.ad_model_id=models.model_id 
                JOIN brands ON models.model_brand_id= brands.brand_id
                WHERE ad_price > $price_from 
                and ad_price < $price_to
                and ad_production_year >= $year_from
                and ad_production_year <= $year_to
                and ad_engine_size >= $engine_size_from
                and ad_engine_size <= $engine_size_to
                and ad_engine_power >= $engine_power_from
                and ad_engine_power <= $engine_power_to
                and ad_km <= $km_to
				and (ad_fuel = '$fuel_diesel'
				or ad_fuel = '$fuel_benzin'
				or ad_fuel = '$fuel_gas')
				and brands.brand_id = $brand_id
				and models.model_id = $model_id
				";
		} else {
		$search_for = "SELECT * FROM ads 
	            JOIN models ON ads.ad_model_id=models.model_id 
                JOIN brands ON models.model_brand_id= brands.brand_id
                WHERE ad_price > $price_from 
                and ad_price < $price_to
                and ad_production_year >= $year_from
                and ad_production_year <= $year_to
                and ad_engine_size >= $engine_size_from
                and ad_engine_size <= $engine_size_to
                and ad_engine_power >= $engine_power_from
                and ad_engine_power <= $engine_power_to
                and ad_km <= $km_to
				and (ad_fuel = '$fuel_diesel'
				or ad_fuel = '$fuel_benzin'
				or ad_fuel = '$fuel_gas')
				and brands.brand_id = $brand_id
				";
		}	
} elseif(!($exterior_type_values=='undefined') and ($fuel_type_values=='undefined')){

		if($model_id != NULL){
		$search_for = "SELECT * FROM ads 
	            JOIN models ON ads.ad_model_id=models.model_id 
                JOIN brands ON models.model_brand_id= brands.brand_id
                WHERE ad_price > $price_from 
                and ad_price < $price_to
                and ad_production_year >= $year_from
                and ad_production_year <= $year_to
                and ad_engine_size >= $engine_size_from
                and ad_engine_size <= $engine_size_to
                and ad_engine_power >= $engine_power_from
                and ad_engine_power <= $engine_power_to
                and ad_km <= $km_to
				and (ad_exterior_type = '$ext_kabriolet'
				or ad_exterior_type = '$ext_sedan'	
                or ad_exterior_type = '$ext_sportowy'
				or ad_exterior_type = '$ext_kombi'
				or ad_exterior_type = '$ext_hatchback'
				or ad_exterior_type = '$ext_pickup'
				or ad_exterior_type = '$ext_terenowy'
				or ad_exterior_type = '$ext_van'
				or ad_exterior_type = '$ext_suv'
				or ad_exterior_type = '$ext_inny')
				and brands.brand_id = $brand_id
				and models.model_id = $model_id
				";
		} else {
		$search_for = "SELECT * FROM ads 
	            JOIN models ON ads.ad_model_id=models.model_id 
                JOIN brands ON models.model_brand_id= brands.brand_id
                WHERE ad_price > $price_from 
                and ad_price < $price_to
                and ad_production_year >= $year_from
                and ad_production_year <= $year_to
                and ad_engine_size >= $engine_size_from
                and ad_engine_size <= $engine_size_to
                and ad_engine_power >= $engine_power_from
                and ad_engine_power <= $engine_power_to
                and ad_km <= $km_to
				and (ad_exterior_type = '$ext_kabriolet'
				or ad_exterior_type = '$ext_sedan'	
                or ad_exterior_type = '$ext_sportowy'
				or ad_exterior_type = '$ext_kombi'
				or ad_exterior_type = '$ext_hatchback'
				or ad_exterior_type = '$ext_pickup'
				or ad_exterior_type = '$ext_terenowy'
				or ad_exterior_type = '$ext_van'
				or ad_exterior_type = '$ext_suv'
				or ad_exterior_type = '$ext_inny')
				and brands.brand_id = $brand_id
				";
		}
} elseif(!($exterior_type_values=='undefined') and !($fuel_type_values=='undefined')){
	
		if($model_id != NULL){
		$search_for = "SELECT * FROM ads 
	            JOIN models ON ads.ad_model_id=models.model_id 
                JOIN brands ON models.model_brand_id= brands.brand_id
                WHERE ad_price > $price_from 
                and ad_price < $price_to
                and ad_production_year >= $year_from
                and ad_production_year <= $year_to
                and ad_engine_size >= $engine_size_from
                and ad_engine_size <= $engine_size_to
                and ad_engine_power >= $engine_power_from
                and ad_engine_power <= $engine_power_to
                and ad_km <= $km_to
				and (ad_exterior_type = '$ext_kabriolet'
				or ad_exterior_type = '$ext_sedan'	
                or ad_exterior_type = '$ext_sportowy'
				or ad_exterior_type = '$ext_kombi'
				or ad_exterior_type = '$ext_hatchback'
				or ad_exterior_type = '$ext_pickup'
				or ad_exterior_type = '$ext_terenowy'
				or ad_exterior_type = '$ext_van'
				or ad_exterior_type = '$ext_suv'
				or ad_exterior_type = '$ext_inny')
				and (ad_fuel = '$fuel_diesel'
				or ad_fuel = '$fuel_benzin'
				or ad_fuel = '$fuel_gas')
				and brands.brand_id = $brand_id
				and models.model_id = $model_id
				";
		} else {
		$search_for = "SELECT * FROM ads 
	            JOIN models ON ads.ad_model_id=models.model_id 
                JOIN brands ON models.model_brand_id= brands.brand_id
                WHERE ad_price > $price_from 
                and ad_price < $price_to
                and ad_production_year >= $year_from
                and ad_production_year <= $year_to
                and ad_engine_size >= $engine_size_from
                and ad_engine_size <= $engine_size_to
                and ad_engine_power >= $engine_power_from
                and ad_engine_power <= $engine_power_to
                and ad_km <= $km_to
				and (ad_exterior_type = '$ext_kabriolet'
				or ad_exterior_type = '$ext_sedan'	
                or ad_exterior_type = '$ext_sportowy'
				or ad_exterior_type = '$ext_kombi'
				or ad_exterior_type = '$ext_hatchback'
				or ad_exterior_type = '$ext_pickup'
				or ad_exterior_type = '$ext_terenowy'
				or ad_exterior_type = '$ext_van'
				or ad_exterior_type = '$ext_suv'
				or ad_exterior_type = '$ext_inny')
				and (ad_fuel = '$fuel_diesel'
				or ad_fuel = '$fuel_benzin'
				or ad_fuel = '$fuel_gas')
				and brands.brand_id = $brand_id
				";
		}
}

	 $all_data = mysqli_query($con,$search_for);
	 
	 echo "<table style='padding:10px;'>";
	 if($all_data) {
	 
        while($data = mysqli_fetch_array($all_data)){    
		echo "<tr style='font-family: 'Signika', Arial, serif;font-weight: 400;height: 230px;width:1030px;padding:10px;margin-bottom:40px;margin-top:20px;'>";
		echo "<td style='margin-bottom:10px;'>";
		echo "<div class='classic_offer_list_one' style='padding:0px;'>";
		echo "<div class='offer-list-img' style='padding:10px;width:960px;'>";
 
		echo "<div class='imgLiquidFill imgLiquid imgLiquid_bgSize imgLiquid_ready' style='width: 328px; height: 210px; float: left; border: 1px solid rgb(179, 179, 179); background-image: url(/images/data/".$data['ad_main_img']."); background-size: cover; background-position: center top; background-repeat: no-repeat;'>";
        //echo "<div class='imgLiquidFill imgLiquid' style='width:328px;height:210px;float:left;border:1px solid #B3B3B3;'>";		
		$img = "/images/data/".$data['ad_main_img'];
        $dir = "/images/data";
        $var_to_check = $data['ad_main_img'];
            
		/*if(!is_null($var_to_check)){	
		echo "<div style='width: 328px; height: 210px; float: left; border: 1px solid rgb(179, 179, 179); background-image: url(/imgages/data/".$data['ad_main_img']."); background-size: cover; background-position: center top; background-repeat: no-repeat;' class='imgLiquidFill imgLiquid imgLiquid_bgSize imgLiquid_ready'>";
		} else {
		echo "<div style='width: 328px; height: 210px; float: left; border: 1px solid rgb(179, 179, 179); background-image: url(/images/data/no_image_classic.jpg); background-size: cover; background-position: center top; background-repeat: no-repeat;' class='imgLiquidFill imgLiquid imgLiquid_bgSize imgLiquid_ready'>";
		}*/
		
		echo "<a style='transition: all 0.2s ease-in-out 0s; display: block; width: 100%; height: 100%;' href='/ogloszenia/index/".$data['ad_id']."'>";
			
		if(!is_null($var_to_check)){
		echo "<img style='width:328px;display:none;' src='/images/data/".$data['ad_main_img']."' />";
		} else {
		echo "<img style='width:328px;display:none;' src='/images/data/no_image_classic.jpg' />";
		}
		echo '</a></div>';

		echo "<div class='offer-list-desc' style='padding-left:0px;'>";
		echo "<p style='color:#657796;font-weight:bold;font-size:17px;text-decoration:none;padding-top:5px;'>";
      
		echo "<a href='/ogloszenia/index/".$data['ad_id']."' style='color:#657796;'>".$data['ad_title']."</a></p>";

        echo "<table class='table table-hover table-condensed' style='font-size:12px;'>";
        echo "<tr>";
        echo "<td class='gray-td'>rok produkcji:</td>";
        echo "<td class='value-td'>".$data['ad_production_year']."</td>";
        echo "<td class='gray-td'>przebieg (km):</td>";
        echo "<td class='value-td'>".$data['ad_km']."</td>"; 
		echo "<td class='gray-td'>typ:</td>";    
        echo "<td class='value-td'>".$data['ad_exterior_type']."</td>";
        echo "</tr>";    
        
		echo "<tr>";
        echo "<td class='gray-td'>rodzaj paliwa:</td>";   
        echo "<td class='value-td'>".$data['ad_fuel']."</td>";
        echo "<td class='gray-td'>moc silnika (KM):</td>"; 
        echo "<td class='value-td'>".$data['ad_engine_power']."</td>";
        echo "<td class='gray-td'>pojemność:</td>";
        echo "<td class='value-td'>".$data['ad_engine_size']."</td>";
        echo "</tr>";
                  
        echo "</table>";
		echo "<br />";
		
		echo "<div style='float:left;font-size:12px;width:100%;'>";
		echo "<div style='width:140px;float:left;'>";
		
		echo "<p><strong></strong><font style='font-size:26px;font-weight:bold;color:#B30B13;'>";
		echo "<span class='glyphicon glyphicon-tag' style='font-size:14px;color:#B8B8B8;'></span>";
		echo number_format($data['ad_price'],0, "", " ");
		echo '</font> pln</p>';
		echo '</div>';

		
		echo '</div>';
		echo '</div>';
		echo '</td></tr>';
		
		}			
        } else {
            return false;
        }
		echo '</table>';
?>


