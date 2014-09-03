<?php

namespace E4W\Zf2BoardTest\Factory\Service;

use E4W\Zf2Board\Factory\Service\TopicServiceFactory;
use Zend\Mvc\Controller\ControllerManager;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceLocatorInterface;

class TopicServiceFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var TopicServiceFactory */
    protected $factory;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    public function setUp()
    {
        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->serviceLocator = $serviceLocator;

        $factory = new TopicServiceFactory;
        $this->factory = $factory;
    }

    public function testCreateService()
    {
        $topicMapper = 'E4W\Zf2Board\Mapper\TopicMapperInterface';

        $moduleOptions = $this->getMock('E4W\Zf2Board\Options\ModuleOptions');

        $this->serviceLocator->expects($this->at(0))
            ->method('get')
            ->with('E4W\Zf2Board\Options\ModuleOptions')
            ->willReturn($moduleOptions);

        $moduleOptions->expects($this->once())
            ->method('getTopicMapper')
            ->willReturn($topicMapper);

        $topicMapperMock = $this->getMock($topicMapper);

        $this->serviceLocator->expects($this->at(1))
            ->method('get')
            ->with($topicMapper)
            ->willReturn($topicMapperMock);

        $topicCreateForm = $this->getMockBuilder('E4W\Zf2Board\Form\Post\CreateForm')
            ->disableOriginalConstructor()
            ->getMock();

        $this->serviceLocator->expects($this->at(2))
            ->method('get')
            ->with('E4W\Zf2Board\Form\Topic\CreateForm')
            ->willReturn($topicCreateForm);

        $result = $this->factory->createService($this->serviceLocator);

        $this->assertInstanceOf('E4W\Zf2Board\Service\TopicService', $result);
    }
}
