<?php

namespace Eye4web\Zf2BoardTest\Mapper\DoctrineORM;

use Doctrine\DBAL\Query\QueryBuilder;
use Eye4web\Zf2Board\Mapper\DoctrineORM\TopicMapper;
use PHPUnit_Framework_TestCase;

class TopicMapperTest extends PHPUnit_Framework_TestCase
{
    /** @var TopicMapper */
    protected $mapper;

    /** @var \Doctrine\ORM\EntityManager */
    protected $objectManager;

    /** @var \Eye4web\Zf2Board\Options\ModuleOptionsInterface */
    protected $options;

    /** @var \Eye4web\Zf2Board\Service\SlugServiceInterface */
    protected $slugService;

    /** @var \Zend\EventManager\EventManager */
    protected $eventManager;

    public function setUp()
    {
        /** @var \Doctrine\ORM\EntityManager $objectManager */
        $objectManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->objectManager = $objectManager;

        /** @var \Eye4web\Zf2Board\Options\ModuleOptionsInterface $options */
        $options = $this->getMock('Eye4web\Zf2Board\Options\ModuleOptions');
        $this->options = $options;

        /** @var \Eye4web\Zf2Board\Service\SlugServiceInterface $slugService */
        $slugService = $this->getMock('Eye4web\Zf2Board\Service\SlugServiceInterface');
        $this->slugService = $slugService;

        /** @var \Zend\EventManager\EventManager $eventManager */
        $eventManager = $this->getMock('Zend\EventManager\EventManager');
        $this->eventManager = $eventManager;

        $mapper = new TopicMapper($objectManager, $slugService, $options);
        $mapper->setEventManager($eventManager);

        $this->mapper = $mapper;
    }

    public function testFind()
    {
        $objectRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $topicEntity = 'Eye4web\Zf2Board\Entity\Topic';
        $topicMock = $this->getMock($topicEntity);
        $topicId = 1;

        $this->options->expects($this->once())
                      ->method('getTopicEntity')
                      ->willReturn($topicEntity);

        $this->objectManager->expects($this->once())
                            ->method('getRepository')
                            ->with($topicEntity)
                            ->willReturn($objectRepository);

        $objectRepository->expects($this->once())
                         ->method('find')
                         ->with($topicId)
                         ->willReturn($topicMock);

        $result = $this->mapper->find($topicId);

        $this->assertSame($topicMock, $result);
    }

    public function testFindAll()
    {
        $objectRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $topicEntity = 'Eye4web\Zf2Board\Entity\Topic';
        $topics = [];

        $this->options->expects($this->once())
                      ->method('getTopicEntity')
                      ->willReturn($topicEntity);

        $this->objectManager->expects($this->once())
                            ->method('getRepository')
                            ->with($topicEntity)
                            ->willReturn($objectRepository);

        $objectRepository->expects($this->once())
                         ->method('findBy')
                         ->with([], [
                             'pinned' => 'desc',
                         ])
                         ->willReturn($topics);

        $result = $this->mapper->findAll();

        $this->assertSame($topics, $result);
    }

    public function testFindByBoard()
    {
        /** @var \Doctrine\Common\Persistence\ObjectRepository $objectRepository */
        $objectRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');

        $boardId = 1;
        $topicEntity = 'Eye4web\Zf2Board\Entity\Topic';
        $topics = [];

        $this->options->expects($this->once())
                      ->method('getTopicEntity')
                      ->willReturn($topicEntity);

        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $this->getMockBuilder(QueryBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $queryBuilder->expects($this->any())
            ->method('select')
            ->willReturn($queryBuilder);
        $queryBuilder->expects($this->any())
            ->method('from')
            ->willReturn($queryBuilder);
        $queryBuilder->expects($this->any())
            ->method('leftJoin')
            ->willReturn($queryBuilder);
        $queryBuilder->expects($this->any())
            ->method('where')
            ->willReturn($queryBuilder);
        $queryBuilder->expects($this->any())
            ->method('orderBy')
            ->willReturn($queryBuilder);

        $this->objectManager->expects($this->once())
                            ->method('createQueryBuilder')
                            ->willReturn($queryBuilder);

        $result = $this->mapper->findByBoard($boardId);

        $this->assertSame($topics, $result);
    }

    public function testCreateNotValid()
    {
        /** @var \Zend\Form\Form $form */
        $form = $this->getMockBuilder('Eye4web\Zf2Board\Form\Topic\CreateForm')
                     ->disableOriginalConstructor()
                     ->getMock();

        /** @var \Eye4web\Zf2Board\Entity\BoardInterface $boardMock */
        $boardMock = $this->getMock('Eye4web\Zf2Board\Entity\Board');

        /** @var \Eye4web\Zf2Board\Entity\UserInterface $userMock */
        $userMock = $this->getMock('Eye4web\Zf2Board\Entity\UserInterface');

        $form->expects($this->once())
             ->method('isValid')
             ->willReturn(false);

        $result = $this->mapper->create($form, $boardMock, $userMock);

        $this->assertFalse($result);
    }

    public function testCreateValid()
    {
        /** @var \Zend\Form\Form $form */
        $form = $this->getMockBuilder('Eye4web\Zf2Board\Form\Topic\CreateForm')
                     ->disableOriginalConstructor()
                     ->getMock();

        /** @var \Eye4web\Zf2Board\Entity\BoardInterface $boardMock */
        $boardMock = $this->getMock('Eye4web\Zf2Board\Entity\Board');
        $boardId = 1;

        /** @var \Eye4web\Zf2Board\Entity\UserInterface $userMock */
        $userMock = $this->getMock('Eye4web\Zf2Board\Entity\UserInterface');
        $userId = 1;

        /** @var \Eye4web\Zf2Board\Entity\TopicInterface $topicMock */
        $topicMock = $this->getMock('Eye4web\Zf2Board\Entity\Topic');

        $form->expects($this->once())
             ->method('isValid')
             ->willReturn(true);

        $form->expects($this->once())
             ->method('getData')
             ->willReturn($topicMock);

        $userMock->expects($this->once())
                 ->method('getId')
                 ->willReturn($userId);

        $topicMock->expects($this->once())
                  ->method('setUser')
                  ->with($userId);

        $boardMock->expects($this->once())
                  ->method('getId')
                  ->willReturn($boardId);

        $topicMock->expects($this->once())
                  ->method('setBoard')
                  ->with($boardId);

        $this->eventManager->expects($this->at(0))
             ->method('trigger')
             ->with('create.pre', $this->mapper, [
                 'topic' => $topicMock,
                 'user' => $userMock,
                 'board' => $boardMock,
             ]);

        $this->eventManager->expects($this->at(1))
             ->method('trigger')
             ->with('create.post', $this->mapper, [
                 'topic' => $topicMock,
                 'user' => $userMock,
                 'board' => $boardMock,
             ]);

        $this->objectManager->expects($this->once())
             ->method('persist')
             ->with($topicMock);

        $this->objectManager->expects($this->once())
            ->method('flush');

        $result = $this->mapper->create($form, $boardMock, $userMock);

        $this->assertSame($topicMock, $result);
    }

    public function testSaveWrongInstance()
    {
        $this->setExpectedException('Exception');
        $this->mapper->save(null);
    }

    public function testSaveSuccess()
    {
        /** @var \Eye4web\Zf2Board\Entity\PostInterface $postMock */
        $topicMock = $this->getMock('Eye4web\Zf2Board\Entity\TopicInterface');

        $this->objectManager->expects($this->once())
             ->method('persist')
             ->with($topicMock);

        $this->objectManager->expects($this->once())
             ->method('flush');

        $result = $this->mapper->save($topicMock);

        $this->assertSame($topicMock, $result);
    }
}
