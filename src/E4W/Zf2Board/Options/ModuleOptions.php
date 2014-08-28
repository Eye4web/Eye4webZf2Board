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

namespace E4W\Zf2Board\Options;

use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions implements ModuleOptionsInterface
{
    /**
     * @var string
     */
    protected $boardEntity = 'E4W\Zf2Board\Entity\Board';

    /**
     * @var string
     */
    protected $boardMapper = 'E4W\Zf2Board\Mapper\DoctrineORMBoardMapper';

    /**
     * @var string
     */
    protected $topicEntity = 'E4W\Zf2Board\Entity\Topic';

    /**
     * @var string
     */
    protected $topicMapper = 'E4W\Zf2Board\Mapper\DoctrineORMTopicMapper';

    /** @var AuthenticationService */
    protected $authenticationService = null;

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
     * @param boolean $_strictMode__
     */
    public function setStrictMode($_strictMode__)
    {
        $this->__strictMode__ = $_strictMode__;
    }

    /**
     * @return boolean
     */
    public function getStrictMode()
    {
        return $this->__strictMode__;
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
     * @param AuthenticationService $authenticationService
     */
    public function setAuthenticationService($authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    /**
     * @return AuthenticationService
     */
    public function getAuthenticationService()
    {
        return $this->authenticationService;
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
}
