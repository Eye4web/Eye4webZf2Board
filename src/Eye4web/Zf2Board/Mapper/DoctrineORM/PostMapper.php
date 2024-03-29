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

use Eye4web\Zf2Board\Entity\PostInterface;
use Eye4web\Zf2Board\Entity\TopicInterface;
use Eye4web\Zf2Board\Entity\UserInterface;
use Eye4web\Zf2Board\Mapper\PostMapperInterface;
use Eye4web\Zf2Board\Options\ModuleOptionsInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\Form\FormInterface;

class PostMapper implements PostMapperInterface, EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    /** @var \Doctrine\ORM\EntityManager */
    protected $objectManager;

    /** @var ModuleOptionsInterface */
    protected $options;

    public function __construct(
        \Doctrine\Persistence\ObjectManager $objectManager,
        ModuleOptionsInterface $options
    ) {
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
        ], ['created' => 'ASC']);
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
        $post->setTopic($topic);

        $this->getEventManager()->trigger('create.pre', $this, [
            'form' => $form,
            'post' => $post,
            'user' => $user,
        ]);

        $post = $this->save($post);

        $this->getEventManager()->trigger('create.post', $this, [
            'form' => $form,
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
        $post->setTopic($topic);

        $this->getEventManager()->trigger('update.pre', $this, [
            'form' => $form,
            'post' => $post,
            'user' => $user,
        ]);

        $post = $this->save($post);

        $this->getEventManager()->trigger('update.post', $this, [
            'form' => $form,
            'post' => $post,
            'user' => $user,
        ]);

        return $post;
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete($id)
    {
        $post = $this->find($id);

        if (!$post) {
            throw new \Exception('The post does not exist');
        }

        $this->getEventManager()->trigger('delete.pre', $this, [
            'post' => $post,
        ]);

        $this->objectManager->remove($post);
        $this->objectManager->flush();

        return true;
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
