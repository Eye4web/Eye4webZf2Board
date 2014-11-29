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

namespace Eye4web\Zf2Board\Factory\Controller;

use Eye4web\Zf2Board\Controller\BoardController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BoardControllerFactory implements FactoryInterface
{
    /**
     * Create controller
     *
     * @param ServiceLocatorInterface $controllerManager
     * @return BoardController
     */
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        /** @var ServiceLocatorInterface $serviceManager */
        $serviceManager = $controllerManager->getServiceLocator();

        /** @var \Eye4web\Zf2Board\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceManager->get('Eye4web\Zf2Board\Options\ModuleOptions');

        /** @var \Eye4web\Zf2Board\Service\BoardService $boardService */
        $boardService = $serviceManager->get('Eye4web\Zf2Board\Service\BoardService');

        /** @var \Eye4web\Zf2Board\Service\TopicService $topicService */
        $topicService = $serviceManager->get('Eye4web\Zf2Board\Service\TopicService');

        /** @var \Eye4web\Zf2Board\Service\PostService $postService */
        $postService = $serviceManager->get('Eye4web\Zf2Board\Service\PostService');

        /** @var \Zend\Form\Form $topicCreateForm */
        $topicCreateForm = $serviceManager->get('Eye4web\Zf2Board\Form\Topic\CreateForm');

        /** @var \Zend\Form\Form $postCreateForm */
        $postCreateForm = $serviceManager->get('Eye4web\Zf2Board\Form\Post\CreateForm');

        /** @var \Zend\Form\Form $postEditForm */
        $postEditForm = $serviceManager->get('Eye4web\Zf2Board\Form\Post\EditForm');

        /** @var \Zend\Authentication\AuthenticationService $authenticationService */
        $authenticationService = $serviceManager->get($moduleOptions->getAuthenticationService());

        $controller = new BoardController(
            $boardService,
            $topicService,
            $postService,
            $topicCreateForm,
            $postCreateForm,
            $postEditForm,
            $authenticationService,
            $moduleOptions
        );

        /** @var \Zend\EventManager\EventManager $eventManager */
        $eventManager = $serviceManager->get('EventManager');

        $controller->setEventManager($eventManager);

        return $controller;
    }
}
