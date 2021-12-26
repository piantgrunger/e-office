<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_m_jenis_absen".
 *
 * @property int $id_jenis_absen
 * @property string $nama_jenis_absen
 * @property string $status_hadir
 */
class JenisAbsen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_m_jenis_absen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status_hadir'], 'string'],
            [['nama_jenis_absen'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_jenis_absen' => Yii::t('app', 'Id Jenis Absen'),
            'nama_jenis_absen' => Yii::t('app', 'Nama Jenis Absen'),
            'status_hadir' => Yii::t('app', 'Status Hadir'),
        ];
    }
}
