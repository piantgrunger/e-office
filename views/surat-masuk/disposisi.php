<?php
use hscstudio\mimin\components\Mimin;

use yii\helpers\Url;
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
    <div class="table-responsive">

   
  
    <?= DetailView::widget([
          'options' => ['class' => 'table table-hover',"style"=>"font-size:smaller;"],
          
  
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
                'contentOptions' => ['style' => 'width:50%; white-space: normal;'],

                
                'value' => function ($model) {
                    return "<p>". ($model->pengirim_surat).' <hr>  '. $model->perihal. "<br>".$model->isi_surat."</p>";
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
    </div>

    <div class="table-responsive">
<div class="card comment-block">
                                                    <div class="card-header">
                                                        <h5 class="card-header-text"><i class="icofont icofont-comment m-r-5"></i> Disposisi</h5>
                                                    </div>
                                                    <div class="card-block">
                                                        <ul class="media-list">
                                                          <?php foreach ($model->disposisi as $detail) { ?>  
                                                            <li class="media">
                                                                <div class="media-left">
                                                                    <a href="#">
                                                                        <img class="media-object img-radius comment-img" src="https://banjarbaru-bagawi.id/media/<?=$detail->pegawai->foto?>" >
                                                                    </a>
                                                                </div>
                                                                <div class="media-body">
                                                                <?php if ((Mimin::checkRoute($this->context->id."/delete-disposisi"))) { ?>
                                                                    <span class="f-right"><a href='<?=Url::to(["delete-disposisi",'id'=>$detail->id])?>' data-method="POST" data-confirm="Apakah Anda yakin ingin menghapus disposisi ini??" class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i></a> </span>
                                                                <?php } ?>
                                                                    <h6 class="media-heading txt-primary"><?=$detail->pegawai->nama_lengkap?> - <?=$detail->pegawai->nama_jabatan?> <span class="f-12 text-muted m-l-5"><?=Yii::$app->formatter->asDate($detail->tanggal_disposisi)?></span></h6>
                                                                    <p><?=$detail->catatan_disposisi?></p>
                                                                    <p><?=$detail->jawaban_disposisi?></p>
                                                                    
                                                                    <div class="m-t-10 m-b-25">
                                                                        <span class="f-14  "> <?=$detail->label_disposisi?></span> 
                                                                        <?php if (Yii::$app->user->identity->id_pegawai === $detail->id_pegawai) {?>
                                                                            <hr style="dashed">
                                                                        <span><a href="<?=Url::to(["create-disposisi",'id_disposisi'=>$detail->id,'id_surat_masuk'=>$detail->id_surat_masuk])?>" class="m-r-14 f-12 btn btn btn-primary btn-waves btn-sm">Disposisikan</a> </span>
                                                                        <span><a href="<?=Url::to(["jawab-disposisi",'id'=>$detail->id])?>" class="m-r-14 f-12 btn btn btn-info btn-waves btn-sm">Jawab Disposisi</a> </span>
                                  
                                                                        <?php } ?>
                                                                    </div>
                                                                    <hr>
                                                                </div>
                                                            </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </div>
 </div>


</div>
