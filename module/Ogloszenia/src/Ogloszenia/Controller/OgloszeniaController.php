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
require_once 'search.php';

class OgloszeniaController extends AbstractActionController
{
	public function indexoldAction(){
	$ss =  __DIR__ . '/../view';
	  echo $ss;
	  return false;
	}  
    public function indexAction()
    {
		$viewModel = new ViewModel();
        $ad_id = $this->params()->fromRoute('id');
		$adTable = $this->getServiceLocator()->get('AdTable');
			
			if($ad_id){      
				
				//image table to get images for add
				$imageTable = $this->getServiceLocator()->get('ImageTable');
			
				//get ad content
				$ads_to_show = $adTable->getSingleAd($ad_id);
						
				//get images for this ad
				$images = $imageTable->getAdImages($ad_id);
						
				//set diff. layout for single ad page
				$layout = $this->layout();
				$layout->setTemplate('layout/layout_single_ad.phtml');
				
				//set template for single ad page
				$viewModel->setTemplate('/ogloszenia/ogloszenia/ad.phtml'); // path to phtml file under view folder
				$viewModel->setVariable('title', $ads_to_show->ad_title);		 				
				//send variables to the view
				$viewModel->setVariables(array('images' => $images));
				//brand i model tu chyba nie trzeba rpzesylac
	
				//ads_to_show contain ads		
				$viewModel->setVariable('ogloszenia', $ads_to_show);
	//print_r($ads_to_show);
				return $viewModel;
				//return false;
	 		}
		
    }

	
	public function szukajAction(){
  	$search_query = $this->request->getPost();
    
	if($search_query){
	$viewModel = new ViewModel();
  	$layout = $this->layout();
	$layout->setTemplate('layout/layout_search.phtml');
	$viewModel->setVariable('title', 'wyniki wyszukiwania');		 										
  	$search = new Search();
	$results = $search->get_results($search_query['searchbox']);
    //$results = $search->get_results('passat');
    $viewModel->setVariable('ogloszenia', $results);
    
    //------------------menu
	$brandTable = $this->getServiceLocator()->get('BrandMainTable');
    $menu_brands = $brandTable->fetchAll();
	$viewModel->setVariable('menu_brands', $menu_brands);
	//end menu
	
	return $viewModel;
	} else return false;
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
		$viewModel->setVariable('title', 'dodaj ogłoszenie');		 				
		return $viewModel;
	}
	

	
	public function updateAction(){
	  
    if(!$this->request->isPost()){
      return $this->redirect()->toRoute(NULL, 
        array('controller' => 'ogloszenia',
            'action' => 'dodaj'
        ));
    }
    
    $post = $this->request->getPost();
		$form=$this->getServiceLocator()->get('EdytujForm');
    $form->setData($post);
    
    if(!$form->isValid()){
		$adTable = $this->getServiceLocator()->get('AdTable');
		$ad = $adTable->getAd($post->ad_id);

		$imageTable = $this->getServiceLocator()->get('imageTable');
		$image = $imageTable->getImages($ad->ad_id);
  
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
				'image' => $image,
		 		'ad_main_img' => $ad->ad_main_img,
		 		'ad_id' => $ad->ad_id,
     
		));
		} elseif(empty($post->ad_model_id)){
			$model = new ViewModel(array(
				'error' => true,
				'form' => $form,
				'image' => $image,
		 		'ad_main_img' => $ad->ad_main_img,
		 		'ad_id' => $ad->ad_id,
				));        
		}
		$model->setTemplate('ogloszenia/ogloszenia/edytuj.phtml');
		return $model;
    }
		
    $this->getServiceLocator()->get('AdTable')->updateAd($post);
    
		//if(!empty($post->description_content)){
			$this->getServiceLocator()->get('DescriptionTable')->updateDescription($post);
		//}
  
		$this->getServiceLocator()->get('ExtraTable')->updateExtra($post);
  	$this->deleteImages($post);
		$this->processFilesAction($post->ad_id);    
    
    return $this->redirect()->toRoute(NULL , array(
      'controller' => 'Ogloszenia',
      'action' => 'dodaj'
    ));
	}
	
	private function deleteImages($post){
		
		$image_table = $this->getServiceLocator()->get('imageTable');
		$ad_table = $this->getServiceLocator()->get('adTable');
		
		(isset($post->delete_ad_main_img) && $post->delete_ad_main_img == 1) ? $ad_table->deleteMainImage($post->ad_id) : null;
		(isset($post->delete_image_2) && $post->delete_image_2 == 1) ? $image_table->deleteImage('image_2', $post->ad_id) : null;
		(isset($post->delete_image_3) && $post->delete_image_3 == 1) ? $image_table->deleteImage('image_3', $post->ad_id) : null;
		(isset($post->delete_image_4) && $post->delete_image_4 == 1) ? $image_table->deleteImage('image_4', $post->ad_id) : null;
		(isset($post->delete_image_5) && $post->delete_image_5 == 1) ? $image_table->deleteImage('image_5', $post->ad_id) : null;		
		(isset($post->delete_image_6) && $post->delete_image_6 == 1) ? $image_table->deleteImage('image_6', $post->ad_id) : null;		
		(isset($post->delete_image_7) && $post->delete_image_7 == 1) ? $image_table->deleteImage('image_7', $post->ad_id) : null;		
		(isset($post->delete_image_8) && $post->delete_image_8 == 1) ? $image_table->deleteImage('image_8', $post->ad_id) : null;		
		(isset($post->delete_image_9) && $post->delete_image_9 == 1) ? $image_table->deleteImage('image_9', $post->ad_id) : null;		
		
		return true;
		
	}
	
	
   public function usunAction(){
	
	
		$adTable = $this->getServiceLocator()->get('AdTable');
		$ad = $adTable->getAd($this->params()->fromRoute('id'));
		
		
		$session = new Container('my_session');
		
		if(!empty($session->user_email) and !empty($ad)){
		
		$userTable = $this->getServiceLocator()->get('UserTable');
		$user_id = $userTable->getUserByEmail($session->user_email);
	    
		if($user_id->user_id == $ad->ad_user_id){
		
		$ad_id = $this->params()->fromRoute('id');
	
		$adTable = $this->getServiceLocator()->get('AdTable');
		//$ad = $adTable->getAd($this->params()->fromRoute('id'));
		
		
		
		$adTable->deleteAd($ad_id);
		return $this->redirect()->toRoute('users', 
        array('controller' => 'Index',
            'action' => 'index'
        ));
		} else {
			return $this->redirect()->toRoute('Application', 
			array('controller' => 'Index',
				'action' => 'index'
			));
			}
		} else {
			return $this->redirect()->toRoute('Application', 
			array('controller' => 'Index',
				'action' => 'index'
			));
		}
	}
	
   public function edytujAction(){
	
		$layout = $this->layout();
		$layout->setTemplate('layout/layout_single_ad.phtml');

		$adTable = $this->getServiceLocator()->get('AdTable');
		$ad = $adTable->getAd($this->params()->fromRoute('id'));
		
		
		$session = new Container('my_session');
		
		if(!empty($session->user_email) and !empty($ad)){
		
		$userTable = $this->getServiceLocator()->get('UserTable');
		$user_id = $userTable->getUserByEmail($session->user_email);
	    
		if($user_id->user_id == $ad->ad_user_id){
		
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
//	print_r($brand);  
      $viewModel = new ViewModel(array(
         'form' => $form,
		 			'model_id' => $model->model_id,
		 'model_name' => $model->model_name,
		 'image' => $image,
		 'ad_main_img' => $ad->ad_main_img,
		 'ad_id' => $ad->ad_id,
         //'id' => $this->params()->fromRoute('id')
      ));
      return $viewModel;
//      return false;
	} else {
		return $this->redirect()->toRoute('application', 
        array('controller' => 'Index',
            'action' => 'index'
        ));
		}


	} else{
	return $this->redirect()->toRoute('application', 
        array('controller' => 'Index',
            'action' => 'index'
        ));
	}
  }
 
    
  public function processFilesAction($image_ad_id){
    
	$request = $this->getRequest(); 
    
    if ($request->isPost()) {
		
    //if there is a post, then lets roll
    //create array for exchange data - will be used later to save data to DB
    $exchange_data = array();
		  
    // Fetch Configuration from Module Config
    //fo now we want to get location for temp folder (files uploaded before resize)
    $uploadPath = $this->getTmpFileUploadLocation();
    
    // Save Uploaded file - configure adapter to save files
    $adapter = new \Zend\File\Transfer\Adapter\Http();
	  $adapter->setDestination($uploadPath);
    //$adapter->setDestination('http://scarto.com/images/tmp_data');

   
    //there are 9 images from form - lets put them in an array
    $images_form = array('ad_main_img', 'image_2', 'image_3', 'image_4', 'image_5', 'image_6', 'image_7', 'image_8', 'image_9');
    
    //foreach image copy image, rename and resize
    foreach($images_form as $img){
      
      //get images parameters (names etc.)
      $current_image = $this->params()->fromFiles($img);
      
      //if there is an image, then go on
      if(!empty($current_image['name'])){
        
        //a) copy file, if success then go on
        if($adapter->receive($current_image['name'])){
          
          // b) rename file:
          $time = time(); // to randomize file name
          $old_file = $uploadPath.'/'.$current_image['name'];
          $new_file_name = $time.$current_image['name'];
          $new_file = $uploadPath.'/'.$new_file_name;
          rename($old_file, $new_file);
          
          // c) add data to exchange_data array (later this will be saved to DB)
          // ex. $exchange_data['image_2'] = $copied_image['name']
          $exchange_data[$img] = $new_file_name;
          
          // d) resize and copy to final destination folder
 
          //first get extenstion of file
          $new_img_ext = strtolower(pathinfo($new_file, PATHINFO_EXTENSION)); 
          // resize :)

		  $this->resizeAction($new_img_ext, $new_file, $new_file_name);
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
            
          		$ad = new Ad($exchange_data);
							$ad->exchangeArray($exchange_data);
            	$adTable = $this->getServiceLocator()->get('AdTable');
            	$adTable->updateAdMainImage($ad, $image_ad_id);
          
        }
    }
	return false;
	
  }

  public function resizeAction($new_img_ext, $new_file, $new_img_name){
   //based on extension we need to use different 'imagecreatefrom'
   
   //this fix problem with php 5 and gd2
   //without that we will get error: 
   //"imagecreatefromjpeg() : gd-jpeg, libjpeg: recoverable error: Premature end of JPEG"
   //with some jpeg files
   ini_set('gd.jpeg_ignore_warning', 1);
   
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
                $path = $this->getFileUploadLocation();  
                $destination_to_save = $path.'/'.$new_img_name;
               
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
	
	$ad_id = $this->createAd($form->getData());
    return $this->redirect()->toRoute(NULL, array(
      'controller' => 'ogloszenia',
      'action' => 'index',
	  'id' => $ad_id, 
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
    
	if(empty($_POST['description_content'])){
		$data['description_content'] = ' '; //add space in case desc is empty
	}
		$description = new Description();
		$data['description_ad_id'] = $ad_id; //add ad_id to the description object
		
		$description->exchangeArray($data);
		$descriptionTable = $this->getServiceLocator()->get('descriptionTable');
		$descriptionTable->saveDescription($description);
	
	
    $extra = new Extra();
    $data['extra_ad_id'] = $ad_id; //add ad_id to the description object
	$extra->exchangeArray($data);
    $extraTable = $this->getServiceLocator()->get('ExtraTable');
    $extraTable->saveExtra($extra);
    
	//ej sprawdzenie czy są obrazki!
	$this->processFilesAction($ad_id); //this will copy images and update data in DB tables
	
    return $ad_id;
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

	public function aboutAction()
    {
	$viewModel = new ViewModel(); 
	$layout = $this->layout();
	$layout->setTemplate('layout/layout_single_ad.phtml');
	$viewModel->setVariable('title', 'O stronie');		 				
				
	return $viewModel;	
	}
	
    public function regulaminAction()
    {
	$layout = $this->layout();
	$layout->setTemplate('layout/layout_single_ad.phtml');

	$viewModel = new ViewModel(); 
	$viewModel->setVariable('title', 'Regulamin');		 				
				
	return $viewModel;	
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
	
	
}
