<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Ogloszenia\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Storage\ArrayStorage;
use Zend\Session\SessionManager;
use Zend\View\Model\ViewModel;
use Zend\Http\Request;
use Zend\Filter\File\RenameUpload;
use Zend\Session\Container;
use Zend\Authentication\AuthenticationService;
use Ogloszenia\Form\AddForm;
use Ogloszenia\Model\Image;
use Ogloszenia\Model\ImageTable;
use Ogloszenia\Model\Ad;
use Ogloszenia\Model\AdTable;
use Ogloszenia\Model\Description;
use Ogloszenia\Model\DescriptionTable;
use Ogloszenia\Model\Extra;
use Ogloszenia\Model\ExtraTable;
use Ogloszenia\Model\User;
use Ogloszenia\Model\UserTable;

class OgloszeniaController extends AbstractActionController
{
    public function indexAction()
    {
        return array();
    }

	
    public function dodajAction()
    {	
		$model = '';
		$container = new Container('my_session');
			
		//create form
		$form = new AddForm();
    
        $brand_table = $this->getServiceLocator()->get('BrandTable');
		
		//$view_model = new ViewModel();
		
		$layout = $this->layout();
		$layout->setTemplate('layout/layout_single_ad.phtml');


		if(!empty($container->user_email)){
			$viewModel = new ViewModel(array('brands' => $brand_table->fetchAll(), 'form' => $form, 'user_email' => $container->user_email, 'model' => $model));
		} else {
			$viewModel = new ViewModel(array('brands' => $brand_table->fetchAll(), 'form' => $form, 'model' => $model));
		}
		
		return $viewModel;
	}
	
   public function edytujAction(){
		$adTable = $this->getServiceLocator()->get('AdTable');
		$ad = $adTable->getAd($this->params()->fromRoute('id'));
		
		$modelTable = $this->getServiceLocator()->get('ModelTable');
		$model = $modelTable->getModelNameById($ad->ad_model_id);

		$brandTable = $this->getServiceLocator()->get('BrandTable');	
		$brand = $brandTable->getBrandNameById($model->model_brand_id);

		

		$descriptionTable = $this->getServiceLocator()->get('descriptionTable');
		$description = $descriptionTable->getDescription($ad->ad_id);
		
		$extraTable = $this->getServiceLocator()->get('extraTable');
		$extra = $extraTable->getExtra($ad->ad_id);
		
		$imageTable = $this->getServiceLocator()->get('imageTable');
		$image = $imageTable->getImages($ad->ad_id);

	  
      $form = $this->getServiceLocator()->get('EdytujForm');
      $form->bind($brand);
	  $form->bind($model);
	 $form->bind($ad);
	
	  if(!empty($description)){
		$form->bind($description);
	  }
	  
	  if(!empty($extra)){
		$form->bind($extra);
	  }
	  
	  if(!empty($image)){
		$form->bind($image);
	  }
	  
      $viewModel = new ViewModel(array(
         'form' => $form,
		 'model_id' => $model->model_id,
		 'model_name' => $model->model_name,
		 'image' => $image,
         //'id' => $this->params()->fromRoute('id')
      ));
      return $viewModel;
//      return false;
  }
 
    
  public function processFilesAction($image_ad_id){
    
	$request = $this->getRequest(); 
    
    if ($request->isPost()) {
		
    //if there is a post, then lets roll
    //create array for exchange data - will be used later to save data to DB
    $exchange_data = array();
		  
    // Fetch Configuration from Module Config
    //fo now we want to get location for temp folder (files uploaded before resize)
	$targetPath = 'images/tmp_data/';
	
   
    //there are 9 images from form - lets put them in an array
    $images_form = array('ad_main_img', 'image_2', 'image_3', 'image_4', 'image_5', 'image_6', 'image_7', 'image_8', 'image_9');
    
    //foreach image copy image, rename and resize
    foreach($images_form as $img){
      
      
      //if there is an image, then go on
      if(!empty($_FILES[$img]['name'])){
		$time = time(); // to randomize file name
     	$random_name = $time.$_FILES[$img]['name'];
		$targetFileName = $targetPath . $random_name;
        
        //a) copy file, if success then go on
        if(move_uploaded_file($_FILES[$img]['tmp_name'], $targetFileName)){
         
          // b) add data to exchange_data array (later this will be saved to DB)
          // ex. $exchange_data['image_2'] = $copied_image['name']
          $exchange_data[$img] = $random_name;
          
          // c) resize and copy to final destination folder
 
          //first get extenstion of file
          $new_img_ext = strtolower(pathinfo($targetFileName, PATHINFO_EXTENSION)); 
          // d) resize :)

		  $this->resizeAction($new_img_ext, $targetFileName, $random_name);
        }
      }
    }
    
    //when there is data in an array, then save it to the DB
    if (!empty($exchange_data)) {
        	$image = new Image();
            $exchange_data['image_ad_id'] = $image_ad_id;
            $image->exchangeArray($exchange_data);
            $imageTable = $this->getServiceLocator()->get('ImageTable');
            $imageTable->saveUpload($image);
            
			$ad = new Ad();
			$ad->exchangeArray($exchange_data);
            $adTable = $this->getServiceLocator()->get('AdTable');
            $adTable->updateAdMainImage($ad, $image_ad_id);
            
        }
    }
	return true;
	
  }

  public function resizeAction($new_img_ext, $new_file, $new_img_name){
   //based on extension we need to use different 'imagecreatefrom'
                switch ($new_img_ext) {
                       case "jpg":
                       case "jpeg":
                       $source_image = imagecreatefromjpeg($new_file);
                       break;
                       case "png":
                       $source_image = imagecreatefrompng($new_file);
                       break;
                       case "gif":
                       $source_image = imagecreatefromgif($new_file);
                       break;
                }
                
                //RATIO SIZE
                //first, we take original file size
                $source_imagex = imagesx($source_image);
                $source_imagey = imagesy($source_image);
                //count ratio (x/y)
                $ratio_original = $source_imagex/$source_imagey;
                
                //new x val is always the same: 680px                
                $dest_imagex = 680;
                //based on ratio and x we count y val, y val is rounded
                $dest_imagey = round($dest_imagex/$ratio_original);
                
                //create destination image
                $dest_image = imagecreatetruecolor($dest_imagex, $dest_imagey);
                imagecopyresampled($dest_image, $source_image, 0, 0, 0, 0, $dest_imagex,
                $dest_imagey, $source_imagex, $source_imagey);
                //header("Content-Type: image/jpeg");
                
                //$path is a destination folder
				$path = 'images/data/';
                $destination_to_save = $path.$new_img_name;
               
                //based on extension we need to use different 'imageXXX'
                switch ($new_img_ext) {
                       case "jpg":
                       imagejpeg($dest_image,$destination_to_save,80);    
          	           break;
                       case "jpeg":
                       imagejpeg($dest_image,$destination_to_save,80);    
          	           break;
                       case "png":
                       imagepng($dest_image,$destination_to_save,4);    
          	           break;
                       case "gif":
                       imagegif($dest_image,$destination_to_save);    
          	           break;
                }
                
                
                //return the new image - we want to put it into DB
                return $new_img_name;        
             
  }
  
	
  public function processAction(){
    if(!$this->request->isPost()){
      return $this->redirect()->toRoute(NULL, 
        array('controller' => 'ogloszenia',
            'action' => 'dodaj'
        ));
    }
    
    $post = $this->request->getPost();
    $form=$this->getServiceLocator()->get('AddForm');
    $form->setData($post);
    
    if(!$form->isValid()){
		$layout = $this->layout();
		$layout->setTemplate('layout/layout_single_ad.phtml');
		
		if(!empty($post->ad_model_id)){
			$modelTable=$this->getServiceLocator()->get('ModelTable');
			$model_name = $modelTable->getModelNameById($post->ad_model_id);
		
		$model = new ViewModel(array(
				'error' => true,
				'form' => $form,
				'model_id' => $post->ad_model_id,
				'model_name' => $model_name->model_name,
		));
		} elseif(empty($post->ad_model_id)){
			$model = new ViewModel(array(
				'error' => true,
				'form' => $form,
				));        
		}
		$model->setTemplate('ogloszenia/ogloszenia/dodaj.phtml');
		return $model;
    }
	
	$this->createAd($form->getData());
    return $this->redirect()->toRoute(NULL, array(
      'controller' => 'ogloszenia',
      'action' => 'dodaj'  
    ));
	//return false;
  }

    public function createAd(array $data){
    
	//COUNT DATES
	// count expiration date 
    $time_now = date('Y-m-d H:i:s', $timestamp=time());
    $nr_of_days = 30;
    $expires_at = mktime(0, 0, 0, date("m"), date("d")+$nr_of_days, date("Y")); 
    $expiration_date = date('Y-m-d H:i:s', $timestamp=$expires_at);
      
	
	//add created and expires to the data array
	$data['ad_created'] = $time_now;
	$data['ad_expires'] = $expiration_date;
	
	//if user was logged in, then get user id and insert this into data
	$container = new Container('my_session');
            
	if(!empty($container->user_email)){
		$userTable = $this->getServiceLocator()->get('UserTable');
		$user_data = $userTable->getUserByEmail($container->user_email);
		$data['ad_user_id'] = $user_data->user_id;
		//first name bym jednak dal w fimrzuklarz
	} elseif(empty($container->user_email)){
		//print_r($data);
		$data_user = array();
		$data_user['user_email'] = $data['ad_mail'];
			if(!empty($data['ad_first_name'])){
				$data_user['user_name'] = $data['ad_first_name'];
			}
		//print_r($data_user);
		$new_user_id = $this->createUser($data_user);
		$data['ad_user_id'] = $new_user_id;		
	}
	
	$ad = new Ad();
    $ad->exchangeArray($data);
	
	$adTable = $this->getServiceLocator()->get('AdTable');
    $ad_id = $adTable->saveAd($ad);
    
	if(!empty($_POST['description_content'])){
		$description = new Description();
		$data['description_ad_id'] = $ad_id; //add ad_id to the description object
		
		$description->exchangeArray($data);
		$descriptionTable = $this->getServiceLocator()->get('descriptionTable');
		$descriptionTable->saveDescription($description);
	}
	
    $extra = new Extra();
    $data['extra_ad_id'] = $ad_id; //add ad_id to the description object
	$extra->exchangeArray($data);
    $extraTable = $this->getServiceLocator()->get('ExtraTable');
    $extraTable->saveExtra($extra);
    
	//ej sprawdzenie czy są obrazki!
	$this->processFilesAction($ad_id); //this will copy images and update data in DB tables
	
    return true;
    }  
	
  public function createUser(array $data){
        
    $user = new User();
    $user->exchangeArray($data);
    $userTable = $this->getServiceLocator()->get('AdUserTable');
    $user_id = $userTable->addSaveUser($user);
    
    return $user_id;
    }
	
	public function getModelsAction(){
		
    
    //used by getmodels-homepage.js

		
		//get brand and model tables
		$brand_table = $this->getServiceLocator()->get('BrandTable');
		$model_table = $this->getServiceLocator()->get('ModelTable');
		
		//get selected brand name from form
		$brand_name = $_POST['selectedbrand'];
		
		//get brand id
		$brand = $brand_table->getBrandId($brand_name);
		
    
		$models = $model_table->getModelsForBrand($brand->brand_id);
		
		foreach($models as $model){
			echo "<option value='".$model->model_id."'>".$model->model_name."</option>";
		}
		
		return false;
	}

		public function getModelsByBrandAction(){
		    
		//used by getmodels2.js
		
		//get brand and model tables
		//$brand_table = $this->getServiceLocator()->get('BrandTable');
		//$model_table = $this->getServiceLocator()->get('ModelTable');
		
		//get selected brand name from form
		echo $brand_name = $_POST['selectedbrand'];
		
		//get brand id
		/*$brand = $brand_table->getBrandId($brand_name);
		
    
		$models = $model_table->getModelsForBrand($brand->brand_id);
		
		foreach($models as $model){
			echo "<option value='".$model->model_id."'>".$model->model_name."</option>";
		}
		*/
		return false;
	}

	public function getFileUploadLocation()
	{
		// Fetch Configuration from Module Config
		$config = $this->getServiceLocator()->get('config');
		return $config['module_config']['upload_location'];
	}	
  
	public function getTmpFileUploadLocation()
	{
		// Fetch Configuration from Module Config
		$config = $this->getServiceLocator()->get('config');
		return $config['tmp_module_config']['tmp_upload_location'];
	}

 public function kopiujAction(){
    echo __DIR__;
	$request = $this->getRequest(); 
    
    if ($request->isPost()) {
		
    	  
    $targetPath = 'C:\www/scarto/public/images/tmp_data/';
	
   
    //there are 9 images from form - lets put them in an array
    $images_form = array('ad_main_img', 'image_2', 'image_3', 'image_4', 'image_5', 'image_6', 'image_7', 'image_8', 'image_9');
    
    //foreach image copy image, rename and resize
    foreach($images_form as $img){
      
      
      //if there is an image, then go on
      if(!empty($_FILES[$img]['name'])){
		//$time = time(); // to randomize file name
     	//$random_name = $time.$_FILES[$img]['name'];
		$name = $_FILES[$img]['name'];
		
		$targetFileName = $targetPath . $name;
        
        //a) copy file, if success then go on
        move_uploaded_file($_FILES[$img]['tmp_name'], $targetFileName);
         
      }
    }
    
	return false;
	
  }
  }

 	
	
}
