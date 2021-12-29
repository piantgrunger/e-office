<?php


use hscstudio\mimin\components\Mimin;
use yii\helpers\Html;
use app\widgets\grid\GridView;
use yii\widgets\Pjax;

$gridColumns=[['class' => 'yii\grid\SerialColumn'],
 'no_agenda',
[
    'label' => 'Nomor Surat - Tanggal Surat',
  'format' => 'raw',
    'value' => function ($model) {
        return $model->nomor_surat.' <br>  <b>Tanggal: </b>'. (Yii::$app->formatter->asDate($model->tgl_surat)) ."<br>".
        '<b>Diterima: </b> '. (Yii::$app->formatter->asDate($model->tgl_terima)) ."<br>";
    }
] ,
[
    'label' => 'Asal dan Isi Surat',
    'format' => 'raw',
    'value' => function ($model) {
        return "<b> Pengirim : </b>" .($model->pengirim? $model->pengirim->nama_satuan_kerja :  strtoupper($model->asal_surat)).' <hr style="dotted">  '. $model->perihal .'<br>'.$model->isi_surat.'<hr style="dotted"><center>' .Html::a('File Surat', ['/document/'.$model->file_surat], ['class' => 'btn btn-success btn-sm btn-waves' , 'target' => '_blank']) ."</center>";
    }
] ,


// 'tgl_terima',
            // 'asal_surat',
            // 'perihal',
            // 'file_surat',

         ['class' => 'app\widgets\grid\ActionColumn',   'template' => Mimin::filterActionColumn([
              'update','delete'], $this->context->route) ." <hr> <center>{disposisi} </center>",
                'buttons' => [
                    'disposisi' => function ($url, $model) {
                        return Html::a('<i class="fa fa-share-alt"></i> Disposisi', ['disposisi','id'=>$model->id], ['class' => 'btn  btn-sm btn-primary btn-waves']);
                    },

            ],
         ]
        ];


/* @var $this yii\web\View */
/* @var $searchModel app\models\SuratMasukSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Surat Masuk';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="surat-masuk-index">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);?>

    <p> <?php if ((Mimin::checkRoute($this->context->id."/create"))) { ?>        <?=  Html::a('Surat Masuk Baru', ['create'], ['class' => 'btn btn-success']) ?>
    <?php } ?>    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
      //  'filterModel' => $searchModel,
        'columns' => $gridColumns,
           ]);
 ?>
    <?php Pjax::end(); ?>
</div>
