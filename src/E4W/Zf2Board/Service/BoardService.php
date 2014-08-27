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

namespace E4W\Zf2Board\Service;

use E4W\Zf2Board\Mapper\BoardMapperInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;

class BoardService implements EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    /** @var BoardMapperInterface */
    protected $boardMapper;

    public function __construct(BoardMapperInterface $boardMapper)
    {
        $this->boardMapper = $boardMapper;
    }

    /**
     * @param int $id
     * @return \E4W\Zf2Board\Entity\BoardInterface
     */
    public function find($id)
    {
        return $this->boardMapper->find($id);
    }

    /**
     * @return \E4W\Zf2Board\Entity\BoardInterface[]
     */
    public function findAll()
    {
        return $this->boardMapper->findAll();
    }

    /**
     * @param $id
     * @return boolean
     */
    public function delete($id)
    {
        return $this->boardMapper->delete($id);
    }

    public function create(array $data)
    {
        return false;
    }
}
