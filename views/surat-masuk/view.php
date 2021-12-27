<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use hscstudio\mimin\components\Mimin;

/* @var $this yii\web\View */
/* @var $model app\models\SuratMasuk */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Daftar Surat Masuk', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="surat-masuk-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
             <?php if ((Mimin::checkRoute($this->context->id."/update"))){ ?>        <?= Html::a('Ubah', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php } if ((Mimin::checkRoute($this->context->id."/delete"))){ ?>        <?= Html::a('Hapus', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Apakah Anda yakin ingin menghapus item ini??',
                'method' => 'post',
            ],
        ]) ?>
        <?php } ?>    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nomor_surat',
            'id_jenis_surat',
            'sifat',
            'tgl_surat',
            'tgl_terima',
            'asal_surat',
            'perihal',
            'file_surat',
        ],
    ]) ?>

</div>
