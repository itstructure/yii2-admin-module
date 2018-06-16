<?php

use Itstructure\AdminModule\Module;

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model Itstructure\AdminModule\models\Language */

$this->title = Module::t('languages', 'Create language');
$this->params['breadcrumbs'][] = [
    'label' => Module::t('languages', 'Languages'),
    'url' => [
        $this->params['urlPrefix'].'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="language-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
