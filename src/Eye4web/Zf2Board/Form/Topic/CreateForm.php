<?php

/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace Eye4web\Zf2Board\Form\Topic;

use Eye4web\Zf2Board\Entity\TopicInterface;
use Zend\Form\Element;
use Zend\InputFilter\InputFilterProviderInterface;

class CreateForm extends \ZfcBase\Form\ProvidesEventsForm implements InputFilterProviderInterface
{
    /** @var \Doctrine\ORM\EntityManager */
    protected $objectManager;

    public function __construct(TopicInterface $object, $name = 'create-topic')
    {
        parent::__construct($name);

        $this->setObject($object);
        $this->setHydrator(new \Laminas\Hydrator\ClassMethodsHydrator(false));

        $this->add([
            'name' => 'name',
            'type'  => 'Zend\Form\Element\Text',
            'options' => [
                'label' => 'Subject',
            ],
            'attributes' => [
                'class' => 'small form-control',
                'placeholder' => 'Subject'
            ],
        ]);

        $this->add([
            'name' => 'text',
            'type'  => 'Zend\Form\Element\Textarea',
            'options' => [
                'label' => 'Topic',
            ],
            'attributes' => [
                'class' => 'small form-control',
                'placeholder' => 'Topic text'
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

        $this->getEventManager()->trigger('init', $this);
    }

    public function getInputFilterSpecification()
    {
        return [
            [
                'name' => 'name',
                'required' => true,
                'filters'  => [
                    [
                        'name' => 'StripTags'
                    ],
                    [
                        'name' => 'StringTrim'
                    ],
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 255,
                        ],
                    ],
                ],
            ],
            [
                'name' => 'text',
                'required' => true,
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                        ],
                    ],
                ],
            ],
        ];
    }
}
