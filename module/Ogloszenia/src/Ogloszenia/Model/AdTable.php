<?php
namespace Ogloszenia\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class AdTable
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
  
  public function getAdsByUser($user_id)
  {
    $resultSet = $this->tableGateway->select(array('ad_user_id' => $user_id));
    return $resultSet;
  }
  
  public function getSingleAd($id){
			$ad_id = (int) $id;
		  $rowset = $this->tableGateway->select(
	      function (Select $select) use ($ad_id) {
				$select->where(array('ads.ad_id' => $ad_id));
				$select->join('ad_descriptions', "ad_descriptions.description_ad_id = ads.ad_id");
				$select->join('ad_extras', "ad_extras.extra_ad_id = ads.ad_id");
				$select->join('models', "models.model_id = ads.ad_model_id");	
				$select->join('brands', "brands.brand_id = models.model_brand_id");
				
				});    
	    return $rowset->current();
  }
  
  public function saveAd(Ad $ad){
		//save ad

    $data = array(
			'ad_id' => $ad->ad_id,
			'ad_user_id' => $ad->ad_user_id,
			'ad_model_id' => $ad->ad_model_id,
			'ad_title' => $ad->ad_title,
			'ad_production_year' => $ad->ad_production_year,
			'ad_km' => $ad->ad_km,
			'ad_engine_power' => $ad->ad_engine_power,
			'ad_engine_size' => $ad->ad_engine_size,
			'ad_gearbox' => $ad->ad_gearbox,
			'ad_fuel' => $ad->ad_fuel,
			'ad_exterior_type' => $ad->ad_exterior_type,
			'ad_doors_nr' => $ad->ad_doors_nr,
			'ad_car_color' => $ad->ad_car_color,
			'ad_created' => $ad->ad_created,
			'ad_expires' => $ad->ad_expires,
			'ad_price' => $ad->ad_price,
			'ad_first_name' => $ad->ad_first_name,
			'ad_phone_nr' => $ad->ad_phone_nr,
			'ad_mail' => $ad->ad_mail,
			'ad_condition' => $ad->ad_condition,
			'ad_main_img' => $ad->ad_main_img,
	   );
    
    $id = (int)$ad->ad_id;
      if($id==0){
        $this->tableGateway->insert($data);
        return $ad_id = $this->tableGateway->lastInsertValue; 
      } /*else {
      if($this->getUser($id)){
        $this->tableGateway->update($data); 
      } else {
        throw new \Exception('nie ma takiego id');
      }
    }*/
  
	}


  
  public function getAd($id){
    $id = (int)$id;
    $rowset = $this->tableGateway->select(array('ad_id' => $id));
   
    
    $row = $rowset->current();
    if(!$row){
    return false;
	//throw new \Exception("nie można znaleźć wiersza $id");
    }
    return $row;
  }
	
	public function updateAd($ad){
    $data = array(
			'ad_id' => $ad->ad_id,
			'ad_user_id' => $ad->ad_user_id,
			'ad_model_id' => $ad->ad_model_id,
			'ad_title' => $ad->ad_title,
			'ad_production_year' => $ad->ad_production_year,
			'ad_km' => $ad->ad_km,
			'ad_engine_power' => $ad->ad_engine_power,
			'ad_engine_size' => $ad->ad_engine_size,
			'ad_gearbox' => $ad->ad_gearbox,
			'ad_fuel' => $ad->ad_fuel,
			'ad_exterior_type' => $ad->ad_exterior_type,
			'ad_doors_nr' => $ad->ad_doors_nr,
			'ad_car_color' => $ad->ad_car_color,
			'ad_price' => $ad->ad_price,
			'ad_first_name' => $ad->ad_first_name,
			'ad_phone_nr' => $ad->ad_phone_nr,
			'ad_condition' => $ad->ad_condition,
	   );
    
      if($this->getAd($ad->ad_id)){
          $this->tableGateway->update($data,array('ad_id' => $ad->ad_id)); 
      } else {
        throw new \Exception('nie ma takiego id');
      }
    }
	
	public function updateAdMainImage(Ad $ad, $id){
		  if(!empty($ad->ad_main_img)){
		  $data = array(
				'ad_main_img' => $ad->ad_main_img,
			);
			
			$this->tableGateway->update($data, array('ad_id' => $id));
		}
	}
  
  
  public function deleteMainImage($id)
  {
	  $data = array(
    	'ad_main_img' => NULL,
    );
    
    $this->tableGateway->update($data,array('ad_id' => $id));
  }
 
 
  public function deleteAd($id)
  {
//  $this->tableGateway->delete(array('ad_id' => $id));
	
  
	$id = (int)$id;
    $rowset = $this->tableGateway->select(array('ad_id' => $id));
   
    
    $row = $rowset->current();
    if($row){
    $this->tableGateway->delete(array('ad_id' => $id));
	}elseif(!$row){
      throw new \Exception("nie można znaleźć wiersza $id");
    }
    }
  
  //pomocnicze
  /*
  private function getIDs(){
    $array_id = array();
    $all_ads = $this->fetchAll();
    foreach($all_ads as $ad){
      array_push($array_id, $ad->ad_id);
    }
    return $array_id;
  }
  
    public function getRandom($nr){
    //first, we want to get random ads from IDs array
    //can't use rand on obnject so we will make array
    $ids = $this->getIDs(); //return array with all ids
    $ads_id = array_rand($ids, $nr); //return indexes in $ids, not value!
    
    if($nr==1){
      $random_ads = $this->getAd($ids[$ads_id]);
    } else {
      $random_ads = array();
      foreach($ads_id as $ad){ //$ad is an index in $ids, not an id value
        array_push($random_ads, $this->getAd($ids[$ad])); 
      }
    }
    return $random_ads;
  }
  
     public function fetchAll()
  {
    //$resultSet = $this->tableGateway->select();
    //return $resultSet;
  
    $rowset = $this->tableGateway->select(
      function (Select $select) {
      //$select->columns(array());
      //$select->where(array('ads.ad_id'=>$id));
      $select->join('models', 'models.model_id = ads.ad_model_id');
      $select->join('brands', 'brands.brand_id = models.model_brand_id');
      });
     
    return $rowset; 
  
    }*/ 
}