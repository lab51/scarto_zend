<?php
namespace Ogloszenia\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class DescriptionTable
{
  protected $tableGateway;
 
  public function __construct(TableGateway $tableGateway) {
    $this->tableGateway = $tableGateway;
  }
  
  public function saveDescription(Description $description){
		//save ad

    $data = array(
			'description_content' => $description->description_content,
			'description_ad_id' => $description->description_ad_id
     );
    
    $id = (int)$description->description_id;
      if($id==0){
        $this->tableGateway->insert($data);
        return true; 
      } /*else {
      if($this->getUser($id)){
        $this->tableGateway->update($data); 
      } else {
        throw new \Exception('nie ma takiego id');
      }
    }*/
  
	}
  
  
  public function getDescription($id){
    $id = (int)$id;
    $rowset = $this->tableGateway->select(array('description_ad_id' => $id));
   
    
    $row = $rowset->current();
    if(!$row){
      return false;
	  //throw new \Exception("nie można znaleźć wiersza $id");
    }
    return $row;
  }
  
  
	public function updateDescription($description){
    $data = array(
			'description_content' => $description->description_content,
			'description_ad_id' => $description->ad_id
     );
    
      if($this->getDescription($description->ad_id)){
          $this->tableGateway->update($data,array('description_ad_id' => $description->ad_id)); 
      } else {
        $this->tableGateway->insert($data);  
	    }
	    
	    return true;
    }
}