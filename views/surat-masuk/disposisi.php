<?php

use app\widgets\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\data\ArrayDataProvider;

$dataProvider = new ArrayDataProvider([
    'allModels' => $model->disposisi,
     'sort' => [
        'attributes' => ['tgl_disposisi'],
    ],
    'pagination' => [
        'pageSize' => 20,
    ],
]);

/* @var $this yii\web\View */
/* @var $model app\models\SuratMasuk */

$this->title = $model->perihal;
$this->params['breadcrumbs'][] = ['label' => 'Daftar Surat Masuk', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="surat-masuk-view">

   
  
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Nomor Surat - Tanggal Surat',
              'format' => 'raw',
                'value' => function ($model) {
                    return $model->nomor_surat.' <br>  '. (Yii::$app->formatter->asDate($model->tgl_surat));
                }
            ] ,
            [
                'label' => 'Asal dan Isi Surat',
                'format' => 'raw',
                'value' => function ($model) {
                    return ($model->pengirim? $model->pengirim->nama_satuan_kerja :  strtoupper($model->asal_surat)).' <hr>  '. $model->perihal;
                }
            ] ,
            [
                'label' => 'File Surat',
                'format' => 'raw',
                'value' => function ($model) {
                    return  Html::a('File Surat', ['/document/'.$model->file_surat], ['class' => 'btn btn-success btn-waves' , 'target' => '_blank']);
                }
            ]
        ],
    ]) ?>

<?=Html::a('Disposisi Baru', ['create-disposisi','id'=>$model->id], ['class' => 'btn btn-info btn-waves']) ?>

<?= GridView::widget([
        'dataProvider' => $dataProvider,
    //    'filterModel' => $searchModel,
        'columns' => [
            'tanggal_disposisi:date',
            'pegawai.nama_lengkap',
            'pegawai.nama_jabatan',
            'status_disposisi',
            'catatan_disposisi',
        ],
           ]);
 ?>


</div>
