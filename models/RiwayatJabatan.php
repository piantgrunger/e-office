<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tb_m_riwayat_jabatan}}".
 *
 * @property int $id_riwayat_jabatan
 * @property int $id_pegawai
 * @property int $id_jabatan
 * @property string $nama_jabatan
 * @property string $tmt
 * @property string $no_sk
 * @property string $pejabat
 */
class RiwayatJabatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tb_m_riwayat_jabatan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pegawai', 'id_jabatan'], 'integer'],
            [['tmt'], 'safe'],
            [['nama_jabatan','unit_kerja'], 'string', 'max' => 255],
            [['no_sk', 'pejabat'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_riwayat_jabatan' => Yii::t('app', 'Id Riwayat Jabatan'),
            'id_pegawai' => Yii::t('app', 'Id Pegawai'),
            'id_jabatan' => Yii::t('app', 'Id Jabatan'),
            'nama_jabatan' => Yii::t('app', 'Nama Jabatan'),
            'tmt' => Yii::t('app', 'Tmt'),
            'no_sk' => Yii::t('app', 'No Sk'),
            'pejabat' => Yii::t('app', 'Pejabat'),
        ];
    }
    public function getPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'id_pegawai']);
    }
  
     public function getJabatanFungsional()
    {
        return $this->hasOne(JabatanFungsional::className(), ['id_jabatan_fungsional' => 'id_jabatan']);
    }

}
