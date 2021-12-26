<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_m_jadwal_kerja".
 *
 * @property int $id_d_jadwal
 * @property int $id_pegawai
 * @property string $tanggal
 * @property string $jam_masuk
 * @property string $jam_pulang
 *
 * @property TbMPegawai $pegawai
 */
class JadwalKerja extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $id_satuan_kerja;
    public $id_unit_kerja;

    public static function tableName()
    {
        return 'tb_m_jadwal_kerja';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pegawai', 'tanggal', 'jam_masuk', 'jam_pulang'], 'required'],
            [['id_pegawai'], 'integer'],
            [['tanggal', 'jam_masuk', 'jam_pulang','id_unit_kerja'], 'safe'],
            [['id_pegawai'], 'exist', 'skipOnError' => true, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['id_pegawai' => 'id_pegawai']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_d_jadwal' => Yii::t('app', 'Id D Jadwal'),
            'id_pegawai' => Yii::t('app', 'Id Pegawai'),
            'tanggal' => Yii::t('app', 'Tanggal'),
            'jam_masuk' => Yii::t('app', 'Jam Masuk'),
            'jam_pulang' => Yii::t('app', 'Jam Pulang'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'id_pegawai']);
    }
    public function getNama_pegawai()
    {
        return is_null($this->pegawai) ?'' : '' . $this->pegawai->nama_lengkap;
    }
}
