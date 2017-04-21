<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Data */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'time',
            'number',
            'name',
            [
                'attribute' => 'Event',
                'value' => function($model){
                    return $model->event == '192.168.10.15' ? 'Salida' : 'Entrada';
                }
            ],
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
                    return Yii::$app->formatter->asDatetime($model->updated_at, 'medium');
                },
            ],
            [
                'attribute' => 'Updated_by',
                'value' => function($model){
                    return User::findIdentity($model->updated_by)->username;
                },
            ],
            [
                'attribute' => 'Created_at',
                'value' => function($model){
                    return $model->region->name;
                },
            ]
        ],
    ]) ?>

</div>
