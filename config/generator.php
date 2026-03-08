<?php

return [
    /**
     * If any input file(image) as default will use options below.
     */
    'image' => [
        'disk' => 'public',
        'default' => 'https://placehold.co/300?text=No+Image+Available',
        'crop' => true,
        'aspect_ratio' => true,
        'width' => 300,
        'height' => 300,
    ],

    'format' => [
        'first_year' => 1970,
        'date' => 'Y-m-d',
        'month' => 'Y/m',
        'time' => 'H:i',
        'datetime' => 'Y-m-d H:i:s',
        'limit_text' => 100,
    ],

    'sidebars' => [
        [
            'header' => 'Utilities',
            'permissions' => [
                'user view',
                'role & permission view'
            ],
            'menus' => [
                [
                    'title' => 'User & Roles',
                    'icon' => '<i class="ti ti-users fs-5 me-2"></i>',
                    'route' => null,
                    'permissions' => [
                        'user view',
                        'role & permission view'
                    ],
                    'submenus' => [
                        [
                            'title' => 'Users',
                            'route' => 'users',
                            'permission' => 'user view'
                        ],
                        [
                            'title' => 'Roles',
                            'route' => 'roles',
                            'permission' => 'role & permission view'
                        ]
                    ]
                ]
            ]
        ]
    ]
];
