<?php
namespace Ogloszenia\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;

class BrandTable
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

	public function getBrandId($brand){
	$rowset = $this->tableGateway->select(array('brand_name' => $brand));
    $row = $rowset->current();
    if(!$row){
      throw new \Exception("nie mozna znalezc wiersza $id");
    }
    return $row;
	}

	public function getBrandNameById($id){
	$rowset = $this->tableGateway->select(array('brand_id' => $id));
    $row = $rowset->current();
    if(!$row){
      throw new \Exception("nie mozna znalezc wiersza $id");
    }
    return $row;
	}
	
	public function getSuggestions(){
  $resultSet = $this->tableGateway->select();
    return $resultSet;
  
/*	$adapter = $this->tableGateway->getAdapter();
     $sql = "select * from brands";
	 $statement = $adapter->query($sql); 
	return $statement->execute(); 
*/	
	}
	
}