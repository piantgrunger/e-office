<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "akun".
 *
 * @property int $id
 * @property int $parent_id
 * @property int $level
 * @property string $kode
 * @property string $nama
 * @property string $d_k
 * @property string $m_d
 * @property string $Kelompok
 */
class Akun extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akun';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'level'], 'integer'],
            [['kode', 'nama', 'd_k', 'kelompok'], 'required'],
            [['kode'], 'string', 'max' => 10],
            [['nama', 'kelompok'], 'string', 'max' => 100],
            [['d_k', 'm_d'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'level' => 'Level',
            'kode' => 'Kode',
            'nama' => 'Nama',
            'd_k' => 'D K',
            'm_d' => 'M D',
            'kelompok' => 'Kelompok',
        ];
    }
}
