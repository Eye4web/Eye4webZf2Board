<?php

namespace Eye4web\Zf2BoardTest\Options;

use Eye4web\Zf2Board\Options\ModuleOptions;
use PHPUnit_Framework_TestCase;

class ModuleOptionsTest extends PHPUnit_Framework_TestCase
{
    /** @var \Eye4web\Zf2Board\Options\ModuleOptions */
    protected $options;

    public function setUp()
    {
        $options = new ModuleOptions([]);
        $this->options = $options;
    }

    public function testCorrectEntities()
    {
        $options = $this->options;
        $before = 'Eye4web\Zf2Board\Entity\Board';
        $after = '\Eye4web\Zf2Board\Entity\Board';

        $result = $options->correctEntity($before);

        $this->assertSame($after, $result);
    }
}
