<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Date */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="date-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'seconds',
            'minutes',
            'hours',
            'number_day',
            'number_weeks_day',
            'number_month',
            'year',
            'number_years_day',
            'weekday',
            'month',
            'unix_time',
            'event',
            'persona_id',
        ],
    ]) ?>

</div>
