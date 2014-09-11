<?php
namespace Application\Model;

class Ad
{
  public $ad_id;
  public $ad_user_id;
  public $ad_model_id;
  public $ad_title;
  public $ad_production_year;
  public $ad_km;
  public $ad_engine_power;
  public $ad_engine_size;
  public $ad_gearbox;
  public $ad_fuel;
  public $ad_exterior_type;
  public $ad_doors_nr;
  public $ad_car_color;
  public $ad_created;
  public $ad_expires;
  public $ad_price;
  public $ad_first_name;
  public $ad_phone_nr;
  public $ad_mail;
  public $ad_contact_desc;
  public $ad_condition;
  public $ad_main_img;
  public $ad_activated;
  public $model_name;
  public $brand_name;
  public $brand_url;
  public $model_url;
	public $description_content;
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
	public $extra_park_asist;
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
	
//  public $password;

  function exchangeArray($data){
    $this->ad_id = (isset($data['ad_id'])) ? $data['ad_id'] : null;  
    $this->ad_user_id = (isset($data['ad_user_id'])) ? $data['ad_user_id'] : null;  
    $this->ad_model_id = (isset($data['ad_model_id'])) ? $data['ad_model_id'] : null;  
    $this->ad_title = (isset($data['ad_title'])) ? $data['ad_title'] : null;  
    $this->ad_production_year = (isset($data['ad_production_year'])) ? $data['ad_production_year'] : null;  
    $this->ad_km = (isset($data['ad_km'])) ? $data['ad_km'] : null;  
    $this->ad_engine_power = (isset($data['ad_engine_power'])) ? $data['ad_engine_power'] : null;  
    $this->ad_engine_size = (isset($data['ad_engine_size'])) ? $data['ad_engine_size'] : null;  
    $this->ad_gearbox = (isset($data['ad_gearbox'])) ? $data['ad_gearbox'] : null;  
    $this->ad_fuel = (isset($data['ad_fuel'])) ? $data['ad_fuel'] : null;  
    $this->ad_exterior_type = (isset($data['ad_exterior_type'])) ? $data['ad_exterior_type'] : null;  
    $this->ad_doors_nr = (isset($data['ad_doors_nr'])) ? $data['ad_doors_nr'] : null;  
    $this->ad_car_color = (isset($data['ad_car_color'])) ? $data['ad_car_color'] : null;  
    $this->ad_created = (isset($data['ad_created'])) ? $data['ad_created'] : null;  
    $this->ad_expires = (isset($data['ad_expires'])) ? $data['ad_expires'] : null;  
    $this->ad_price = (isset($data['ad_price'])) ? $data['ad_price'] : null;  
    $this->ad_first_name = (isset($data['ad_first_name'])) ? $data['ad_first_name'] : null;  
    $this->ad_phone_nr = (isset($data['ad_phone_nr'])) ? $data['ad_phone_nr'] : null;  
    $this->ad_mail = (isset($data['ad_mail'])) ? $data['ad_mail'] : null;  
    $this->ad_contact_desc = (isset($data['ad_contact_desc'])) ? $data['ad_contact_desc'] : null;  
    $this->ad_condition = (isset($data['ad_condition'])) ? $data['ad_condition'] : null;  
    $this->ad_main_img = (isset($data['ad_main_img'])) ? $data['ad_main_img'] : null;  
    $this->ad_activated = (isset($data['ad_activated'])) ? $data['ad_activated'] : null;    
    $this->model_name = (isset($data['model_name'])) ? $data['model_name'] : null;      
    $this->brand_name = (isset($data['brand_name'])) ? $data['brand_name'] : null;      
    $this->model_url = (isset($data['model_url'])) ? $data['model_url'] : null;      
    $this->brand_url = (isset($data['brand_url'])) ? $data['brand_url'] : null;      
    $this->description_content = (isset($data['description_content'])) ? $data['description_content'] : null;      
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
		$this->extra_park_asist = (isset($data['extra_park_asist'])) ? $data['extra_park_asist'] : null;      
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

  }
  
public function setData($data) {
		if (!empty($data) && isset($data['name']) && $data['name'] && isset($data['surname']) && $data['surname'] && isset($data['pseudonym']) && $data['pseudonym']) {
			$this->data = $data;
			return $this;
		} else {
			throw new Exception('Invalid data');
		}
	}

  //potrzebne zeby dzia�a� hydrator
  public function getArrayCopy()
  {
      return get_object_vars($this);
  }
  
}