<?php
namespace Ogloszenia\Model;

class Extra
{
	public $extra_id;
	public $extra_clima;
	public $extra_abs;
	public $extra_asr;
	public $extra_eds;
	public $extra_esp;
	public $extra_alufelgi;
	public $extra_autoalarm;
	public $extra_diff;
	public $extra_gearbox_block;
	public $extra_central_lock;
	public $extra_rain_ind;
	public $extra_electric_mirrors;
	public $extra_electric_windows;  
	public $extra_hook;
	public $extra_immobiliser;
	public $extra_gas_instalation;
	public $extra_xenons;
	public $extra_heat_seats;
	public $extra_radio;
	public $extra_leather_seats;
	public $extra_gps_nav;
	public $extra_fog_lights;
	public $extra_tempomat;
	public $extra_wheel_helper;
	public $extra_4x4;
	public $extra_ad_id;


  function exchangeArray($data){
		$this->extra_id = (isset($data['extra_id'])) ? $data['extra_id'] : null;      
		$this->extra_clima = (isset($data['extra_clima'])) ? $data['extra_clima'] : null;      
		$this->extra_abs = (isset($data['extra_abs'])) ? $data['extra_abs'] : null;      
		$this->extra_asr = (isset($data['extra_asr'])) ? $data['extra_asr'] : null;      
		$this->extra_eds = (isset($data['extra_eds'])) ? $data['extra_eds'] : null;      
		$this->extra_esp = (isset($data['extra_esp'])) ? $data['extra_esp'] : null;      
		$this->extra_alufelgi = (isset($data['extra_alufelgi'])) ? $data['extra_alufelgi'] : null;      
		$this->extra_autoalarm = (isset($data['extra_autoalarm'])) ? $data['extra_autoalarm'] : null; 
		$this->extra_diff = (isset($data['extra_diff'])) ? $data['extra_diff'] : null;      
		$this->extra_gearbox_block = (isset($data['extra_gearbox_block'])) ? $data['extra_gearbox_block'] : null;      
		$this->extra_central_lock = (isset($data['extra_central_lock'])) ? $data['extra_central_lock'] : null;      
		$this->extra_rain_ind = (isset($data['extra_rain_ind'])) ? $data['extra_rain_ind'] : null;      
		$this->extra_electric_mirrors = (isset($data['extra_electric_mirrors'])) ? $data['extra_electric_mirrors'] : null;      
		$this->extra_electric_windows = (isset($data['extra_electric_windows'])) ? $data['extra_electric_windows'] : null;      
		$this->extra_hook = (isset($data['extra_hook'])) ? $data['extra_hook'] : null;       
		$this->extra_immobiliser = (isset($data['extra_immobiliser'])) ? $data['extra_immobiliser'] : null;         
		$this->extra_gas_instalation = (isset($data['extra_gas_instalation'])) ? $data['extra_gas_instalation'] : null;         
		$this->extra_xenons = (isset($data['extra_xenons'])) ? $data['extra_xenons'] : null;         
		$this->extra_heat_seats = (isset($data['extra_heat_seats'])) ? $data['extra_heat_seats'] : null;         
		$this->extra_radio = (isset($data['extra_radio'])) ? $data['extra_radio'] : null;         
		$this->extra_leather_seats = (isset($data['extra_leather_seats'])) ? $data['extra_leather_seats'] : null;         
		$this->extra_gps_nav = (isset($data['extra_gps_nav'])) ? $data['extra_gps_nav'] : null;         
		$this->extra_fog_lights = (isset($data['extra_fog_lights'])) ? $data['extra_fog_lights'] : null;         
		$this->extra_tempomat = (isset($data['extra_tempomat'])) ? $data['extra_tempomat'] : null;      
		$this->extra_wheel_helper = (isset($data['extra_wheel_helper'])) ? $data['extra_wheel_helper'] : null;      
		$this->extra_4x4 = (isset($data['extra_4x4'])) ? $data['extra_4x4'] : null;      
		$this->extra_ad_id = (isset($data['extra_ad_id'])) ? $data['extra_ad_id'] : null;      

  }
  

  //potrzebne zeby dzia?a? hydrator
  public function getArrayCopy()
  {
      return get_object_vars($this);
  }
  
}