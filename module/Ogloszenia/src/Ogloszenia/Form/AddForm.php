<?php
namespace Ogloszenia\Form;

use Zend\Form\Form;
use Zend\Form\Element\Select;

class AddForm extends Form
{

public function __construct($name = null)
{
parent::__construct('Add');

$this->add(array(
    'name' => 'ad_title',
    'attributes' => array(
      'type' => 'text',
	  'class' => 'form-control', 
	  'style' => 'padding:2px;height:26px;width:400px;font-weight:bold;',
    ),
    'options' => array(  
      'label' => '<b>Tytuł ogłoszenia*</b>',   
    ),
));

$this->add(array(
    'name' => 'ad_user_id',
    'attributes' => array(
      'type' => 'hidden',
	  'value' => '8', 
    ),
));
$this->add(array(
    'name' => 'description_content',
    'attributes' => array(
      'type' => 'textarea',
	  'class' => 'form-control',
	  'style' => 'width:600px;',
	  'rows' => '5',
	  'cols' => '100',	  
    ),
));

$this->add(array(
    'name' => 'ad_first_name',
    'attributes' => array(
      'type' => 'text',
	  'class' => 'form-control',
	  'style' => 'padding:2px;height:26px;width:190px;',
    ),
    'options' => array(
      'label' => 'imię',
    ),
));


$this->add(array(
    'name' => 'ad_mail',
    'attributes' => array(
      'type' => 'text',
	  'class' => 'form-control',
	  'style' => 'padding:2px;height:26px;width:190px;',
    ),
    'options' => array(
      'label' => '<b>adres email*</b>',
    ),
));

$this->add(array(
    'name' => 'ad_phone_nr',
    'attributes' => array(
      'type' => 'text',
	  'class' => 'form-control',
	  'style' => 'padding:2px;height:26px;width:190px;',
    ),
    'options' => array(
      'label' => 'numer telefonu',
    ),
));


$this->add(array(
    'type' => 'Zend\Form\Element\Select',
    'name' => 'brand_name',
	'attributes' => array(
		'id' => 'brand_name',
		'class' => 'form-control',
		'style' => 'padding:2px;height:26px;',
		'onchange' => 'getModels(this.value)',
    ),
    'options' => array(
		'label' => '<b>Marka*</b>',
        'value_options' => array('' => 'wybierz', 'opel' => 'opel', 'volkswagen' => 'volkswagen', 'audi' => 'audi', 'seat' => 'seat', 'bmw' => 'bmw', 'maybach' => 'maybach', 'mercedes-benz' => 'mercedes-benz', 'mini' => 'mini', 'porsche' => 'porsche', 'skoda' => 'skoda')
        ),
));

$this->add(array(
    'type' => 'Zend\Form\Element\Select',
    'name' => 'ad_model_id',
	'attributes' => array(
		'class' => 'form-control',
		'style' => 'padding:2px;height:26px;',
		'id' => 'ad_model_id',
	),
    'options' => array(
  		'label' => '<b>Model*</b>',
      'disable_inarray_validator' => true,      
      'value_options' => array('' => 'wybierz'),  
    ),
));


//POPRAWIC :/
$this->add(array(
    'type' => 'Zend\Form\Element\Select',
    'name' => 'ad_production_year',
	'attributes' => array(
		'class' => 'form-control',
		'style' => 'padding:2px;height:26px;',
		'id' => 'ad_production_year',
    ),
    'options' => array(
		'label' => '<b>Rok produkcji*</b>',
    'value_options' => array('' => 'wybierz', '2014'=>'2014','2013'=>'2013','2012'=>'2012','2011'=>'2011','2010'=>'2010','2009'=>'2009','2008'=>'2008','2007'=>'2007','2006'=>'2006','2005'=>'2005','2004'=>'2004','2003'=>'2003','2002'=>'2002','2001'=>'2001','2000'=>'2000',
		'1999'=>'1999','1998'=>'1998','1997'=>'1997','1996'=>'1996','1995'=>'1995','1994'=>'1994','1993'=>'1993','1992'=>'1992','1991'=>'1991','1990'=>'1990',
		'1989'=>'1989','1988'=>'1988','1987'=>'1987','1986'=>'1986','1985'=>'1985','1984'=>'1984','1983'=>'1983','1982'=>'1982','1980'=>'1980','1979'=>'1979','1978'=>'1978','1977'=>'1977','1976'=>'1976','1975'=>'1975','1974'=>'1974','1973'=>'1973','1972'=>'1972','1971'=>'1971','1970'=>'1970',
		'1969'=>'1969','1968'=>'1968','1967'=>'1967','1966'=>'1966','1965'=>'1965','1964'=>'1964','1963'=>'1963','1962'=>'1962','1961'=>'1961','1960'=>'1960','1959'=>'1959','1958'=>'1958','1957'=>'1957','1956'=>'1956','1955'=>'1955','1954'=>'1954','1953'=>'1953','1952'=>'1952','1951'=>'1951',
		'1950'=>'1950','1949'=>'1949','1948'=>'1948','1947'=>'1947','1946'=>'1946','1945'=>'1945','1944'=>'1944','1943'=>'1943','1942'=>'1942','1941'=>'1941','1940'=>'1940','1939'=>'1939','1938'=>'1938','1937'=>'1937','1936'=>'1936','1935'=>'1935','1934'=>'1934','1933'=>'1933','1932'=>'1932',
		'1931'=>'1931','1930'=>'1930','1929'=>'1929','1928'=>'1928','1927'=>'1927','1926'=>'1926','1925'=>'1925','1924'=>'1924','1923'=>'1923','1922'=>'1922','1921'=>'1921','1920'=>'1920','1919'=>'1919','1918'=>'1918','1917'=>'1917','1916'=>'1916','1915'=>'1915','1914'=>'1914','1913'=>'1913','1912'=>'1912','1911'=>'1911','1910'=>'1910','1909'=>'1909','1908'=>'1908','1907'=>'1907','1906'=>'1906','1905'=>'1905','1904'=>'1904','1903'=>'1903','1902'=>'1902','1901'=>'1901','1900'=>'1900')
	),
));

$this->add(array(
    'type' => 'Zend\Form\Element\Select',
    'name' => 'ad_exterior_type',
	'attributes' => array(
		'class' => 'form-control',
		'style' => 'padding:2px;height:26px;',
		'id' => 'ad_exterior_type',
	),
    'options' => array(
		'label' => '<b>Nadwozie*</b>',
		'value_options' => array('' => 'wybierz', 'kabriolet' => 'kabriolet', 'sedan' => 'sedan', 'sportowy' => 'sportowy', 'kombi' => 'kombi', 'hatchback' => 'hatchback', 'pickup' => 'pickup', 'terenowy' => 'terenowy', 'van' => 'van', 'suv' => 'suv', 'inny' => 'inny')
	),
));

$this->add(array(
    'name' => 'ad_price',
    'attributes' => array(
      'class' => 'form-control',
	  'style' => 'padding:2px;height:26px;width:190px;',
	  'type' => 'text',
    ),
    'options' => array(
      'label' => '<b>Cena*</b>',
    ),
));

$this->add(array(
    'type' => 'Zend\Form\Element\Select',
    'name' => 'ad_gearbox',
	'attributes' => array(
		'class' => 'form-control',
		'style' => 'padding:2px;height:26px;',
		'id' => 'ad_gearbox',
	),
    'options' => array(
		'label' => 'Skrzynia biegów',
		'value_options' => array('' => 'wybierz', 'manualna' => 'manualna', 'automatyczna' => 'automatyczna', 'sekwencyjna' => 'sekwencyjna')
	),
));

$this->add(array(
    'type' => 'Zend\Form\Element\Select',
    'name' => 'ad_fuel',
	'attributes' => array(
		'class' => 'form-control',
		'style' => 'padding:2px;height:26px;',
		'id' => 'ad_fuel',
	),
    'options' => array(
		'label' => 'Rodzaj paliwa',
		'value_options' => array('' => 'wybierz', 'benzyna' => 'benzyna', 'diesel' => 'diesel', 
		'gaz' => 'benzyna+gaz', 'elektryczny' => 'elektryczny', 'hybryda' => 'hybryda', 'inne' => 'inne' )
	),
));
   

$this->add(array(
    'type' => 'Zend\Form\Element\Select',
    'name' => 'ad_doors_nr',
	'attributes' => array(
		'class' => 'form-control',
		'style' => 'padding:2px;height:26px;',
		'id' => 'ad_doors_nr',
	),
    'options' => array(
		'label' => 'Liczba drzwi',
		'value_options' => array('' => 'wybierz', '3' => '2/3', '5' => '4/5')
	),
));

$this->add(array(
    'type' => 'Zend\Form\Element\Select',
    'name' => 'ad_car_color',
	'attributes' => array(
		'class' => 'form-control',	
		'style' => 'padding:2px;height:26px;',
		'id' => 'ad_car_color',
	),
    'options' => array(
		'label' => 'Kolor nadwozia',
		'value_options' => array('' => 'wybierz', 'grafitowy' => 'grafitowy', 'granatowy' => 'granatowy',
			'niebieski' => 'niebieski', 'pomarańczowy' => 'pomarańczowy', 'różowy' => 'różowy', 
			'srebrny' => 'srebrny', 'szary' => 'szary', 'fioletowy' => 'fioletowy', 'wiśniowy' => 'wiśniowy',
			'zielony' => 'zielony', 'złoty' => 'złoty', 'żółty' => 'żółty', 'czarny' => 'czarny', 
			'czerwony' => 'czerwony', 'brązowy' => 'brązowy', 'bordowy' => 'bordowy', 'biały' => 'biały', 
			'beżowy' => 'beżowy', 'inny' => 'inny'
		)
	),
));
                

$this->add(array(
    'name' => 'ad_km',
    'attributes' => array(
      'class' => 'form-control',
	  'style' => 'padding:2px;height:26px;width:190px;', 
	  'type' => 'text',
    ),
    'options' => array(
      'label' => 'Przebieg (km)',
    ),
));

$this->add(array(
    'name' => 'ad_engine_power',
    'attributes' => array(
      'class' => 'form-control',
	  'style' => 'padding:2px;height:26px;width:190px;',
	  'type' => 'text',
    ),
    'options' => array(
      'label' => 'Moc silnika (KM)',
    ),
));
 
$this->add(array(
    'name' => 'ad_engine_size',
    'attributes' => array(
      'class' => 'form-control', 
	  'style' => 'padding:2px;height:26px;width:190px;',	  
	  'type' => 'text',
    ),
    'options' => array(
      'label' => 'Pojemność silnika (cm3)',
    ),
)); 
   
$this->add(array(
    'type' => 'Zend\Form\Element\Select',
    'name' => 'ad_condition',
	'attributes' => array(
		'class' => 'form-control',	
		'style' => 'padding:2px;height:26px;',
		'id' => 'ad_condition',
	),
    'options' => array(
		'label' => 'Stan',
		'value_options' => array('' => 'wybierz', '1' => 'bezwypadkowy', '2' => 'uszkodzony')
	),
));

$this->add(array(
    'name' => 'extra_clima',
	'type' => 'Zend\Form\Element\Checkbox',
    'options' => array(
      'checked_value' => '1'
    ),
));    
   
$this->add(array(
    'name' => 'extra_abs',
	'type' => 'Zend\Form\Element\Checkbox',
    'options' => array(
      'checked_value' => '1'
    ),
));       

$this->add(array(
    'name' => 'extra_asr',
	'type' => 'Zend\Form\Element\Checkbox',
    'options' => array(
      'checked_value' => '1'
    ),
));

$this->add(array(
    'name' => 'extra_eds',
	'type' => 'Zend\Form\Element\Checkbox',
    'options' => array(
      'checked_value' => '1'
    ),
));

$this->add(array(
    'name' => 'extra_esp',
	'type' => 'Zend\Form\Element\Checkbox',
    'options' => array(
      'checked_value' => '1'
    ),
));
   

$this->add(array(
    'name' => 'extra_alufelgi',
	'type' => 'Zend\Form\Element\Checkbox',
    'options' => array(
      'checked_value' => '1'
    ),
));


$this->add(array(
    'name' => 'extra_autoalarm',
	'type' => 'Zend\Form\Element\Checkbox',
    'options' => array(
      'checked_value' => '1'
    ),
));   


$this->add(array(
    'name' => 'extra_diff',
	'type' => 'Zend\Form\Element\Checkbox',
    'options' => array(
      'checked_value' => '1'
    ),
));


$this->add(array(
    'name' => 'extra_gearbox_block',
	'type' => 'Zend\Form\Element\Checkbox',
    'options' => array(
      'checked_value' => '1'
    ),
));

$this->add(array(
    'name' => 'extra_central_lock',
	'type' => 'Zend\Form\Element\Checkbox',
    'options' => array(
      'checked_value' => '1'
    ),
));

$this->add(array(
    'name' => 'extra_rain_ind',
	'type' => 'Zend\Form\Element\Checkbox',
    'options' => array(
      'checked_value' => '1'
    ),
));

$this->add(array(
    'name' => 'extra_electric_mirrors',
	'type' => 'Zend\Form\Element\Checkbox',
    'options' => array(
      'checked_value' => '1'
    ),
));

$this->add(array(
    'name' => 'extra_electric_windows',
	'type' => 'Zend\Form\Element\Checkbox',
    'options' => array(
      'checked_value' => '1'
    ),
));

$this->add(array(
    'name' => 'extra_hook',
	'type' => 'Zend\Form\Element\Checkbox',
    'options' => array(
      'checked_value' => '1'
    ),
));

$this->add(array(
    'name' => 'extra_immobiliser',
	'type' => 'Zend\Form\Element\Checkbox',
    'options' => array(
      'checked_value' => '1'
    ),
));

$this->add(array(
    'name' => 'extra_gas_instalation',
	'type' => 'Zend\Form\Element\Checkbox',
    'options' => array(
      'checked_value' => '1'
    ),
));

$this->add(array(
    'name' => 'extra_xenons',
	'type' => 'Zend\Form\Element\Checkbox',
    'options' => array(
      'checked_value' => '1'
    ),
));

$this->add(array(
    'name' => 'extra_heat_seats',
	'type' => 'Zend\Form\Element\Checkbox',
    'options' => array(
      'checked_value' => '1'
    ),
));

$this->add(array(
    'name' => 'extra_radio',
	'type' => 'Zend\Form\Element\Checkbox',
    'options' => array(
      'checked_value' => '1'
    ),
));

$this->add(array(
    'name' => 'extra_leather_seats',
	'type' => 'Zend\Form\Element\Checkbox',
    'options' => array(
      'checked_value' => '1'
    ),
));

$this->add(array(
    'name' => 'extra_gps_nav',
	'type' => 'Zend\Form\Element\Checkbox',
    'options' => array(
      'checked_value' => '1'
    ),
));

$this->add(array(
    'name' => 'extra_fog_lights',
	'type' => 'Zend\Form\Element\Checkbox',
    'options' => array(
      'checked_value' => '1'
    ),
));

$this->add(array(
    'name' => 'extra_tempomat',
	'type' => 'Zend\Form\Element\Checkbox',
    'options' => array(
      'checked_value' => '1'
    ),
));

$this->add(array(
    'name' => 'extra_wheel_helper',
	'type' => 'Zend\Form\Element\Checkbox',
    'options' => array(
      'checked_value' => '1'
    ),
));


$this->add(array(
    'name' => 'extra_4x4',
	'type' => 'Zend\Form\Element\Checkbox',
    'options' => array(
      'checked_value' => '1'
    ),
));

$this->add(array(
    'name' => 'ad_main_img',
    'attributes' => array(
        'type'  => 'file',
		'id' => 'ad_main_img',
        ),
    'options' => array(
        'label' => 'Główne zdjęcie',
        ),
));
         
$this->add(array(
    'name' => 'image_2',
    'attributes' => array(
        'type'  => 'file',
        ),
));

$this->add(array(
    'name' => 'image_3',
    'attributes' => array(
        'type'  => 'file',
        ),
));

$this->add(array(
    'name' => 'image_4',
    'attributes' => array(
        'type'  => 'file',
        ),
));

$this->add(array(
    'name' => 'image_5',
    'attributes' => array(
        'type'  => 'file',
        ),
));

$this->add(array(
    'name' => 'image_6',
    'attributes' => array(
        'type'  => 'file',
        ),
));

$this->add(array(
    'name' => 'image_7',
    'attributes' => array(
        'type'  => 'file',
        ),
));

$this->add(array(
    'name' => 'image_8',
    'attributes' => array(
        'type'  => 'file',
        ),
));

$this->add(array(
    'name' => 'image_9',
    'attributes' => array(
        'type'  => 'file',
        ),
));

$this->add(array(
    'name' => 'submit',
    'attributes' => array(
      'type' => 'submit',
	  'class' => 'btn btn-large btn-primary',
	  'style' => 'margin-bottom: 40px;float:left;margin-left:0px;margin-top:50px;width:200px;',
      'value' => 'dodaj ogłoszenie',
    ),
));


}

private function listYears(){
	$years = array();
	
	$current_year = date("Y");
        
		$year_range = range($current_year, 1900);
            foreach ($year_range as $year){
				$ej = array('ss' => $year_range);
                array_push($years, $ej);
            }
	return $years;		
}

}