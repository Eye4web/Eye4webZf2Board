<?php

namespace E4W\Zf2BoardTest\Form\Post;

use E4W\Zf2Board\Form\Post\CreateForm;
use PHPUnit_Framework_TestCase;

class CreateFormTest extends PHPUnit_Framework_TestCase
{
    /** @var CreateForm */
    protected $form;

    public function setUp()
    {
        /** @var \E4W\Zf2Board\Entity\PostInterface $object */
        $object = $this->getMock('\E4W\Zf2Board\Entity\Post');

        $this->form = new CreateForm($object);
    }

    public function testHasElements()
    {
        $form = $this->form;

        $this->assertTrue($form->has('text'));
        $this->assertTrue($form->has('csrf'));
        $this->assertTrue($form->has('submit'));
    }
}