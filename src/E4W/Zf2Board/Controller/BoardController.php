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
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BoardController extends AbstractActionController
{
    /** @var BoardService */
    protected $boardService;

    public function __construct(BoardService $boardService)
    {
        $this->boardService = $boardService;
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

    public function createBoardAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setTemplate('e4w-zf2-board/board/board/create.phtml');

        $redirectUrl = $this->url()->fromRoute('e4w/create-board');
        $prg = $this->prg($redirectUrl, true);

        $boardService = $this->boardService;

        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg;
        } elseif ($prg === false) {
            return $viewModel;
        }

        if ($boardService->create($prg)) {
            return true;
        }

        return $viewModel;
    }
}
