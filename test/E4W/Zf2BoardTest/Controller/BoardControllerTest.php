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

        $controller = new BoardController($boardService);
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