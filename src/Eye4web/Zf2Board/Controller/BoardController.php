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

namespace Eye4web\Zf2Board\Controller;

use Eye4web\Zf2Board\Options\ModuleOptionsInterface;
use Eye4web\Zf2Board\Service\BoardService;
use Eye4web\Zf2Board\Service\PostService;
use Eye4web\Zf2Board\Service\TopicService;
use Zend\Authentication\AuthenticationService;
use Zend\Form\Form;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;

class BoardController extends AbstractActionController
{
    /** @var BoardService */
    protected $boardService;

    /** @var TopicService */
    protected $topicService;

    /** @var PostService */
    protected $postService;

    /** @var Form */
    protected $boardCreateForm;

    /** @var Form */
    protected $topicCreateForm;

    /** @var Form */
    protected $postCreateForm;

    /** @var Form */
    protected $postEditForm;

    /** @var AuthenticationService */
    protected $authenticationService;

    /** @var ModuleOptionsInterface */
    protected $options;

    public function __construct(
        BoardService $boardService,
        TopicService $topicService,
        PostService $postService,
        Form $boardCreateForm,
        Form $topicCreateForm,
        Form $postCreateForm,
        Form $postEditForm,
        AuthenticationService $authenticationService,
        ModuleOptionsInterface $options
    ) {
        $this->boardService = $boardService;
        $this->boardCreateForm = $boardCreateForm;

        $this->topicService = $topicService;
        $this->topicCreateForm = $topicCreateForm;

        $this->postService = $postService;
        $this->postCreateForm = $postCreateForm;
        $this->postEditForm = $postEditForm;

        $this->authenticationService = $authenticationService;

        $this->options = $options;
    }

    public function boardListAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setTemplate('eye4web-zf2-board/board/board/list.phtml');

        $viewModel->setVariables([
            'boards' => $this->boardService->findAll()
        ]);

        return $viewModel;
    }

    public function boardAction()
    {
        $boardService = $this->boardService;
        $topicService = $this->topicService;

        $board = $boardService->find($this->params('id'));
        $slug = $this->params('slug');

        if (!$board) {
            throw new \Exception('The board does not exist');
        }

        if ($slug != $board->getSlug()) {
            return $this->redirect()->toRoute('e4w/board/view', ['id' => $board->getId(), 'slug' => $board->getSlug()]);
        }

        $topics = $topicService->findByBoard($board->getId());

        // Paginator
        $paginator = new Paginator(new ArrayAdapter($topics));
        $page = $this->params('page');

        $paginator->setDefaultItemCountPerPage($this->options->getTopicsPerBoard());
        $paginator->setCurrentPageNumber($page);

        $viewModel = new ViewModel();
        $viewModel->setTemplate('eye4web-zf2-board/board/board/view.phtml');

        $viewModel->setVariables([
            'board' => $board,
            'topics' => $paginator,
        ]);

        return $viewModel;
    }

    public function topicAction()
    {
        $boardService = $this->boardService;
        $topicService = $this->topicService;
        $postService = $this->postService;
        $postCreateForm = $this->postCreateForm;

        $topic = $topicService->find($this->params('id'));
        $slug = $this->params('slug');

        if (!$topic) {
            throw new \Exception('The topic does not exist');
        }

        if ($slug != $topic->getSlug()) {
            return $this->redirect()->toRoute('e4w/topic/view', ['id' => $topic->getId(), 'slug' => $topic->getSlug()]);
        }

        $board = $boardService->find($topic->getBoard());

        // Paginator
        $posts = $postService->findByTopic($topic->getId());
        $paginator = new Paginator(new ArrayAdapter($posts));
        $page = $this->params('page');

        $paginator->setDefaultItemCountPerPage($this->options->getPostsPerTopic());
        $paginator->setCurrentPageNumber($page);


        $viewModel = new ViewModel();
        $viewModel->setTemplate('eye4web-zf2-board/board/topic/view.phtml');

        $viewModel->setVariables([
            'board' => $board,
            'topic' => $topic,
            'posts' => $paginator,
            'postCreateForm' => $postCreateForm,
        ]);

        $redirectUrl = $this->url()->fromRoute('e4w/topic/view', [
            'id' => $topic->getId(),
            'slug' => $topic->getSlug()
        ]);

        $prg = $this->prg($redirectUrl, true);

        $identity = $this->authenticationService->getIdentity();

        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg;
        } elseif ($prg === false) {
            return $viewModel;
        }

        if (!$topic->isLocked() && $postService->create($prg, $topic, $identity)) {
            return $this->redirect()->toUrl($redirectUrl);
        }

        return $viewModel;
    }

    public function topicCreateAction()
    {
        $board = $this->boardService->find($this->params('board'));

        if (!$board) {
            throw new \Exception('The board does not exist');
        }

        $form = $this->topicCreateForm;

        $viewModel = new ViewModel();
        $viewModel->setTemplate('eye4web-zf2-board/board/topic/create.phtml');
        $viewModel->setVariable('form', $form);

        $redirectUrl = $this->url()->fromRoute('e4w/topic/create', ['board' => $board->getId()]);
        $prg = $this->prg($redirectUrl, true);

        $topicService = $this->topicService;

        $identity = $this->authenticationService->getIdentity();

        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg;
        } elseif ($prg === false) {
            return $viewModel;
        }

        if ($topic = $topicService->create($prg, $board, $identity)) {
            return $this->redirect()->toRoute('e4w/topic/view', ['id' => $topic->getId(), 'slug' => $topic->getSlug()]);
        }

        return $viewModel;
    }

    public function postEditAction()
    {
        $postService = $this->postService;
        $topicService = $this->topicService;
        $authenticationService = $this->authenticationService;

        /** @var \Eye4web\Zf2Board\Entity\UserInterface $identity */
        $identity = $authenticationService->getIdentity();

        if (!$authenticationService->hasIdentity()) {
            throw new \Exception('You need to be signed in to edit posts');
        }

        $postId = $this->params('id');
        $post = $postService->find($postId);

        if (!$post) {
            throw new \Exception('The post does not exist');
        }

        if ($post->getUser() != $identity->getId()) {
            throw new \Exception('You do not have the rights to edit this post');
        }

        $form = $this->postEditForm;
        $form->bind($post);

        $viewModel = new ViewModel();
        $viewModel->setTemplate('eye4web-zf2-board/board/post/edit.phtml');

        $viewModel->setVariables([
            'form' => $form,
            'post' => $post,
        ]);

        $redirectUrl = $this->url()->fromRoute('e4w/post/edit', ['id' => $post->getId()]);
        $prg = $this->prg($redirectUrl, true);

        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg;
        } elseif ($prg === false) {
            return $viewModel;
        }

        $topic = $topicService->find($post->getTopic());

        if ($post = $postService->update($prg, $topic, $identity)) {
            return $this->redirect()->toRoute('e4w/topic/view', ['id' => $topic->getId(), 'slug' => $topic->getSlug()]);
        }

        return $viewModel;
    }

    public function postDeleteAction()
    {
        $postService = $this->postService;
        $topicService = $this->topicService;
        $authenticationService = $this->authenticationService;

        /** @var \Eye4web\Zf2Board\Entity\UserInterface $identity */
        $identity = $authenticationService->getIdentity();

        if (!$authenticationService->hasIdentity()) {
            throw new \Exception('You need to be signed in to edit posts');
        }

        $postId = $this->params('id');
        $post = $postService->find($postId);

        if (!$post) {
            throw new \Exception('The post does not exist');
        }

        if ($post->getUser() != $identity->getId()) {
            throw new \Exception('You do not have the rights to delete this post');
        }

        $topic = $topicService->find($post->getTopic());

        $url = $this->url()->fromRoute('e4w/topic/view', ['id' => $topic->getId(), 'slug' => $topic->getSlug()]);

        $postService->delete($post->getId());

        return $this->redirect()->toUrl($url);
    }
}