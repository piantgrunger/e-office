<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


use Yii;

/**
 * This is the model class for table "tb_d_pegawai_pasangan".
 *
 * @property int $id
 * @property int|null $id_pegawai
 * @property string $tanggal_lahir
 * @property string $tanggal_perkawinan
 * @property int|null $urutan
 * @property string|null $status
 *
 * @property TbMPegawai $pegawai
 */
class DetPegawaiPasangan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_d_pegawai_pasangan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'urutan'], 'integer'],
            [['tanggal_lahir', 'tanggal_perkawinan'], 'required'],
            [['id_pegawai'], 'safe'],
            [['status','nama'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            'tanggal_lahirBeforeSave' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'tanggal_lahir',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'tanggal_lahir',
                ],

                'value' => function () {
                    return implode('-', array_reverse(explode('-', $this->tanggal_lahir)));
                },
            ],


            'tmtBeforeSave' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'tanggal_perkawinan',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'tanggal_perkawinan',
                ],

                'value' => function () {
                    return implode('-', array_reverse(explode('-', $this->tanggal_perkawinan)));
                },
            ],
        ];
    }

  
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_pegawai' => 'Id Pegawai',
            'tanggal_lahir' => 'Tanggal Lahir',
            'tanggal_perkawinan' => 'Tanggal Perkawinan',
            'urutan' => 'Urutan',
            'status' => 'Status',
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
