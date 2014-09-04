<?php

namespace Eye4web\Zf2BoardTest\Factory\View\Helper;

use Eye4web\Zf2Board\Factory\View\Helper\BoardHelperFactory;
use Zend\Mvc\Controller\ControllerManager;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceLocatorInterface;

class BoardHelperFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var BoardHelperFactory */
    protected $factory;

    /** @var ServiceLocatorInterface */
    protected $helperManager;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    public function setUp()
    {
        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->serviceLocator = $serviceLocator;

        /** @var ServiceLocatorInterface $helperManager */
        $helperManager = $this->getMockBuilder('Zend\View\HelperPluginManager')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->helperManager = $helperManager;

        $helperManager->expects($this->once())
                       ->method('getServiceLocator')
                       ->willReturn($serviceLocator);

        $factory = new BoardHelperFactory;
        $this->factory = $factory;
    }

    public function testCreateService()
    {
        $authorService = $this->getMockBuilder('Eye4web\Zf2Board\Service\AuthorService')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->serviceLocator->expects($this->at(0))
                             ->method('get')
                             ->with('Eye4web\Zf2Board\Service\AuthorService')
                             ->willReturn($authorService);

        $authenticationService = $this->getMockBuilder('Zend\Authentication\AuthenticationService')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->serviceLocator->expects($this->at(1))
                             ->method('get')
                             ->with('Eye4web\Zf2Board\Service\AuthenticationService')
                             ->willReturn($authenticationService);

        $result = $this->factory->createService($this->helperManager);

        $this->assertInstanceOf('Eye4web\Zf2Board\View\Helper\BoardHelper', $result);
    }
}
