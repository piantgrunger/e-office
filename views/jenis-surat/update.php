<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\JenisSurat */

$this->title = 'Update Jenis Surat: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Daftar Jenis Surat', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jenis-surat-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
