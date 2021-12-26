<?php

namespace app\models;

use Yii;
use mdm\behaviors\ar\RelationTrait;

/**
 * This is the model class for table "tb_mt_skp".
 *
 * @property int $id_skp
 * @property int $id_pegawai
 * @property int $id_penilai
 * @property string $uraian_tugas
 * @property string $angka_kredit
 * @property int $kuantitas
 * @property string $satuan_kuantitas
 * @property int $waktu
 * @property string $satuan_waktu
 * @property string $biaya
 * @property int $tahun
 *
 * @property TbDtSkp[] $tbDtSkps
 * @property TbMPegawai $pegawai
 * @property TbMPegawai $penilai
 */
class SasaranKinerjaPegawai extends \yii\db\ActiveRecord
{
   public $total;

    use RelationTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_mt_skp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pegawai', 'id_penilai', 'uraian_tugas', 'kuantitas', 'satuan_kuantitas', 'waktu', 'satuan_waktu', 'tahun'], 'required'],
            [['id_pegawai', 'id_penilai', 'kuantitas', 'waktu', 'tahun'], 'integer'],
            [['uraian_tugas','status_skp','status_verifikasi','keterangan'], 'string'],
            [['angka_kredit', 'biaya'], 'number'],
           [['tanggal_skp'],'safe'],
            [['satuan_kuantitas', 'satuan_waktu'], 'string', 'max' => 255],
            [['id_pegawai'], 'exist', 'skipOnError' => true, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['id_pegawai' => 'id_pegawai']],
            [['id_penilai'], 'exist', 'skipOnError' => true, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['id_penilai' => 'id_pegawai']],
            [['waktu'], 'number', 'max' => '12', 'whenClient' => 'function (attribute, value) {return $("#sasarankinerjapegawai-satuan_waktu").val() == "Bulan";}'],
  
          [['angka_kredit'],'required','when' => function($model) {
             
             return $model->pegawai->jabatanFungsional->status_jabatan ==='Fungsional Tertentu';
            },'message' => 'Pegawai JFT Harus Mengisi Angka Kredit','enableClientValidation' => false
              ],
              
            [['status_skp'] ,'default','value' => 'Diajukan' ],
            [['kuantitas'], 'checkKuantitas'],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function checkKuantitas($attribute, $params)
    {
        // no real check at the moment to be sure that the error is triggered
        //     $pos = substr($this->nik, 0, 4);
        //     if ((strlen($this->nik) !== 16) || ($pos !== '3523')) {
        //         $this->addError($attribute, 'Format NIK Harus 16 digit dan diawali 3523');
        //         return false;
        //     }
      
       if (count($this->detailSasaranKinerjaPegawai)==0)
       {
         $this->addError($attribute, 'SKP Harus di breakdown dulu per bulan');
    
         return false;
       }  
         
        $qty = 0;
        foreach ($this->detailSasaranKinerjaPegawai as $detail) {
            $qty += $detail->kuantitas;
        }

        if ($qty != $this->kuantitas) {
            $this->addError($attribute, 'Kuantitas tidak sama dengan breakdown perbulan');

            return false;
        } else {
            return true;
        }
    }
    public function attributeLabels()
    {
        return [
            'id_skp' => Yii::t('app', 'Id Skp'),
            'id_pegawai' => Yii::t('app', 'Id Pegawai'),
            'id_penilai' => Yii::t('app', 'Id Penilai'),
            'uraian_tugas' => Yii::t('app', 'Uraian Tugas'),
            'angka_kredit' => Yii::t('app', 'Angka Kredit'),
            'kuantitas' => Yii::t('app', 'Kuantitas'),
            'satuan_kuantitas' => Yii::t('app', 'Satuan Kuantitas'),
            'waktu' => Yii::t('app', 'Waktu'),
            'satuan_waktu' => Yii::t('app', 'Satuan Waktu'),
            'biaya' => Yii::t('app', 'Biaya'),
            'tahun' => Yii::t('app', 'Tahun'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetailSasaranKinerjaPegawai()
    {
        return $this->hasMany(DetSasaranKinerjaPegawai::className(), ['id_skp' => 'id_skp']);
    }

    public function SetDetailSasaranKinerjaPegawai($value)
    {
        return $this->loadRelated('detailSasaranKinerjaPegawai', $value);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'id_pegawai']);
    }
  public function getSkp_all()
    {
        return SasaranKinerjaPegawai::find()->where(['id_pegawai' => $this->id_pegawai,'tahun'=>$this->tahun])->select(new \yii\db\Expression('status_skp,count(*) as total'))->groupBy('status_skp')->all() ;
    }

  
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPenilai()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'id_penilai']);
    }
}
