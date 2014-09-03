<?php

namespace E4W\Zf2BoardTest\Mapper\DoctrineORM;

use E4W\Zf2Board\Mapper\DoctrineORM\AuthorMapper;
use PHPUnit_Framework_TestCase;

class AuthorMapperTest extends PHPUnit_Framework_TestCase
{
    /** @var AuthorMapper */
    protected $mapper;

    /** @var \Doctrine\ORM\EntityManager */
    protected $objectManager;

    /** @var \E4W\Zf2Board\Options\ModuleOptionsInterface */
    protected $options;

    public function setUp()
    {
        /** @var \Doctrine\ORM\EntityManager $objectManager */
        $objectManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->objectManager = $objectManager;

        /** @var \E4W\Zf2Board\Options\ModuleOptionsInterface $options */
        $options = $this->getMock('E4W\Zf2Board\Options\ModuleOptions');

        $this->options = $options;

        $mapper = new AuthorMapper($objectManager, $options);

        $this->mapper = $mapper;
    }

    public function testFind()
    {
        $objectRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $authorEntity = 'E4W\Zf2Board\Entity\Author';
        $author = $this->getMock($authorEntity);
        $authorId = 1;

        $this->options->expects($this->once())
                      ->method('getAuthorEntity')
                      ->willReturn($authorEntity);

        $this->objectManager->expects($this->once())
                            ->method('getRepository')
                            ->with($authorEntity)
                            ->willReturn($objectRepository);

        $objectRepository->expects($this->once())
                         ->method('find')
                         ->with($authorId)
                         ->willReturn($author);

        $result = $this->mapper->find($authorId);

        $this->assertSame($author, $result);
    }
}
