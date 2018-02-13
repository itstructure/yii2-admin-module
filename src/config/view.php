<?php

use yii\helpers\ArrayHelper;
use Itstructure\AdminModule\Module;
use Itstructure\AdminModule\components\AdminView;

$mainMenuConfig = [];

if ($this->isMultilanguage){

    // Add language link to sidebar.
    $mainMenuConfig = ArrayHelper::merge(
        $mainMenuConfig,
        [
            'menuItems' => [
                'language' => [
                    'title' => Module::t('languages', 'Languages'),
                    'icon' => 'fa fa-language',
                    'url' => '/admin/language',
                ],
            ],
        ]
    );
}

return [
    'view' => [
        'class' => AdminView::class,
        'skin' => AdminView::SKIN_GREEN_LIGHT,
        'bodyLayout' => AdminView::LAYOUT_SIDEBAR_MINI,
        'mainMenuConfig' => $mainMenuConfig,
    ],
];
