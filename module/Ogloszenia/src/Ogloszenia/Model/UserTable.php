<?php
namespace Ogloszenia\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class UserTable
{
  protected $tableGateway;
  
  public function __construct(TableGateway $tableGateway) {
    $this->tableGateway = $tableGateway;
  }
  
  
  public function fetchAll()
  {
    $resultSet = $this->tableGateway->select();
    return $resultSet;
  }
  
  public function getUser($id){
    $id = (int)$id;
    $rowset = $this->tableGateway->select(array('user_id' => $id));
    $row = $rowset->current();
    if(!$row){
      throw new \Exception("nie można znaleźć wiersza $id");
    }
    return $row;
  }
  
  public function getUserByEmail($userEmail)
  {
    $rowset = $this->tableGateway->select(array('user_email' => $userEmail));
    $row = $rowset->current();
    if(!$row){
      throw new \Exception("nie można znaleźć adreesu $userEmail");
    }
    return $row;
  }
  
  
  public function addSaveUser(User $user){
    $pass =  $this->randomPassword();
	
	$data = array(
     'user_email' => $user->user_email,
     'user_name'  => $user->user_name,
	 'user_password'  => md5($pass),
     );
    
    $id = (int)$user->user_id;
      if($id==0){
        $this->tableGateway->insert($data);
		//WYSYLKA MAILA
		$message = "Witaj. Konto w scarto.pl zostalo zalozone. Login to ten adres email, haslo to ".$pass.".\r\nPozdrawiamy";
		mail($user->user_email, 'nowe konto w scarto.pl', $message);
        return $user_id = $this->tableGateway->lastInsertValue; 
      }  {
        throw new \Exception('nie ma takiego id');
		}
	}
	
	private function randomPassword(){
		
		$a_z = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
      
		$password_array = array();
		$top = rand(8,12);
		
		for($i=1;$i<$top;$i++){
			$int = rand(0,61);
			$rand_char = $a_z[$int];
			array_push($password_array, $rand_char);        
		} 
      
		$password = implode('', $password_array);
      
	return $password;

	}
  

  
}