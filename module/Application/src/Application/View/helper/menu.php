<?php 
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Application\Model\BrandTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Controller\IndexController as Index;
use Zend\ServiceManager\ServiceLocatorInterface as ServiceLocator;

class Menu extends AbstractHelper
{

  protected $table;

  public function __construct(BrandTable $table)
  {
    $this->table = $table;
  }
  
  
  public function __invoke()
    {
         //$menu = $this->getServiceLocator()->get('BrandTable');
         return $table->fetchAll();
    }
  
}

