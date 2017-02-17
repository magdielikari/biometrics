<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Date */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Date',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="date-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
