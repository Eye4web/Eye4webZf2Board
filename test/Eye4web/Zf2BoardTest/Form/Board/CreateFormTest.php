<?php

namespace Eye4web\Zf2BoardTest\Form\Board;

use Eye4web\Zf2Board\Form\Board\CreateForm;
use PHPUnit_Framework_TestCase;

class CreateFormTest extends PHPUnit_Framework_TestCase
{
    /** @var CreateForm */
    protected $form;

    public function setUp()
    {
        /** @var \Eye4web\Zf2Board\Entity\BoardInterface $object */
        $object = $this->getMock('\Eye4web\Zf2Board\Entity\Board');

        $this->form = new CreateForm($object);
    }

    public function testHasElements()
    {
        $form = $this->form;

        $this->assertTrue($form->has('name'));
        $this->assertTrue($form->has('submit'));
    }
}
