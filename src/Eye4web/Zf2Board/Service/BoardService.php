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
use Eye4web\Zf2Board\Entity\UserInterface;
use Eye4web\Zf2Board\Mapper\BoardMapperInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\Form\FormInterface;

class BoardService implements EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    /** @var BoardMapperInterface */
    protected $boardMapper;

    /** @var FormInterface */
    protected $boardCreateForm;

    public function __construct(BoardMapperInterface $boardMapper, $boardCreateForm)
    {
        $this->boardMapper = $boardMapper;
        $this->boardCreateForm = $boardCreateForm;
    }

    /**
     * @param int $id
     * @return BoardInterface
     */
    public function find($id)
    {
        return $this->boardMapper->find($id);
    }

    /**
     * @return BoardInterface[]
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

    /**
     * @param array $data
     * @param UserInterface $user
     * @return bool|BoardInterface
     */
    public function create(array $data, UserInterface $user)
    {
        $form = $this->boardCreateForm;
        $form->setData($data);

        return $this->boardMapper->create($form, $user);
    }

    /**
     * @param array $data
     * @param BoardInterface $board
     * @return bool|BoardInterface
     */
    public function edit(array $data, BoardInterface $board)
    {
        $form = $this->boardCreateForm;
        $form->bind($board);

        $form->setData($data);

        return $this->boardMapper->edit($form);
    }
}
