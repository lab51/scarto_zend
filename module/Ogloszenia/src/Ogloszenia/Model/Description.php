<?php
namespace Ogloszenia\Model;

class Description
{
	public $description_id;
	public $description_content;
	public $description_ad_id;

  function exchangeArray($data){
    $this->description_id = (isset($data['description_id']) && !empty($data['description_id'])) ? $data['description_id'] : null;      
    $this->description_content = (isset($data['description_content']) && !empty($data['description_content'])) ? $data['description_content'] : null;      
    $this->description_ad_id = (isset($data['description_ad_id']) && !empty($data['description_ad_id'])) ? $data['description_ad_id'] : null;      
  
	}
  

  //potrzebne zeby dzia?a? hydrator
  public function getArrayCopy()
  {
      return get_object_vars($this);
  }
  
}