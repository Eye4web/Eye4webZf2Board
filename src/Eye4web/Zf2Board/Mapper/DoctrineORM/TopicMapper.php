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

namespace Eye4web\Zf2Board\Mapper\DoctrineORM;

use Eye4web\Zf2Board\Entity\BoardInterface;
use Eye4web\Zf2Board\Entity\TopicInterface;
use Eye4web\Zf2Board\Entity\UserInterface;
use Eye4web\Zf2Board\Mapper\TopicMapperInterface;
use Eye4web\Zf2Board\Options\ModuleOptionsInterface;
use Eye4web\Zf2Board\Service\SlugServiceInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\Form\FormInterface;

class TopicMapper implements TopicMapperInterface, EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    /** @var \Doctrine\ORM\EntityManager */
    protected $objectManager;

    /** @var SlugServiceInterface */
    protected $slugService;

    /** @var ModuleOptionsInterface */
    protected $options;

    public function __construct(
        \Doctrine\Common\Persistence\ObjectManager $objectManager,
        SlugServiceInterface $slugService,
        ModuleOptionsInterface $options
    ) {
        $this->objectManager = $objectManager;
        $this->slugService = $slugService;
        $this->options = $options;
    }

    /**
     * @param int $id
     * @return TopicInterface|null
     */
    public function find($id)
    {
        return $this->objectManager->getRepository($this->options->getTopicEntity())->find($id);
    }

    /**
     * @return array|TopicInterface[]
     */
    public function findAll()
    {
        return $this->objectManager->getRepository($this->options->getTopicEntity())->findBy([], [
            'pinned' => 'desc',
        ]);
    }

    /**
     * @param int $boardId
     * @return array|\Eye4web\Zf2Board\Entity\TopicInterface[]
     */
    public function findByBoard($boardId)
    {
        $queryBuilder = $this->objectManager->createQueryBuilder();
        $queryBuilder->select('t')
            ->from($this->options->getTopicEntity(), 't')
            ->leftJoin('t.posts', 'p')
            ->where('t.board = :boardId')
            ->addOrderBy('t.pinned', 'DESC')
            ->addOrderBy('p.created', 'DESC');

        $queryBuilder->setParameter('boardId', $boardId);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete($id)
    {
        $topic = $this->find($id);

        if (!$topic) {
            throw new \Exception('The topic does not exist');
        }

        $this->getEventManager()->trigger('delete.pre', $this, [
            'topic' => $topic,
        ]);

        $this->objectManager->remove($topic);
        $this->objectManager->flush();

        return true;
    }

    /**
     * @param int $id
     * @throws \Exception
     */
    public function pin($id)
    {
        $topic = $this->find($id);

        if (!$topic) {
            throw new \Exception('The topic does not exist');
        }

        $this->getEventManager()->trigger('pin.pre', $this, [
            'topic' => $topic,
        ]);

        $topic->setPinned(true);

        $this->objectManager->flush();
    }

    /**
     * @param int $id
     * @throws \Exception
     */
    public function unpin($id)
    {
        $topic = $this->find($id);

        if (!$topic) {
            throw new \Exception('The topic does not exist');
        }

        $this->getEventManager()->trigger('unpin.pre', $this, [
            'topic' => $topic,
        ]);

        $topic->setPinned(false);

        $this->objectManager->flush();
    }

    /**
     * @param int $id
     * @throws \Exception
     */
    public function lock($id)
    {
        $topic = $this->find($id);

        if (!$topic) {
            throw new \Exception('The topic does not exist');
        }

        $this->getEventManager()->trigger('lock.pre', $this, [
            'topic' => $topic,
        ]);

        $topic->setLocked(true);

        $this->objectManager->flush();
    }

    /**
     * @param int $id
     * @throws \Exception
     */
    public function unlock($id)
    {
        $topic = $this->find($id);

        if (!$topic) {
            throw new \Exception('The topic does not exist');
        }

        $this->getEventManager()->trigger('unlock.pre', $this, [
            'topic' => $topic,
        ]);

        $topic->setLocked(false);

        $this->objectManager->flush();
    }

    /**
     * @param $form
     * @param BoardInterface $board
     * @param UserInterface $user
     * @return bool|TopicInterface|null
     */
    public function create($form, BoardInterface $board, UserInterface $user)
    {
        if (!$form->isValid()) {
            return false;
        }

        /** @var TopicInterface $topic */
        $topic = $form->getData();

        $topic->setSlug($this->slugService->generate($topic->getName()));
        $topic->setUser($user->getId());
        $topic->setBoard($board->getId());

        $this->getEventManager()->trigger('create.pre', $this, [
            'topic' => $topic,
            'user' => $user,
            'board' => $board,
        ]);

        $topic = $this->save($topic);

        $this->getEventManager()->trigger('create.post', $this, [
            'topic' => $topic,
            'user' => $user,
            'board' => $board,
        ]);

        return $topic;
    }

    /**
     * @param FormInterface $form
     * @return bool|TopicInterface|null
     */
    public function edit(FormInterface $form)
    {
        if (!$form->isValid()) {
            return false;
        }

        /** @var TopicInterface $topic */
        $topic = $form->getData();

        $this->getEventManager()->trigger('edit.pre', $this, [
            'topic' => $topic,
        ]);

        $topic = $this->save($topic);

        $this->getEventManager()->trigger('edit.post', $this, [
            'topic' => $topic,
        ]);

        return $topic;
    }

    /**
     * @param TopicInterface $topic
     * @return TopicInterface
     */
    public function save(TopicInterface $topic)
    {
        $this->objectManager->persist($topic);
        $this->objectManager->flush();

        return $topic;
    }
}
