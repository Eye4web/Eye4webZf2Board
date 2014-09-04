<?php

namespace Eye4web\Zf2BoardTest\Factory\Form\Topic;

use Eye4web\Zf2Board\Factory\Form\Topic\CreateFormFactory;
use Zend\Mvc\Controller\ControllerManager;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceLocatorInterface;

class CreateFormFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var CreateFormFactory */
    protected $factory;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    public function setUp()
    {
        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->serviceLocator = $serviceLocator;

        $factory = new CreateFormFactory;
        $this->factory = $factory;
    }

    public function testCreateService()
    {
        $moduleOptions = $this->getMockBuilder('Eye4web\Zf2Board\Options\ModuleOptions')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->serviceLocator->expects($this->at(0))
                             ->method('get')
                             ->with('Eye4web\Zf2Board\Options\ModuleOptions')
                             ->willReturn($moduleOptions);

        $topicEntityMock = $this->getMockBuilder('Eye4web\Zf2Board\Entity\Topic')
                                ->disableOriginalConstructor()
                                ->getMock();

        $moduleOptions->expects($this->once())
                      ->method('getTopicEntity')
                      ->willReturn($topicEntityMock);

        $result = $this->factory->createService($this->serviceLocator);

        $this->assertInstanceOf('Eye4web\Zf2Board\Form\Topic\CreateForm', $result);
    }
}
