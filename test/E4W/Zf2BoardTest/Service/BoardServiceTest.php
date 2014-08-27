<?php

namespace E4W\Zf2BoardTest\Service;

use E4W\Zf2Board\Service\BoardService;
use PHPUnit_Framework_TestCase;

class BoardServiceTest extends PHPUnit_Framework_TestCase
{
    /** @var \E4W\Zf2Board\Mapper\BoardMapperInterface */
    protected $boardMapper;

    /** @var \E4W\Zf2Board\Service\BoardService */
    protected $boardService;

    public function setUp()
    {
        /** @var \E4W\Zf2Board\Mapper\BoardMapperInterface $mapper */
        $mapper = $this->getMock('E4W\Zf2Board\Mapper\BoardMapperInterface');
        $this->boardMapper = $mapper;

        $service = new BoardService($mapper);
        $this->boardService = $service;
    }

    public function testFind()
    {
        $id = 1;
        $return = new \E4W\Zf2Board\Entity\Board;

        $this->boardMapper->expects($this->once())
                          ->method('find')
                          ->with($id)
                          ->willReturn($return);

        $result = $this->boardService->find($id);

        $this->assertSame($return, $result);
    }

    public function testFindAll()
    {
        $return = [];

        $this->boardMapper->expects($this->once())
                          ->method('findAll')
                          ->willReturn($return);

        $result = $this->boardService->findAll();

        $this->assertSame($return, $result);
    }

    public function testDeleteSuccess()
    {
        $id = 1;

        $this->boardMapper->expects($this->once())
            ->method('delete')
            ->with($id)
            ->willReturn(true);

        $result = $this->boardService->delete($id);

        $this->assertTrue($result);
    }

    public function testDeleteFail()
    {
        $id = 1;

        $this->boardMapper->expects($this->once())
                          ->method('delete')
                          ->with($id)
                          ->willReturn(false);

        $result = $this->boardService->delete($id);

        $this->assertFalse($result);
    }
}