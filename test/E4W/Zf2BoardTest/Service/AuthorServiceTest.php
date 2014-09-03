<?php

namespace E4W\Zf2BoardTest\Options;

use E4W\Zf2Board\Service\AuthorService;
use PHPUnit_Framework_TestCase;

class AuthorServiceTest extends PHPUnit_Framework_TestCase
{
    /** @var AuthorService */
    protected $service;

    /** @var \E4W\Zf2Board\Mapper\AuthorMapperInterface */
    protected $mapper;

    public function setUp()
    {
        /** @var \E4W\Zf2Board\Mapper\AuthorMapperInterface $mapper */
        $mapper = $this->getMock('\E4W\Zf2Board\Mapper\AuthorMapperInterface');
        $this->mapper = $mapper;

        $service = new AuthorService($mapper);
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
}
