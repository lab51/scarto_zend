<?php
namespace Ogloszenia\Form;
use Zend\InputFilter\InputFilter;

class AddFilter extends InputFilter
{
	
public function __construct()
{
  
$this->add(array(
  'name' => 'ad_title',
  'required' => true,
  'filters' => array(
    array(
    'name' => 'StripTags',
    ),
  ),
  'validators' => array(
    array(
      'name' => 'StringLength',
      'options' => array(
        'encoding' => 'UTF-8',
        'min' => 2,
        'max' => 90,
      ),
    ),
  ),
));

$this->add(array(
  'name' => 'brand_name',
  'required' => true,
	));

$this->add(array(
  'name' => 'ad_model_id',
  'required' => true,
	));


$this->add(array(
  'name' => 'ad_production_year',
  'required' => true,
  'filters' => array(
    array(
      'name' => 'Digits',
    ),
  ),  
	));


$this->add(array(
  'name' => 'ad_exterior_type',
  'required' => true,
	));

$this->add(array(
  'name' => 'ad_gearbox',
  'required' => false,
	));
	
$this->add(array(
  'name' => 'ad_fuel',
  'required' => false,
	));	


$this->add(array(
  'name' => 'ad_doors_nr',
  'required' => false,
	));	
	
	
$this->add(array(
  'name' => 'ad_car_color',
  'required' => false,
	));	
	
	
$this->add(array(
  'name' => 'ad_condition',
  'required' => false,
	));	
	
$this->add(array(
  'name' => 'ad_price',
  'required' => true,
  'filters' => array(
      array('name' => 'Int')
  ),
  'validators' => array(
    array(
      'name' => 'Between',
      'options' => array(
        'min' => 1,
        'max' => 10000000,
      ),
    ),
  ),  
	));

$this->add(array(
  'name' => 'ad_km',
  'required' => false,
  'filters' => array(
      array('name' => 'Digits')
    ),  
	));


$this->add(array(
  'name' => 'ad_engine_power',
  'required' => false,
  'filters' => array(
      array('name' => 'Int')
    ),
   'validators' => array(
    array(
      'name' => 'Between',
      'options' => array(
        'min' => 0,
        'max' => 1500,
      ),
      ),
    ), 
	));


$this->add(array(
  'name' => 'ad_engine_size',
  'required' => false,
  'filters' => array(
      array('name' => 'Int')
    ),
  'validators' => array(
    array(
      'name' => 'Between',
      'options' => array(
        'min' => 0,
        'max' => 9000,
      ),
    ),
  ),  
	));

$this->add(array(
  'name' => 'description_content',
  'required' => false,
  'filters' => array(
    array(
    'name' => 'StripTags',
    ),
  ),
  'validators' => array(
    array(
      'name' => 'StringLength',
      'options' => array(
        'encoding' => 'UTF-8',
        'max' => 9000,
      ),
    ),
  ),
));


$this->add(array(
  'name' => 'first_name',
  'required' => false,
  'filters' => array(
    array(
    'name' => 'StripTags',
    ),
  ),
  'validators' => array(
    array(
      'name' => 'StringLength',
      'options' => array(
        'encoding' => 'UTF-8',
        'min' => 2,  
        'max' => 20,
      ),
    ),
  ),
));

$this->add(array(
  'name' => 'ad_phone_nr',
  'required' => false,
	));

$this->add(array(
  'name' => 'ad_mail',
  'required' => true,
  'validators' => array(
    array(
      'name' => 'EmailAddress',
      'options' => array(
        'domain' => true,
      ),
    ),
  ),
));



}

}