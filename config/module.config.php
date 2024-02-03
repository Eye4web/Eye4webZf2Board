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
                'type' => 'Zend\Router\Http\Literal',
                'options' => [
                    'route' => '/'
                ],
                'may_terminate' => false,
                'child_routes' => [
                    'board' => [
                        'type' => 'Zend\Router\Http\Literal',
                        'options' => [
                            'route' => 'board'
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'list' => [
                                'type' => 'Zend\Router\Http\Segment',
                                'options' => [
                                    'route'    => '/list',
                                    'defaults' => [
                                        'controller' => 'Eye4web\Zf2Board\Controller\BoardController',
                                        'action'     => 'boardList',
                                    ],
                                ],
                            ],
                            'view' => [
                                'type' => 'Zend\Router\Http\Segment',
                                'options' => [
                                    'route'    => '/view/:id{-}[-:slug][/page/:page]',
                                    'defaults' => [
                                        'controller' => 'Eye4web\Zf2Board\Controller\BoardController',
                                        'action'     => 'board',
                                        'page'       => 1,
                                    ],
                                ],
                            ],
                        ]
                    ],
                    'topic' => [
                        'type' => 'Zend\Router\Http\Literal',
                        'options' => [
                            'route' => 'topic'
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'view' => [
                                'type' => 'Zend\Router\Http\Segment',
                                'options' => [
                                    'route'    => '/view/:id{-}[-:slug][/page/:page]',
                                    'defaults' => [
                                        'controller' => 'Eye4web\Zf2Board\Controller\BoardController',
                                        'action'     => 'topic',
                                        'page'       => 1,
                                    ],
                                ],
                            ],
                            'create' => [
                                'type' => 'Zend\Router\Http\Segment',
                                'options' => [
                                    'route'    => '/create/:board',
                                    'defaults' => [
                                        'controller' => 'Eye4web\Zf2Board\Controller\BoardController',
                                        'action'     => 'topicCreate',
                                    ],
                                ],
                            ],
                        ]
                    ],
                    'post' => [
                        'type' => 'Zend\Router\Http\Literal',
                        'options' => [
                            'route' => 'post'
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'edit' => [
                                'type' => 'Zend\Router\Http\Segment',
                                'options' => [
                                    'route'    => '/edit/:id',
                                    'defaults' => [
                                        'controller' => 'Eye4web\Zf2Board\Controller\BoardController',
                                        'action'     => 'postEdit',
                                    ],
                                ],
                            ],
                            'delete' => [
                                'type' => 'Zend\Router\Http\Segment',
                                'options' => [
                                    'route'    => '/delete/:id',
                                    'defaults' => [
                                        'controller' => 'Eye4web\Zf2Board\Controller\BoardController',
                                        'action'     => 'postDelete',
                                    ],
                                ],
                            ],
                        ]
                    ]
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
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'paths' => [
                    'default' => __DIR__ . '/doctrine',
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    'Eye4web\Zf2Board\Entity' => 'zf2board_driver'
                ]
            ]
        ],
    ],
];
