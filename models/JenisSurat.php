<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jenis_surat".
 *
 * @property int $id
 * @property string $nama
 * @property string $keterangan
 */
class JenisSurat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jenis_surat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'kode'], 'required'],
            ['kode', 'unique'],
            
            [['keterangan'], 'string'],
            [['nama'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'keterangan' => 'Keterangan',
        ];
    }
}
