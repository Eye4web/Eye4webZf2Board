<?php

namespace E4W\Zf2BoardTest\Service;

use E4W\Zf2Board\Options\ModuleOptions;
use PHPUnit_Framework_TestCase;

class ModuleOptionsTest extends PHPUnit_Framework_TestCase
{
    /** @var ModuleOptions */
    protected $moduleOptions;

    public function setUp()
    {
        /** @var ModuleOptions $options */
        $options = new ModuleOptions;
        $this->moduleOptions = $options;
    }

    public function testBoardEntity()
    {
        $string = 'string';

        $this->moduleOptions->setBoardEntity($string);
        $result = $this->moduleOptions->getBoardEntity();

        $this->assertSame($string, $result);
    }

    public function testBoardMapper()
    {
        $string = 'string';

        $this->moduleOptions->setBoardMapper($string);
        $result = $this->moduleOptions->getBoardMapper();

        $this->assertSame($string, $result);
    }
}