<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_mt_penilaian".
 *
 * @property int        $id_penilaian
 * @property int        $bulan
 * @property int        $tahun
 * @property string     $orientasi_pelayanan
 * @property string     $integritas
 * @property string     $komitmen
 * @property string     $disiplin
 * @property string     $kerjasama
 * @property string     $kepemimpinan
 * @property string     $jumlah
 * @property string     $rata_rata
 * @property string     $status
 * @property int        $id_pegawai
 * @property int        $id_penilai
 * @property TbMPegawai $penilai
 * @property TbMPegawai $pegawai
 */
class Penilaian extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_mt_penilaian';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bulan', 'tahun', 'orientasi_pelayanan', 'integritas', 'komitmen', 'disiplin', 'kerjasama', 'id_pegawai'], 'required'],
            [['bulan', 'tahun', 'id_pegawai', 'id_penilai'], 'integer'],
            ['bulan', 'unique', 'comboNotUnique' => 'Penilaian Pada Bulan Ini Telah Dibuat.', 'targetAttribute' => ['bulan', 'tahun', 'id_pegawai']],
            [['jumlah', 'rata_rata'], 'number'],
            [['orientasi_pelayanan', 'integritas', 'komitmen', 'disiplin', 'kerjasama', 'kepemimpinan'], 'number', 'min' => 0, 'max' => 98],
            [['jumlah'], 'defaultJumlah'],

            [['kepemimpinan'], 'required', 'enableClientValidation' => false, 'when' => function ($model) {
                return $model->pegawai->is_atasan;
            }],

            [['rata_rata'], 'defaultRatarata'],
            [['id_penilai'], 'default', 'value' => function ($model) {
                return yii::$app->user->identity->id_pegawai;
            }],

            [['status'], 'string', 'max' => 100],
            [['id_penilai'], 'exist', 'skipOnError' => true, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['id_penilai' => 'id_pegawai']],
            [['id_pegawai'], 'exist', 'skipOnError' => true, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['id_pegawai' => 'id_pegawai']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function defaultJumlah()
    {
        $this->jumlah = $this->orientasi_pelayanan + $this->integritas +$this->komitmen+ $this->disiplin + $this->kerjasama + (!is_numeric($this->kepemimpinan) ? 0 : $this->kepemimpinan);

        return true;
    }

    public function defaultRatarata()
    {
        $this->rata_rata = $this->jumlah / (!is_numeric($this->kepemimpinan) ? 5 : 6);

        return true;
    }

    public function attributeLabels()
    {
        return [
            'id_penilaian' => Yii::t('app', 'Id Penilaian'),
            'bulan' => Yii::t('app', 'Bulan'),
            'tahun' => Yii::t('app', 'Tahun'),
            'orientasi_pelayanan' => Yii::t('app', 'Orientasi Pelayanan'),
            'integritas' => Yii::t('app', 'Integritas'),
            'komitmen' => Yii::t('app', 'Komitmen'),
            'disiplin' => Yii::t('app', 'Disiplin'),
            'kerjasama' => Yii::t('app', 'Kerjasama'),
            'kepemimpinan' => Yii::t('app', 'Kepemimpinan'),
            'jumlah' => Yii::t('app', 'Jumlah'),
            'rata_rata' => Yii::t('app', 'Rata Rata'),
            'status' => Yii::t('app', 'Status'),
            'id_pegawai' => Yii::t('app', 'Id Pegawai'),
            'id_penilai' => Yii::t('app', 'Id Penilai'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPenilai()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'id_penilai']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'id_pegawai']);
    }


    public function getnilai_huruf($nilai) 
    {

        if($nilai<=50) {
            return "(Buruk)";
        } elseif($nilai<=60) {
            return "(Sedang)";
        } elseif($nilai<=75) {
            return "(Cukup)";
        } elseif($nilai<91) {
            return "(Baik)";
        } else {
            return "(Sangat Baik)";
        }

    }
}
