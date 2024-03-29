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

namespace Eye4web\Zf2Board\Factory\Service;

use Eye4web\Zf2Board\Service\PostService;
use Zend\Form\Form;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PostServiceFactory implements \Zend\ServiceManager\Factory\FactoryInterface
{
    /**
     * Create controller
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return PostService
     */
    public function __invoke(\Psr\Container\ContainerInterface $serviceLocator, $requestedName, array $options = null)
    {
        /** @var \Eye4web\Zf2Board\Options\ModuleOptions $options */
        $options = $serviceLocator->get('Eye4web\Zf2Board\Options\ModuleOptions');

        /** @var \Eye4web\Zf2Board\Mapper\PostMapperInterface $mapper */
        $mapper = $serviceLocator->get($options->getPostMapper());

        /** @var Form $postCreateForm */
        $postCreateForm = $serviceLocator->get('Eye4web\Zf2Board\Form\Post\CreateForm');

        /** @var Form $postEditForm */
        $postEditForm = $serviceLocator->get('Eye4web\Zf2Board\Form\Post\EditForm');

        $service = new PostService($mapper, $postCreateForm, $postEditForm);

        return $service;
    }
}
