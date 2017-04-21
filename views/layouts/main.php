<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('@web/img/log.png', ['alt'=>Yii::$app->name]),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            !Yii::$app->user->isGuest ? (
                ['label' => 'Start', 'items' => [
                        ['label' => 'File','url' => ['/file/index']],
                        ['label' => 'Data','url' => ['/data/index']],
                    ]
                ]
            ) : (            
                ['label' => 'Mission', 'url' => ['/site/index']]
            )
            ,!Yii::$app->user->isGuest ? (
                ['label' => 'Synthesis', 'items' => [
                        ['label' => 'Person','url' => ['/person/index']],
                        ['label' => 'Date','url' => ['/date/index']],
                    ]
                ]
            ) : (            
                ['label' => 'Vision', 'url' => ['/site/index']]
            )
            ,!Yii::$app->user->isGuest ? (
                ['label' => 'Analysis', 'items' => [
                        ['label' => 'Event','url' => ['/event/index']],
                        ['label' => 'Worked','url' => ['/worked/index']],
                    ]
                ]
            ) : (            
                ['label' => 'Values', 'url' => ['/site/index']]
            )
            ,!Yii::$app->user->isGuest ? (
                ['label' => 'Report', 'items' => [
                        ['label' => 'Record','url' => ['/record/index']],
                    ]
                ]
            ) : (            
                ['label' => 'Principles', 'url' => ['/site/index']]
            )
            ,Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
