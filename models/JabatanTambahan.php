<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tb_m_jabatan_tambahan}}".
 *
 * @property int $id_jabatan_tambahan
 * @property string $nama_jabatan
 * @property string $tambahan_tpp
 *
 * @property TbMPegawai[] $tbMPegawais
 */
class JabatanTambahan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tb_m_jabatan_tambahan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tambahan_tpp','tunjangan_tpp'], 'number'],
            [['nama_jabatan'], 'string', 'max' => 100],
            [['nama_jabatan'], 'required'],
            [['nama_jabatan'], 'unique'],


        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_jabatan_tambahan' => Yii::t('app', 'Id Jabatan Tambahan'),
            'nama_jabatan' => Yii::t('app', 'Nama Jabatan'),
            'tambahan_tpp' => Yii::t('app', 'Tambahan Tpp'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTbMPegawais()
    {
        return $this->hasMany(TbMPegawai::className(), ['id_jabatan_tambahan' => 'id_jabatan_tambahan']);
    }
}
