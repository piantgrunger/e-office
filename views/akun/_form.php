<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Akun */
/* @var $form ActiveForm */
?>
<div class="akun-_form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'parent_id') ?>
        <?= $form->field($model, 'level') ?>
        <?= $form->field($model, 'kode') ?>
        <?= $form->field($model, 'nama') ?>
        <?= $form->field($model, 'd_k') ?>
        <?= $form->field($model, 'kelompok') ?>
        <?= $form->field($model, 'm_d') ?>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- akun-_form -->
