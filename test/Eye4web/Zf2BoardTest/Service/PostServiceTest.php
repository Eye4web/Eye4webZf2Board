<?php

namespace Eye4web\Zf2BoardTest\Options;

use Eye4web\Zf2Board\Service\PostService;
use PHPUnit_Framework_TestCase;

class PostServiceTest extends PHPUnit_Framework_TestCase
{
    /** @var PostService */
    protected $service;

    /** @var \Eye4web\Zf2Board\Mapper\PostMapperInterface */
    protected $mapper;

    /** @var \Zend\Form\Form */
    protected $postCreateForm;

    /** @var \Zend\Form\Form */
    protected $postEditForm;

    public function setUp()
    {
        /** @var \Eye4web\Zf2Board\Mapper\PostMapperInterface $mapper */
        $mapper = $this->getMock('\Eye4web\Zf2Board\Mapper\PostMapperInterface');
        $this->mapper = $mapper;

        /** @var \Zend\Form\Form $postCreateForm */
        $postCreateForm = $this->getMockBuilder('\Eye4web\Zf2Board\Form\Post\CreateForm')
                               ->disableOriginalConstructor()
                               ->getMock();

        $this->postCreateForm = $postCreateForm;

        /** @var \Zend\Form\Form $postEditForm */
        $postEditForm = $this->getMockBuilder('\Eye4web\Zf2Board\Form\Post\EditForm')
                             ->disableOriginalConstructor()
                             ->getMock();

        $this->postEditForm = $postEditForm;

        $service = new PostService($mapper, $postCreateForm, $postEditForm);
        $this->service = $service;
    }

    public function testFind()
    {
        $id = 1;

        $this->mapper->expects($this->once())
                     ->method('find')
                     ->with($id);

        $this->service->find($id);
    }

    public function testFindByTopic()
    {
        $id = 1;

        $this->mapper->expects($this->once())
                     ->method('find')
                     ->with($id);

        $this->service->find($id);
    }

    public function testCreate()
    {
        $data = [];

        /** @var \Eye4web\Zf2Board\Entity\UserInterface $userMock */
        $userMock = $this->getMock('Eye4web\Zf2Board\Entity\UserInterface');

        /** @var \Eye4web\Zf2Board\Entity\TopicInterface $topicMock */
        $topicMock = $this->getMock('Eye4web\Zf2Board\Entity\Topic');

        $postCreateForm = $this->postCreateForm;

        $postCreateForm->expects($this->once())
                        ->method('setData')
                        ->with($data);

        $this->mapper->expects($this->once())
                     ->method('create');

        $this->service->create($data, $topicMock, $userMock);
    }

    public function testUpdate()
    {
        $data = [];

        /** @var \Eye4web\Zf2Board\Entity\UserInterface $userMock */
        $userMock = $this->getMock('Eye4web\Zf2Board\Entity\UserInterface');

        /** @var \Eye4web\Zf2Board\Entity\TopicInterface $topicMock */
        $topicMock = $this->getMock('Eye4web\Zf2Board\Entity\Topic');

        $postEditForm = $this->postEditForm;

        $postEditForm->expects($this->once())
                     ->method('setData')
                     ->with($data);

        $this->mapper->expects($this->once())
                     ->method('update');

        $this->service->update($data, $topicMock, $userMock);
    }
}
