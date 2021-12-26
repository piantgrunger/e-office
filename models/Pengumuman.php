<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "tb_mt_pengumuman".
 *
 * @property int $id_pengumuman
 * @property string|null $tanggal_pengumuman
 * @property string $isi_pengumuman
 * @property int|null $id_satuan_kerja
 */
class Pengumuman extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_mt_pengumuman';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal_pengumuman'], 'safe'],
            [['isi_pengumuman'], 'required'],
            [['isi_pengumuman'], 'string'],
            [['id_satuan_kerja','id_pegawai','jumlah_penerima','jumlah_terkirim','jumlah_gagal'], 'integer'],
        ];
    }

  
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['tanggal_pengumuman'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                 'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pengumuman' => 'Id Pengumuman',
            'tanggal_pengumuman' => 'Tanggal Pengumuman',
            'isi_pengumuman' => 'Isi Pengumuman',
            'id_satuan_kerja' => 'Id Satuan Kerja',
        ];
    }
  
      public function getSatuanKerja()
    {
        return $this->hasOne(SatuanKerja::className(), ['id_satuan_kerja' => 'id_satuan_kerja']);
    }

      public function getPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'id_pegawai']);
    }

    public function getNama_satuan_kerja()
    {
        return is_null($this->satuanKerja) ? '' : $this->satuanKerja->nama_satuan_kerja;
    }
  
   public function getRecipient()
   {
     
     $model = Pegawai::find();
     if ( !is_null( $this->id_pegawai )) {
       $model->andWhere(['id_pegawai'=>$this->id_pegawai]);
     }
     if ( !is_null( $this->id_satuan_kerja )) {
       $model->andWhere(['id_satuan_kerja'=>$this->id_satuan_kerja])
       ->andWhere(['!=','telepon',""]);
     }
     $model->andWhere('telepon is not null');
     
     return $model->all();
     
     
   }  
  


}
