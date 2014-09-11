<?php
namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class AdMainTable
{
  protected $tableGateway;
 
  public function __construct(TableGateway $tableGateway) {
    $this->tableGateway = $tableGateway;
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
  
  
  public function getAd($id){
   $ad_id = (int) $id;
    $rowset = $this->tableGateway->select(
      function (Select $select) use ($id){
      //$select->columns(array());
      $select->where(array('ads.ad_id'=>$id));
      $select->join('models', 'models.model_id = ads.ad_model_id');
      $select->join('brands', 'brands.brand_id = models.model_brand_id');
      });
     
    return $rowset->current(); 
    
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
  
    }
  
 public function getAds($brand_id)
  {	
			$id = (int) $brand_id;
		  $rowset = $this->tableGateway->select(
	      function (Select $select) use ($id) {
	      //$select->join('models', "models.model_brand_id = $id");
	      $select->join('models', "models.model_id = ads.ad_model_id");
		  $select->where(array('models.model_brand_id' => $id));
		  $select->join('brands', "brands.brand_id = models.model_brand_id");
		  $select->join('ad_descriptions', "ad_descriptions.description_ad_id = ads.ad_id");
	      });  
	    return $rowset;
  }
 
public function getAdsByModel($model_id)
  {	
		  $id = (int) $model_id;
		  $rowset = $this->tableGateway->select(
	      function (Select $select) use ($id) {
	      //$select->join('models', "models.model_brand_id = $id");
	      $select->join('models', "models.model_id = ads.ad_model_id");
		  $select->join('brands', "brands.brand_id = models.model_brand_id");
		  $select->join('ad_descriptions', "ad_descriptions.description_ad_id = ads.ad_id");
		  $select->where(array('models.model_id' => $id));
	      });

			return $rowset;
		
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

  
  //pomocnicze
  
  private function getIDs(){
    $array_id = array();
    $all_ads = $this->fetchAll();
    foreach($all_ads as $ad){
      array_push($array_id, $ad->ad_id);
    }
    return $array_id;
  }
}