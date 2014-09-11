<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Ogloszenia;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Session\SessionManager;
use Zend\Session\Container;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Ogloszenia\Model\Brand;
use Ogloszenia\Model\BrandTable;
use Ogloszenia\Model\Model;
use Ogloszenia\Model\ModelTable;
use Ogloszenia\Model\Ad;
use Ogloszenia\Model\AdTable;
use Ogloszenia\Model\Description;
use Ogloszenia\Model\DescriptionTable;
use Ogloszenia\Model\Extra;
use Ogloszenia\Model\ExtraTable;
use Ogloszenia\Model\User;
use Ogloszenia\Model\UserTable;
use Ogloszenia\Model\Image;
use Ogloszenia\Model\ImageTable;
use Ogloszenia\Form\AddForm;
use Ogloszenia\Form\EdytujForm;

class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }
	
	
     public function getServiceConfig(){
      return array(
        'abstract_factories' => array(),
        'aliases' => array(),
        'factories' => array(
			'BrandTable' => function($sm) {
                $tableGateway = $sm->get('BrandTableGateway');
                $table = new BrandTable($tableGateway);
                return $table;
            },
            'BrandTableGateway' => function($sm){
                $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                $resultSetPrototype = new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new Brand());
                return new TableGateway('brands', $dbAdapter, null, $resultSetPrototype);
            },
            'ModelTable' => function($sm) {
                $tableGateway = $sm->get('ModelTableGateway');
                $table = new ModelTable($tableGateway);
                return $table;
            },
            'ModelTableGateway' => function($sm){
                $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                $resultSetPrototype = new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new Model());
                return new TableGateway('models', $dbAdapter, null, $resultSetPrototype);
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
            'AdTable' => function($sm) {
                $tableGateway = $sm->get('AdTableGateway');
                $table = new AdTable($tableGateway);
                return $table;
            },
            'AdTableGateway' => function($sm){
                $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                $resultSetPrototype = new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new Ad());
                return new TableGateway('ads', $dbAdapter, null, $resultSetPrototype);
            },
            'DescriptionTable' => function($sm) {
                $tableGateway = $sm->get('DescriptionTableGateway');
                $table = new DescriptionTable($tableGateway);
                return $table;
            },
            'DescriptionTableGateway' => function($sm){
                $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                $resultSetPrototype = new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new Description());
                return new TableGateway('ad_descriptions', $dbAdapter, null, $resultSetPrototype);
            },			
            'ExtraTable' => function($sm) {
                $tableGateway = $sm->get('ExtraTableGateway');
                $table = new ExtraTable($tableGateway);
                return $table;
            },
            'ExtraTableGateway' => function($sm){
                $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                $resultSetPrototype = new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new Extra());
                return new TableGateway('ad_extras', $dbAdapter, null, $resultSetPrototype);
            },
            'AdUserTable' => function($sm) {
                $tableGateway = $sm->get('UserTableGateway');
                $table = new UserTable($tableGateway);
                return $table;
            },
            'UserTableGateway' => function($sm){
                $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                $resultSetPrototype = new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new User());
                return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
            },			

           //FORMS
            'AddForm' => function($sm){
                $form = new \Ogloszenia\Form\AddForm();
                $form->setInputFilter($sm->get('AddFilter'));
                return $form;
            },
						'EdytujForm' => function($sm){
                $form = new \Ogloszenia\Form\EdytujForm();
                $form->setInputFilter($sm->get('EdytujFilter'));
                return $form;
            },
            //FILTERS
            'AddFilter' => function($sm){
               return new \Ogloszenia\Form\AddFilter(); 
            },
            'EdytujFilter' => function($sm){
               return new \Ogloszenia\Form\EdytujFilter(); 
            },
        ),
        'invokables' => array(),
        'services' => array(),
        'shared' => array(),
      );
    }
}
