<?php

namespace Eye4web\Zf2BoardTest\Factory\Options;

use Eye4web\Zf2Board\Factory\Options\ModuleOptionsFactory;
use Zend\Mvc\Controller\ControllerManager;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModuleOptionsFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var ModuleOptionsFactory */
    protected $factory;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    public function setUp()
    {
        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->serviceLocator = $serviceLocator;

        $factory = new ModuleOptionsFactory;
        $this->factory = $factory;
    }

    public function testCreateServiceWithoutConfig()
    {
        $config = [];

        $this->serviceLocator->expects($this->at(0))
                             ->method('get')
                             ->with('Config')
                             ->willReturn($config);

        $result = $this->factory->createService($this->serviceLocator);

        $this->assertInstanceOf('Eye4web\Zf2Board\Options\ModuleOptions', $result);
    }

    public function testCreateServiceWithConfig()
    {
        $config = [
            'e4w' => [
                'board' => []
            ]
        ];

        $this->serviceLocator->expects($this->at(0))
                             ->method('get')
                             ->with('Config')
                             ->willReturn($config);

        $result = $this->factory->createService($this->serviceLocator);

        $this->assertInstanceOf('Eye4web\Zf2Board\Options\ModuleOptions', $result);
    }
}
