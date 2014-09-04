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

namespace Eye4web\Zf2Board\Options;

use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions implements ModuleOptionsInterface
{
    /** @var string */
    protected $boardEntity = 'Eye4web\Zf2Board\Entity\Board';

    /** @var string */
    protected $boardMapper = 'Eye4web\Zf2Board\Mapper\DoctrineORM\BoardMapper';

    /** @var string */
    protected $topicEntity = 'Eye4web\Zf2Board\Entity\Topic';

    /** @var string */
    protected $topicMapper = 'Eye4web\Zf2Board\Mapper\DoctrineORM\TopicMapper';

    /** @var string */
    protected $postEntity = 'Eye4web\Zf2Board\Entity\Post';

    /** @var string */
    protected $postMapper = 'Eye4web\Zf2Board\Mapper\DoctrineORM\PostMapper';

    /** @var null */
    protected $authorEntity = null;

    /** @var string */
    protected $authorMapper = 'Eye4web\Zf2Board\Mapper\DoctrineORM\AuthorMapper';

    /** @var AuthenticationService */
    protected $authenticationService = null;

    /** @var int */
    protected $topicsPerBoard = 25;

    /** @var int */
    protected $postsPerTopic = 15;

    /**
     * Ensure that the entity has the correct name
     *
     * @param $entityClass
     * @return string
     */
    public function correctEntity($entityClass)
    {
        if (substr($entityClass, 0, 1) !== '\\') {
            $entityClass = '\\' . $entityClass;
        }

        return $entityClass;
    }

    /**
     * @param string $topicMapper
     */
    public function setTopicMapper($topicMapper)
    {
        $this->topicMapper = $topicMapper;
    }

    /**
     * @return string
     */
    public function getTopicMapper()
    {
        return $this->topicMapper;
    }

    /**
     * @param \Zend\Authentication\AuthenticationService $authenticationService
     */
    public function setAuthenticationService($authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     * @return \Zend\Authentication\AuthenticationService
     */
    public function getAuthenticationService()
    {
        return $this->authenticationService;
    }

    /**
     * @param null $authorEntity
     */
    public function setAuthorEntity($authorEntity)
    {
        $this->authorEntity = $authorEntity;
    }

    /**
     * @return null
     */
    public function getAuthorEntity()
    {
        return $this->correctEntity($this->authorEntity);
    }

    /**
     * @param string $authorMapper
     */
    public function setAuthorMapper($authorMapper)
    {
        $this->authorMapper = $authorMapper;
    }

    /**
     * @return string
     */
    public function getAuthorMapper()
    {
        return $this->authorMapper;
    }

    /**
     * @param string $boardEntity
     */
    public function setBoardEntity($boardEntity)
    {
        $this->boardEntity = $boardEntity;
    }

    /**
     * @return string
     */
    public function getBoardEntity()
    {
        return $this->correctEntity($this->boardEntity);
    }

    /**
     * @param string $boardMapper
     */
    public function setBoardMapper($boardMapper)
    {
        $this->boardMapper = $boardMapper;
    }

    /**
     * @return string
     */
    public function getBoardMapper()
    {
        return $this->boardMapper;
    }

    /**
     * @param string $postEntity
     */
    public function setPostEntity($postEntity)
    {
        $this->postEntity = $postEntity;
    }

    /**
     * @return string
     */
    public function getPostEntity()
    {
        return $this->correctEntity($this->postEntity);
    }

    /**
     * @param string $postMapper
     */
    public function setPostMapper($postMapper)
    {
        $this->postMapper = $postMapper;
    }

    /**
     * @return string
     */
    public function getPostMapper()
    {
        return $this->postMapper;
    }

    /**
     * @param string $topicEntity
     */
    public function setTopicEntity($topicEntity)
    {
        $this->topicEntity = $topicEntity;
    }

    /**
     * @return string
     */
    public function getTopicEntity()
    {
        return $this->correctEntity($this->topicEntity);
    }

    /**
     * @param int $topicsPerBoard
     */
    public function setTopicsPerBoard($topicsPerBoard)
    {
        $this->topicsPerBoard = $topicsPerBoard;
    }

    /**
     * @return int
     */
    public function getTopicsPerBoard()
    {
        return $this->topicsPerBoard;
    }

    /**
     * @param int $postsPerTopic
     */
    public function setPostsPerTopic($postsPerTopic)
    {
        $this->postsPerTopic = $postsPerTopic;
    }

    /**
     * @return int
     */
    public function getPostsPerTopic()
    {
        return $this->postsPerTopic;
    }
}
