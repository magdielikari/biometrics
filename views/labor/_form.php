<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Labor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="labor-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'in')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'out')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'person_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_id')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
