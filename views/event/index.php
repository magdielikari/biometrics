<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\User;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Events');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'person.name',
            [
                'attribute'=>'Event',
                'value'=>function($dataProvider){
                    return $dataProvider->event == '192.168.10.15' ? 'Salida' : 'Entrada';
                }
            ],
            'year',
            'number_years_day',
            [
                'attribute'=>'Time',
                'value'=>function($dataProvider){
                    return Yii::$app->formatter->asDatetime($dataProvider->unix_time, 'short');
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
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [ 
                    'update' => False, 
                    'delete' => False
                ],
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
