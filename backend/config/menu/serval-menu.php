<?php
return [
    'menuItems' => [
        [
            'label' => 'Dashboard',
            'url' => ['/', '/dashboard/index'],
        ],
        [
            'label' => 'User',
            'iconContent' => '\e900',
            'url' => ['/user', '/user/index', '/user/view', '/user/update', '/user/create'],
        ],
        [
            'label' => 'Data',
            'url' => '#',
            'sub_menu' => [
                'options' => [
                    'class' => '',
                    'tag' => 'div',
                ],
                'label' => 'Data',
                'menu_items' =>
                    [   // массив елементів
                        [ // колонка ( в даному випадку перша)
                            [ // група може бути як з лейблом так і і без лейбла

                                'label' => Yii::t('serval', 'Sliders & Slides'),

                                [
                                    'label' => Yii::t('serval', 'Sliders'),
                                    'url' => ['/carousel', '/carousel/index', '/carousel/view', '/carousel/update', '/carousel/create'],
                                    'url-exceptions' => ['/carousel', '/carousel/index', '/carousel/view', '/carousel/update', '/carousel/create'],
                                ],

                                [
                                    'label' => Yii::t('serval', 'Slides'),
                                    'url' => ['/carousel-item', '/carousel-item/index', '/carousel-item/view', '/carousel-item/update', '/carousel-item/create', 'carousel-item/create'],
                                ],
                            ],

                            [
                                'label' => Yii::t('serval', 'ETC'),
                                [
                                    'label' => 'Countrys',
                                    'url' => ['/country', '/country/index', '/country/view', '/country/update', '/country/create'],
                                ],

                                [
                                    'label' => 'Tours',
                                    'url' => ['/tour', '/tour/index', '/tour/view', '/tour/update', '/tour/create'],
                                ],

                                [
                                    'label' => 'Articles',
                                    'url' => ['/article', '/article/index', '/article/view', '/article/update', '/article/create'],
                                ],

                                [
                                    'label' => 'Pages',
                                    'url' => ['/page', '/page/index', '/page/view', '/page/update', '/page/create'],
                                ],
                            ],

                        ],
                    ],
            ],
        ],

        [
            'label' => 'SEO',
            'url' => '#',
            'sub_menu' => [
                'options' => [
                    'class' => '',
                    'tag' => 'div',
                ],
                'label' => 'SEO',
                'menu_items' => [
                    [
                        [

                            [
                                'label' => 'Meta Tags',
                                'url' => ['/meta-tags', '/meta-tags/index', '/meta-tags/view', '/meta-tags/update', '/meta-tags/create'],
                            ],
                            [
                                'label' => 'Sitemap',
                                'url' => ['/sitemap', '/sitemap/index', '/sitemap/view', '/sitemap/update', '/sitemap/create'],
                            ],
                            [
                                'label' => 'Robots',
                                'url' => ['/robots', '/robots/index', '/robots/view', '/robots/update', '/robots/create'],
                            ],

                        ],
                    ],
                ],
            ],
        ],

        [
            'label' => 'System',
            'url' => '#',
            'sub_menu' =>
                [
                    'options' =>
                        [
                            'class' => '',
                            'tag' => 'div',
                        ],

                    'label' => 'System',
                    'menu_items' =>

                        [
                            [
                                [
                                    'label' => 'Configuration',
                                    [
                                        'label' => 'Main',
                                        'url' => ['/system/main'],
                                    ],
                                    [
                                        'label' => 'Frontend',
                                        'url' => ['/system/frontend'],
                                    ],
                                    [
                                        'label' => 'Backend',
                                        'url' => ['/system/backend'],
                                    ],
                                ],
                            ],
                        ],
                ],
        ],

    ],
];
