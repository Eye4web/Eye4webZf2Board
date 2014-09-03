<?php

namespace E4W\Zf2BoardTest\Options;

use E4W\Zf2Board\Service\BoardService;
use PHPUnit_Framework_TestCase;

class BoardServiceTest extends PHPUnit_Framework_TestCase
{
    /** @var BoardService */
    protected $service;

    /** @var \E4W\Zf2Board\Mapper\AuthorMapperInterface */
    protected $mapper;

    /** @var \Zend\Form\Form */
    protected $boardCreateForm;

    public function setUp()
    {
        /** @var \E4W\Zf2Board\Mapper\BoardMapperInterface $mapper */
        $mapper = $this->getMock('\E4W\Zf2Board\Mapper\BoardMapperInterface');
        $this->mapper = $mapper;

        /** @var \Zend\Form\Form $form */
        $boardCreateForm = $this->getMock('\E4W\Zf2Board\Form\Board\CreateForm');
        $this->boardCreateForm = $boardCreateForm;

        $service = new BoardService($mapper, $boardCreateForm);
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

        /** @var \E4W\Zf2Board\Entity\UserInterface $userMock */
        $userMock = $this->getMock('E4W\Zf2Board\Entity\UserInterface');

        $boardCreateForm = $this->boardCreateForm;

        $boardCreateForm->expects($this->once())
                        ->method('setData')
                        ->with($data);

        $this->mapper->expects($this->once())
                     ->method('create')
                     ->with($boardCreateForm, $userMock);

        $this->service->create($data, $userMock);
    }
}