<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\File */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Files'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-view">

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
            'name',
            [
                'attribute'=>'Size',
                'value'=>function($dataProvider){
                    return 
                        Yii::$app->formatter->asShortSize($dataProvider->size, 1);
                },
            ],
            'error',
            [
                'attribute'=>'Created_at',
                'value'=>function($dataProvider){
                    return 
                        Yii::$app->formatter->asDatetime($dataProvider->created_at, 'medium');
                },
            ],
            [
                'attribute'=>'Update_at',
                'value'=>function($dataProvider){
                    return 
                        Yii::$app->formatter->asDatetime($dataProvider->updated_at, 'medium');
                },
            ],
        ],
    ]) ?>

</div>
