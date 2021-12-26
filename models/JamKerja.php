<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_m_jam_kerja".
 *
 * @property int $id_jam_kerja
 * @property string $nama_jam_kerja
 * @property string $jam_masuk
 * @property string $jam_pulang
 */
class JamKerja extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_m_jam_kerja';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jam_masuk', 'jam_pulang'], 'required'],
            [['jam_masuk', 'jam_pulang'], 'safe'],
            [['nama_jam_kerja'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_jam_kerja' => Yii::t('app', 'Id Jam Kerja'),
            'nama_jam_kerja' => Yii::t('app', 'Nama Jam Kerja'),
            'jam_masuk' => Yii::t('app', 'Jam Masuk'),
            'jam_pulang' => Yii::t('app', 'Jam Pulang'),
        ];
    }
}
