<?php

namespace Eye4web\Zf2BoardTest\Options;

use Eye4web\Zf2Board\Service\BoardService;
use PHPUnit_Framework_TestCase;

class BoardServiceTest extends PHPUnit_Framework_TestCase
{
    /** @var BoardService */
    protected $service;

    /** @var \Eye4web\Zf2Board\Mapper\AuthorMapperInterface */
    protected $mapper;

    /** @var \Zend\Form\Form */
    protected $boardCreateForm;

    public function setUp()
    {
        /** @var \Eye4web\Zf2Board\Mapper\BoardMapperInterface $mapper */
        $mapper = $this->getMock('\Eye4web\Zf2Board\Mapper\BoardMapperInterface');

        $this->mapper = $mapper;

        /** @var \Zend\Form\Form $form */
        $boardCreateForm = $this->getMockBuilder('\Eye4web\Zf2Board\Form\Board\CreateForm')
                                ->disableOriginalConstructor()
                                ->getMock();

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

        $this->service->findAll();
    }
}
