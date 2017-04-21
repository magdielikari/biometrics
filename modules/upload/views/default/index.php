<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\FileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Files');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'rowOptions' => function($model){
            if($model->error == 0){
                return ['class' => 'success'];
            }else{
                return ['class' => 'danger'];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'attribute'=>'Size',
                'value'=>function($dataProvider){
                    return 
                        Yii::$app->formatter->asShortSize($dataProvider->size, 1);
                },
            ],
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
