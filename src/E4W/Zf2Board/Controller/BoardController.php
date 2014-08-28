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

namespace E4W\Zf2Board\Controller;

use E4W\Zf2Board\Service\BoardService;
use E4W\Zf2Board\Service\TopicService;
use Zend\Authentication\AuthenticationService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BoardController extends AbstractActionController
{
    /** @var BoardService */
    protected $boardService;

    /** @var TopicService */
    protected $topicService;

    protected $boardCreateForm;

    protected $topicCreateForm;

    /** @var AuthenticationService */
    protected $authenticationService;

    public function __construct(BoardService $boardService, TopicService $topicService, $boardCreateForm, $topicCreateForm, AuthenticationService $authenticationService)
    {
        $this->boardService = $boardService;
        $this->topicService = $topicService;
        $this->boardCreateForm = $boardCreateForm;
        $this->topicCreateForm = $topicCreateForm;
        $this->authenticationService = $authenticationService;
    }

    public function boardListAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setTemplate('e4w-zf2-board/board/board/list.phtml');

        $viewModel->setVariables([
            'boards' => $this->boardService->findAll()
        ]);

        return $viewModel;
    }

    public function boardCreateAction()
    {
        $form = $this->boardCreateForm;

        $viewModel = new ViewModel();
        $viewModel->setTemplate('e4w-zf2-board/board/board/create.phtml');
        $viewModel->setVariable('form', $form);

        $redirectUrl = $this->url()->fromRoute('e4w/board-create');
        $prg = $this->prg($redirectUrl, true);

        $boardService = $this->boardService;

        $identity = $this->authenticationService->getIdentity();

        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg;
        } elseif ($prg === false) {
            return $viewModel;
        }

        if ($board = $boardService->create($prg, $identity)) {
            die("Board created");
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
        $viewModel->setTemplate('e4w-zf2-board/board/topic/create.phtml');
        $viewModel->setVariable('form', $form);

        $redirectUrl = $this->url()->fromRoute('e4w/topic-create');
        $prg = $this->prg($redirectUrl, true);

        $topicService = $this->topicService;

        $identity = $this->authenticationService->getIdentity();

        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg;
        } elseif ($prg === false) {
            return $viewModel;
        }

        if ($board = $topicService->create($prg, $board, $identity)) {
            die("Board created");
        }

        return $viewModel;
    }
}
