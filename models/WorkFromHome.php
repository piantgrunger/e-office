<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "tb_mt_wfh".
 *
 * @property int $id_wfh
 * @property int $id_pegawai
 * @property string $tanggal_wfh
 *
 * @property TbMPegawai $pegawai
 */
class WorkFromHome extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_mt_wfh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pegawai', 'tanggal_wfh'], 'required'],
            [['id_pegawai'], 'integer'],
            [['tanggal_wfh'], 'safe'],
            [['id_pegawai'], 'exist', 'skipOnError' => true, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['id_pegawai' => 'id_pegawai']],
        ];
    }
  
     public function behaviors()
    {
        return [
            'tgl_absenBeforeSave' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'tanggal_wfh',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'tanggal_wfh',
                ],

                'value' => function () {
                    return implode('-', array_reverse(explode('-', $this->tanggal_wfh)));
                },
            ],
           
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_wfh' => 'Id Wfh',
            'id_pegawai' => 'Pegawai',
            'tanggal_wfh' => 'Tanggal Wfh',
        ];
    }

    /**
     * Gets query for [[Pegawai]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'id_pegawai']);
    }
}
