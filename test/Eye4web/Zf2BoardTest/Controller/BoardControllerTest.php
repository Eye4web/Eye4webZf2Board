<?php

namespace Eye4web\Zf2BoardTest\Controller;

use Eye4web\Zf2Board\Controller\BoardController;
use PHPUnit_Framework_TestCase;

class BoardControllerTest extends PHPUnit_Framework_TestCase
{
    /** @var \Eye4web\Zf2Board\Controller\BoardController */
    protected $controller;

    /** @var \Eye4web\Zf2Board\Service\BoardService */
    protected $boardService;

    /** @var \Zend\Mvc\Controller\PluginManager */
    protected $pluginManager;

    /** @var \Eye4web\Zf2Board\Service\TopicService */
    protected $topicService;

    /** @var \Eye4web\Zf2Board\Service\PostService */
    protected $postService;

    /** @var \Eye4web\Zf2Board\Form\Board\CreateForm */
    protected $boardCreateForm;

    /** @var \Eye4web\Zf2Board\Form\Topic\CreateForm */
    protected $topicCreateForm;

    /** @var \Eye4web\Zf2Board\Form\Post\CreateForm */
    protected $postCreateForm;

    /** @var \Eye4web\Zf2Board\Form\Post\EditForm */
    protected $postEditForm;

    /** @var \Zend\Authentication\AuthenticationService */
    protected $authenticationService;

    /** @var \Zend\EventManager\EventManager */
    protected $eventManager;

    public $pluginManagerPlugins = [];

    public function setUp()
    {
        /** @var \Eye4web\Zf2Board\Service\BoardService $boardService */
        $boardService = $this->getMockBuilder('Eye4web\Zf2Board\Service\BoardService')
                             ->disableOriginalConstructor()
                             ->getMock();

        $this->boardService = $boardService;

        /** @var \Zend\Mvc\Controller\PluginManager $pluginManager */
        $pluginManager = $this->getMock('Zend\Mvc\Controller\PluginManager', array('get'));

        $pluginManager->expects($this->any())
                      ->method('get')
                      ->will($this->returnCallback(array($this, 'helperMockCallbackPluginManagerGet')));

        $this->pluginManager = $pluginManager;

        /** @var \Eye4web\Zf2Board\Service\TopicService $topicService */
        $topicService = $this->getMockBuilder('Eye4web\Zf2Board\Service\TopicService')
                             ->disableOriginalConstructor()
                             ->getMock();

        $this->topicService = $topicService;

        /** @var \Eye4web\Zf2Board\Service\PostService $postService */
        $postService = $this->getMockBuilder('Eye4web\Zf2Board\Service\PostService')
                            ->disableOriginalConstructor()
                            ->getMock();

        $this->postService = $postService;

        /** @var \Zend\Form\Form $boardCreateForm */
        $boardCreateForm = $this->getMockBuilder('Eye4web\Zf2Board\Form\Board\CreateForm')
                                ->disableOriginalConstructor()
                                ->getMock();

        $this->boardCreateForm = $boardCreateForm;

        /** @var \Zend\Form\Form $topicCreateForm */
        $topicCreateForm = $this->getMockBuilder('Eye4web\Zf2Board\Form\Topic\CreateForm')
                                ->disableOriginalConstructor()
                                ->getMock();

        $this->topicCreateForm = $topicCreateForm;

        /** @var \Zend\Form\Form $postCreateForm */
        $postCreateForm = $this->getMockBuilder('Eye4web\Zf2Board\Form\Post\CreateForm')
                               ->disableOriginalConstructor()
                               ->getMock();

        $this->postCreateForm = $postCreateForm;

        /** @var \Zend\Form\Form $postEdit */
        $postEditForm = $this->getMockBuilder('Eye4web\Zf2Board\Form\Post\EditForm')
                             ->disableOriginalConstructor()
                             ->getMock();

        $this->postEditForm = $postEditForm;

        /** @var \Zend\Authentication\AuthenticationService $authenticationService */
        $authenticationService = $this->getMock('Zend\Authentication\AuthenticationService');

        $this->authenticationService = $authenticationService;

        /** @var \Eye4web\Zf2Board\Options\ModuleOptionsInterface $moduleOptions */
        $moduleOptions = $this->getMock('Eye4web\Zf2Board\Options\ModuleOptions');

        $this->authenticationService = $authenticationService;

        $eventManager = $this->getMock('Zend\EventManager\EventManager');
        $this->eventManager = $eventManager;

        $controller = new BoardController(
            $boardService,
            $topicService,
            $postService,
            $boardCreateForm,
            $topicCreateForm,
            $postCreateForm,
            $postEditForm,
            $authenticationService,
            $moduleOptions
        );

        $controller->setPluginManager($pluginManager);
        $controller->setEventManager($eventManager);

        $this->controller = $controller;
    }

    public function testBoardListAction()
    {
        $this->eventManager->expects($this->at(0))
            ->method('trigger')
            ->with('page.view', $this->controller, [
                'page' => 'boardList',
        ]);

        $this->boardService->expects($this->once())
                           ->method('findAll')
                           ->willReturn([]);

        $result = $this->controller->boardListAction();

        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
    }

    public function testBoardActionBoardNotExisting()
    {
        $this->eventManager->expects($this->at(0))
            ->method('trigger')
            ->with('page.view', $this->controller, [
                'page' => 'board',
            ]);

        $this->boardService->expects($this->once())
                           ->method('find')
                           ->willReturn(null);

        $this->setExpectedException('Exception');

        $this->controller->boardAction();
    }

    public function testBoardActionBoardExistsWrongSlug()
    {
        $this->eventManager->expects($this->at(0))
            ->method('trigger')
            ->with('page.view', $this->controller, [
                'page' => 'board',
            ]);

        $boardMock = $this->getMock('\Eye4web\Zf2Board\Entity\Board');
        $boardId = 1;

        $this->boardService->expects($this->once())
            ->method('find')
            ->willReturn($boardMock);

        $boardMock->expects($this->exactly(2))
            ->method('getSlug')
            ->willReturn('slug');

        $boardMock->expects($this->once())
            ->method('getId')
            ->willReturn($boardId);

        $redirect = $this->getMock('Zend\Mvc\Controller\Plugin\Redirect', ['toRoute']);

        $redirect->expects($this->once())
            ->method('toRoute')
            ->with('e4w/board/view', ['id' => $boardId, 'slug' => 'slug']);

        $this->pluginManagerPlugins['redirect'] = $redirect;

        $this->controller->boardAction();
    }

    public function testBoardActionBoardExistsCorrectSlug()
    {
        $this->eventManager->expects($this->at(0))
            ->method('trigger')
            ->with('page.view', $this->controller, [
                'page' => 'board',
            ]);

        $boardMock = $this->getMock('\Eye4web\Zf2Board\Entity\Board');
        $boardId = 1;

        $this->boardService->expects($this->once())
                           ->method('find')
                           ->willReturn($boardMock);

        $boardMock->expects($this->once())
                  ->method('getSlug')
                  ->willReturn(null);

        $boardMock->expects($this->once())
            ->method('getId')
            ->willReturn($boardId);

        $this->topicService->expects($this->once())
                           ->method('findByBoard')
                           ->with($boardId)
                           ->willReturn([]);

        $result = $this->controller->boardAction();

        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
    }

    public function testTopicActionBoardNotExisting()
    {
        $this->eventManager->expects($this->at(0))
            ->method('trigger')
            ->with('page.view', $this->controller, [
                'page' => 'topic',
            ]);

        $this->topicService->expects($this->once())
             ->method('find')
             ->willReturn(null);

        $this->setExpectedException('Exception');

        $this->controller->topicAction();
    }

    public function testTopicActionTopicExistsWrongSlug()
    {
        $this->eventManager->expects($this->at(0))
            ->method('trigger')
            ->with('page.view', $this->controller, [
                'page' => 'topic',
            ]);

        $topicMock = $this->getMock('\Eye4web\Zf2Board\Entity\Topic');
        $topicId = 1;

        $this->topicService->expects($this->once())
             ->method('find')
             ->willReturn($topicMock);

        $topicMock->expects($this->exactly(2))
                  ->method('getSlug')
                  ->willReturn('slug');

        $topicMock->expects($this->once())
                  ->method('getId')
                  ->willReturn($topicId);

        $redirect = $this->getMock('Zend\Mvc\Controller\Plugin\Redirect', ['toRoute']);

        $redirect->expects($this->once())
                 ->method('toRoute')
                 ->with('e4w/topic/view', ['id' => $topicId, 'slug' => 'slug']);

        $this->pluginManagerPlugins['redirect'] = $redirect;

        $this->controller->topicAction();
    }

    public function testTopicActionTopicExistsCorrectSlug()
    {
        $this->eventManager->expects($this->at(0))
            ->method('trigger')
            ->with('page.view', $this->controller, [
                'page' => 'topic',
            ]);

        $topicMock = $this->getMock('\Eye4web\Zf2Board\Entity\Topic');
        $topicId = 1;
        $redirectUrl = 'url';
        $postData = [];
        $identity = $this->getMock('\Eye4web\Zf2Board\Entity\UserInterface');

        $this->topicService->expects($this->once())
             ->method('find')
             ->willReturn($topicMock);

        $topicMock->expects($this->exactly(2))
            ->method('getSlug')
            ->willReturn(null);

        $topicMock->expects($this->exactly(2))
                  ->method('getId')
                  ->willReturn($topicId);

        $this->postService->expects($this->once())
             ->method('findByTopic')
             ->with($topicId)
             ->willReturn([]);

        $url = $this->getMock('Zend\Mvc\Controller\Plugin\Url', ['fromRoute']);

        $url->expects($this->once())
            ->method('fromRoute')
            ->with('e4w/topic/view', ['id' => $topicId, 'slug' => null])
            ->willReturn($redirectUrl);

        $this->pluginManagerPlugins['url'] = $url;

        $prg = $this->getMock('Zend\Mvc\Controller\Plugin\PostRedirectGet', ['__invoke']);

        $prg->expects($this->once())
            ->method('__invoke')
            ->willReturn($postData);

        $this->pluginManagerPlugins['prg'] = $prg;

        $this->authenticationService->expects($this->once())
                                    ->method('getIdentity')
                                    ->willReturn($identity);

        $this->postService->expects($this->once())
                          ->method('create')
                          ->with($postData, $topicMock, $identity)
                          ->willReturn(false);

        $result = $this->controller->topicAction();

        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
    }

    public function testTopicActionTopicExistsCorrectSlugPost()
    {
        $this->eventManager->expects($this->at(0))
            ->method('trigger')
            ->with('page.view', $this->controller, [
                'page' => 'topic',
            ]);

        $topicMock = $this->getMock('\Eye4web\Zf2Board\Entity\Topic');
        $topicId = 1;
        $redirectUrl = 'url';
        $postData = [];
        $identity = $this->getMock('\Eye4web\Zf2Board\Entity\UserInterface');

        $this->topicService->expects($this->once())
             ->method('find')
             ->willReturn($topicMock);

        $topicMock->expects($this->exactly(2))
            ->method('getSlug')
            ->willReturn(null);

        $topicMock->expects($this->exactly(2))
                  ->method('getId')
                  ->willReturn($topicId);

        $this->postService->expects($this->once())
             ->method('findByTopic')
             ->with($topicId)
             ->willReturn([]);

        $url = $this->getMock('Zend\Mvc\Controller\Plugin\Url', ['fromRoute']);

        $url->expects($this->once())
            ->method('fromRoute')
            ->with('e4w/topic/view', ['id' => $topicId, 'slug' => null])
            ->willReturn($redirectUrl);

        $this->pluginManagerPlugins['url'] = $url;

        $prg = $this->getMock('Zend\Mvc\Controller\Plugin\PostRedirectGet', ['__invoke']);

        $prg->expects($this->once())
            ->method('__invoke')
            ->willReturn($postData);

        $this->pluginManagerPlugins['prg'] = $prg;

        $this->authenticationService->expects($this->once())
                                    ->method('getIdentity')
                                    ->willReturn($identity);

        $this->postService->expects($this->once())
                          ->method('create')
                          ->with($postData, $topicMock, $identity)
                          ->willReturn(true);

        $redirect = $this->getMock('Zend\Mvc\Controller\Plugin\Redirect', ['toUrl']);

        $redirect->expects($this->once())
                 ->method('toUrl')
                 ->with($redirectUrl);

        $this->pluginManagerPlugins['redirect'] = $redirect;

        $this->controller->topicAction();
    }

    public function testTopicCreateActionBoardNotExisting()
    {
        $this->eventManager->expects($this->at(0))
            ->method('trigger')
            ->with('page.view', $this->controller, [
                'page' => 'topicCreate',
            ]);

        $this->boardService->expects($this->once())
            ->method('find')
            ->willReturn(null);

        $this->setExpectedException('Exception');

        $this->controller->topicCreateAction();
    }

    public function testTopicCreateActionBoardExists()
    {
        $boardMock = $this->getMock('Eye4web\Zf2Board\Entity\Board');
        $identityMock = $this->getMock('Eye4web\Zf2Board\Entity\UserInterface');
        $boardId = 1;
        $redirectUrl = 'url';
        $postData = [];

        $this->boardService->expects($this->once())
                           ->method('find')
                           ->willReturn($boardMock);

        $boardMock->expects($this->once())
                  ->method('getId')
                  ->willReturn($boardId);

        $this->authenticationService->expects($this->once())
                                    ->method('getIdentity')
                                    ->willReturn($identityMock);

        $url = $this->getMock('Zend\Mvc\Controller\Plugin\Url', ['fromRoute']);

        $url->expects($this->once())
            ->method('fromRoute')
            ->with('e4w/topic/create', ['board' => $boardId])
            ->willReturn($redirectUrl);

        $this->pluginManagerPlugins['url'] = $url;

        $prg = $this->getMock('Zend\Mvc\Controller\Plugin\PostRedirectGet', ['__invoke']);

        $prg->expects($this->once())
            ->method('__invoke')
            ->willReturn($postData);

        $this->pluginManagerPlugins['prg'] = $prg;

        $this->topicService->expects($this->once())
                           ->method('create')
                           ->with($postData, $boardMock, $identityMock)
                           ->willReturn(false);

        $result = $this->controller->topicCreateAction();

        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
    }

    public function testTopicCreateActionBoardExistsPost()
    {
        $boardMock = $this->getMock('Eye4web\Zf2Board\Entity\Board');
        $topicMock = $this->getMock('Eye4web\Zf2Board\Entity\Topic');
        $identityMock = $this->getMock('Eye4web\Zf2Board\Entity\UserInterface');
        $boardId = 1;
        $redirectUrl = 'url';
        $postData = [];
        $topicId = 1;
        $topicSlug = 'slug';

        $this->boardService->expects($this->once())
                           ->method('find')
                           ->willReturn($boardMock);

        $boardMock->expects($this->once())
                  ->method('getId')
                  ->willReturn($boardId);

        $this->authenticationService->expects($this->once())
                                    ->method('getIdentity')
                                    ->willReturn($identityMock);

        $url = $this->getMock('Zend\Mvc\Controller\Plugin\Url', ['fromRoute']);

        $url->expects($this->once())
            ->method('fromRoute')
            ->with('e4w/topic/create', ['board' => $boardId])
            ->willReturn($redirectUrl);

        $this->pluginManagerPlugins['url'] = $url;

        $prg = $this->getMock('Zend\Mvc\Controller\Plugin\PostRedirectGet', ['__invoke']);

        $prg->expects($this->once())
            ->method('__invoke')
            ->willReturn($postData);

        $this->pluginManagerPlugins['prg'] = $prg;

        $this->topicService->expects($this->once())
                           ->method('create')
                           ->with($postData, $boardMock, $identityMock)
                           ->willReturn($topicMock);

        $topicMock->expects($this->once())
                  ->method('getId')
                  ->willReturn($topicId);

        $topicMock->expects($this->once())
                  ->method('getSlug')
                  ->willReturn($topicSlug);

        $redirect = $this->getMock('Zend\Mvc\Controller\Plugin\Redirect', ['toRoute']);

        $redirect->expects($this->once())
                 ->method('toRoute')
                 ->with('e4w/topic/view', ['id' => $topicId, 'slug' => $topicSlug]);

        $this->pluginManagerPlugins['redirect'] = $redirect;

        $this->controller->topicCreateAction();
    }

    public function testPostEditNotSignedIn()
    {
        $this->authenticationService->expects($this->once())
            ->method('hasIdentity')
            ->willReturn(false);

        $this->setExpectedException('Exception');

        $this->controller->postEditAction();
    }

    public function testPostEditPostNotExisting()
    {
        $this->authenticationService->expects($this->once())
            ->method('hasIdentity')
            ->willReturn(true);

        $this->postService->expects($this->once())
                          ->method('find')
                          ->willReturn(false);

        $this->setExpectedException('Exception');

        $this->controller->postEditAction();
    }

    public function testPostEditPostUsersNotIdentical()
    {
        $postMock = $this->getMock('\Eye4web\Zf2Board\Entity\Post');
        $identityMock = $this->getMock('Eye4web\Zf2Board\Entity\UserInterface');
        $userOne = 1;
        $userTwo = 2;

        $this->authenticationService->expects($this->once())
            ->method('hasIdentity')
            ->willReturn(true);

        $this->postService->expects($this->once())
                          ->method('find')
                          ->willReturn($postMock);

        $postMock->expects($this->once())
                 ->method('getUser')
                 ->willReturn($userOne);

        $this->authenticationService->expects($this->once())
                                    ->method('getIdentity')
                                    ->willReturn($identityMock);

        $identityMock->expects($this->once())
                     ->method('getId')
                     ->willReturn($userTwo);

        $this->setExpectedException('Exception');

        $this->controller->postEditAction();
    }

    public function testPostEditPostSuccess()
    {
        $topicMock = $this->getMock('\Eye4web\Zf2Board\Entity\Topic');
        $identityMock = $this->getMock('\Eye4web\Zf2Board\Entity\UserInterface');
        $postMock = $this->getMock('\Eye4web\Zf2Board\Entity\Post');
        $postId = 1;
        $topicId = 1;
        $topicSlug = 'slug';
        $redirectUrl = 'url';
        $postData = [];
        $userOne = 1;
        $userTwo = 1;

        $this->authenticationService->expects($this->once())
            ->method('hasIdentity')
            ->willReturn(true);

        $this->postService->expects($this->once())
                          ->method('find')
                          ->willReturn($postMock);

        $postMock->expects($this->once())
                 ->method('getUser')
                 ->willReturn($userOne);

        $this->authenticationService->expects($this->once())
                                    ->method('getIdentity')
                                    ->willReturn($identityMock);

        $identityMock->expects($this->once())
                     ->method('getId')
                     ->willReturn($userTwo);

        $postMock->expects($this->once())
                 ->method('getId')
                 ->willReturn($postId);

        $url = $this->getMock('Zend\Mvc\Controller\Plugin\Url', ['fromRoute']);

        $url->expects($this->once())
            ->method('fromRoute')
            ->with('e4w/post/edit', ['id' => $postId])
            ->willReturn($redirectUrl);

        $this->pluginManagerPlugins['url'] = $url;

        $prg = $this->getMock('Zend\Mvc\Controller\Plugin\PostRedirectGet', ['__invoke']);

        $prg->expects($this->once())
            ->method('__invoke')
            ->willReturn($postData);

        $this->pluginManagerPlugins['prg'] = $prg;

        $this->authenticationService->expects($this->once())
                                    ->method('getIdentity')
                                    ->willReturn($identityMock);

        $this->topicService->expects($this->once())
            ->method('find')
            ->willReturn($topicMock);

        $this->postService->expects($this->once())
                          ->method('update')
                          ->with($postData, $topicMock, $identityMock)
                          ->willReturn($postMock);

        $topicMock->expects($this->once())
                  ->method('getId')
                  ->willReturn($topicId);

        $topicMock->expects($this->once())
                  ->method('getSlug')
                  ->willReturn($topicSlug);

        $redirect = $this->getMock('Zend\Mvc\Controller\Plugin\Redirect', ['toRoute']);

        $redirect->expects($this->once())
            ->method('toRoute')
            ->with('e4w/topic/view', ['id' => $topicId, 'slug' => $topicSlug]);

        $this->pluginManagerPlugins['redirect'] = $redirect;

        $this->controller->postEditAction();
    }

    public function testPostDeleteNotSignedIn()
    {
        $this->authenticationService->expects($this->once())
            ->method('hasIdentity')
            ->willReturn(false);

        $this->setExpectedException('Exception');

        $this->controller->postDeleteAction();
    }

    public function testPostDeletePostNotExisting()
    {
        $this->authenticationService->expects($this->once())
            ->method('hasIdentity')
            ->willReturn(true);

        $this->postService->expects($this->once())
                          ->method('find')
                          ->willReturn(false);

        $this->setExpectedException('Exception');

        $this->controller->postDeleteAction();
    }

    public function testPostDeletePostUsersNotIdentical()
    {
        $postMock = $this->getMock('\Eye4web\Zf2Board\Entity\Post');
        $identityMock = $this->getMock('Eye4web\Zf2Board\Entity\UserInterface');
        $userOne = 1;
        $userTwo = 2;

        $this->authenticationService->expects($this->once())
            ->method('hasIdentity')
            ->willReturn(true);

        $this->postService->expects($this->once())
                          ->method('find')
                          ->willReturn($postMock);

        $postMock->expects($this->once())
                 ->method('getUser')
                 ->willReturn($userOne);

        $this->authenticationService->expects($this->once())
                                    ->method('getIdentity')
                                    ->willReturn($identityMock);

        $identityMock->expects($this->once())
                     ->method('getId')
                     ->willReturn($userTwo);

        $this->setExpectedException('Exception');

        $this->controller->postDeleteAction();
    }

    public function testPostDeletePostSuccess()
    {
        $topicMock = $this->getMock('\Eye4web\Zf2Board\Entity\Topic');
        $identityMock = $this->getMock('\Eye4web\Zf2Board\Entity\UserInterface');
        $postMock = $this->getMock('\Eye4web\Zf2Board\Entity\Post');
        $postId = 1;
        $topicId = 1;
        $topicSlug = 'slug';
        $redirectUrl = 'url';
        $userOne = 1;
        $userTwo = 1;

        $this->authenticationService->expects($this->once())
            ->method('hasIdentity')
            ->willReturn(true);

        $this->postService->expects($this->once())
                          ->method('find')
                          ->willReturn($postMock);

        $postMock->expects($this->once())
                 ->method('getUser')
                 ->willReturn($userOne);

        $this->authenticationService->expects($this->once())
                                    ->method('getIdentity')
                                    ->willReturn($identityMock);

        $identityMock->expects($this->once())
                     ->method('getId')
                     ->willReturn($userTwo);

        $postMock->expects($this->once())
                 ->method('getId')
                 ->willReturn($postId);

        $url = $this->getMock('Zend\Mvc\Controller\Plugin\Url', ['fromRoute']);

        $url->expects($this->once())
            ->method('fromRoute')
            ->with('e4w/topic/view', ['id' => $topicId, 'slug' => $topicSlug])
            ->willReturn($redirectUrl);

        $this->pluginManagerPlugins['url'] = $url;

        $this->authenticationService->expects($this->once())
                                    ->method('getIdentity')
                                    ->willReturn($identityMock);

        $this->topicService->expects($this->once())
             ->method('find')
             ->willReturn($topicMock);

        $this->postService->expects($this->once())
                          ->method('delete')
                          ->with($postId)
                          ->willReturn(true);

        $topicMock->expects($this->once())
                  ->method('getId')
                  ->willReturn($topicId);

        $topicMock->expects($this->once())
                  ->method('getSlug')
                  ->willReturn($topicSlug);

        $redirect = $this->getMock('Zend\Mvc\Controller\Plugin\Redirect', ['toUrl']);

        $redirect->expects($this->once())
                 ->method('toUrl')
                 ->with($redirectUrl);

        $this->pluginManagerPlugins['redirect'] = $redirect;

        $this->controller->postDeleteAction();
    }

    public function helperMockCallbackPluginManagerGet($key)
    {
        return (array_key_exists($key, $this->pluginManagerPlugins))
            ? $this->pluginManagerPlugins[$key]
            : null;
    }
}
