<?php

namespace E4W\Zf2BoardTest\Factory\Mapper\DoctrineORM;

use E4W\Zf2Board\Factory\Mapper\DoctrineORM\TopicMapperFactory;
use Zend\Mvc\Controller\ControllerManager;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceLocatorInterface;

class TopicMapperFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var TopicMapperFactory */
    protected $factory;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    public function setUp()
    {
        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->serviceLocator = $serviceLocator;

        $factory = new TopicMapperFactory;
        $this->factory = $factory;
    }

    public function testCreateService()
    {
        $objectManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->serviceLocator->expects($this->at(0))
                             ->method('get')
                             ->with('Doctrine\ORM\EntityManager')
                             ->willReturn($objectManager);

        $moduleOptions = $this->getMockBuilder('E4W\Zf2Board\Options\ModuleOptions')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->serviceLocator->expects($this->at(1))
                             ->method('get')
                             ->with('E4W\Zf2Board\Options\ModuleOptions')
                             ->willReturn($moduleOptions);

        $slugService = $this->getMock('E4W\Zf2Board\Service\SlugService');

        $this->serviceLocator->expects($this->at(2))
                             ->method('get')
                             ->with('E4W\Zf2Board\Service\SlugService')
                             ->willReturn($slugService);

        $result = $this->factory->createService($this->serviceLocator);

        $this->assertInstanceOf('E4W\Zf2Board\Mapper\DoctrineORM\TopicMapper', $result);
    }
}
