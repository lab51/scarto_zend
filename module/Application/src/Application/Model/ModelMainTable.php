<?php
namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class ModelMainTable
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

	public function getModelId($model_name, $brand_id){
	$rowset = $this->tableGateway->select(array('model_name' => $model_name, 'model_brand_id' => $brand_id));
    $row = $rowset->current();
    if(!$row){
      return false;
      //throw new \Exception("nie mozna znalezc wiersza $id");
    }
    return $row;
	}
	
	public function getModelsForBrand($brand_id){

	//$resultSet = $this->tableGateway->select(array('model_brand_id' => $brand_id));

	$resultSet = $this->tableGateway->select(function (Select $select) use ($brand_id){
	$select->where(array('model_brand_id' => $brand_id));	
	$select->order('model_name ASC');
    });

	return $resultSet;
	}

	public function getSeriesForBrand($brand_id){
    $id = (int) $brand_id;
	//$resultSet = $this->tableGateway->select(array('model_brand_id' => $brand_id));

	$resultSet = $this->tableGateway->select(function (Select $select) use ($id) {
	$select->columns(array('model_series_name'));
	$select->where(array('model_brand_id' => $id));	
	$select->quantifier('DISTINCT');
	$select->order('model_series_name ASC');
    });
	
	return $resultSet;
	}	
}