<?php

namespace Eye4web\Zf2BoardTest\Mapper\DoctrineORM;

use Eye4web\Zf2Board\Mapper\DoctrineORM\PostMapper;
use PHPUnit_Framework_TestCase;

class PostMapperTest extends PHPUnit_Framework_TestCase
{
    /** @var PostMapper */
    protected $mapper;

    /** @var \Doctrine\ORM\EntityManager */
    protected $objectManager;

    /** @var \Eye4web\Zf2Board\Options\ModuleOptionsInterface */
    protected $options;

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

        $eventManager = $this->getMock('Zend\EventManager\EventManager');

        $this->eventManager = $eventManager;

        $mapper = new PostMapper($objectManager, $options);
        $mapper->setEventManager($eventManager);

        $this->mapper = $mapper;
    }

    public function testFind()
    {
        $objectRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $postEntity = 'Eye4web\Zf2Board\Entity\Post';
        $postMock = $this->getMock($postEntity);
        $postId = 1;

        $this->options->expects($this->once())
                      ->method('getPostEntity')
                      ->willReturn($postEntity);

        $this->objectManager->expects($this->once())
                            ->method('getRepository')
                            ->with($postEntity)
                            ->willReturn($objectRepository);

        $objectRepository->expects($this->once())
                         ->method('find')
                         ->with($postId)
                         ->willReturn($postMock);

        $result = $this->mapper->find($postId);

        $this->assertSame($postMock, $result);
    }

    public function testFindByTopic()
    {
        /** @var \Doctrine\Common\Persistence\ObjectRepository $objectRepository */
        $objectRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');

        $topicId = 1;
        $postEntity = 'Eye4web\Zf2Board\Entity\Post';
        $posts = [];

        $this->options->expects($this->once())
                      ->method('getPostEntity')
                      ->willReturn($postEntity);

        $this->objectManager->expects($this->once())
                            ->method('getRepository')
                            ->with($postEntity)
                            ->willReturn($objectRepository);

        $objectRepository->expects($this->once())
                         ->method('findBy')
                         ->with(['topic' => $topicId])
                         ->willReturn($posts);

        $result = $this->mapper->findByTopic($topicId);

        $this->assertSame($posts, $result);
    }

    public function testCreateNotValid()
    {
        /** @var \Zend\Form\Form $form */
        $form = $this->getMockBuilder('Eye4web\Zf2Board\Form\Post\CreateForm')
                     ->disableOriginalConstructor()
                     ->getMock();

        /** @var \Eye4web\Zf2Board\Entity\TopicInterface $topicMock */
        $topicMock = $this->getMock('Eye4web\Zf2Board\Entity\Topic');

        /** @var \Eye4web\Zf2Board\Entity\UserInterface $userMock */
        $userMock = $this->getMock('Eye4web\Zf2Board\Entity\UserInterface');

        $form->expects($this->once())
             ->method('isValid')
             ->willReturn(false);

        $result = $this->mapper->create($form, $topicMock, $userMock);

        $this->assertFalse($result);
    }

    public function testCreateValid()
    {
        /** @var \Zend\Form\Form $form */
        $form = $this->getMockBuilder('Eye4web\Zf2Board\Form\Post\CreateForm')
                     ->disableOriginalConstructor()
                     ->getMock();

        /** @var \Eye4web\Zf2Board\Entity\TopicInterface $topicMock */
        $topicMock = $this->getMock('Eye4web\Zf2Board\Entity\Topic');
        $topicId = 1;

        /** @var \Eye4web\Zf2Board\Entity\UserInterface $userMock */
        $userMock = $this->getMock('Eye4web\Zf2Board\Entity\UserInterface');
        $userId = 1;

        /** @var \Eye4web\Zf2Board\Entity\PostInterface $postMock */
        $postMock = $this->getMock('Eye4web\Zf2Board\Entity\Post');

        $form->expects($this->once())
             ->method('isValid')
             ->willReturn(true);

        $form->expects($this->once())
             ->method('getData')
             ->willReturn($postMock);

        $userMock->expects($this->once())
                 ->method('getId')
                 ->willReturn($userId);

        $postMock->expects($this->once())
                 ->method('setUser')
                 ->with($userId);

        $topicMock->expects($this->once())
                  ->method('getId')
                  ->willReturn($topicId);

        $postMock->expects($this->once())
                 ->method('setTopic')
                 ->with($topicId);

        $this->eventManager->expects($this->at(0))
                           ->method('trigger')
                           ->with('create.pre', $this->mapper, [
                'post' => $postMock,
                'user' => $userMock
        ]);

        $this->eventManager->expects($this->at(1))
                           ->method('trigger')
                           ->with('create.post', $this->mapper, [
                'post' => $postMock,
                'user' => $userMock
        ]);

        $this->objectManager->expects($this->once())
                            ->method('persist')
                            ->with($postMock);

        $this->objectManager->expects($this->once())
                            ->method('flush');

        $result = $this->mapper->create($form, $topicMock, $userMock);

        $this->assertSame($postMock, $result);
    }

    public function testUpdateNotValid()
    {
        /** @var \Zend\Form\Form $form */
        $form = $this->getMockBuilder('Eye4web\Zf2Board\Form\Post\CreateForm')
                     ->disableOriginalConstructor()
                     ->getMock();

        /** @var \Eye4web\Zf2Board\Entity\TopicInterface $topicMock */
        $topicMock = $this->getMock('Eye4web\Zf2Board\Entity\Topic');

        /** @var \Eye4web\Zf2Board\Entity\UserInterface $userMock */
        $userMock = $this->getMock('Eye4web\Zf2Board\Entity\UserInterface');

        $form->expects($this->once())
             ->method('isValid')
             ->willReturn(false);

        $result = $this->mapper->update($form, $topicMock, $userMock);

        $this->assertFalse($result);
    }

    public function testUpdateValid()
    {
        /** @var \Zend\Form\Form $form */
        $form = $this->getMockBuilder('Eye4web\Zf2Board\Form\Post\CreateForm')
                     ->disableOriginalConstructor()
                     ->getMock();

        /** @var \Eye4web\Zf2Board\Entity\TopicInterface $topicMock */
        $topicMock = $this->getMock('Eye4web\Zf2Board\Entity\Topic');
        $topicId = 1;

        /** @var \Eye4web\Zf2Board\Entity\UserInterface $userMock */
        $userMock = $this->getMock('Eye4web\Zf2Board\Entity\UserInterface');
        $userId = 1;

        /** @var \Eye4web\Zf2Board\Entity\PostInterface $postMock */
        $postMock = $this->getMock('Eye4web\Zf2Board\Entity\Post');

        $form->expects($this->once())
             ->method('isValid')
             ->willReturn(true);

        $form->expects($this->once())
             ->method('getData')
             ->willReturn($postMock);

        $userMock->expects($this->once())
                 ->method('getId')
                 ->willReturn($userId);

        $postMock->expects($this->once())
                 ->method('setUser')
                 ->with($userId);

        $topicMock->expects($this->once())
                  ->method('getId')
                  ->willReturn($topicId);

        $postMock->expects($this->once())
                 ->method('setTopic')
                 ->with($topicId);

        $this->eventManager->expects($this->at(0))
                           ->method('trigger')
                           ->with('update.pre', $this->mapper, [
                'post' => $postMock,
                'user' => $userMock
        ]);

        $this->eventManager->expects($this->at(1))
                           ->method('trigger')
                           ->with('update.post', $this->mapper, [
                'post' => $postMock,
                'user' => $userMock
        ]);

        $this->objectManager->expects($this->once())
                            ->method('persist')
                            ->with($postMock);

        $this->objectManager->expects($this->once())
                            ->method('flush');

        $result = $this->mapper->update($form, $topicMock, $userMock);

        $this->assertSame($postMock, $result);
    }

    public function testDeletePostNotExisting()
    {
        $objectRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $postEntity = 'Eye4web\Zf2Board\Entity\Post';
        $postId = 1;

        $this->options->expects($this->once())
            ->method('getPostEntity')
            ->willReturn($postEntity);

        $this->objectManager->expects($this->at(0))
            ->method('getRepository')
            ->with($postEntity)
            ->willReturn($objectRepository);

        $this->options->expects($this->once())
            ->method('getPostEntity')
            ->willReturn($postEntity);

        $this->objectManager->expects($this->at(0))
            ->method('getRepository')
            ->with($postEntity)
            ->willReturn($objectRepository);

        $objectRepository->expects($this->once())
            ->method('find')
            ->with($postId)
            ->willReturn(false);

        $this->setExpectedException('Exception');

        $this->mapper->delete($postId);
    }

    public function testDeletePostSuccess()
    {
        $objectRepository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $postEntity = 'Eye4web\Zf2Board\Entity\Post';
        $postMock = $this->getMock($postEntity);
        $postId = 1;

        $this->options->expects($this->once())
            ->method('getPostEntity')
            ->willReturn($postEntity);

        $this->objectManager->expects($this->once())
            ->method('getRepository')
            ->with($postEntity)
            ->willReturn($objectRepository);

        $objectRepository->expects($this->once())
                         ->method('find')
                         ->with($postId)
                         ->willReturn($postMock);

        $this->objectManager->expects($this->once())
                            ->method('remove')
                            ->with($postMock);

        $this->objectManager->expects($this->once())
                            ->method('flush');

        $result = $this->mapper->delete($postId);
    }

    public function testSaveWrongInstance()
    {
        $this->setExpectedException('Exception');
        $this->mapper->save(null);
    }

    public function testSaveSuccess()
    {
        /** @var \Eye4web\Zf2Board\Entity\PostInterface $postMock */
        $postMock = $this->getMock('Eye4web\Zf2Board\Entity\PostInterface');

        $this->objectManager->expects($this->once())
                            ->method('persist')
                            ->with($postMock);

        $this->objectManager->expects($this->once())
                            ->method('flush');

        $result = $this->mapper->save($postMock);

        $this->assertSame($postMock, $result);
    }
}
