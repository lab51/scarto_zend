<?php
namespace Ogloszenia\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class ModelTable
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

  public function getModelsForBrand($brand_id)
  {
    $resultSet = $this->tableGateway->select(array('model_brand_id' => $brand_id));
    return $resultSet;
  }

	public function getModelId($model_name, $brand_id){
		$rowset = $this->tableGateway->select(array('model_name' => $model_name, 'model_brand_id' => $brand_id));
    $row = $rowset->current();
    if(!$row){
      throw new \Exception("nie mozna znalezc wiersza $id");
    }
    return $row;
	}
	
	
	public function getModelNameById($id){
	$rowset = $this->tableGateway->select(array('model_id' => $id));
    $row = $rowset->current();
    if(!$row){
      throw new \Exception("nie mozna znalezc wiersza $id");
    }
    return $row;
	}
	
}