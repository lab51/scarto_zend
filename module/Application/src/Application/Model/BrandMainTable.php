<?php
namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;


class BrandMainTable
{
  protected $tableGateway;
 
  public function __construct(TableGateway $tableGateway) {
    $this->tableGateway = $tableGateway;
  }
  
  public function fetchAll()
  {
	$resultSet = $this->tableGateway->select(function (Select $select) {
        $select->order('brand_name ASC'); 
    });

	return $resultSet;
  }

	public function getBrandId($brand){
		$rowset = $this->tableGateway->select(array('brand_name' => $brand));
    $row = $rowset->current();
    if(!$row){
      //throw new \Exception("nie mozna znalezc wiersza $id");
      return false;
    }
    return $row;
	}
  
}