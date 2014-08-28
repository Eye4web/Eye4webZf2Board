<?php
namespace E4W\Zf2Board\Factory\Form\Topic;

use E4W\Zf2Board\Form\Topic\CreateForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CreateFormFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return CreateForm
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Doctrine\ORM\EntityManager $objectManager */
        $objectManager = $serviceLocator->get('Doctrine\ORM\EntityManager');

        $form = new CreateForm($objectManager);
        return $form;
    }
}
