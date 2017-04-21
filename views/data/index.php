<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\User;
use app\components\helpers\MyQuery;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\DataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Datas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-index">

    <h1><?= Html::encode($this->title) ?></h1>
        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'time',
            'number',
            'name',
            [
                'attribute'=>'Event',
                'value'=>function($dataProvider){
                    return $dataProvider->event == '192.168.10.15' ? 'Salida' : 'Entrada';
                }
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
                'attribute' => 'File name',
                'value' => 'file.name'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [ 
                    'update' => False, 
                    'delete' => False
                    ]
            ]          
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
