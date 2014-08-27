<?php

namespace E4W\Zf2BoardTest\Service;

use E4W\Zf2Board\Service\BoardService;
use PHPUnit_Framework_TestCase;

class BoardServiceTest extends PHPUnit_Framework_TestCase
{
    protected $boardMapper;

    protected $boardService;

    public function setUp()
    {
        $mapper = $this->getMock('E4W\Zf2Board\Mapper\BoardMapperInterface');
        $this->boardMapper = $mapper;

        $service = new BoardService($mapper);
        $this->boardService = $service;
    }

    /*
    public function testFind()
    {
        $this->boardMapper->expects()

    */
}