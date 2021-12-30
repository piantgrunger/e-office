<?php

use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Arrayhelper;
use kartik\widgets\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\SuratMasuk */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="surat-masuk-form">

    <?php $form = ActiveForm::begin([
          'layout' => 'horizontal'
    ]); ?>
        <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->

        <?php
               if ($model->id_satuan_kerja == null) {
                   echo $form->field($model, 'id_satuan_kerja')->widget(Select2::classname(), [
                          'data' => Arrayhelper::map(app\models\SatuanKerja::find()->all(), 'id_satuan_kerja', 'nama_satuan_kerja'),
                          'options' => ['placeholder' => 'Pilih Satuan Kerja ...'],
                          'pluginOptions' => [
                              'allowClear' => true
                          ],
                      ]);
               } else {
                   echo $form->field($model, 'id_satuan_kerja')->hiddenInput()->label(false);
               }
        
        
        ?>

    <?= $form->field($model, 'nomor_surat')->textInput(['maxlength' => true  ,
        'placeholder' => 'Nomor Surat']) ?>
    

    <?= $form->field($model, 'id_jenis_surat')->widget(Select2::className(), [
        'data'=> ArrayHelper::map(\app\models\JenisSurat::find()->select(['id','nama'=>"concat(kode,' - ',nama)"])->asArray()->all(), 'id', 'nama'),
        'options'=>['placeholder'=>'Pilih Jenis Surat'],
        'pluginOptions'=>['allowClear'=>true],
    ]) ?>
    

    <?= $form->field($model, 'sifat')->widget(
        Select2::className(),
        [
        'data'=>['Biasa'=>'Biasa','Penting'=>'Penting','Segera'=>'Segera','Rahasia'=>'Rahasia','Lainnya'=>'Lainnya'],
        'options'=>['placeholder'=>'Pilih Sifat Surat'],
        'pluginOptions'=>['allowClear'=>true],
    ]
    ) ?>
    

    <?= $form->field($model, 'tgl_surat')->widget(DateControl::className(), [
        'type'=>DateControl::FORMAT_DATE,
        'widgetOptions' => [
            'type' => 1,
            'pluginOptions' => [
                'autoclose' => true,
               
                
            ]
        ]
    ]) ?>
    
    
   
    <?=$form->field($model, 'id_pengirim')->widget(Select2::className(), [
        'data'=>ArrayHelper::map(app\models\SatuanKerja::find()->select(['id_satuan_kerja','nama_satuan_kerja'])->asArray()->all(), 'id_satuan_kerja', 'nama_satuan_kerja'),
        'options'=>['placeholder'=>'Pilih Pengirim Surat Internal'],
        'pluginOptions'=>['allowClear'=>true],
    ])->label('Asal Pengirim Surat Internal');?>
    

    <?= $form->field($model, 'asal_surat')->textInput(['maxlength' => true,
        'placeholder' => 'Asal Pengirim Surat External'])
        ->label('Asal Pengirim Surat External') ?>
    

    <?= $form->field($model, 'perihal')->textArea(['rows' => 6]) ?>
    <?= $form->field($model, 'isi_surat')->textArea(['rows' => 6]) ?>
    


    <?= $form->field($model, 'file_surat')->widget(FileInput::className(), [
  'options' => ['accept' => 'PDF'],
  'pluginOptions' => [
      'overwriteInitial'=>true,
      'showUpload' => false,
      'initialPreview'=> [
          Url::to(['/document\/'.$model->file_surat], true),
      ],
      'initialPreviewFileType'=> 'pdf' , // image is the default and can be overridden in config below
 

      //'initialCaption'=>$model->proposal,
      'initialPreviewAsData'=>true,
  ],
])
?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
