<?php
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