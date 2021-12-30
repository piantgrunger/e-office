<?php


use hscstudio\mimin\components\Mimin;
use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\Pjax;

$gridColumns=[['class' => 'yii\grid\SerialColumn'],

[
    'label' => 'Nomor Surat - Tanggal Surat',
  'format' => 'raw',
    'value' => function ($detail) {
        $model = $detail->suratMasuk;
        return ($model) ?($model->nomor_surat.' <br>  <b>Tanggal: </b>'. (Yii::$app->formatter->asDate($model->tgl_surat)) ."<br>".
        '<b>Diterima: </b> '. (Yii::$app->formatter->asDateTime($model->tgl_terima)) ."<br>") : "";
    }
] ,
[
    'label' => 'Asal dan Isi Surat',
    'format' => 'raw',
    'value' => function ($detail) {
        $model = $detail->suratMasuk;
        return ($model) ?("<b> Pengirim : </b>" .($model->pengirim_surat).' <hr style="dotted">  '. $model->perihal .'<br>'.$model->isi_surat.'<hr style="dotted"><center>' .Html::a('<i class="fas fa-share"></i> Disposisi', ['disposisi','id'=>$model->id], ['class' => 'btn btn-info btn-sm btn-waves' , 'target' => '_blank' , 'data-pjax'=>0]) ."</center>") : "";
    }
] ,




// 'tgl_terima',
            // 'asal_surat',
            // 'perihal',
            // 'file_surat',
       ];


/* @var $this yii\web\View */
/* @var $searchModel app\models\SuratMasukSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Disposisi Surat Masuk';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="surat-masuk-index">
 <div class="table-responsive">   <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
      //  'filterModel' => $searchModel,
        'columns' => $gridColumns,
           ]);
 ?>
    <?php Pjax::end(); ?>
    </div>

</div>
