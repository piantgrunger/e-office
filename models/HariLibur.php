<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tb_m_hari_libur".
 *
 * @property int $id_hari_libur
 * @property string $nama_hari_libur
 * @property string $tanggal_libur
 */
class HariLibur extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_m_hari_libur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal_libur'], 'safe'],
            [['nama_hari_libur'], 'string', 'max' => 50],
            [['tanggal_libur'], 'unique'],
        ];
    }

    public function behaviors()
    {
        return [



            "tanggal_liburBeforeSave" => [
                "class" => TimestampBehavior::className(),
                "attributes" => [
                    ActiveRecord::EVENT_BEFORE_INSERT => "tanggal_libur",
                    ActiveRecord::EVENT_BEFORE_UPDATE => "tanggal_libur",
                ],

                "value" => function () {
                    return implode("-", array_reverse(explode("-", $this->tanggal_libur)));
                }



            ],





        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_hari_libur' => Yii::t('app', 'Id Hari Libur'),
            'nama_hari_libur' => Yii::t('app', 'Nama Hari Libur'),
            'tanggal_libur' => Yii::t('app', 'Tanggal Libur'),
        ];
    }
}
