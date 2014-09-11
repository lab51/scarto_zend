<?php 
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
//use Application\Model\BrandTable;
//use Zend\Mvc\Controller\AbstractActionController;
//use Zend\ServiceManager\ServiceLocatorAwareInterface;
//use Zend\ServiceManager\ServiceLocatorInterface;
//use Application\Controller\IndexController as Index;
//use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;
//use Zend\Authentication\AuthenticationService;
use Zend\Session\SessionManager;
use Zend\Session\Container;

class LogStatus extends AbstractHelper
{

  public function __invoke()
    {
		//return $this->getAuthService()->getStorage()->read('user_email');
  
		$container = new Container('my_session');
            
		if(!empty($container->user_email)){
			return '1';
		} elseif(empty($container->user_email)){
			return '0';
		} else {
			return '3';
		}
	}
  
}

