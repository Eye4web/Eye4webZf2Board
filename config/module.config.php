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
    'router' => [
        'routes' => [
            'e4w' => [
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route' => '/'
                ],
                'may_terminate' => false,
                'child_routes' => [
                    'board-list' => [
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => [
                            'route'    => 'boards',
                            'defaults' => [
                                'controller' => 'E4W\Zf2Board\Controller\BoardController',
                                'action'     => 'boardList',
                            ],
                        ],
                    ],
                    'board-create' => [
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => [
                            'route'    => 'create-board',
                            'defaults' => [
                                'controller' => 'E4W\Zf2Board\Controller\BoardController',
                                'action'     => 'boardCreate',
                            ],
                        ],
                    ],
                    'topic-create' => [
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => [
                            'route'    => 'create-topic/:board',
                            'defaults' => [
                                'controller' => 'E4W\Zf2Board\Controller\BoardController',
                                'action'     => 'topicCreate',
                            ],
                        ],
                    ],
                ]
            ]
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'aliases' => [
            'translator' => 'MvcTranslator',
        ],
    ],
    'translator' => [
        'locale' => 'en_US',
        'translation_file_patterns' => [
            [
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ],
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],

    'doctrine' => [
        'driver' => [
            'zf2board_driver' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => [
                    __DIR__ . '/../src/E4W/Zf2Board/Entity',
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    'E4W\Zf2Board' => 'zf2board_driver'
                ]
            ]
        ],
    ],
];
