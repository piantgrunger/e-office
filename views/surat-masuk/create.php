<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SuratMasuk */

$this->title = 'Surat Masuk Baru';
$this->params['breadcrumbs'][] = ['label' => 'Daftar Surat Masuk', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="surat-masuk-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
