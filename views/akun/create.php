<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Akun */

$this->title = Yii::t('app', 'Akun Baru');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Daftar Akun'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="akun-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
