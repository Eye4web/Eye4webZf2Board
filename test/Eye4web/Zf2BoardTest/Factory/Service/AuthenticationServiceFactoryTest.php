<?php

namespace Eye4web\Zf2BoardTest\Factory\Service;

use Eye4web\Zf2Board\Factory\Service\AuthenticationServiceFactory;
use Zend\Mvc\Controller\ControllerManager;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthenticationServiceFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var AuthenticationServiceFactory */
    protected $factory;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    public function setUp()
    {
        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->serviceLocator = $serviceLocator;

        $factory = new AuthenticationServiceFactory;
        $this->factory = $factory;
    }

    public function testCreateService()
    {
        $authenticationService = 'Zend\Authentication\AuthenticationService';

        $moduleOptions = $this->getMock('Eye4web\Zf2Board\Options\ModuleOptions');

        $this->serviceLocator->expects($this->at(0))
                             ->method('get')
                             ->with('Eye4web\Zf2Board\Options\ModuleOptions')
                             ->willReturn($moduleOptions);

        $moduleOptions->expects($this->once())
                      ->method('getAuthenticationService')
                      ->willReturn($authenticationService);

        $authenticationServiceMock = $this->getMock($authenticationService);

        $this->serviceLocator->expects($this->at(1))
                             ->method('get')
                             ->with($authenticationService)
                             ->willReturn($authenticationServiceMock);

        $result = $this->factory->createService($this->serviceLocator);

        $this->assertInstanceOf($authenticationService, $result);
    }
}
