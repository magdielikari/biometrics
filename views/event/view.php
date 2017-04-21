<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;
/* @var $this yii\web\View */
/* @var $model app\models\Event */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'year',
            'number_years_day',
           [
                'attribute'=>'Time',
                'value'=>function($dataProvider){
                    return Yii::$app->formatter->asDatetime($dataProvider->unix_time, 'medium');
                },
            ],
            [
                'attribute'=>'Event',
                'value'=>function($dataProvider){
                    return $dataProvider->event == '192.168.10.15' ? 'Salida' : 'Entrada';
                }
            ],
            [
                'attribute'=>'Created_at',
                'value'=>function($dataProvider){
                    return Yii::$app->formatter->asDatetime($dataProvider->created_at, 'medium');
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
                    return Yii::$app->formatter->asDatetime($dataProvider->updated_at, 'medium');
                },
            ],
            [
                'attribute'=>'Updated_by',
                'value'=>function($dataProvider){
                    return User::findIdentity($dataProvider->updated_by)->username;
                },
            ],
            'person.name',
        ],
    ]) ?>

</div>
