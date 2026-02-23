<?php

return [
    /**
     * If any input file(image) as default will use options below.
     */
    'image' => [
        /**
         * Path for store the image.
         *
         * Available options:
         * 1. public or storage.public
         * 2. local or storage.local
         * 3. public_path
         * 4. S3
         */
        'disk' => 'public',

        /**
         * Will be used if image is nullable and default value is null.
         */
        'default' => 'https://placehold.co/300?text=No+Image+Available',

        /**
         * Crop the uploaded image using intervention image.
         */
        'crop' => true,

        /**
         * When set to true the uploaded image aspect ratio will still original.
         */
        'aspect_ratio' => true,

        /**
         * Crop image size.
         */
        'width' => 300,
        'height' => 300,
    ],

    'format' => [
        /**
         * Will be used to first year on select, if any column type year.
         */
        'first_year' => 1970,

        /**
         * If any date column type will cast and display used this format, but for input date still will used Y-m-d format.
         *
         * another most common format:
         * - M d Y
         * - d F Y
         * - Y m d
         */
        'date' => 'Y-m-d',

        /**
         * If any input type month will cast and display used this format.
         */
        'month' => 'Y/m',

        /**
         * If any input type time will cast and display used this format.
         */
        'time' => 'H:i',

        /**
         * If any datetime column type or datetime-local on input, will cast and display used this format.
         */
        'datetime' => 'Y-m-d H:i:s',

        /**
         * Limit string on index view for any column type text or long text.
         */
        'limit_text' => 100,
    ],

    /**
     * It will be used for generator to manage and showing menus on sidebar views.
     *
     * Example:
     * [
     *   'header' => 'Main',
     *
     *   // All permissions in menus[] and submenus[]
     *   'permissions' => ['test view'],
     *
     *   menus' => [
     *       [
     *          'title' => 'Main Data',
     *          'icon' => '<i class="bi bi-collection-fill"></i>',
     *          'route' => null,
     *
     *          // permission always null when isset submenus
     *          'permission' => null,
     *
     *          // All permissions on submenus[] and will empty[] when submenus equals to []
     *          'permissions' => ['test view'],
     *
     *          'submenus' => [
     *                 [
     *                     'title' => 'Tests',
     *                     'route' => '/tests',
     *                     'permission' => 'test view'
     *                  ]
     *               ],
     *           ],
     *       ],
     *  ],
     *
     * This code below always changes when you use a generator, and maybe you must format the code.
     */
    'sidebars' => [
        [
            'header' => 'Merchant',
            'permissions' => [
                'merchant view'
            ],
            'menus' => [
                [
                    'title' => 'Merchant',
                    'icon' => '<i class="ti ti-building-store fs-5 me-2"></i>',
                    'route' => '/merchants',
                    'permission' => 'merchant view',
                    'permissions' => [],
                    'submenus' => []
                ]
            ]
        ],
        [
            'header' => 'Transaksi',
            'permissions' => [
                'transaksi view'
            ],
            'menus' => [
                [
                    'title' => 'Transaksi',
                    'icon' => '<i class="ti ti-receipt fs-5 me-2"></i>',
                    'route' => '/transaksis',
                    'permission' => 'transaksi view',
                    'permissions' => [],
                    'submenus' => []
                ]
            ]
        ],
        [
            'header' => 'Tarik Saldo',
            'permissions' => [
                'tarik saldo view'
            ],
            'menus' => [
                [
                    'title' => 'Tarik Saldo',
                    'icon' => '<i class="ti ti-transfer-out fs-5 me-2"></i>',
                    'route' => '/tarik-saldos',
                    'permission' => 'tarik saldo view',
                    'permissions' => [],
                    'submenus' => []
                ]
            ]
        ],
        [
            'header' => 'Bank',
            'permissions' => [
                'bank view'
            ],
            'menus' => [
                [
                    'title' => 'Bank',
                    'icon' => '<i class="ti ti-building-bank fs-5 me-2"></i>',
                    'route' => '/banks',
                    'permission' => 'bank view',
                    'permissions' => [],
                    'submenus' => []
                ]
            ]
        ],
        [
            'header' => 'Simulator QRIS',
            'permissions' => [
                'simulator view'
            ],
            'menus' => [
                [
                    'title' => 'Simulator QRIS',
                    'icon' => '<i class="ti ti-qrcode fs-5 me-2"></i>',
                    'route' => '/simulators',
                    'permission' => 'simulator view',
                    'permissions' => [],
                    'submenus' => []
                ]
            ]
        ],
        [
            'header' => 'System Log',
            'permissions' => [
                'log generate qr view',
                'log generate qr delete',
                'log callback view',
                'log callback delete',
                'log resend callback view',
                'log resend callback delete',
                'log query payment status view',
                'log query payment status delete',
                'log token b2b view',
                'log token b2b delete',
                'activity log view'
            ],
            'menus' => [
                [
                    'title' => 'System Log',
                    'icon' => '<i class="ti ti-file-text fs-5 me-2"></i>',
                    'route' => null,
                    'permissions' => [
                        'log generate qr view',
                        'log generate qr delete',
                        'log callback view',
                        'log callback delete',
                        'log resend callback view',
                        'log resend callback delete',
                        'log query payment status view',
                        'log query payment status delete',
                        'log token b2b view',
                        'log token b2b delete',
                        'activity log view'
                    ],
                    'submenus' => [
                        [
                            'title' => 'Log Generate QR',
                            'route' => 'log-generate-qrs',
                            'permission' => 'log generate qr view'
                        ],
                        [
                            'title' => 'Log Query Payment Status',
                            'route' => 'log-query-payment-status',
                            'permission' => 'log query payment status view'
                        ],
                        [
                            'title' => 'Log Token B2B',
                            'route' => 'log-token-b2b',
                            'permission' => 'log token b2b view'
                        ],
                        [
                            'title' => 'Log Callback',
                            'route' => 'log-callbacks',
                            'permission' => 'log callback view'
                        ],
                        [
                            'title' => 'Log Resend Callback',
                            'route' => 'log-resend-callbacks',
                            'permission' => 'log resend callback view'
                        ],
                        [
                            'title' => 'Activity Log',
                            'route' => 'activity-logs',
                            'permission' => 'activity log view'
                        ]
                    ]
                ]
            ]
        ],
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
