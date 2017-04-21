<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\User;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\RecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Records');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="record-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function($model){
            if($model->time_worked >= 28800){
                return ['class' => 'success'];
            }else{
                return ['class' => 'danger'];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'person.name',
            'date.weekday',
            'date.number_day',
            'date.month',
            'date.year',
            'counter_record',
            [
                'attribute'=>'Time Record',
                'value'=>function($dataProvider){
                    return Yii::$app->formatter->asDuration($dataProvider->time_record);
                },
            ],
            'counter_worked',
            [
                'attribute'=>'Time Worked',
                'value'=>function($dataProvider){
                    return Yii::$app->formatter->asDuration($dataProvider->time_worked);
                },
            ],
            //'min_record',
            //'max_record',
            //'average_record',
            //'created_at',
            //'created_by',
            // 'updated_at',
            // 'updated_by',

            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [ 
                    'update' => False, 
                    'delete' => False
                    ]
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
