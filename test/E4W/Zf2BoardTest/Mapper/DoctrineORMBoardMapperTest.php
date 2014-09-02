<?php

namespace E4W\Zf2BoardTest\Mapper;

use E4W\Zf2Board\Mapper\DoctrineORM\BoardMapper;
use PHPUnit_Framework_TestCase;

class BoardMapperTest extends PHPUnit_Framework_TestCase
{
    /** @var \E4W\Zf2Board\Mapper\DoctrineORM\BoardMapper */
    protected $mapper;

    /** @var \Doctrine\Common\Persistence\ObjectManager */
    protected $objectManager;

    /** @var \E4W\Zf2Board\Options\ModuleOptionsInterface */
    protected $moduleOptions;

    public function setUp()
    {
        /** @var \Doctrine\Common\Persistence\ObjectManager $objectManager */
        $objectManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->objectManager = $objectManager;

        /** @var \E4W\Zf2Board\Options\ModuleOptionsInterface $moduleOptions */
        $moduleOptions = $this->getMock('E4W\Zf2Board\Options\ModuleOptionsInterface');
        $this->moduleOptions = $moduleOptions;

        $mapper = new BoardMapper($objectManager, $moduleOptions);
        $this->mapper = $mapper;
    }

    public function testFind()
    {
        $id = 1;

        $boardEntity = $this->getMock('\E4W\Zf2Board\Entity\BoardInterface');
        $objectRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');

        $this->moduleOptions->expects($this->once())
                            ->method('getBoardEntity')
                            ->willReturn('\E4W\Zf2Board\Entity\BoardInterface');

        $this->objectManager->expects($this->once())
                            ->method('getRepository')
                            ->with('\E4W\Zf2Board\Entity\BoardInterface')
                            ->willReturn($objectRepository);

        $objectRepository->expects($this->once())
                         ->method('find')
                         ->with($id)
                         ->willReturn($boardEntity);

        $result = $this->mapper->find($id);

        $this->assertSame($boardEntity, $result);
    }

    public function testFindAll()
    {
        $return = [];

        $objectRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');

        $this->moduleOptions->expects($this->once())
                            ->method('getBoardEntity')
                            ->willReturn('\E4W\Zf2Board\Entity\BoardInterface');

        $this->objectManager->expects($this->once())
                            ->method('getRepository')
                            ->with('\E4W\Zf2Board\Entity\BoardInterface')
                            ->willReturn($objectRepository);

        $objectRepository->expects($this->once())
                         ->method('findAll')
                         ->willReturn($return);

        $result = $this->mapper->findAll();

        $this->assertSame($return, $result);
    }

    public function testDeleteWithWrongBoardId()
    {
        $id = 1;

        $objectRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');

        $this->moduleOptions->expects($this->once())
            ->method('getBoardEntity')
            ->willReturn('\E4W\Zf2Board\Entity\BoardInterface');

        $this->objectManager->expects($this->once())
            ->method('getRepository')
            ->with('\E4W\Zf2Board\Entity\BoardInterface')
            ->willReturn($objectRepository);

        $objectRepository->expects($this->once())
                         ->method('find')
                         ->with($id)
                         ->willReturn(null);

        $this->setExpectedException('Exception', 'The board does not exist');

        $this->mapper->delete($id);
    }

    public function testDeleteWithExistingBoardId()
    {
        $id = 1;

        $boardEntity = $this->getMock('\E4W\Zf2Board\Entity\BoardInterface');
        $objectRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');

        $this->moduleOptions->expects($this->once())
            ->method('getBoardEntity')
            ->willReturn('\E4W\Zf2Board\Entity\BoardInterface');

        $this->objectManager->expects($this->once())
            ->method('getRepository')
            ->with('\E4W\Zf2Board\Entity\BoardInterface')
            ->willReturn($objectRepository);

        $objectRepository->expects($this->once())
                         ->method('find')
                         ->with($id)
                         ->willReturn($boardEntity);

        $result = $this->mapper->delete($id);

        $this->assertTrue($result);
    }
}