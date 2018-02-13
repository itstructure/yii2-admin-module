<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use Itstructure\AdminModule\Module;

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model Itstructure\AdminModule\models\Language */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Module::t('languages', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="language-view">

    <p>
        <?php echo Html::a(Module::t('main', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a(Module::t('main', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Module::t('main', 'Are you sure you want to do this action?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'id',
                'label' => Module::t('main', 'ID')
            ],
            [
                'attribute' => 'locale',
                'label' => Module::t('languages', 'Locale')
            ],
            [
                'attribute' => 'shortName',
                'label' => Module::t('languages', 'Short name')
            ],
            [
                'attribute' => 'name',
                'label' => Module::t('languages', 'Language name')
            ],
            [
                'attribute' => 'default',
                'label' => Module::t('main', 'Default')
            ],
            [
                'attribute' => 'created_at',
                'format' =>  ['date', 'dd.MM.Y H:m:s'],
                'label' => Module::t('main', 'Created date')
            ],
            [
                'attribute' => 'updated_at',
                'format' =>  ['date', 'dd.MM.Y H:m:s'],
                'label' => Module::t('main', 'Updated date')
            ],
        ],
    ]) ?>

</div>
