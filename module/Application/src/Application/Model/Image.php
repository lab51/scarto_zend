<?php
namespace Application\Model;

class Image
{
  public $image_name;
	
//  public $password;

  function exchangeArray($data){
  	$this->image_name = (isset($data['image_name'])) ? $data['image_name'] : null;           
	}
  
  //potrzebne zeby dzia?a? hydrator
  public function getArrayCopy()
  {
      return get_object_vars($this);
  }
  
}