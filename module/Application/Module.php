<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\SessionManager;
use Zend\Session\Container;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Ad;
use Application\Model\AdMainTable;
use Application\Model\Brand;
use Application\Model\BrandMainTable;
use Application\Model\Model;
use Application\Model\ModelMainTable;
use Application\Model\Image;
use Application\Model\ImageTable;
use Application\View\Helper\Menu;
use Application\View\Helper\LogStatus;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
     public function getServiceConfig(){
      return array(
        'abstract_factories' => array(),
        'aliases' => array(),
        'factories' => array(
            /*'Menu' => function ($serviceManager) {
                // Get the service locator 
                $serviceLocator = $serviceManager->getServiceLocator();
                // pass it to your helper 
                return new \Application\View\Helper\Menu($serviceLocator);
            },*/        
            
            //DB
            'AdMainTable' => function($sm) {
                $tableGateway = $sm->get('AdTableGateway');
                $table = new AdMainTable($tableGateway);
                return $table;
            },
            'AdTableGateway' => function($sm){
                $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                $resultSetPrototype = new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new Ad());
                return new TableGateway('ads', $dbAdapter, null, $resultSetPrototype);
            },
            'ImageTable' => function($sm) {
                $tableGateway = $sm->get('ImageTableGateway');
                $table = new ImageTable($tableGateway);
                return $table;
            },
            'ImageTableGateway' => function($sm){
                $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                $resultSetPrototype = new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new Image());
                return new TableGateway('moto_images', $dbAdapter, null, $resultSetPrototype);
            },
			'BrandMainTable' => function($sm) {
                $tableGateway = $sm->get('BrandTableGateway');
                $table = new BrandMainTable($tableGateway);
                return $table;
            },
            'BrandTableGateway' => function($sm){
                $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                $resultSetPrototype = new ResultSet();
				$resultSetPrototype->order('brand_name ASC'); 
                $resultSetPrototype->setArrayObjectPrototype(new Brand());
                return new TableGateway('brands', $dbAdapter, null, $resultSetPrototype);
            },
			'ModelMainTable' => function($sm) {
                $tableGateway = $sm->get('ModelTableGateway');
                $table = new ModelMainTable($tableGateway);
                return $table;
            },
            'ModelTableGateway' => function($sm){
                $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                $resultSetPrototype = new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new Model());
                return new TableGateway('models', $dbAdapter, null, $resultSetPrototype);
            },          
        ),
        'invokables' => array(),
        'services' => array(),
        'shared' => array(),
      );
    }
    
    public function getViewHelperConfig()
  {
    return array(
      'factories' => array(
        'Menu' => function($sm) {
          $sm = $sm->getServiceLocator(); // $sm was the view helper's locator
          $table = $sm->get('BrandTable');
          $helper = new Application\View\Helper\Menu($table);
          return $helper;
        },
        'LogStatus' => function($sm) {
          //$sm = $sm->getServiceLocator(); // $sm was the view helper's locator
          $helper = new Application\View\Helper\LogStatus;
          return $helper;
        }
      )
    );
  }
    
    

}
