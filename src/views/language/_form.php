<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use Itstructure\AdminModule\Module;

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $model Itstructure\AdminModule\models\Language */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="language-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">

            <?php echo $form->field($model, 'locale')->textInput([
                'maxlength' => true
            ])->label(Module::t('languages', 'Locale')) ?>

            <?php echo $form->field($model, 'shortName')->textInput([
                'maxlength' => true
            ])->label(Module::t('languages', 'Short name')) ?>

            <?php echo $form->field($model, 'name')->textInput([
                'maxlength' => true
            ])->label(Module::t('languages', 'Language name')) ?>

            <?php echo $form->field($model, 'default')->checkbox([
                'value' => 1,
                'label' => Module::t('languages', 'Set this language as default')
            ]) ?>

        </div>
    </div>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Module::t('main', 'Create') : Module::t('main', 'Update'), [
            'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
