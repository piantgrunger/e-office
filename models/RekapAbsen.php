<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vw_rekap_absen".
 *
 * @property int $id_pegawai
 * @property int $bulan
 * @property int $tahun
 * @property string $terlambat
 * @property string $tanpa_keterangan
 * @property string $ijin
 * @property string $cuti
 * @property string $libur
 */
class RekapAbsen extends \yii\db\ActiveRecord
{
    /**
     * {@inherit
     doc}
     */
   public $nama_skpd;
    public static function tableName()
    {
        return 'tb_mt_rekap_absen';
    }
    public static function primaryKey()
    {
        return ['id_pegawai'];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pegawai'], 'required'],
            [['id_pegawai', 'bulan', 'tahun'], 'integer'],
            [['terlambat', 'tanpa_keterangan', 'ijin', 'cuti', 'libur'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'satuanKerja.nama_satuan_kerja' => 'Nama Satuan Kerja',

            'id_pegawai' => 'Id Pegawai',
            'bulan' => 'Bulan',
            'tahun' => 'Tahun',
            'terlambat' => 'Terlambat',
            'tanpa_keterangan' => 'Tanpa Keterangan',
            'ijin' => 'Ijin',
            'cuti' => 'Cuti',
            'libur' => 'Libur',
        ];
    }
    public function getPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'id_pegawai']);
    }
    public function getSatuanKerja()
    {
        return $this->hasOne(SatuanKerja::className(), ['id_satuan_kerja' => 'id_satuan_kerja']);
    }

    public function getNama_lengkap()
    {
        return is_null($this->pegawai) ? '' : $this->pegawai->nama_lengkap;
    }
    public function getNip()
    {
        return is_null($this->pegawai) ? '' : $this->pegawai->nip;
    }
}
