<?php

namespace E4W\Zf2BoardTest\Mapper;

use E4W\Zf2Board\Controller\BoardController;
use PHPUnit_Framework_TestCase;

class BoardControllerTest extends PHPUnit_Framework_TestCase
{
    /** @var \E4W\Zf2Board\Controller\BoardController */
    protected $controller;

    /** @var \E4W\Zf2Board\Service\BoardService */
    protected $boardService;

    /** @var \Zend\Mvc\Controller\PluginManager */
    protected $pluginManager;

    /** @var \E4W\Zf2Board\Service\TopicService */
    protected $topicService;

    /** @var \E4W\Zf2Board\Service\PostService */
    protected $postService;

    /** @var \E4W\Zf2Board\Form\Board\CreateForm */
    protected $boardCreateForm;

    /** @var \E4W\Zf2Board\Form\Topic\CreateForm */
    protected $topicCreateForm;

    /** @var \E4W\Zf2Board\Form\Post\CreateForm */
    protected $postCreateForm;

    /** @var \Zend\Authentication\AuthenticationService */
    protected $authenticationService;

    public $pluginManagerPlugins = [];

    public function setUp()
    {
        /** @var \E4W\Zf2Board\Service\BoardService $boardService */
        $boardService = $this->getMockBuilder('E4W\Zf2Board\Service\BoardService')
                             ->disableOriginalConstructor()
                             ->getMock();

        $this->boardService = $boardService;

        /** @var \Zend\Mvc\Controller\PluginManager $pluginManager */
        $pluginManager = $this->getMock('Zend\Mvc\Controller\PluginManager', array('get'));

        $pluginManager->expects($this->any())
                      ->method('get')
                      ->will($this->returnCallback(array($this, 'helperMockCallbackPluginManagerGet')));

        $this->pluginManager = $pluginManager;

        /** @var \E4W\Zf2Board\Service\TopicService $topicService */
        $topicService = $this->getMockBuilder('E4W\Zf2Board\Service\TopicService')
                             ->disableOriginalConstructor()
                             ->getMock();

        $this->topicService = $topicService;

        /** @var \E4W\Zf2Board\Service\PostService $postService */
        $postService = $this->getMockBuilder('E4W\Zf2Board\Service\PostService')
                            ->disableOriginalConstructor()
                            ->getMock();

        $this->postService = $postService;

        /** @var \Zend\Form\Form $boardCreateForm */
        $boardCreateForm = $this->getMockBuilder('E4W\Zf2Board\Form\Board\CreateForm')
                                ->disableOriginalConstructor()
                                ->getMock();

        $this->boardCreateForm = $boardCreateForm;

        /** @var \Zend\Form\Form $topicCreateForm */
        $topicCreateForm = $this->getMockBuilder('E4W\Zf2Board\Form\Topic\CreateForm')
                                ->disableOriginalConstructor()
                                ->getMock();

        $this->topicCreateForm = $topicCreateForm;

        /** @var \Zend\Form\Form $postCreateForm */
        $postCreateForm = $this->getMockBuilder('E4W\Zf2Board\Form\Post\CreateForm')
                               ->disableOriginalConstructor()
                               ->getMock();

        $this->postCreateForm = $postCreateForm;

        /** @var \Zend\Authentication\AuthenticationService $authenticationService */
        $authenticationService = $this->getMock('Zend\Authentication\AuthenticationService');

        $this->authenticationService = $authenticationService;

        $controller = new BoardController($boardService, $topicService, $postService, $boardCreateForm, $topicCreateForm, $postCreateForm, $authenticationService);
        $controller->setPluginManager($pluginManager);

        $this->controller = $controller;
    }

    public function testBoardListAction()
    {
        $this->boardService->expects($this->once())
                           ->method('findAll')
                           ->willReturn([]);

        $result = $this->controller->boardListAction();

        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
    }

    public function helperMockCallbackPluginManagerGet($key)
    {
        return (array_key_exists($key, $this->pluginManagerPlugins))
            ? $this->pluginManagerPlugins[$key]
            : null;
    }
}