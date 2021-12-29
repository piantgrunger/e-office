<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SuratMasuk */

$this->title = 'Surat Masuk Baru';
$this->params['breadcrumbs'][] = ['label' => 'Daftar Surat Masuk', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="surat-masuk-create">

  
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
