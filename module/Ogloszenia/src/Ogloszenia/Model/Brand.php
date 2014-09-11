<?php
namespace Ogloszenia\Model;

class Brand
{
  public $brand_name;
  public $brand_id;
  
//  public $password;

  function exchangeArray($data){
    $this->brand_id = (isset($data['brand_id'])) ? $data['brand_id'] : null;      
		$this->brand_name = (isset($data['brand_name'])) ? $data['brand_name'] : null;           
	}
  
  //potrzebne zeby dzia?a? hydrator
  public function getArrayCopy()
  {
      return get_object_vars($this);
  }
  
}