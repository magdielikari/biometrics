<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="site-index">

    <div class="jumbotron">
        <?=
            Html::img('@web/img/logo.jpg', ['alt'=>Yii::$app->name]);
        ?>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-3">
                <h2>Start</h2>

                <p> "File" te permite cargar el archivo de Excel.</p>
                <p> Con "Data" compruebas que se exportaron correctamente los datos.</p>

                <p><a class="btn btn-default" href="<?= Url::to(['file/index']);?>">File &raquo;</a></p>
            </div>
            <div class="col-lg-3">
                <h2>Synthesis</h2>
                    <p> "Person" contiene el registro de las personas.</p>
                    <p> "Date" contiene el registro de los días laborados.</p>
                <p><a class="btn btn-default" href="<?= Url::to(['person/index']);?>">Person &raquo;</a></p>
            </div>
            <div class="col-lg-3">
                <h2>Analysis</h2>

                    <p> "Event" contiene todos los registros ya sea de entrada o salida.</p>
                    <p> "Worked" contiene los pares de entrada-salida de los días laborados.</p>

                <p><a class="btn btn-default" href="<?= Url::to(['worked/index']);?>">Worked &raquo;</a></p>
            </div>
            <div class="col-lg-3">
                <h2>Report</h2>

                    <p> "Record" contiene un reporte con los días laborados por cada persona; 
                    así un total de horas laboradas y registradas en día.</p>

                <p><a class="btn btn-default" href="<?= Url::to(['record/index']);?>">Record &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
