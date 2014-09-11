<?php
namespace Ogloszenia\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class ExtraTable
{
  protected $tableGateway;
 
  public function __construct(TableGateway $tableGateway) {
    $this->tableGateway = $tableGateway;
  }
  
  public function saveExtra(Extra $extra){
		//save ad

    $data = array(
			'extra_clima' => $extra->extra_clima,
			'extra_abs' => $extra->extra_abs,
			'extra_asr' => $extra->extra_asr,
			'extra_eds' => $extra->extra_eds,
			'extra_esp' => $extra->extra_esp,
			'extra_alufelgi' => $extra->extra_alufelgi,
			'extra_autoalarm' => $extra->extra_autoalarm,
			'extra_diff' => $extra->extra_diff,
			'extra_gearbox_block' => $extra->extra_gearbox_block,
			'extra_central_lock' => $extra->extra_central_lock,
			'extra_rain_ind' => $extra->extra_rain_ind,
			'extra_electric_mirrors' => $extra->extra_electric_mirrors,
			'extra_electric_windows' => $extra->extra_electric_windows,
			'extra_hook' => $extra->extra_hook,
			'extra_immobiliser' => $extra->extra_immobiliser,
			'extra_gas_instalation' => $extra->extra_gas_instalation,
			'extra_xenons' => $extra->extra_xenons,
			'extra_heat_seats' => $extra->extra_heat_seats,
			'extra_radio' => $extra->extra_radio,
			'extra_leather_seats' => $extra->extra_leather_seats,
			'extra_gps_nav' => $extra->extra_gps_nav,
			'extra_fog_lights' => $extra->extra_fog_lights,
			'extra_tempomat' => $extra->extra_tempomat,
			'extra_wheel_helper' => $extra->extra_wheel_helper,
			'extra_4x4' => $extra->extra_4x4,
			'extra_ad_id' => $extra->extra_ad_id,
     );
    
    $id = (int)$extra->extra_id;
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
  
  
  public function getExtra($id){
    $id = (int)$id;
    $rowset = $this->tableGateway->select(array('extra_ad_id' => $id));
   
    
    $row = $rowset->current();
    if(!$row){
      throw new \Exception("nie można znaleźć wiersza $id");
    }
    return $row;
  }
  
  
	public function updateExtra($extra){
    $data = array(
			'extra_clima' => $extra->extra_clima,
			'extra_abs' => $extra->extra_abs,
			'extra_asr' => $extra->extra_asr,
			'extra_eds' => $extra->extra_eds,
			'extra_esp' => $extra->extra_esp,
			'extra_alufelgi' => $extra->extra_alufelgi,
			'extra_autoalarm' => $extra->extra_autoalarm,
			'extra_diff' => $extra->extra_diff,
			'extra_gearbox_block' => $extra->extra_gearbox_block,
			'extra_central_lock' => $extra->extra_central_lock,
			'extra_rain_ind' => $extra->extra_rain_ind,
			'extra_electric_mirrors' => $extra->extra_electric_mirrors,
			'extra_electric_windows' => $extra->extra_electric_windows,
			'extra_hook' => $extra->extra_hook,
			'extra_immobiliser' => $extra->extra_immobiliser,
			'extra_gas_instalation' => $extra->extra_gas_instalation,
			'extra_xenons' => $extra->extra_xenons,
			'extra_heat_seats' => $extra->extra_heat_seats,
			'extra_radio' => $extra->extra_radio,
			'extra_leather_seats' => $extra->extra_leather_seats,
			'extra_gps_nav' => $extra->extra_gps_nav,
			'extra_fog_lights' => $extra->extra_fog_lights,
			'extra_tempomat' => $extra->extra_tempomat,
			'extra_wheel_helper' => $extra->extra_wheel_helper,
			'extra_4x4' => $extra->extra_4x4,
		  );
    
      if($this->getExtra($extra->ad_id)){
          $this->tableGateway->update($data,array('extra_ad_id' => $extra->ad_id)); 
      } else {
        $this->tableGateway->insert($data);  
	    }
	    
	    return true;
    }
  
}