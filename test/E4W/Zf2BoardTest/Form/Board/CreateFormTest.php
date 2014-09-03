<?php

namespace E4W\Zf2BoardTest\Form\Board;

use E4W\Zf2Board\Form\Board\CreateForm;
use PHPUnit_Framework_TestCase;

class CreateFormTest extends PHPUnit_Framework_TestCase
{
    /** @var CreateForm */
    protected $form;

    public function setUp()
    {
        /** @var \E4W\Zf2Board\Entity\BoardInterface $object */
        $object = $this->getMock('\E4W\Zf2Board\Entity\Board');

        $this->form = new CreateForm($object);
    }

    public function testHasElements()
    {
        $form = $this->form;

        $this->assertTrue($form->has('name'));
        $this->assertTrue($form->has('submit'));
    }
}
