<?php
namespace Ogloszenia\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class ImageTable
{
  protected $tableGateway;
  
  public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
  
  public function saveUpload(Image $image){
    $data = array(
    'image_2' => (isset($image->image_2) && !empty($image->image_2)) ? $image->image_2 : null,
    'image_3' => (isset($image->image_3) && !empty($image->image_3)) ? $image->image_3 : null,
    'image_4' => (isset($image->image_4) && !empty($image->image_4)) ? $image->image_4 : null,
   	'image_5' => $image->image_5,
	'image_6' => $image->image_6,
	'image_7' => $image->image_7,
	'image_8' => $image->image_8,
	'image_9' => $image->image_9,
	'image_ad_id' => $image->image_ad_id,
     );
    
      if($old_images = $this->getImages($image->image_ad_id)){
	      
	      $data1 = array(
    'image_2' => (isset($image->image_2) && !empty($image->image_2)) ? $image->image_2 : $old_images->image_2,
    'image_3' => (isset($image->image_3) && !empty($image->image_3)) ? $image->image_3 : $old_images->image_3,
    'image_4' => (isset($image->image_4) && !empty($image->image_4)) ? $image->image_4 : $old_images->image_4,
    'image_5' => (isset($image->image_5) && !empty($image->image_5)) ? $image->image_5 : $old_images->image_5,
    'image_6' => (isset($image->image_6) && !empty($image->image_6)) ? $image->image_6 : $old_images->image_6,
    'image_7' => (isset($image->image_7) && !empty($image->image_7)) ? $image->image_7 : $old_images->image_7,
    'image_8' => (isset($image->image_8) && !empty($image->image_8)) ? $image->image_8 : $old_images->image_8,
    'image_9' => (isset($image->image_9) && !empty($image->image_9)) ? $image->image_9 : $old_images->image_9,
    'image_ad_id' => $image->image_ad_id,
     );
      $this->tableGateway->update($data1,array('image_ad_id' => $image->image_ad_id));
         	 
      } else {
        $this->tableGateway->insert($data);  
	    }
	
  }
  
  
  public function deleteImage($column, $id)
  {
	  $data = array(
    	$column => NULL,
    );
    
    $this->tableGateway->update($data,array('image_ad_id' => $id));
  }
  
  public function getImages($id){
    $id = (int)$id;
    $rowset = $this->tableGateway->select(array('image_ad_id' => $id));
    
    $row = $rowset->current();
    if(!$row){
      //throw new \Exception("nie można znaleźć wiersza $id");
	  return false;
    }
    return $row;
  }

  
  public function getAdImages($id){

    $resultSet = $this->tableGateway->select(array('image_ad_id' => $id));
    return $resultSet;
   
  }

}