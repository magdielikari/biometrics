<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;
/* @var $this yii\web\View */
/* @var $model app\models\Record */

$this->title = $model->person_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Records'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="record-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'person.name',
            'date.weekday',
            'date.number_day',
            'date.month',
            'date.year',
            'counter_record',
            'time_record',
            'counter_worked',
            'time_worked',
            'counter_record',
            'counter_worked',
            'min_record',
            'max_record',
            'average_record',
            'time_worked',
            'time_record',
            [
                'attribute'=>'Created_at',
                'value'=>function($dataProvider){
                    return Yii::$app->formatter->asDatetime($dataProvider->created_at, 'short');
                },
            ],
            [
                'attribute'=>'Created_by',
                'value'=>function($dataProvider){
                    return User::findIdentity($dataProvider->created_by)->username;
                },
            ],
            [
                'attribute'=>'Updated_at',
                'value'=>function($dataProvider){
                    return Yii::$app->formatter->asDatetime($dataProvider->updated_at, 'short');
                },
            ],
            [
                'attribute'=>'Updated_by',
                'value'=>function($dataProvider){
                    return User::findIdentity($dataProvider->updated_by)->username;
                },
            ],
        ],
    ]) ?>

</div>
