<?php
    use kartik\select2\Select2;
    use app\models\Pegawai;
use yii\helpers\ArrayHelper;

$jabatan =0;
$satuanKerja ='';

    if (Yii::$app->user->identity->pegawai) {
        $jabatan = Yii::$app->user->identity->pegawai->id_jabatan_fungsional;
        $satuanKerja = Yii::$app->user->identity->pegawai->id_satuan_kerja;
        $pegawai = ArrayHelper::map((Pegawai::find()

        ->select(['id_pegawai', 'nama'=>"concat(nip,' - ',gelar_depan,' ', nama,' ',gelar_belakang ,' - ', nama_jabatan_fungsional)"])
        ->leftJoin('tb_m_jabatan_fungsional', 'tb_m_jabatan_fungsional.id_jabatan_fungsional = tb_m_pegawai.id_jabatan_fungsional')
          ->where(['id_atasan' => $jabatan ,'tb_m_pegawai.id_satuan_kerja'=>$satuanKerja])
          ->asArray()
          ->all()), 'id_pegawai', 'nama');
        ;
    } else {
        $satuanKerja = Yii::$app->user->identity->id_satuan_kerja;
        $pegawai = ArrayHelper::map((Pegawai::find()

      ->select(['id_pegawai', 'nama'=>"concat(nip,' - ',gelar_depan,' ', nama,' ',gelar_belakang ,' - ', nama_jabatan_fungsional ,' - ', nama_satuan_kerja)"])
      ->innerJoin('tb_m_satuan_kerja', 'tb_m_satuan_kerja.id_satuan_kerja = tb_m_pegawai.id_satuan_kerja')
      ->leftJoin('tb_m_jabatan_fungsional', 'tb_m_jabatan_fungsional.id_jabatan_fungsional = tb_m_pegawai.id_jabatan_fungsional')
        ->where('coalesce(tb_m_pegawai.id_satuan_kerja,0) '. (is_null($satuanKerja) ? '<>0' : '='.$satuanKerja))
        ->orderBy('tb_m_pegawai.id_satuan_kerja,id_eselon')
        ->asArray()
        ->all()), 'id_pegawai', 'nama');
        ;
    }

   

?>
<td>
 <?=$form->field($model, "[$key]id_pegawai")->widget(Select2::className(), [
    'data'=>$pegawai,
    'options'=>['placeholder'=>'Pilih Pegawai'],
    'pluginOptions'=>['allowClear'=>true],
    ])->label(false);

  ?>
</td>
<td>
<a data-action="delete" id='delete3' class="btn btn-danger btn-sm" title="Hapus"> <span class="fa fa-trash"></span></a>
</td>