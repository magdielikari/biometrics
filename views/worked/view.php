<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Worked */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Workeds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="worked-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'person.name',
            'date.weekday',
            'date.number_day',
            'date.month',
            'date.year',
            [
                'attribute'=>'In',
                'value'=>function($dataProvider){
                    return Yii::$app->formatter->asDatetime($dataProvider->in, 'short');
                },
            ],
            [
                'attribute'=>'Out',
                'value'=>function($dataProvider){
                    return Yii::$app->formatter->asDatetime($dataProvider->out, 'short');
                },
            ],
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
