<?php


use hscstudio\mimin\components\Mimin;
use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\Pjax;

$gridColumns=[['class' => 'yii\grid\SerialColumn'],
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
        return  strtoupper($model->asal_surat).' <hr>  '. $model->perihal;
    }
] ,

// 'tgl_terima',
            // 'asal_surat',
            // 'perihal',
            // 'file_surat',

         ['class' => 'app\widgets\grid\ActionColumn',   'template' => Mimin::filterActionColumn([
              'update','delete','view'], $this->context->route),    ],    ];


/* @var $this yii\web\View */
/* @var $searchModel app\models\SuratMasukSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Surat Masuk';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="surat-masuk-index">
<h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);?>

    <p> <?php if ((Mimin::checkRoute($this->context->id."/create"))) { ?>        <?=  Html::a('Surat Masuk Baru', ['create'], ['class' => 'btn btn-success']) ?>
    <?php } ?>    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
           ]);
 ?>
    <?php Pjax::end(); ?>
</div>
