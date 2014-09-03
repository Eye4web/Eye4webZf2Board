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

use E4W\Zf2Board\Entity\PostInterface;
use E4W\Zf2Board\Entity\TopicInterface;
use E4W\Zf2Board\Entity\UserInterface;
use E4W\Zf2Board\Mapper\PostMapperInterface;
use E4W\Zf2Board\Options\ModuleOptionsInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;

class PostMapper implements PostMapperInterface, EventManagerAwareInterface
{
    use EventManagerAwareTrait;

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
     * @return PostInterface|null
     */
    public function find($id)
    {
        return $this->objectManager->getRepository($this->options->getPostEntity())->find($id);
    }

    /**
     * @param int $topicId
     * @return PostInterface[]|array
     */
    public function findByTopic($topicId)
    {
        return $this->objectManager->getRepository($this->options->getPostEntity())->findBy([
            'topic' => $topicId
        ]);
    }

    /**
     * @param $form
     * @param TopicInterface $topic
     * @param UserInterface $user
     * @return bool|PostInterface
     */
    public function create($form, TopicInterface $topic, UserInterface $user)
    {
        if (!$form->isValid()) {
            return false;
        }

        /** @var PostInterface $post */
        $post = $form->getData();

        $post->setUser($user->getId());
        $post->setTopic($topic->getId());

        $this->getEventManager()->trigger('create.pre', $this, [
            'post' => $post,
            'user' => $user,
        ]);

        $post = $this->save($post);

        $this->getEventManager()->trigger('create.post', $this, [
            'post' => $post,
            'user' => $user,
        ]);

        return $post;
    }

    /**
     * @param $form
     * @param TopicInterface $topic
     * @param UserInterface $user
     * @return bool|PostInterface
     */
    public function update($form, TopicInterface $topic, UserInterface $user)
    {
        if (!$form->isValid()) {
            return false;
        }

        /** @var PostInterface $post */
        $post = $form->getData();

        $post->setUser($user->getId());
        $post->setTopic($topic->getId());

        $this->getEventManager()->trigger('update.pre', $this, [
            'post' => $post,
            'user' => $user,
        ]);

        $post = $this->save($post);

        $this->getEventManager()->trigger('update.post', $this, [
            'post' => $post,
            'user' => $user,
        ]);

        return $post;
    }

    /**
     * @param PostInterface $post
     * @return PostInterface
     */
    public function save(PostInterface $post)
    {
        $this->objectManager->persist($post);
        $this->objectManager->flush();

        return $post;
    }
}