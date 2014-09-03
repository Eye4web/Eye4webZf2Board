<?php

namespace E4W\Zf2BoardTest\Factory\Service;

use E4W\Zf2Board\Factory\Service\AuthorServiceFactory;
use Zend\Mvc\Controller\ControllerManager;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthorServiceFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var AuthorServiceFactory */
    protected $factory;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    public function setUp()
    {
        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->serviceLocator = $serviceLocator;

        $factory = new AuthorServiceFactory;
        $this->factory = $factory;
    }

    public function testCreateService()
    {
        $authorMapper = 'E4W\Zf2Board\Mapper\AuthorMapperInterface';

        $moduleOptions = $this->getMock('E4W\Zf2Board\Options\ModuleOptions');

        $this->serviceLocator->expects($this->at(0))
                             ->method('get')
                             ->with('E4W\Zf2Board\Options\ModuleOptions')
                             ->willReturn($moduleOptions);

        $moduleOptions->expects($this->once())
                      ->method('getAuthorMapper')
                      ->willReturn($authorMapper);

        $authorMapperMock = $this->getMock($authorMapper);

        $this->serviceLocator->expects($this->at(1))
                             ->method('get')
                             ->with($authorMapper)
                             ->willReturn($authorMapperMock);

        $result = $this->factory->createService($this->serviceLocator);

        $this->assertInstanceOf('E4W\Zf2Board\Service\AuthorService', $result);
    }
}
