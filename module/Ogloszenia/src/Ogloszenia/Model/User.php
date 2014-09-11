<?php
namespace Ogloszenia\Model;

class User
{
  public $user_id;
  public $user_name;
  public $user_email;
  public $user_password;


  function exchangeArray($data){
    $this->user_id = (isset($data['user_id'])) ? $data['user_id'] : null;  
    $this->user_name = (isset($data['user_name'])) ? $data['user_name'] : null;
    $this->user_email = (isset($data['user_email'])) ? $data['user_email'] : null;
    $this->user_password = (isset($data['user_password'])) ? $data['user_password'] : null;
    
  
          
    }

  
  
  //potrzebne zeby działał hydrator
  public function getArrayCopy()
  {
      return get_object_vars($this);
  }
  
}