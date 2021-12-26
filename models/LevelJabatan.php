<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_m_level_jabatan".
 *
 * @property int    $id_level_jabatan
 * @property string $nama_level_jabatan
 * @property int    $kelas_level_jabatan
 * @property string $nilai_jabatan
 * @property string $ikkd
 * @property string $tpp_dinamis
 * @property string $tpp_statis
 */
class LevelJabatan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_m_level_jabatan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_level_jabatan', 'kelas_level_jabatan', 'nilai_jabatan', 'ikkd', 'tpp_dinamis', 'tpp_statis'], 'required'],
            [['kelas_level_jabatan'], 'integer'],
            [['nilai_jabatan', 'ikkd', 'tpp_dinamis', 'tpp_statis'], 'number'],
            [['nama_level_jabatan'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_level_jabatan' => Yii::t('app', 'Id Level Jabatan'),
            'nama_level_jabatan' => Yii::t('app', 'Nama Level Jabatan'),
            'kelas_level_jabatan' => Yii::t('app', 'Kelas Level Jabatan'),
            'nilai_jabatan' => Yii::t('app', 'Nilai Jabatan'),
            'ikkd' => Yii::t('app', 'IKKD'),
            'tpp_dinamis' => Yii::t('app', 'TPP Dinamis'),
            'tpp_statis' => Yii::t('app', 'TPP Statis'),
        ];
    }
}
