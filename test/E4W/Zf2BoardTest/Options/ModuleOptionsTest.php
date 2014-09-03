<?php

namespace E4W\Zf2BoardTest\Options;

use E4W\Zf2Board\Options\ModuleOptions;
use PHPUnit_Framework_TestCase;

class ModuleOptionsTest extends PHPUnit_Framework_TestCase
{
    /** @var \E4W\Zf2Board\Options\ModuleOptions */
    protected $options;

    public function setUp()
    {
        $options = new ModuleOptions([]);
        $this->options = $options;
    }

    public function testCorrectEntities()
    {
        $options = $this->options;
        $before = 'E4W\Zf2Board\Entity\Board';
        $after = '\E4W\Zf2Board\Entity\Board';

        $result = $options->correctEntity($before);

        $this->assertSame($after, $result);
    }
}
