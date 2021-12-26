<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vw_capaian_pegawai".
 *
 * @property int $id_pegawai
 * @property int $id_satuan_kerja
 * @property string $nip
 * @property string $nama
 * @property string $uraian_tugas
 * @property int $tahun
 * @property int $bulan
 * @property string $kuantitas
 * @property string $satuan_kuantitas
 * @property string $kuantitas_realisasi
 * @property string $kualitas_realisasi
 * @property string $nilai_capaian
 */
class TotalCapaianPegawai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vw_total_capaian';
    }
    public static function primaryKey()
    {
        return ['id_pegawai'];
    }
    public function getPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['nip' => 'nip']);
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pegawai', 'nama', 'uraian_tugas', 'tahun', 'bulan', 'kuantitas'], 'required'],
            [['id_pegawai', 'id_satuan_kerja', 'tahun', 'bulan'], 'integer'],
            [['uraian_tugas'], 'string'],
            [['kuantitas', 'kuantitas_realisasi', 'kualitas_realisasi', 'nilai_capaian'], 'number'],
            [['nip'], 'string', 'max' => 100],
            [['nama', 'satuan_kuantitas'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pegawai' => 'Id Pegawai',
            'id_satuan_kerja' => 'Id Satuan Kerja',
            'nip' => 'Nip',
            'nama' => 'Nama',
            'uraian_tugas' => 'Uraian Tugas',
            'tahun' => 'Tahun',
            'bulan' => 'Bulan',
            'kuantitas' => 'Kuantitas',
            'satuan_kuantitas' => 'Satuan Kuantitas',
            'kuantitas_realisasi' => 'Kuantitas Realisasi',
            'kualitas_realisasi' => 'Kualitas Realisasi',
            'nilai_capaian' => 'Nilai Capaian',
        ];
    }
  
  
    public function getCapaian_huruf()
    {
        if($this->capaian_total<=50) {
            return "Buruk";
        } elseif($this->capaian_total<=60) {
            return "Sedang";
        } elseif($this->capaian_total<=75) {
            return "Cukup";
        } elseif($this->capaian_total<91) {
            return "Baik";
        } else {
            return "Sangat Baik";
        }


    }
}
