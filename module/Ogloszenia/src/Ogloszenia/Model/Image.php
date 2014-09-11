<?php
namespace Ogloszenia\Model;

class Image
{
  public $image_id;

  public $image_name;
  public $image_2;
  public $image_3;
  public $image_4;
  public $image_5;
  public $image_6;
  public $image_7;
  public $image_8;
  public $image_9;
  public $image_ad_id;
  
//  public $password;

  function exchangeArray($data){
    $this->image_id = (isset($data['image_id']) && !empty($data['image_id'])) ? $data['image_id'] : null;  
    $this->image_name = (isset($data['image_name']) && !empty($data['image_name']) ) ? $data['image_name'] : null;
    $this->image_2 = (isset($data['image_2']) && !empty($data['image_2'])) ? $data['image_2'] : null;
    $this->image_3 = (isset($data['image_3']) && !empty($data['image_3'])) ? $data['image_3'] : null;
	$this->image_4 = (isset($data['image_4']) && !empty($data['image_4'])) ? $data['image_4'] : null;
	$this->image_5 = (isset($data['image_5']) && !empty($data['image_5'])) ? $data['image_5'] : null;
	$this->image_6 = (isset($data['image_6']) && !empty($data['image_6'])) ? $data['image_6'] : null;
	$this->image_7 = (isset($data['image_7']) && !empty($data['image_7'])) ? $data['image_7'] : null;
	$this->image_8 = (isset($data['image_8']) && !empty($data['image_8'])) ? $data['image_8'] : null;
	$this->image_9 = (isset($data['image_9']) && !empty($data['image_9'])) ? $data['image_9'] : null;
	$this->image_ad_id = (isset($data['image_ad_id']) && !empty($data['image_ad_id'])) ? $data['image_ad_id'] : null;
    
  }
  
  //potrzebne zeby działał hydrator
  public function getArrayCopy()
  {
      return get_object_vars($this);
  }
  
}