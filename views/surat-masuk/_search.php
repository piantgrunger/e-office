<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SuratMasukSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="surat-masuk-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nomor_surat') ?>

    <?= $form->field($model, 'id_jenis_surat') ?>

    <?= $form->field($model, 'sifat') ?>

    <?= $form->field($model, 'tgl_surat') ?>

    <?php // echo $form->field($model, 'tgl_terima') ?>

    <?php // echo $form->field($model, 'asal_surat') ?>

    <?php // echo $form->field($model, 'perihal') ?>

    <?php // echo $form->field($model, 'file_surat') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
