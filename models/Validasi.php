<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_mt_validasi".
 *
 * @property int $id_validasi
 * @property int $id_satuan_kerja
 * @property string $periode
 * @property string $tanggal_validasi
 */
class Validasi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_mt_validasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_satuan_kerja', 'periode', 'tanggal_validasi'], 'required'],
            [['id_satuan_kerja'], 'integer'],
            [['tanggal_validasi'], 'safe'],
            [['periode'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_validasi' => Yii::t('app', 'Id Validasi'),
            'id_satuan_kerja' => Yii::t('app', 'Id Satuan Kerja'),
            'periode' => Yii::t('app', 'Periode'),
            'tanggal_validasi' => Yii::t('app', 'Tanggal Validasi'),
        ];
    }
}
