<?php

namespace E4W\Zf2BoardTest\Factory\Controller;

use E4W\Zf2Board\Factory\Controller\BoardControllerFactory;
use Zend\Mvc\Controller\ControllerManager;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceLocatorInterface;

class BoardControllerFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var BoardControllerFactory */
    protected $factory;

    /** @var ControllerManager */
    protected $controllerManager;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    public function setUp()
    {
        /** @var ControllerManager $controllerManager */
        $controllerManager = $this->getMock('Zend\Mvc\Controller\ControllerManager');
        $this->controllerManager = $controllerManager;

        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->serviceLocator = $serviceLocator;

        $controllerManager->expects($this->any())
                          ->method('getServiceLocator')
                          ->willReturn($serviceLocator);

        $factory = new BoardControllerFactory;
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

        $boardService = $this->getMockBuilder('E4W\Zf2Board\Service\BoardService')
                             ->disableOriginalConstructor()
                             ->getMock();

        $this->serviceLocator->expects($this->at(1))
                             ->method('get')
                             ->with('E4W\Zf2Board\Service\BoardService')
                             ->willReturn($boardService);

        $topicService = $this->getMockBuilder('E4W\Zf2Board\Service\TopicService')
                             ->disableOriginalConstructor()
                             ->getMock();

        $this->serviceLocator->expects($this->at(2))
                             ->method('get')
                             ->with('E4W\Zf2Board\Service\TopicService')
                             ->willReturn($topicService);

        $postService = $this->getMockBuilder('E4W\Zf2Board\Service\PostService')
                            ->disableOriginalConstructor()
                            ->getMock();

        $this->serviceLocator->expects($this->at(3))
                             ->method('get')
                             ->with('E4W\Zf2Board\Service\PostService')
                             ->willReturn($postService);

        $boardCreateForm = $this->getMockBuilder('E4W\Zf2Board\Form\Board\CreateForm')
                                ->disableOriginalConstructor()
                                ->getMock();

        $this->serviceLocator->expects($this->at(4))
                             ->method('get')
                             ->with('E4W\Zf2Board\Form\Board\CreateForm')
                             ->willReturn($boardCreateForm);

        $topicCreateForm = $this->getMockBuilder('E4W\Zf2Board\Form\Topic\CreateForm')
                                ->disableOriginalConstructor()
                                ->getMock();

        $this->serviceLocator->expects($this->at(5))
                             ->method('get')
                             ->with('E4W\Zf2Board\Form\Topic\CreateForm')
                             ->willReturn($topicCreateForm);

        $postCreateForm = $this->getMockBuilder('E4W\Zf2Board\Form\Post\CreateForm')
                               ->disableOriginalConstructor()
                               ->getMock();

        $this->serviceLocator->expects($this->at(6))
                             ->method('get')
                             ->with('E4W\Zf2Board\Form\Post\CreateForm')
                             ->willReturn($postCreateForm);

        $postEditForm = $this->getMockBuilder('E4W\Zf2Board\Form\Post\EditForm')
                             ->disableOriginalConstructor()
                             ->getMock();

        $this->serviceLocator->expects($this->at(7))
                             ->method('get')
                             ->with('E4W\Zf2Board\Form\Post\EditForm')
                             ->willReturn($postEditForm);

        $moduleOptions->expects($this->once())
                      ->method('getAuthenticationService')
                      ->willReturn('AuthenticationService');

        $authenticationService = $this->getMockBuilder('Zend\Authentication\AuthenticationService')
                                      ->disableOriginalConstructor()
                                      ->getMock();

        $this->serviceLocator->expects($this->at(8))
                             ->method('get')
                             ->with('AuthenticationService')
                             ->willReturn($authenticationService);

        $result = $this->factory->createService($this->controllerManager);

        $this->assertInstanceOf('E4W\Zf2Board\Controller\BoardController', $result);
    }
}
