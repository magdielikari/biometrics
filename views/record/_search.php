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

    <?= $form->field($model, 'global') ?>

    <?php // $form->field($model, 'date_id') ?>

    <?php // $form->field($model, 'counter_record') ?>

    <?php // $form->field($model, 'counter_worked') ?>

    <?php // $form->field($model, 'min_record') ?>

    <?php // echo $form->field($model, 'max_record') ?>

    <?php // echo $form->field($model, 'average_record') ?>

    <?php // echo $form->field($model, 'time_worked') ?>

    <?php // echo $form->field($model, 'time_record') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
