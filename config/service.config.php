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

return [
    'factories' => [
        // Services
        'Eye4web\Zf2Board\Service\AuthorService' => 'Eye4web\Zf2Board\Factory\Service\AuthorServiceFactory',
        'Eye4web\Zf2Board\Service\BoardService' => 'Eye4web\Zf2Board\Factory\Service\BoardServiceFactory',
        'Eye4web\Zf2Board\Service\TopicService' => 'Eye4web\Zf2Board\Factory\Service\TopicServiceFactory',
        'Eye4web\Zf2Board\Service\PostService' => 'Eye4web\Zf2Board\Factory\Service\PostServiceFactory',
        'Eye4web\Zf2Board\Service\SlugService' => 'Eye4web\Zf2Board\Factory\Service\SlugServiceFactory',

        // Mappers
        'Eye4web\Zf2Board\Mapper\DoctrineORM\AuthorMapper' => 'Eye4web\Zf2Board\Factory\Mapper\DoctrineORM\AuthorMapperFactory',
        'Eye4web\Zf2Board\Mapper\DoctrineORM\BoardMapper' => 'Eye4web\Zf2Board\Factory\Mapper\DoctrineORM\BoardMapperFactory',
        'Eye4web\Zf2Board\Mapper\DoctrineORM\TopicMapper' => 'Eye4web\Zf2Board\Factory\Mapper\DoctrineORM\TopicMapperFactory',
        'Eye4web\Zf2Board\Mapper\DoctrineORM\PostMapper' => 'Eye4web\Zf2Board\Factory\Mapper\DoctrineORM\PostMapperFactory',

        // Options
        'Eye4web\Zf2Board\Options\ModuleOptions' => 'Eye4web\Zf2Board\Factory\Options\ModuleOptionsFactory',

        // Forms
        'Eye4web\Zf2Board\Form\Board\CreateForm' => 'Eye4web\Zf2Board\Factory\Form\Board\CreateFormFactory',

        'Eye4web\Zf2Board\Form\Topic\CreateForm' => 'Eye4web\Zf2Board\Factory\Form\Topic\CreateFormFactory',

        'Eye4web\Zf2Board\Form\Post\CreateForm' => 'Eye4web\Zf2Board\Factory\Form\Post\CreateFormFactory',
        'Eye4web\Zf2Board\Form\Post\EditForm' => 'Eye4web\Zf2Board\Factory\Form\Post\EditFormFactory',

        // Authentication Service
        'Eye4web\Zf2Board\Service\AuthenticationService' => 'Eye4web\Zf2Board\Factory\Service\AuthenticationServiceFactory',
    ]
];
