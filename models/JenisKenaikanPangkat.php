<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_m_jenis_kenaikan_pangkat".
 *
 * @property int $id_jenis_kenaikan_pangkat
 * @property string|null $jenis_kenaikan_pangkat
 * @property string|null $syarat
 */
class JenisKenaikanPangkat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_m_jenis_kenaikan_pangkat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['syarat'], 'string'],
            [['jenis_kenaikan_pangkat'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_jenis_kenaikan_pangkat' => 'Id Jenis Kenaikan Pangkat',
            'jenis_kenaikan_pangkat' => 'Jenis Kenaikan Pangkat',
            'syarat' => 'Syarat',
        ];
    }
}
