<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Storage\ArrayStorage;
use Zend\Session\SessionManager;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Application\Model\Ad;
use Application\Model\AdMainTable;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {
		$viewModel = new ViewModel(); //create viewmodel here because later some options will have diff. layouts
		$adTable = $this->getServiceLocator()->get('AdMainTable');
		$modelTable = $this->getServiceLocator()->get('ModelMainTable');
		$brandTable = $this->getServiceLocator()->get('BrandMainTable');
				      
		//get parameteres from URL (ex. audi/a4/321 -> brand/model/ad_id)		  
		$brand_name = $this->params()->fromRoute('brand');
		$model_name = $this->params()->fromRoute('model');
	    
			

		//URL like /audi
		//show all ads for brand
		if(!empty($brand_name) && empty($model_name)){
			$brandTable = $this->getServiceLocator()->get('BrandMainTable');
			
			//set diff. layout for ads list
				$layout = $this->layout();
				$layout->setTemplate('layout/layout_list.phtml');
					
			//get brand_id	
			$brand_id = $brandTable->getBrandId($brand_name);				
				
			if(!empty($brand_id)){   

				//get all ads for this brand	
				$ads_to_show = $adTable->getAds($brand_id->brand_id);
					
				//set template for ads list
				$viewModel->setTemplate('/application/index/list.phtml'); // path to phtml file under view folder
					
				//send variable to the view (for breadcrumb)
				$viewModel->setVariable('brand', $brand_name);
				
				//and send models to the left menu (to the layout)
				$current_brand_id = $brand_id->brand_id;
				$menu_models = $modelTable->getModelsForBrand($current_brand_id);
				
				
				$models = array(); //models without series
				foreach($menu_models as $model){
						array_push($models, $model);						
				}
				
				
				
				//print_r($menu_models);
				$viewModel->setVariable('menu_models', $models);
				//$viewModel->setVariable('menu_series', $series);
				//$viewModel->setVariable('unique_series', $unique_series);
				$viewModel->setVariable('menu_brand_id', $brand_id->brand_id);
				
	 		} else { //add else to redirect
        header("Location: http://scarto.pl");
        die();
    }
    }	else if (!empty($brand_name) && !empty($model_name)){
			//URL like /audi/a4
			//show all ads for this model
			//$modelTable = $this->getServiceLocator()->get('ModelMainTable');
			//$brandTable = $this->getServiceLocator()->get('BrandMainTable');
			

			//set diff. layout for ads list
				$layout = $this->layout();
				$layout->setTemplate('layout/layout_list.phtml');
				$viewModel->setVariable('brand', $brand_name);
				$viewModel->setVariable('model', $model_name);
							
			//get brand id
			$brand_id = $brandTable->getBrandId($brand_name);//we need brand id in case two brands have same models											
															//such as Audi A4 and VW A4	
			
			//get model id		
			$model_id = $modelTable->getModelId($model_name, $brand_id->brand_id);					
			
			if(!empty($model_id)){      
				
				//get ads for this model
				$ads_to_show = $adTable->getAdsByModel($model_id->model_id);
				
				//set template for list view
				$viewModel->setTemplate('/application/index/list.phtml'); 
				
				//and send models to the left menu (to the layout)
				$current_brand_id = $brand_id->brand_id;
				$menu_models = $modelTable->getModelsForBrand($current_brand_id);
				$viewModel->setVariable('menu_models', $menu_models);
				$viewModel->setVariable('menu_brand_id', $brand_id->brand_id);
				
				//send variables to the view (for breadcrumb)
				$viewModel->setVariables(array('brand' => $brand_name, 'model' => $model_name));
	 		} else { //add else to redirect
        header("Location: http://scarto.pl");
        die();
    }

		} else {// if (empty($brand_name) && empty($model_name)){

			//for now we want to have random ads for main page
			
			//get main ad data - there is one main ad
			$home_page_main_ad = $adTable->getRandom(1);
			
			//get random ads for main page - there are 6 random ads
			$ads_to_show = $adTable->getRandom(6);
			
			//send main_ad data to the view
			$viewModel->setVariable('main_ad', $home_page_main_ad);     
	  	  
		}

	//------------------menu
	$menu_brands = $brandTable->fetchAll();
	$viewModel->setVariable('menu_brands', $menu_brands);
	//end menu
		
	//ads_to_show contain ads		
	$viewModel->setVariable('ogloszenia', $ads_to_show);
	return $viewModel;
    }


	
}
