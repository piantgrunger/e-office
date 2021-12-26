<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vw_total_capaian_tahunan".
 *
 * @property int $id_pegawai
 * @property int|null $id_satuan_kerja
 * @property string|null $nip
 * @property string $nama
 * @property int $tahun
 * @property float|null $total_capaian
 * @property int $tugastambahan
 * @property float|null $capaian_total
 * @property float|null $rata_rata
 * @property float|null $nilai_akhir
 */
class TotalCapaianTahunan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vw_total_capaian_tahunan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pegawai', 'nama', 'tahun'], 'required'],
            [['id_pegawai', 'id_satuan_kerja', 'tahun', 'tugastambahan'], 'integer'],
            [['total_capaian', 'capaian_total', 'rata_rata', 'nilai_akhir'], 'number'],
            [['nip'], 'string', 'max' => 100],
            [['nama'], 'string', 'max' => 255],
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
            'tahun' => 'Tahun',
            'total_capaian' => 'Total Capaian',
            'tugastambahan' => 'Tugastambahan',
            'capaian_total' => 'Capaian Total',
            'rata_rata' => 'Rata Rata',
            'nilai_akhir' => 'Nilai Akhir',
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
