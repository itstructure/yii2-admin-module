<?php

use yii\helpers\{Html, Url};
use yii\grid\GridView;
use Itstructure\AdminModule\Module;
use Itstructure\AdminModule\models\Language;

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $searchModel Itstructure\AdminModule\models\LanguageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('languages', 'Languages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="language-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Module::t('main', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'name' => [
                'label' => Module::t('languages', 'Language name'),
                'value' => function($searchModel) {
                    return Html::a($searchModel->name,
                        Url::to(['view', 'id' => $searchModel->id])
                    );
                },
                'format' => 'raw',
            ],
            'shortName' => [
                'label' => Module::t('languages', 'Short name'),
                'value' => function($searchModel) {
                    return $searchModel->shortName;
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'default',
                'label' => Module::t('main', 'Default'),
                'format' => 'raw',
                'value' => function(Language $model) {
                    if ($model->default) {
                        return Html::tag('i', '', [
                            'class' => 'fa fa-check-circle',
                        ]);
                    }

                    return Html::a(Module::t('languages', 'Set this language as default'), Url::to([
                        'set-default',
                        'languageId' => $model->id,
                    ]), [
                        'title' => Module::t('languages', 'Set this language as default'),
                    ]);
                },
            ],
            [
                'attribute' => 'created_at',
                'label' => Module::t('main', 'Created date'),
                'format' =>  ['date', 'dd.MM.Y H:m:s'],
            ],
            [
                'attribute' => 'updated_at',
                'label' => Module::t('main', 'Updated date'),
                'format' =>  ['date', 'dd.MM.Y H:m:s'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Module::t('main', 'Actions'),
                'template' => '{setDefault} {view} {update} {delete}',
                'visibleButtons' => [
                    'setDefault' => function($model, $key, $index) {
                        return !$model->default;
                    },
                ],
            ],
        ],
    ]); ?>
</div>
