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
class RekapAbsenView extends \yii\db\ActiveRecord
{
    /**
     * {@inherit
     doc}
     */
   public $nama_skpd;
    public $id_satuan_kerja;


    public static function tableName()
    {
        return 'vw_rekap_absen_tahunan';
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
            [['id_pegawai',  'tahun'], 'integer'],
          
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
           'tahun' => 'Tahun',
               
          'tk1'=>'Januari',
          'tk2'=>'Februari',
          'tk3'=>'Maret',
          'tk4'=>'April',
          'tk5'=>'Mei',
          'tk6'=>'Juni',
          'tk7'=>'Juli',
          'tk8'=>'Agustus',
          'tk9'=>'September',
          'tk10'=>'Oktober',
          'tk11'=>'November',
          'tk12'=>'Desember',
          'tktotal'=>'Total',
          
       
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
