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

use Eye4web\Zf2Board\Entity\UserInterface;
use Eye4web\Zf2Board\Mapper\AuthorMapperInterface;
use Eye4web\Zf2Board\Options\ModuleOptionsInterface;

class AuthorMapper implements AuthorMapperInterface
{
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
     * @return UserInterface|null
     */
    public function find($id)
    {
        return $this->objectManager->getRepository($this->options->getAuthorEntity())->find($id);
    }
}
