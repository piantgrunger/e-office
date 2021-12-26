<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vw_capaian_pegawai_tahunan".
 *
 * @property int $id_pegawai
 * @property int|null $id_satuan_kerja
 * @property string|null $nip
 * @property string $nama
 * @property string $uraian_tugas
 * @property int $tahun
 * @property int $kuantitas
 * @property float|null $angka_kredit
 * @property string $satuan_waktu
 * @property float|null $biaya
 * @property string|null $satuan_kuantitas
 * @property int $waktu
 * @property float|null $kuantitas_realisasi
 * @property float|null $kualitas_realisasi
 * @property float|null $capaian
 * @property float|null $nilai_capaian
 */
class CapaianPegawaiTahunan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vw_capaian_pegawai_tahunan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pegawai', 'nama', 'uraian_tugas', 'tahun', 'kuantitas', 'satuan_waktu', 'waktu'], 'required'],
            [['id_pegawai', 'id_satuan_kerja', 'tahun', 'kuantitas', 'waktu'], 'integer'],
            [['uraian_tugas'], 'string'],
            [['angka_kredit', 'biaya', 'kuantitas_realisasi', 'kualitas_realisasi', 'capaian', 'nilai_capaian'], 'number'],
            [['nip'], 'string', 'max' => 100],
            [['nama', 'satuan_waktu', 'satuan_kuantitas'], 'string', 'max' => 255],
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
            'kuantitas' => 'Kuantitas',
            'angka_kredit' => 'Angka Kredit',
            'satuan_waktu' => 'Satuan Waktu',
            'biaya' => 'Biaya',
            'satuan_kuantitas' => 'Satuan Kuantitas',
            'waktu' => 'Waktu',
            'kuantitas_realisasi' => 'Kuantitas Realisasi',
            'kualitas_realisasi' => 'Kualitas Realisasi',
            'capaian' => 'Capaian',
            'nilai_capaian' => 'Nilai Capaian',
        ];
    }
    public function getPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'id_pegawai']);
    }
}

