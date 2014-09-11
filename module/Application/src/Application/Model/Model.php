<?php
namespace Application\Model;

class Model
{
  public $model_name;
  public $model_id;
  public $model_series_name;
  
//  public $password;

  function exchangeArray($data){
    $this->model_id = (isset($data['model_id'])) ? $data['model_id'] : null;      
	$this->model_name = (isset($data['model_name'])) ? $data['model_name'] : null;           
	$this->model_series_name = (isset($data['model_series_name'])) ? $data['model_series_name'] : null;           
	
	}
  
  //potrzebne zeby dzia?a? hydrator
  public function getArrayCopy()
  {
      return get_object_vars($this);
  }
  
}