<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\File */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Files'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            [
                'attribute'=>'Size',
                'value'=>function($dataProvider){
                    return Yii::$app->formatter->asShortSize($dataProvider->size, 1);
                },
            ],
            'error',
            [
                'attribute'=>'Created_at',
                'value'=>function($dataProvider){
                    return Yii::$app->formatter->asDatetime($dataProvider->created_at, 'medium');
                },
            ],
            [
                'attribute'=>'Update_at',
                'value'=>function($dataProvider){
                    return User::findIdentity($dataProvider->created_by)->username;
                },
            ],
        ],
    ]) ?>

    <div class="row">
        <div class="col-md-6">
            <div class="alert alert-success" role="alert"> 
                !Se han migrado <?= $data ?> registros a Data de forma exitosa!
            </div>
        </div>

        <div class="col-md-6">
            <div class="alert alert-success" role="alert"> 
                !Se han migrado <?= $person ?> registros a Person de forma exitosa!
            </div>
        </div>
    </div>

    <?php /* Html::tag('div',  
        isset($event) && isset($date) ? Html::tag('div', 
            Html::tag('div', 
                '¡Se han migrado <?= $event ?> registros a Event de forma exitosa!',  
                ['class' => 'alert alert-success', 'role' => 'alert'] ),
            Html::tag('div', 
                '¡Se han migrado <?= $date ?> registros a Date de forma exitosa!',  
                ['class' => 'alert alert-success', 'role' => 'alert'] ), 
        ['class' => 'col-md-6']) : null, ['class' => 'row']) 
    */?>

    <?php /* Html::tag('div',  
        isset($worked) && isset($record) ? Html::tag('div', 
            Html::tag('div', 
                '¡Se han migrado <?= $worked ?> registros a Worked de forma exitosa!',  
                ['class' => 'alert alert-success', 'role' => 'alert'] ),
            Html::tag('div', 
                '¡Se han migrado <?= $record ?> registros a Record de forma exitosa!',  
                ['class' => 'alert alert-success', 'role' => 'alert'] ), 
        ['class' => 'col-md-6']) : null, ['class' => 'row']) 
    */?>
    
</div>
