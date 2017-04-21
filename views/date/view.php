<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Date */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="date-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'number_day',
            'number_weeks_day',
            'number_month',
            'year',
            'number_years_day',
            'weekday',
            'month',
            [
                'attribute' => 'Created_at',
                'value' => function($model){
                    return Yii::$app->formatter->asDatetime($model->created_at, 'medium');
                },
            ],
            [
                'attribute' => 'Created_by',
                'value' => function($model){
                    return User::findIdentity($model->created_by)->username;
                },
            ],            
            [
                'attribute' => 'Updated_at',
                'value' => function($model){
                    return Yii::$app->formatter->asDatetime($model->updated_by, 'medium');
                },
            ],
            [
                'attribute' => 'Updated_by',
                'value' => function($model){
                    return User::findIdentity($model->updated_by)->username;
                },
            ],
        ],
    ]) ?>

</div>
