<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use GuzzleHttp\Client;

/**
 * This is the model class for table "tb_mt_usul_kenaikan_pangkat".
 *
 * @property int $id_usul_kenaikan_pangkat
 * @property int|null $id_pegawai
 * @property string|null $tanggal_efektif
 * @property int|null $id_jenis_kenaikan_pangkat
 * @property string|null $catatan
 *
 * @property TbMJenisKenaikanPangkat $jenisKenaikanPangkat
 * @property TbMPegawai $pegawai
 */
class UsulKenaikanPangkat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_mt_usul_kenaikan_pangkat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pegawai', 'id_jenis_kenaikan_pangkat'], 'integer'],
            [['tanggal_efektif'], 'safe'],
            [['catatan'], 'string'],
            [['id_pegawai'], 'exist', 'skipOnError' => true, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['id_pegawai' => 'id_pegawai']],
            [['id_jenis_kenaikan_pangkat'], 'exist', 'skipOnError' => true, 'targetClass' => JenisKenaikanPangkat::className(), 'targetAttribute' => ['id_jenis_kenaikan_pangkat' => 'id_jenis_kenaikan_pangkat']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_usul_kenaikan_pangkat' => 'Id Usul Kenaikan Pangkat',
            'id_pegawai' => 'Pegawai',
            'tanggal_efektif' => 'Tanggal Efektif',
            'id_jenis_kenaikan_pangkat' => 'Jenis Kenaikan Pangkat',
            'catatan' => 'Catatan',
        ];
    }

  public function sendNotif() {
            $client = new Client();
      $pesan =' *Kepada Yth. ' .$this->pegawai->nama_lengkap .'* \n kenaikan pangkat anda '
      .$this->jenisKenaikanPangkat->jenis_kenaikan_pangkat.' sudah diusulkan silahkan lengkapi syarat : \n '
      .$this->jenisKenaikanPangkat->syarat.' \n *Silahkan Unggah data anda di* https://banjarbaru-bagawi.id/pegawai/upload-kelengkapan?id='.$this->id_pegawai;
      $data = [
      'number' => $this->pegawai->telepon.'@c.us',
      'message' => $pesan,
      ];

      $client->request("POST", Yii::$app->params['urlSendWA'], [
        'form_params' => $data,
    

      ]);


  }



    public function behaviors()
    {
        return [
            'tgl_resmiBeforeSave' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'tanggal_efektif',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'tanggal_efektif',
                ],

                'value' => function () {
                    return implode('-', array_reverse(explode('-', $this->tanggal_efektif)));
                },
            ],
        ];
    }


    /**
     * Gets query for [[JenisKenaikanPangkat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJenisKenaikanPangkat()
    {
        return $this->hasOne(JenisKenaikanPangkat::className(), ['id_jenis_kenaikan_pangkat' => 'id_jenis_kenaikan_pangkat']);
    }

    /**
     * Gets query for [[Pegawai]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'id_pegawai']);
    }
}
