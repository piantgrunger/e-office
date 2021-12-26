<?php

namespace app\models;

use Yii;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;


/**
 * This is the model class for table "tb_m_kelas_jabatan".
 *
 * @property int $id_kelas_jabatan
 * @property int $kelas_jabatan
 * @property string $tpp_statis
 * @property string $beban_kerja
 * @property string $prestasi_kerja
 * @property string $tempat_bertugas
 * @property string $kondisi_kerja
 * @property string $kelangkaan_profesi
 * @property string $pertimbangan_lainnya
 */
class KelasJabatan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */


    public static function tableName()
    {
        return 'tb_m_kelas_jabatan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kelas_jabatan', 'tpp_statis'], 'required'],
            [['tpp_statis', 'beban_kerja', 'prestasi_kerja', 'tempat_bertugas', 'kondisi_kerja', 'kelangkaan_profesi', 'pertimbangan_lainnya','pembulatan'], 'number'],
            [['tpp_statis', 'beban_kerja', 'prestasi_kerja', 'tempat_bertugas', 'kondisi_kerja', 'kelangkaan_profesi', 'pertimbangan_lainnya'],  'default', 'value' => 0],
        ];
    }


   
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_kelas_jabatan' => 'Id Kelas Jabatan',
            'kelas_jabatan' => 'Kelas Jabatan',
            'tpp_statis' => 'TPP',
            'beban_kerja' => 'Beban Kerja',
            'prestasi_kerja' => 'Prestasi Kerja',
            'tempat_bertugas' => 'Tempat Bertugas',
            'kondisi_kerja' => 'Kondisi Kerja',
            'kelangkaan_profesi' => 'Kelangkaan Profesi',
            'pertimbangan_lainnya' => 'Pertimbangan Lainnya',
        ];
    }
}
