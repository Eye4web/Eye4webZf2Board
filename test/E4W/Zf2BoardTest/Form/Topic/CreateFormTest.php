<?php

namespace E4W\Zf2BoardTest\Form\Topic;

use E4W\Zf2Board\Form\Topic\CreateForm;
use PHPUnit_Framework_TestCase;

class CreateFormTest extends PHPUnit_Framework_TestCase
{
    /** @var CreateForm */
    protected $form;

    public function setUp()
    {
        /** @var \E4W\Zf2Board\Entity\TopicInterface $object */
        $object = $this->getMock('\E4W\Zf2Board\Entity\Topic');

        $this->form = new CreateForm($object);
    }

    public function testHasElements()
    {
        $form = $this->form;

        $this->assertTrue($form->has('name'));
        $this->assertTrue($form->has('csrf'));
        $this->assertTrue($form->has('text'));
        $this->assertTrue($form->has('submit'));
    }
}