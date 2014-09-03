<?php

namespace E4W\Zf2BoardTest\Factory\Service;

use E4W\Zf2Board\Factory\Service\PostServiceFactory;
use Zend\Mvc\Controller\ControllerManager;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceLocatorInterface;

class PostServiceFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var PostServiceFactory */
    protected $factory;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    public function setUp()
    {
        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->serviceLocator = $serviceLocator;

        $factory = new PostServiceFactory;
        $this->factory = $factory;
    }

    public function testCreateService()
    {
        $postMapper = 'E4W\Zf2Board\Mapper\PostMapperInterface';

        $moduleOptions = $this->getMock('E4W\Zf2Board\Options\ModuleOptions');

        $this->serviceLocator->expects($this->at(0))
                             ->method('get')
                             ->with('E4W\Zf2Board\Options\ModuleOptions')
                             ->willReturn($moduleOptions);

        $moduleOptions->expects($this->once())
                      ->method('getPostMapper')
                      ->willReturn($postMapper);

        $postMapperMock = $this->getMock($postMapper);

        $this->serviceLocator->expects($this->at(1))
                             ->method('get')
                             ->with($postMapper)
                             ->willReturn($postMapperMock);

        $postCreateForm = $this->getMockBuilder('E4W\Zf2Board\Form\Post\CreateForm')
                                ->disableOriginalConstructor()
                                ->getMock();

        $this->serviceLocator->expects($this->at(2))
                             ->method('get')
                             ->with('E4W\Zf2Board\Form\Post\CreateForm')
                             ->willReturn($postCreateForm);

        $postEditForm = $this->getMockBuilder('E4W\Zf2Board\Form\Post\EditForm')
                                ->disableOriginalConstructor()
                                ->getMock();

        $this->serviceLocator->expects($this->at(3))
                             ->method('get')
                             ->with('E4W\Zf2Board\Form\Post\EditForm')
                             ->willReturn($postEditForm);

        $result = $this->factory->createService($this->serviceLocator);

        $this->assertInstanceOf('E4W\Zf2Board\Service\PostService', $result);
    }
}
