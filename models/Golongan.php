<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tb_m_golongan}}".
 *
 * @property int $id_golongan
 * @property string $kode_golongan
 * @property string $nama_golongan
 * @property string $nilai_jabatan
 * @property string $ikkd
 * @property string $tpp_dinamis
 * @property string $tpp_statis
 *
 * @property TbMPegawai[] $tbMPegawais
 */
class Golongan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tb_m_golongan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_golongan', 'nama_golongan', 'nilai_jabatan', 'ikkd', 'tpp_dinamis', 'tpp_statis'], 'required'],
            [['nilai_jabatan', 'ikkd', 'tpp_dinamis', 'tpp_statis'], 'number'],
            [['kode_golongan', 'nama_golongan'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_golongan' => Yii::t('app', 'Id Golongan'),
            'kode_golongan' => Yii::t('app', 'Kode Golongan'),
            'nama_golongan' => Yii::t('app', 'Nama Golongan'),
            'nilai_jabatan' => Yii::t('app', 'Nilai Jabatan'),
            'ikkd' => Yii::t('app', 'Ikkd'),
            'tpp_dinamis' => Yii::t('app', 'Tpp Dinamis'),
            'tpp_statis' => Yii::t('app', 'Tpp Statis'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbMPegawais()
    {
        return $this->hasMany(TbMPegawai::className(), ['id_golongan' => 'id_golongan']);
    }
}
