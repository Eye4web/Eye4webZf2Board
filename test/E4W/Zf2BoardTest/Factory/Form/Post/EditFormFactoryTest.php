<?php

namespace E4W\Zf2BoardTest\Factory\Form\Post;

use E4W\Zf2Board\Factory\Form\Post\EditFormFactory;
use Zend\Mvc\Controller\ControllerManager;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceLocatorInterface;

class EditFormFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var EditFormFactory */
    protected $factory;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    public function setUp()
    {
        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->serviceLocator = $serviceLocator;

        $factory = new EditFormFactory;
        $this->factory = $factory;
    }

    public function testCreateService()
    {
        $moduleOptions = $this->getMockBuilder('E4W\Zf2Board\Options\ModuleOptions')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->serviceLocator->expects($this->at(0))
                             ->method('get')
                             ->with('E4W\Zf2Board\Options\ModuleOptions')
                             ->willReturn($moduleOptions);

        $postEntityMock = $this->getMockBuilder('E4W\Zf2Board\Entity\Post')
                               ->disableOriginalConstructor()
                               ->getMock();

        $moduleOptions->expects($this->once())
                      ->method('getPostEntity')
                      ->willReturn($postEntityMock);

        $result = $this->factory->createService($this->serviceLocator);

        $this->assertInstanceOf('E4W\Zf2Board\Form\Post\EditForm', $result);
    }
}
