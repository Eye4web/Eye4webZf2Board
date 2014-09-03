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

namespace E4W\Zf2Board\View\Helper;

use E4W\Zf2Board\Service\AuthorService;
use Zend\Authentication\AuthenticationService;
use Zend\View\Helper\AbstractHelper;

class BoardHelper extends AbstractHelper
{
    /** @var AuthorService */
    protected $authorService;

    /** @var AuthenticationService */
    protected $auth;

    public function __construct(AuthorService $authorService, AuthenticationService $authenticationService)
    {
        $this->authorService = $authorService;
        $this->auth = $authenticationService;
    }

    public function __invoke()
    {
        return $this;
    }

    /**
     * @param int $id
     * @return \E4W\Zf2Board\Entity\UserInterface
     */
    public function getAuthor($id)
    {
        return $this->authorService->find($id);
    }

    /**
     * @return AuthenticationService
     */
    public function getAuth()
    {
        return $this->auth;
    }
}
