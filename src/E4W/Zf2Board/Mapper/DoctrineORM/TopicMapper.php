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

namespace E4W\Zf2Board\Mapper\DoctrineORM;

use E4W\Zf2Board\Entity\BoardInterface;
use E4W\Zf2Board\Entity\TopicInterface;
use E4W\Zf2Board\Entity\UserInterface;
use E4W\Zf2Board\Mapper\TopicMapperInterface;
use E4W\Zf2Board\Options\ModuleOptionsInterface;

class TopicMapper implements TopicMapperInterface
{
    /** @var \Doctrine\ORM\EntityManager */
    protected $objectManager;

    /** @var ModuleOptionsInterface */
    protected $options;

    public function __construct(\Doctrine\Common\Persistence\ObjectManager $objectManager, ModuleOptionsInterface $options)
    {
        $this->objectManager = $objectManager;
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
        return $this->objectManager->getRepository($this->options->getTopicEntity())->findAll();
    }

    /**
     * @param int $boardId
     * @return array|\E4W\Zf2Board\Entity\TopicInterface[]
     */
    public function findByBoard($boardId)
    {
        return $this->objectManager->getRepository($this->options->getTopicEntity())->findBy([
            'board' => $boardId,
        ]);
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

        $this->objectManager->remove($topic);
        $this->objectManager->flush();

        return true;
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

        /** @var TopicInterface $board */
        $topic = $form->getData();
        $topic->setUser($user);

        return $this->save($topic);
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