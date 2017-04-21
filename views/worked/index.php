<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\User;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\WorkedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Workeds');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="worked-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
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
