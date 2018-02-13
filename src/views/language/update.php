<?php

use Itstructure\AdminModule\Module;

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model Itstructure\AdminModule\models\Language */

$this->title = Module::t('languages', 'Update language') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Module::t('languages', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="language-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
