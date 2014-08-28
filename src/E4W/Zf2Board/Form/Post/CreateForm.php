<?php
namespace E4W\Zf2Board\Form\Post;

use Doctrine\Common\Persistence\ObjectManager;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class CreateForm extends Form implements InputFilterProviderInterface
{
    /** @var \Doctrine\ORM\EntityManager */
    protected $objectManager;

    public function __construct(ObjectManager $objectManager, $name = 'create-board')
    {
        parent::__construct($name);

        $this->objectManager = $objectManager;

        $this->add([
            'name' => 'text',
            'type'  => 'Zend\Form\Element\Textarea',
            'options' => [
                'label' => 'Post',
            ],
            'attributes' => [
                'class' => 'small form-control',
                'placeholder' => 'Post text'
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Button',
            'attributes' => [
                'type' => 'submit',
                'class' => 'btn btn-success',
            ],
        ]);
    }

    public function getInputFilterSpecification()
    {
        return [
            [
                'name' => 'text',
                'required' => true,
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 5000,
                        ],
                    ],
                ],
            ],
        ];
    }
}
