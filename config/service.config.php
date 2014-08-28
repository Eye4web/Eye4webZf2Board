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
        'E4W\Zf2Board\Service\BoardService' => 'E4W\Zf2Board\Factory\Service\BoardServiceFactory',
        'E4W\Zf2Board\Service\TopicService' => 'E4W\Zf2Board\Factory\Service\TopicServiceFactory',
        'E4W\Zf2Board\Service\PostService' => 'E4W\Zf2Board\Factory\Service\PostServiceFactory',

        // Mappers
        'E4W\Zf2Board\Mapper\DoctrineORMBoardMapper' => 'E4W\Zf2Board\Factory\Mapper\DoctrineORMBoardMapperFactory',
        'E4W\Zf2Board\Mapper\DoctrineORMTopicMapper' => 'E4W\Zf2Board\Factory\Mapper\DoctrineORMTopicMapperFactory',

        // Options
        'E4W\Zf2Board\Options\ModuleOptions' => 'E4W\Zf2Board\Factory\Options\ModuleOptionsFactory',

        // Forms
        'E4W\Zf2Board\Form\Board\CreateForm' => 'E4W\Zf2Board\Factory\Form\Board\CreateFormFactory',
        'E4W\Zf2Board\Form\Topic\CreateForm' => 'E4W\Zf2Board\Factory\Form\Topic\CreateFormFactory',
        'E4W\Zf2Board\Form\Post\CreateForm' => 'E4W\Zf2Board\Factory\Form\Post\CreateFormFactory',
    ]
];
