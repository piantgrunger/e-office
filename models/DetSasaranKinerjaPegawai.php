<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_dt_skp".
 *
 * @property int $id_d_skp
 * @property int $id_skp
 * @property int $bulan
 * @property int $kuantitas
 *
 * @property TbMtSkp $skp
 */
class DetSasaranKinerjaPegawai extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_dt_skp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'bulan', 'kuantitas' ,'satuan_kuantitas'], 'required'],
            [['id_skp', 'bulan',], 'integer'],
           [['kuantitas'],'number'],
  

            [['id_skp'], 'exist', 'skipOnError' => true, 'targetClass' => SasaranKinerjaPegawai::className(), 'targetAttribute' => ['id_skp' => 'id_skp']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_d_skp' => Yii::t('app', 'Id D Skp'),
            'id_skp' => Yii::t('app', 'Id Skp'),
            'bulan' => Yii::t('app', 'Bulan'),
            'kuantitas' => Yii::t('app', 'Kuantitas'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkp()
    {
        return $this->hasOne(SasaranKinerjaPegawai::className(), ['id_skp' => 'id_skp']);
    }
}
