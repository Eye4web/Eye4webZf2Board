<?php

namespace E4W\Zf2BoardTest\Factory\Service;

use E4W\Zf2Board\Factory\Service\BoardServiceFactory;
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
        $boardMapper = 'E4W\Zf2Board\Mapper\BoardMapperInterface';

        $moduleOptions = $this->getMock('E4W\Zf2Board\Options\ModuleOptions');

        $this->serviceLocator->expects($this->at(0))
                             ->method('get')
                             ->with('E4W\Zf2Board\Options\ModuleOptions')
                             ->willReturn($moduleOptions);

        $moduleOptions->expects($this->once())
                      ->method('getBoardMapper')
                      ->willReturn($boardMapper);

        $boardMapperMock = $this->getMock($boardMapper);

        $this->serviceLocator->expects($this->at(1))
                             ->method('get')
                             ->with($boardMapper)
                             ->willReturn($boardMapperMock);

        $boardCreateForm = $this->getMockBuilder('E4W\Zf2Board\Form\Board\CreateForm')
                                ->disableOriginalConstructor()
                                ->getMock();

        $this->serviceLocator->expects($this->at(2))
                             ->method('get')
                             ->with('E4W\Zf2Board\Form\Board\CreateForm')
                             ->willReturn($boardCreateForm);

        $result = $this->factory->createService($this->serviceLocator);

        $this->assertInstanceOf('E4W\Zf2Board\Service\BoardService', $result);
    }
}
