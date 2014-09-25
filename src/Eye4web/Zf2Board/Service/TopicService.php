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

use Eye4web\Zf2Board\Entity\BoardInterface;
use Eye4web\Zf2Board\Entity\TopicInterface;
use Eye4web\Zf2Board\Entity\UserInterface;
use Eye4web\Zf2Board\Mapper\TopicMapperInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;

class TopicService implements EventManagerAwareInterface
{
    use EventManagerAwareTrait;
    
    /** @var TopicMapperInterface */
    protected $topicMapper;

    /** @var \Zend\Form\Form */
    protected $topicCreateForm;

    public function __construct(TopicMapperInterface $topicMapper, $topicCreateForm)
    {
        $this->topicMapper = $topicMapper;
        $this->topicCreateForm = $topicCreateForm;
    }

    /**
     * @param int $id
     * @return TopicInterface
     */
    public function find($id)
    {
        return $this->topicMapper->find($id);
    }

    /**
     * @return TopicInterface[]
     */
    public function findAll()
    {
        return $this->topicMapper->findAll();
    }

    /**
     * @param int $id
     * @return \Eye4web\Zf2Board\Entity\TopicInterface[]
     */
    public function findByBoard($id)
    {
        return $this->topicMapper->findByBoard($id);
    }

    /**
     * @param int $id
     * @return boolean
     */
    public function delete($id)
    {
        return $this->topicMapper->delete($id);
    }

    /**
     * @param array $data
     * @param BoardInterface $board
     * @param UserInterface $user
     * @return \Eye4web\Zf2Board\Entity\TopicInterface|null
     */
    public function create(array $data, BoardInterface $board, UserInterface $user)
    {
        $form = $this->topicCreateForm;
        $form->setData($data);

        $this->getEventManager()->trigger('create.pre', $this, [
            'data' => $data,
            'board' => $board,
            'user' => $user,
        ]);

        $topic = $this->topicMapper->create($form, $board, $user);

        $this->getEventManager()->trigger('create.post', $this, [
            'data' => $data,
            'board' => $board,
            'user' => $user,
            'topic' => $topic,
        ]);

        return $topic;
    }

    /**
     * @param array $data
     * @param TopicInterface $topic
     * @return bool|TopicInterface
     */
    public function edit(array $data, TopicInterface $topic)
    {
        $form = $this->topicCreateForm;
        $form->bind($topic);

        $form->setData($data);

        $form->remove('csrf');
        $form->getInputFilter()->remove('csrf');

        return $this->topicMapper->edit($form);
    }
}
