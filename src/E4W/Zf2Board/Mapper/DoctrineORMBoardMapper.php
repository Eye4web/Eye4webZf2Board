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

namespace E4W\Zf2Board\Mapper;

use E4W\Zf2Board\Entity\BoardInterface;
use E4W\Zf2Board\Mapper\BoardMapperInterface;
use E4W\Zf2Board\Options\ModuleOptionsInterface;

class DoctrineORMBoardMapper implements BoardMapperInterface
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
     * @return BoardInterface|null
     */
    public function find($id)
    {
        return $this->objectManager->getRepository($this->options->getBoardEntity())->find($id);
    }

    /**
     * @return BoardInterface[]
     */
    public function findAll()
    {
        return $this->objectManager->getRepository($this->options->getBoardEntity())->findAll();
    }

    /**
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function delete($id)
    {
        $board = $this->find($id);

        if (!$board) {
            throw new \Exception('The board does not exist');
        }

        $this->objectManager->remove($board);
        $this->objectManager->flush();

        return true;
    }

    /**
     * @param $form
     * @return bool|BoardInterface
     */
    public function create($form)
    {
        if (!$form->isValid()) {
            return false;
        }

        /** @var BoardInterface $board */
        $board = $form->getData();

        $this->objectManager->persist($board);
        $this->objectManager->flush();

        return $board;
    }
}