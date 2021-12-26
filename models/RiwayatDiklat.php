<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tb_m_riwayat_diklat}}".
 *
 * @property int $id_riwayat_diklat
 * @property int $id_pegawai
 * @property string $tgl_mulai
 * @property string $tgl_selesai
 * @property string $nama_diklat
 * @property string $penyelenggara
 * @property string $tempat
 * @property string $tgl_sttp
 * @property string $no_sttp
 * @property double $jam
 */
class RiwayatDiklat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tb_m_riwayat_diklat}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pegawai'], 'integer'],
            [['tgl_mulai', 'tgl_selesai', 'tgl_sttp'], 'safe'],
            [['jam'], 'number'],
            [['nama_diklat', 'penyelenggara', 'tempat'], 'string', 'max' => 255],
            [['no_sttp'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_riwayat_diklat' => Yii::t('app', 'Id Riwayat Diklat'),
            'id_pegawai' => Yii::t('app', 'Id Pegawai'),
            'tgl_mulai' => Yii::t('app', 'Tgl Mulai'),
            'tgl_selesai' => Yii::t('app', 'Tgl Selesai'),
            'nama_diklat' => Yii::t('app', 'Nama Diklat'),
            'penyelenggara' => Yii::t('app', 'Penyelenggara'),
            'tempat' => Yii::t('app', 'Tempat'),
            'tgl_sttp' => Yii::t('app', 'Tgl Sttp'),
            'no_sttp' => Yii::t('app', 'No Sttp'),
            'jam' => Yii::t('app', 'Jam'),
        ];
    }
}
