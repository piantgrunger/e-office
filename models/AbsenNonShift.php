<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


use Yii;

/**
 * This is the model class for table "tb_mt_absen_non_shift".
 *
 * @property int $id_absen
 * @property string $tgl_absen
 * @property int $id_pegawai
 * @property string $masuk_kerja
 * @property string $pulang_kerja
 * @property string $jam_kerja
 */
class AbsenNonShift extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_mt_absen_non_shift';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tgl_absen', 'id_pegawai','id_jenis_absen'], 'required'],
            [['tgl_absen', 'masuk_kerja', 'pulang_kerja'], 'safe'],
            [['id_pegawai'], 'integer'],
            [['jam_kerja'], 'number'],
            [['file_pendukung', 'alasan'], 'required', 'on' => 'Cuti'],

            [['pulang_kerja'], 'hitungJamKerja'],

        ];
    }
    public function hitungJamKerja($attribute, $params)
    {
        $this->jam_kerja = ceil((strtotime($this->pulang_kerja) - strtotime($this->masuk_kerja)) / 3600);
        if ($this->jam_kerja < 0) {
            $this->jam_kerja = 24 + $this->jam_kerja;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_absen' => 'Id Absen',
            'tgl_absen' => 'Tgl Absen',
            'id_pegawai' => 'Id Pegawai',
            'masuk_kerja' => 'Masuk Kerja',
            'pulang_kerja' => 'Pulang Kerja',
            'jam_kerja' => 'Jam Kerja',
        ];
    }
    public function behaviors()
    {
        return [
            'tgl_absenBeforeSave' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'tgl_absen',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'tgl_absen',
                ],

                'value' => function () {
                    return implode('-', array_reverse(explode('-', $this->tgl_absen)));
                },
            ],
        ];
    }

    public function getPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'id_pegawai']);
    }
    public function getJenisAbsen()
    {
        return $this->hasOne(JenisAbsen::className(), ['id_jenis_absen' => 'id_jenis_absen']);
    }

    public function getNama_jenis_absen()
    {
        return is_null($this->jenisAbsen) ? '' : $this->jenisAbsen->nama_jenis_absen;
    }
}
