<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_m_unit_kerja".
 *
 * @property int $id_unit_kerja
 * @property string $kode_unit_kerja
 * @property string $nama_unit_kerja
 */
class UnitKerja extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_m_unit_kerja';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_unit_kerja', 'nama_unit_kerja','id_satuan_kerja'], 'required'],
            [['kode_unit_kerja'], 'string', 'max' => 50],
            [['nama_unit_kerja'], 'string', 'max' => 100],
            [['tanggal_absen_terakhir'],'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_unit_kerja' => Yii::t('app', 'Id Unit Kerja'),
            'kode_unit_kerja' => Yii::t('app', 'Kode Unit Kerja'),
            'nama_unit_kerja' => Yii::t('app', 'Nama Unit Kerja'),
        ];
    }
    public function getSatuanKerja()
    {
        return $this->hasOne(SatuanKerja::className(), ['id_satuan_kerja' => 'id_satuan_kerja']);
    }
    public function getNama_satuan_kerja()
    {
        return is_null($this->satuanKerja) ? '' : $this->satuanKerja->nama_satuan_kerja;
    }

    public function getChecklog_key(){
        return md5($this->kode_unit_kerja);
    }
}
