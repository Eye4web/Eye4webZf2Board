<?php

namespace E4W\Zf2BoardTest\Options;

use E4W\Zf2Board\View\Helper\BoardHelper;
use PHPUnit_Framework_TestCase;

class BoardHelperTest extends PHPUnit_Framework_TestCase
{
    /** @var BoardHelper */
    protected $helper;

    /** @var \E4W\Zf2Board\Service\AuthorService */
    protected $authorService;

    /** @var \Zend\Authentication\AuthenticationService */
    protected $authenticationService;

    public function setUp()
    {
        /** @var \E4W\Zf2Board\Service\AuthorService $authorService */
        $authorService = $this->getMockBuilder('\E4W\Zf2Board\Service\AuthorService')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->authorService = $authorService;

        /** @var \Zend\Authentication\AuthenticationService $authenticationService */
        $authenticationService = $this->getMock('\Zend\Authentication\AuthenticationService');
        $this->authenticationService = $authenticationService;

        $helper = new BoardHelper($authorService, $authenticationService);
        $this->helper = $helper;
    }

    public function testGetAuthor()
    {
        $id = 1;

        $this->authorService->expects($this->once())
                            ->method('find')
                            ->with($id);

        $this->helper->getAuthor($id);
    }

    public function testGetAuth()
    {
        $result = $this->helper->getAuth();
        $this->assertSame($this->authenticationService, $result);
    }
}