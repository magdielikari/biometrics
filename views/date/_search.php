<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\DateSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="date-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'seconds') ?>

    <?= $form->field($model, 'minutes') ?>

    <?= $form->field($model, 'hours') ?>

    <?= $form->field($model, 'mday') ?>

    <?php // echo $form->field($model, 'wday') ?>

    <?php // echo $form->field($model, 'mon') ?>

    <?php // echo $form->field($model, 'year') ?>

    <?php // echo $form->field($model, 'yday') ?>

    <?php // echo $form->field($model, 'weekday') ?>

    <?php // echo $form->field($model, 'month') ?>

    <?php // echo $form->field($model, '0') ?>

    <?php // echo $form->field($model, 'event') ?>

    <?php // echo $form->field($model, 'persona_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
