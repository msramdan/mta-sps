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
            'header' => 'Progress Penjualan',
            'permissions' => ['kunjungan sales view', 'sph view', 'spk view', 'jadwal teknisi view', 'working view', 'penagihan view'],
            'menus' => [
                [
                    'title' => 'Kunjungan Sales',
                    'icon' => '<i class="ti ti-report-search fs-5 me-2"></i>',
                    'route' => 'kunjungan-sales',
                    'permission' => 'kunjungan sales view',
                    'permissions' => ['kunjungan sales view'],
                    'submenus' => []
                ],
                [
                    'title' => 'SPH',
                    'icon' => '<i class="ti ti-file-certificate fs-5 me-2"></i>',
                    'route' => 'sph',
                    'permission' => 'sph view',
                    'permissions' => ['sph view'],
                    'submenus' => []
                ],
                [
                    'title' => 'SPK/PO',
                    'icon' => '<i class="ti ti-file-invoice fs-5 me-2"></i>',
                    'route' => 'spk',
                    'permission' => 'spk view',
                    'permissions' => ['spk view'],
                    'submenus' => []
                ],
                [
                    'title' => 'Jadwal Teknisi',
                    'icon' => '<i class="ti ti-calendar-time fs-5 me-2"></i>',
                    'route' => 'jadwal-teknisi',
                    'permission' => 'jadwal teknisi view',
                    'permissions' => ['jadwal teknisi view'],
                    'submenus' => []
                ],
                [
                    'title' => 'Working',
                    'icon' => '<i class="ti ti-progress fs-5 me-2"></i>',
                    'route' => 'working',
                    'permission' => 'working view',
                    'permissions' => ['working view'],
                    'submenus' => []
                ],
                [
                    'title' => 'Proses Penagihan',
                    'icon' => '<i class="ti ti-file-invoice fs-5 me-2"></i>',
                    'route' => 'penagihan',
                    'permission' => 'penagihan view',
                    'permissions' => ['penagihan view'],
                    'submenus' => []
                ],
                [
                    'title' => 'Cetak Laporan',
                    'icon' => '<i class="ti ti-file-export fs-5 me-2"></i>',
                    'route' => 'laporan',
                    'permission' => 'penagihan view',
                    'permissions' => ['penagihan view'],
                    'submenus' => []
                ]
            ]
        ],
        [
            'header' => 'Utilities',
            'permissions' => [
                'user view',
                'role & permission view',
                'company view'
            ],
            'menus' => [
                [
                    'title' => 'Perusahaan',
                    'icon' => '<i class="ti ti-building fs-5 me-2"></i>',
                    'route' => 'companies',
                    'permission' => 'company view',
                    'permissions' => ['company view'],
                    'submenus' => []
                ],
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
