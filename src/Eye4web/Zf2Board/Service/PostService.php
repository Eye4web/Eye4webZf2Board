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

namespace Eye4web\Zf2Board\Service;

use Eye4web\Zf2Board\Entity\PostInterface;
use Eye4web\Zf2Board\Entity\TopicInterface;
use Eye4web\Zf2Board\Entity\UserInterface;
use Eye4web\Zf2Board\Mapper\PostMapperInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\Form\Form;

class PostService implements EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    /** @var PostMapperInterface */
    protected $postMapper;

    /** @var Form */
    protected $postCreateForm;

    /** @var Form */
    protected $postEditForm;

    public function __construct(PostMapperInterface $postMapper, Form $postCreateForm, Form $postEditForm)
    {
        $this->postMapper = $postMapper;
        $this->postCreateForm = $postCreateForm;
        $this->postEditForm = $postEditForm;
    }

    /**
     * @param int $id
     * @return PostInterface
     */
    public function find($id)
    {
        return $this->postMapper->find($id);
    }

    /**
     * @param int $topicId
     * @return PostInterface[]
     */
    public function findByTopic($topicId)
    {
        return $this->postMapper->findByTopic($topicId);
    }

    /**
     * @param array $data
     * @param TopicInterface $topic
     * @param UserInterface $user
     * @return bool|PostInterface
     */
    public function create(array $data, TopicInterface $topic, UserInterface $user)
    {
        $form = $this->postCreateForm;
        $form->setData($data);

        return $this->postMapper->create($form, $topic, $user);
    }

    /**
     * @param array $data
     * @param TopicInterface $topic
     * @param UserInterface $user
     * @return bool|PostInterface
     */
    public function update(array $data, TopicInterface $topic, UserInterface $user)
    {
        $form = $this->postEditForm;
        $form->setData($data);

        return $this->postMapper->update($form, $topic, $user);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        return $this->postMapper->delete($id);
    }
}
