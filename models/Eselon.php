<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_m_eselon".
 *
 * @property int $id_eselon
 * @property string $nama_eselon
 * @property string $nilai_jabatan
 * @property string $ikkd
 * @property string $tpp_dinamis
 * @property string $tpp_statis
 *
 * @property TbMJabatanFungsional[] $tbMJabatanFungsionals
 */
class Eselon extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_m_eselon';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_eselon'], 'required'],
            [['nilai_jabatan', 'ikkd', 'tpp_dinamis', 'tpp_statis'], 'number'],
            [['nama_eselon'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_eselon' => Yii::t('app', 'Id Eselon'),
            'nama_eselon' => Yii::t('app', 'Nama Eselon'),
            'nilai_jabatan' => Yii::t('app', 'Nilai Jabatan'),
            'ikkd' => Yii::t('app', 'Ikkd'),
            'tpp_dinamis' => Yii::t('app', 'Tpp Dinamis'),
            'tpp_statis' => Yii::t('app', 'Tpp Statis'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbMJabatanFungsionals()
    {
        return $this->hasMany(TbMJabatanFungsional::className(), ['id_eselon' => 'id_eselon']);
    }
}
