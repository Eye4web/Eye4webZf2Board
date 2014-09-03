<?php

namespace E4W\Zf2BoardTest\Options;

use E4W\Zf2Board\Service\PostService;
use PHPUnit_Framework_TestCase;

class PostServiceTest extends PHPUnit_Framework_TestCase
{
    /** @var PostService */
    protected $service;

    /** @var \E4W\Zf2Board\Mapper\PostMapperInterface */
    protected $mapper;

    /** @var \Zend\Form\Form */
    protected $postCreateForm;

    /** @var \Zend\Form\Form */
    protected $postEditForm;

    public function setUp()
    {
        /** @var \E4W\Zf2Board\Mapper\PostMapperInterface $mapper */
        $mapper = $this->getMock('\E4W\Zf2Board\Mapper\PostMapperInterface');
        $this->mapper = $mapper;

        /** @var \Zend\Form\Form $postCreateForm */
        $postCreateForm = $this->getMock('\E4W\Zf2Board\Form\Post\CreateForm');
        $this->postCreateForm = $postCreateForm;

        /** @var \Zend\Form\Form $postEditForm */
        $postEditForm = $this->getMock('\E4W\Zf2Board\Form\Post\EditForm');
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

        /** @var \E4W\Zf2Board\Entity\UserInterface $userMock */
        $userMock = $this->getMock('E4W\Zf2Board\Entity\UserInterface');

        /** @var \E4W\Zf2Board\Entity\TopicInterface $topicMock */
        $topicMock = $this->getMock('E4W\Zf2Board\Entity\Topic');

        $postCreateForm = $this->postCreateForm;

        $postCreateForm->expects($this->once())
                        ->method('setData')
                        ->with($data);

        $this->mapper->expects($this->once())
                     ->method('create')
                     ->with($postCreateForm, $userMock);

        $this->service->create($data, $topicMock, $userMock);
    }

    public function testUpdate()
    {
        $data = [];

        /** @var \E4W\Zf2Board\Entity\UserInterface $userMock */
        $userMock = $this->getMock('E4W\Zf2Board\Entity\UserInterface');

        /** @var \E4W\Zf2Board\Entity\TopicInterface $topicMock */
        $topicMock = $this->getMock('E4W\Zf2Board\Entity\Topic');

        $postCreateForm = $this->postCreateForm;

        $postCreateForm->expects($this->once())
                        ->method('setData')
                        ->with($data);

        $this->mapper->expects($this->once())
                     ->method('update')
                     ->with($postCreateForm, $userMock);

        $this->service->create($data, $topicMock, $userMock);
    }
}