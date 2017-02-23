<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Record */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Record',
]) . $model->person_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Records'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->person_id, 'url' => ['view', 'person_id' => $model->person_id, 'date_id' => $model->date_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="record-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
