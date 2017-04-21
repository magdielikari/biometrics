<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\Person */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'ci',
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
                    return $model->file->name;
                },
            ]
        ],
    ]) ?>

</div>
