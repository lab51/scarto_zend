
<div style="float:left;margin-left:5px;margin-bottom: 45px;">

   
    
    


<?php
//print_r($title);
        foreach($db_data as $db){
?>
  <a href="<?php echo base_url();?>">scarto.pl</a><span class="divider">/</span>
  <a href="<?php echo base_url();?>osobowe">osobowe</a> <span class="divider">/</span>
  <a href="<?php echo base_url();?>osobowe/lista/<?php echo $db->brand_name; ?>"><?php echo $db->brand_name; ?></a>
  <span class="divider">/</span>
  <a href="<?php echo base_url();?>osobowe/lista/<?php echo $db->brand_name."/".$db->model_name; ?>"><?php echo $db->model_name; ?></a>
  
  
    
          
      <p><h1 style="font-size:24px;"><legend><i class="icon-folder-open" style="margin-top:7px;"></i> <?php echo $db->ad_title; ?></legend></h1>
 
    </p> 			
  
		<div class="one-offer-list-img">
		
		
	
		
		
		   <div id="image" style="width:680px;float:left;">
 			<?php
			if(!empty($db->ad_main_img)){
			echo "<img src='".base_url()."pub/img_cars/".$db->ad_main_img."' style='width:680px;float:left;' class='img-polaroid' /><br />"; 
			} ?>
		  </div>
 		  
                                <div style="width:680px;">
                        
                        <p>
                            <legend><i class="icon-info-sign" style="margin-top:7px;"></i> dane techniczne:</legend>
	         </p>

	 		
            <table class="table table-striped table-condensed" style="font-size:13px;">
                	
            <tr>
                		<td class="gray-td">Marka:</td>
			              <td>
                    <?php 
                        if(isset($db->brand_name)){
                         echo $db->brand_name; 
                        } else {
                         echo '-';
                        }
                    ?> 
                    </td>
                                               
                    <td class="gray-td">Model:</td>
                    <td>
                    <?php 
                    if(isset($db->model_name)){
                      echo $db->model_name; 
                    } else {
                      echo '-';
                    }
                    ?>
                    </td>
                            </tr>
	
                            <tr>
                   <td class="gray-td">Rocznik:</td>
                    <td>
                    <?php 
                        if(isset($db->ad_production_year)){
                         echo $db->ad_production_year; 
                        } else {
                         echo '-';
                        }
                    ?> 
                    </td>
                            
                    <td class="gray-td">Przebieg:</td>
                    <td>
                    <?php 
                        if(isset($db->ad_km)){
                         echo $db->ad_km; 
                        } else {
                         echo '-';
                        }
                    ?> 
                    </td>
                            </tr>
                	          <tr>
                    <td class="gray-td">Rodzaj paliwa:</td>
                    <td>
                    <?php 
                        if(isset($db->ad_fuel)){
                         echo $db->ad_fuel; 
                        } else {
                         echo '-';
                        }
                    ?> 
                    
                    </td>
                              
                    <td class="gray-td">Pojemność:</td>
                    <td>
                    <?php 
                        if(isset($db->ad_engine_size)){
                         echo $db->ad_engine_size; 
                        } else {
                         echo '-';
                        }
                    ?> 
                    </td>
                    </tr>
                            <tr>
                    <td class="gray-td">Moc (KM):</td>
                    <td> 
                    <?php 
                        if(isset($db->ad_engine_power) and ($db->ad_engine_power>0)){
                         echo $db->ad_engine_power; 
                        } else {
                         echo '-';
                        }
                    ?> 
                    </td>
                           
                    <td class="gray-td">Skrzynia biegów:</td>
                    <td>
                    <?php 
                        if(isset($db->ad_gearbox)){
                         echo $db->ad_gearbox; 
                        } else {
                         echo '-';
                        }
                    ?> 
                    </td>
                            </tr>
                	          <tr>
                    <td class="gray-td">Kolor:</td>
                    <td>
                    <?php 
                        if(isset($db->ad_car_color)){
                         echo $db->ad_car_color; 
                        } else {
                         echo '-';
                        }
                    ?> 
                    </td>
                          
                    <td class="gray-td">Liczba drzwi:</td>
                    <td>
                    <?php 
                        if(isset($db->ad_doors_nr)){
                         echo $db->ad_doors_nr; 
                        } else {
                         echo '-';
                        }
                    ?> 
                    </td>
                            </tr>
                            <tr>
                    <td class="gray-td">Stan:</td>
                     <td>
                     <?php 
                        if(isset($db->ad_condition)){
                         if($db->ad_condition==1){
	                        echo 'bezwypadkowy';
                          } elseif($db->ad_condition==0){
	                      	echo 'uszkodzony';    
                         } 
                        } else {
                         echo '-';
                        }
                    ?> 
                    </td>
                            
                    <td class="gray-td">Typ:</td>
                    <td>
                    <?php 
                        if(isset($db->ad_exterior_type)){
                         echo $db->ad_exterior_type; 
                        } else {
                         echo '-';
                        }
                    ?>
                    </td>
                    </tr>
                    </table>

                                </div>
                                <div style="margin-top:10px;width:680px;float:left;">
	
                                <legend><i class="icon-list-alt" style="margin-top:7px;"></i> szczegółowy opis:</legend>
                                <p>
                                            <?php echo nl2br($db->description_content); ?>
                                </p>
                                </div>
                    
     
                    
		</div>

	 	
	<div class="one-offer-list-tech">                
        <div style="max-height:420px;">
<!---galeria miniatur oraz film YT START -->

<?php //JESLI JEST FILM DODANY
if(!empty($db->ad_youtube)){
?>

<div class="tabbable">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#galeria" data-toggle="tab"> zdjęcia</a></li>
    <li><a href="#film" data-toggle="tab"> film</a></li>

  </ul>
  <div class="tab-content">
    <div id="galeria" class="tab-pane active">

          <?php
           //obrazki
           if(empty($db_images) and empty($db->ad_main_img)){
	          echo "<center><img src='".base_url()."pub/img_cars/no_image_s.jpg' style='width:420px;align:center;' class='img-polaroid' /></center>";
           } else {
           foreach($db_images as $img){
          ?>
            <a href="#" rel="<?php echo base_url(); ?>pub/img_cars/<?php echo $img->image_name;?>" class="image"><img src="<?php echo base_url(); ?>pub/img_cars/<?php echo $img->image_name;?>" style="max-width:135px;height:100px;float:left;margin-right:4px;margin-bottom:4px;" class="img-polaroid" />
</a>
  
<?php
	}
	} 
?>
    </div>
      
      <div id="film" class="tab-pane">
<center> <iframe width="410" height="231" src="//www.youtube.com/embed/G8fUmDfk_SE" frameborder="0" allowfullscreen></iframe></center>
    </div>
  </div><!-- /.tab-content -->
</div><!-- /.tabbable -->
<?php } else 
    //JESLI NIE MA FILMU DODANEGO
    {
    ?>

          <?php
           //obrazki
           if(empty($db_images) and empty($db->ad_main_img)){
	          echo "<center><img src='".base_url()."pub/img_cars/no_image_s.jpg' style='width:420px;align:center;' class='img-polaroid' /></center>";
           } else {
           foreach($db_images as $img){
          ?>
            <a href="#" rel="<?php echo base_url(); ?>pub/img_cars/<?php echo $img->image_name;?>" class="image"><img src="<?php echo base_url(); ?>pub/img_cars/<?php echo $img->image_name;?>" style="width:135px;height:100px;float:left;margin-right:4px;margin-bottom:4px;" class="img-polaroid" />
</a>
  
<?php
           }   
      } 
 } 
 ?>
            </div>
                    
<div style="padding-top: 30px;padding-right:40px;float:right;width:410px;font-family: 'Open Sans', sans-serif;font-weight:bold;">
            <legend><i class='icon-tag' style="margin-top:7px;"></i> <font style='color:#3F7EB5;'><?php echo number_format($db->ad_price, 0, "", " "); ?> pln</font></legend>
            </div>
                            
            <div style="padding-top: 10px;float:left;max-width:410px;">
            	                    
	<p><br/>
		<legend><i class="icon-plus" style="margin-top:7px;"></i> dodatkowe wyposażenie:</legend>
	 			</p>

                <p>
<?php 
    $extra_bezpieczenstwo = array('extra_abs', 'extra_asr', 'extra_eds', 'extra_esp', 'extra_fog_lights');
	$extra_komfort = array('extra_clima', 'extra_rain_ind', 'extra_tempomat', 'extra_leather_seats', 'extra_heat_seats');
	$extra_zabezpieczenia = array('extra_autoalarm', 'extra_central_lock', 'extra_gearbox_block');
    $extra_dodatkowe = array('extra_alufelgi', 'extra_diff',   'extra_park_asist', 'extra_electric_mirrors', 'extra_electric_windows', 'extra_hook', 'extra_immobiliser', 'extra_gas_instalation', 'extra_xenons',  'extra_radio',  'extra_gps_nav',  'extra_wheel_helper', 'extra_4x4');
	
    echo "<p><strong>bezpieczeństwo: </strong>";
    $counter_b = 0;
    foreach($extra_bezpieczenstwo as $xb){
        
        if(!empty($db->$xb)) { 
	        
                if($counter_b!=0){
                echo ', '.$db->$xb;
                } else {
                echo $db->$xb;
                }
                $counter_b++;
	    } 
        
     } 
     echo '</p>';
     
     
    echo "<p><strong>komfort: </strong>";
    $counter_k = 0;
    foreach($extra_komfort as $xk){
        if(!empty($db->$xk)) { 
	    if($counter_k != 0){
                echo ', '.$db->$xk;
                } else {
                echo $db->$xk;
                }      
            $counter_k++;    
	    } 
        
     }
    echo '</p>';
     
    
    echo "<p><strong>zabezpieczenia: </strong>";
    $counter_z = 0;
    foreach($extra_zabezpieczenia as $xz){
        if(!empty($db->$xz)) { 
	    if($counter_z != 0){
                echo ', '.$db->$xz;
                } else {
                echo $db->$xz;
                }
                $counter_z++;
        } 
        
     }
    echo '</p>'; 
     
    
    echo "<p><strong>pozostałe: </strong>";
    $counter_p = 0;
    foreach($extra_dodatkowe as $xd){
        if(!empty($db->$xd)) {
            if($counter_p != 0){
                echo ', '.$db->$xd;
                } else {
                echo $db->$xd;
                }
                $counter_p++;
	        } 
        
     }      
     echo '</p>';                        
                                     ?>		
                                         
                                           </p>
                    </div>
                           
            <div style="padding-top: 10px;float:left;width:410px;">         

	

  <div class="tabbable">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#kontakt" data-toggle="tab"> kontakt</a></li>
    <!---<li><a href="#pytanie" data-toggle="tab"> wyślij pytanie</a></li>
     -->
  </ul>
  <div class="tab-content">
    <div id="kontakt" class="tab-pane active">
     
	 			

<p>osoba do kontaktu: <?php echo $db->ad_first_name; ?><br/> 
telefon: <?php echo $db->ad_phone_nr; ?>	 	<br/>	
miejscowość: <?php echo $db->town_name; ?>


    </div>
      
      <!---<div id="pytanie" class="tab-pane">
   
<p>Masz pytania? Napisz do właściciela. Pamiętaj, że nie każdy sprawdza/odpowiada na wiadomości email.</p>
<form action="">
        <p>imię: <input type="text" id="nameq" name="nameq" style="width:100px;" />
        email: <input type="text" id="emailq" name="emailq" style="width:100px;" /></p>
        <p><textarea rows='5' style='width:390px;' name='question'>wpisz pytanie</textarea></p>
        <p><input type="submit" name="wyslij" value="wyślij" /></p> 
</form>
      
    </div> --->
  </div><!-- /.tab-content -->
</div><!-- /.tabbable -->


	
	



<legend><i class="icon-share" style="margin-top:7px;"></i> mogą spodobać się Tobie także:</legend>

<?php 
//pokazuje dwa losowe ogloszenia powiazane
if(!empty($db_like)){
    foreach($db_like as $dbl){
        foreach($dbl as $d){
            if(isset($d->ad_main_img)){ //sprawdzamy czy przeslany jest obrazek
                echo "<a href='".base_url()."osobowe/id/".$d->ad_id."'><img src='".base_url()."pub/img_cars/".$d->ad_main_img."' alt='".$d->ad_title."' class='img-polaroid' style='height:110px;max-width:190px;margin:5px;' /></a>";
            }
        }
        
    }
} ?>


     </div>
                    
                    
                    
                    
	<?php
        }               
    ?>
                                                                               
                                           
                                           
	</div>
	
</div>	


