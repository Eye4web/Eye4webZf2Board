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

namespace Eye4web\Zf2Board\Factory\View\Helper;

use Eye4web\Zf2Board\View\Helper\BoardHelper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BoardHelperFactory implements FactoryInterface
{
    /**
     * Create helper
     *
     * @param ServiceLocatorInterface $helperManager
     * @return BoardHelper
     * @throws \Exception
     */
    public function createService(ServiceLocatorInterface $helperManager)
    {
        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $helperManager->getServiceLocator();

        /** @var \Eye4web\Zf2Board\Service\AuthorService $authorService */
        $authorService = $serviceLocator->get('Eye4web\Zf2Board\Service\AuthorService');

        /** @var \Zend\Authentication\AuthenticationService $authenticationService */
        $authenticationService = $serviceLocator->get('Eye4web\Zf2Board\Service\AuthenticationService');

        if (!$authenticationService) {
            throw new \Exception('No authentication service has been provided');
        }

        $helper = new Boardhelper($authorService, $authenticationService);

        return $helper;
    }
}
