<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tb_dt_hitung_tunjangan}}".
 *
 * @property int                 $id_d_hitung_tunjangan
 * @property int                 $id_hitung_tunjangan
 * @property int                 $id_pegawai
 * @property int                 $jumlah_absen
 * @property string              $total_jam_potong
 * @property string              $tunjangan_tpp
 * @property string              $capaian_kinerja
 * @property string              $tambahan_tpp
 * @property string              $total_tunjangan
 * @property TbMtHitungTunjangan $hitungTunjangan
 * @property TbMPegawai          $pegawai
 */
class DetHitungTunjangan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tb_dt_hitung_tunjangan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_hitung_tunjangan', 'id_pegawai', 'jumlah_absen'], 'integer'],
            [['total_jam_potong', 'tunjangan_tpp', 'capaian_kinerja', 'tambahan_tpp', 'total_tunjangan'], 'number'],
            [['id_hitung_tunjangan'], 'exist', 'skipOnError' => true, 'targetClass' => HitungTunjangan::className(), 'targetAttribute' => ['id_hitung_tunjangan' => 'id_hitung_tunjangan']],
            [['id_pegawai'], 'exist', 'skipOnError' => true, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['id_pegawai' => 'id_pegawai']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_d_hitung_tunjangan' => Yii::t('app', 'Id D Tambahan Penghasilan Pegawai'),
            'id_hitung_tunjangan' => Yii::t('app', 'Id Tambahan Penghasilan Pegawai'),
            'id_pegawai' => Yii::t('app', 'Id Pegawai'),
            'jumlah_absen' => Yii::t('app', 'Jumlah Absen'),
            'total_jam_potong' => Yii::t('app', 'Total Jam Potong'),
            'tunjangan_tpp' => Yii::t('app', 'Tunjangan Tpp'),
            'capaian_kinerja' => Yii::t('app', 'Capaian Kinerja'),
            'tambahan_tpp' => Yii::t('app', 'Tambahan Tpp'),
            'total_tunjangan' => Yii::t('app', 'Total Tunjangan'),
               'pegawai.nama_lengkap' =>'Nama',
            'pegawai.nama_jabatan' =>'Jabatan',
            'pegawai.eselon'=>'Eselon',
            'pegawai.kode_golongan' => 'Pangkat',
            'jumlah_absen' =>'Jumlah Absen',
            'total_jam_potong' =>'Potongan Terlambat / Cuti Besar (Jam)',
            'tunjangan_tpp2' =>'Tunjangan TPP',
            'capaian_kinerja' =>'Capaian Kinerja (%)',
            'total_banding' =>'Konversi Pembelaan Bulan Lalu',
            'tambahan_tpp' =>'Tambahan TPP',
                   ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHitungTunjangan()
    {
        return $this->hasOne(HitungTunjangan::className(), ['id_hitung_tunjangan' => 'id_hitung_tunjangan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTunjangan_tpp2()
    {
        return 2 * $this->tunjangan_tpp;
    }
    public function getPajak()
    {
        $pajak = 0;
        if (substr($this->pegawai->golongan -> kode_golongan, 0, 3) == "III") {
            $pajak = 5 / 100 * $this->total_tunjangan;
        }
        if (substr($this->pegawai->golongan -> kode_golongan, 0, 2) == "IV") {
            $pajak = 15 / 100 * $this->total_tunjangan;
        }
        return $pajak;
    }

    public function getTotal_netto()
    {
        return $this->total_tunjangan - $this->pajak;
    }


    public function getPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'id_pegawai']);
    }
}
