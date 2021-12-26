<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vw_absen_bulanan".
 *
 * @property int    $month(tgl_absen)
 * @property int    $year(tgl_absen)
 * @property int    $id_pegawai
 * @property string $1_pagi
 * @property string $1_siang
 * @property string $2_pagi
 * @property string $2_siang
 * @property string $3_pagi
 * @property string $3_siang
 * @property string $4_pagi
 * @property string $4_siang
 * @property string $5_pagi
 * @property string $5_siang
 * @property string $6_pagi
 * @property string $6_siang
 * @property string $7_pagi
 * @property string $7_siang
 * @property string $8_pagi
 * @property string $8_siang
 * @property string $9_pagi
 * @property string $9_siang
 * @property string $10_pagi
 * @property string $10_siang
 * @property string $11_pagi
 * @property string $11_siang
 * @property string $12_pagi
 * @property string $12_siang
 * @property string $13_pagi
 * @property string $13_siang
 * @property string $14_pagi
 * @property string $14_siang
 * @property string $15_pagi
 * @property string $15_siang
 * @property string $16_pagi
 * @property string $16_siang
 * @property string $17_pagi
 * @property string $17_siang
 * @property string $18_pagi
 * @property string $18_siang
 * @property string $19_pagi
 * @property string $19_siang
 * @property string $20_pagi
 * @property string $20_siang
 * @property string $21_pagi
 * @property string $21_siang
 * @property string $22_pagi
 * @property string $22_siang
 * @property string $23_pagi
 * @property string $23_siang
 * @property string $24_pagi
 * @property string $24_siang
 * @property string $25_pagi
 * @property string $25_siang
 * @property string $26_pagi
 * @property string $26_siang
 * @property string $27_pagi
 * @property string $27_siang
 * @property string $28_pagi
 * @property string $28_siang
 * @property string $29_pagi
 * @property string $29_siang
 * @property string $30_pagi
 * @property string $30_siang
 * @property string $31_pagi
 * @property string $31_siang
 */
class AbsenBulanan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
   public $nama_satuan_kerja;
    public static function tableName()
    {
        return 'tb_mt_absen_bulanan';
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
            [['bulan', 'tahun', 'id_pegawai'], 'integer'],
            [['id_pegawai'], 'required'],
            [['1_pagi', '1_siang', '2_pagi', '2_siang', '3_pagi', '3_siang', '4_pagi', '4_siang', '5_pagi', '5_siang', '6_pagi', '6_siang', '7_pagi', '7_siang', '8_pagi', '8_siang', '9_pagi', '9_siang', '10_pagi', '10_siang', '11_pagi', '11_siang', '12_pagi', '12_siang', '13_pagi', '13_siang', '14_pagi', '14_siang', '15_pagi', '15_siang', '16_pagi', '16_siang', '17_pagi', '17_siang', '18_pagi', '18_siang', '19_pagi', '19_siang', '20_pagi', '20_siang', '21_pagi', '21_siang', '22_pagi', '22_siang', '23_pagi', '23_siang', '24_pagi', '24_siang', '25_pagi', '25_siang', '26_pagi', '26_siang', '27_pagi', '27_siang', '28_pagi', '28_siang', '29_pagi', '29_siang', '30_pagi', '30_siang', '31_pagi', '31_siang'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'month(tgl_absen)' => Yii::t('app', 'Month(tgl Absen)'),
            'year(tgl_absen)' => Yii::t('app', 'Year(tgl Absen)'),
            'id_pegawai' => Yii::t('app', 'Id Pegawai'),
            '1_pagi' => Yii::t('app', '1 Pagi'),
            '1_siang' => Yii::t('app', '1 Siang'),
            '2_pagi' => Yii::t('app', '2 Pagi'),
            '2_siang' => Yii::t('app', '2 Siang'),
            '3_pagi' => Yii::t('app', '3 Pagi'),
            '3_siang' => Yii::t('app', '3 Siang'),
            '4_pagi' => Yii::t('app', '4 Pagi'),
            '4_siang' => Yii::t('app', '4 Siang'),
            '5_pagi' => Yii::t('app', '5 Pagi'),
            '5_siang' => Yii::t('app', '5 Siang'),
            '6_pagi' => Yii::t('app', '6 Pagi'),
            '6_siang' => Yii::t('app', '6 Siang'),
            '7_pagi' => Yii::t('app', '7 Pagi'),
            '7_siang' => Yii::t('app', '7 Siang'),
            '8_pagi' => Yii::t('app', '8 Pagi'),
            '8_siang' => Yii::t('app', '8 Siang'),
            '9_pagi' => Yii::t('app', '9 Pagi'),
            '9_siang' => Yii::t('app', '9 Siang'),
            '10_pagi' => Yii::t('app', '10 Pagi'),
            '10_siang' => Yii::t('app', '10 Siang'),
            '11_pagi' => Yii::t('app', '11 Pagi'),
            '11_siang' => Yii::t('app', '11 Siang'),
            '12_pagi' => Yii::t('app', '12 Pagi'),
            '12_siang' => Yii::t('app', '12 Siang'),
            '13_pagi' => Yii::t('app', '13 Pagi'),
            '13_siang' => Yii::t('app', '13 Siang'),
            '14_pagi' => Yii::t('app', '14 Pagi'),
            '14_siang' => Yii::t('app', '14 Siang'),
            '15_pagi' => Yii::t('app', '15 Pagi'),
            '15_siang' => Yii::t('app', '15 Siang'),
            '16_pagi' => Yii::t('app', '16 Pagi'),
            '16_siang' => Yii::t('app', '16 Siang'),
            '17_pagi' => Yii::t('app', '17 Pagi'),
            '17_siang' => Yii::t('app', '17 Siang'),
            '18_pagi' => Yii::t('app', '18 Pagi'),
            '18_siang' => Yii::t('app', '18 Siang'),
            '19_pagi' => Yii::t('app', '19 Pagi'),
            '19_siang' => Yii::t('app', '19 Siang'),
            '20_pagi' => Yii::t('app', '20 Pagi'),
            '20_siang' => Yii::t('app', '20 Siang'),
            '21_pagi' => Yii::t('app', '21 Pagi'),
            '21_siang' => Yii::t('app', '21 Siang'),
            '22_pagi' => Yii::t('app', '22 Pagi'),
            '22_siang' => Yii::t('app', '22 Siang'),
            '23_pagi' => Yii::t('app', '23 Pagi'),
            '23_siang' => Yii::t('app', '23 Siang'),
            '24_pagi' => Yii::t('app', '24 Pagi'),
            '24_siang' => Yii::t('app', '24 Siang'),
            '25_pagi' => Yii::t('app', '25 Pagi'),
            '25_siang' => Yii::t('app', '25 Siang'),
            '26_pagi' => Yii::t('app', '26 Pagi'),
            '26_siang' => Yii::t('app', '26 Siang'),
            '27_pagi' => Yii::t('app', '27 Pagi'),
            '27_siang' => Yii::t('app', '27 Siang'),
            '28_pagi' => Yii::t('app', '28 Pagi'),
            '28_siang' => Yii::t('app', '28 Siang'),
            '29_pagi' => Yii::t('app', '29 Pagi'),
            '29_siang' => Yii::t('app', '29 Siang'),
            '30_pagi' => Yii::t('app', '30 Pagi'),
            '30_siang' => Yii::t('app', '30 Siang'),
            '31_pagi' => Yii::t('app', '31 Pagi'),
            '31_siang' => Yii::t('app', '31 Siang'),
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
