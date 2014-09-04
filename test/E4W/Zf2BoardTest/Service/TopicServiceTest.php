<?php

namespace Eye4web\Zf2BoardTest\Options;

use Eye4web\Zf2Board\Service\TopicService;
use PHPUnit_Framework_TestCase;

class TopicServiceTest extends PHPUnit_Framework_TestCase
{
    /** @var TopicService */
    protected $service;

    /** @var \Eye4web\Zf2Board\Mapper\TopicMapperInterface */
    protected $mapper;

    /** @var \Zend\Form\Form */
    protected $topicCreateForm;

    /** @var \Zend\Form\Form */
    protected $postEditForm;

    public function setUp()
    {
        /** @var \Eye4web\Zf2Board\Mapper\TopicMapperInterface $mapper */
        $mapper = $this->getMock('\Eye4web\Zf2Board\Mapper\TopicMapperInterface');
        $this->mapper = $mapper;

        /** @var \Zend\Form\Form $topicCreateForm */
        $topicCreateForm = $this->getMockBuilder('\Eye4web\Zf2Board\Form\Post\CreateForm')
                                ->disableOriginalConstructor()
                                ->getMock();

        $this->topicCreateForm = $topicCreateForm;

        $service = new TopicService($mapper, $topicCreateForm);
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

    public function testFindAll()
    {
        $this->mapper->expects($this->once())
                     ->method('findAll');

        $this->service->findAll();
    }

    public function testFindByBoard()
    {
        $boardId = 1;

        $this->mapper->expects($this->once())
             ->method('findByBoard')
             ->with($boardId);

        $this->service->findByBoard($boardId);
    }

    public function testDelete()
    {
        $id = 1;

        $this->mapper->expects($this->once())
             ->method('delete')
             ->with($id);

        $this->service->delete($id);
    }

    public function testCreate()
    {
        $data = [];

        /** @var \Eye4web\Zf2Board\Entity\UserInterface $userMock */
        $userMock = $this->getMock('Eye4web\Zf2Board\Entity\UserInterface');

        /** @var \Eye4web\Zf2Board\Entity\BoardInterface $boardMock */
        $boardMock = $this->getMock('Eye4web\Zf2Board\Entity\Board');

        $topicCreateForm = $this->topicCreateForm;

        $topicCreateForm->expects($this->once())
                        ->method('setData')
                        ->with($data);

        $this->mapper->expects($this->once())
                     ->method('create');

        $this->service->create($data, $boardMock, $userMock);
    }
}
