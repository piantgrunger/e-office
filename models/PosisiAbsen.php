<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vw_posisi_absen".
 *
 * @property int $id_satuan_kerja
 * @property string $periode
 * @property string $tgl_absen_terakhir
 */
class PosisiAbsen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vw_posisi_absen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_satuan_kerja'], 'integer'],
            [['tgl_absen_terakhir'], 'safe'],
            [['periode'], 'string', 'max' => 7],
        ];
    }
    public static function primaryKey()
    {
        return ['id_satuan_kerja'];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_satuan_kerja' => Yii::t('app', 'Id Satuan Kerja'),
            'periode' => Yii::t('app', 'Periode'),
            'tgl_absen_terakhir' => Yii::t('app', 'Tanggal Absen Terakhir'),
        ];
    }

    public function getStatus_validasi()
    {
        return  (!(is_null(Validasi::find()->where(["id_satuan_kerja" => $this->id_satuan_kerja, "periode" => $this->periode])->one())));
    }
}
