<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


use Yii;

/**
 * This is the model class for table "tb_d_pegawai_anak".
 *
 * @property int $id
 * @property int|null $id_pegawai
 * @property string $nama
 * @property string $tanggal_lahir
 * @property string|null $status
 *
 * @property TbMPegawai $pegawai
 */
class DetPegawaiAnak extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_d_pegawai_anak';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pegawai'], 'integer'],
            [['nama', 'tanggal_lahir'], 'required'],
            [['tanggal_lahir'], 'safe'],
            [['nama', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_pegawai' => 'Id Pegawai',
            'nama' => 'Nama',
            'tanggal_lahir' => 'Tanggal Lahir',
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
        ];
    }   
}
