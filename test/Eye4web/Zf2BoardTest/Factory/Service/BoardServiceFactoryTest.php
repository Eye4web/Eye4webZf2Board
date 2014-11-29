<?php

namespace Eye4web\Zf2BoardTest\Factory\Service;

use Eye4web\Zf2Board\Factory\Service\BoardServiceFactory;
use Zend\Mvc\Controller\ControllerManager;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceLocatorInterface;

class BoardServiceFactoryTest extends PHPUnit_Framework_TestCase
{
    /** @var BoardServiceFactory */
    protected $factory;

    /** @var ServiceLocatorInterface */
    protected $serviceLocator;

    public function setUp()
    {
        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->serviceLocator = $serviceLocator;

        $factory = new BoardServiceFactory;
        $this->factory = $factory;
    }

    public function testCreateService()
    {
        $boardMapper = 'Eye4web\Zf2Board\Mapper\BoardMapperInterface';

        $moduleOptions = $this->getMock('Eye4web\Zf2Board\Options\ModuleOptions');

        $this->serviceLocator->expects($this->at(0))
                             ->method('get')
                             ->with('Eye4web\Zf2Board\Options\ModuleOptions')
                             ->willReturn($moduleOptions);

        $moduleOptions->expects($this->once())
                      ->method('getBoardMapper')
                      ->willReturn($boardMapper);

        $boardMapperMock = $this->getMock($boardMapper);

        $this->serviceLocator->expects($this->at(1))
                             ->method('get')
                             ->with($boardMapper)
                             ->willReturn($boardMapperMock);

        $result = $this->factory->createService($this->serviceLocator);

        $this->assertInstanceOf('Eye4web\Zf2Board\Service\BoardService', $result);
    }
}
