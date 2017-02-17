<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Date */

$this->title = Yii::t('app', 'Create Date');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="date-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
