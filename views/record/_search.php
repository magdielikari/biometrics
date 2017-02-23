<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\RecordSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="record-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'person_id') ?>

    <?= $form->field($model, 'date_id') ?>

    <?= $form->field($model, 'counter') ?>

    <?= $form->field($model, 'min') ?>

    <?= $form->field($model, 'max') ?>

    <?php // echo $form->field($model, 'average') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
