<?php

namespace E4W\Zf2BoardTest\Options;

use E4W\Zf2Board\Service\SlugService;
use PHPUnit_Framework_TestCase;

class SlugServiceTest extends PHPUnit_Framework_TestCase
{
    /** @var SlugService */
    protected $service;

    public function setUp()
    {
        $service = new SlugService();
        $this->service = $service;
    }

    public function testGenerate()
    {
        $before = 'a b';
        $after = 'a-b';

        $result = $this->service->generate($before);

        $this->assertSame($after, $result);
    }

    public function testGenerateEmpty()
    {
        $result = $this->service->generate('');

        $this->assertNotEmpty($result);
    }
}