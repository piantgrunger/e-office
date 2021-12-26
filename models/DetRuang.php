<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_d_ruang".
 *
 * @property int $id_d_ruang
 * @property int $id_ruang
 * @property int $id_pegawai
 *
 * @property TbMRuang $ruang
 * @property TbMPegawai $pegawai
 */
class DetRuang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_d_ruang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'id_pegawai'], 'required'],
            [['id_ruang', 'id_pegawai'], 'integer'],
            [['id_pegawai'],'unique','targetAttribute' => ['id_pegawai'] ,'message' => 'Pegawai Sudah Memiliki Ruang',
            'when' => function ($model) {
                return $model->isAttributeChanged('id_pegawai');
            },
              ],
            [['id_ruang'], 'exist', 'skipOnError' => true, 'targetClass' => Ruang::className(), 'targetAttribute' => ['id_ruang' => 'id_ruang']],
            [['id_pegawai'], 'exist', 'skipOnError' => true, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['id_pegawai' => 'id_pegawai']],
        ];
    }


    public function afterSave($isNew, $old)
    {
        $model=$this->pegawai;
        $model->id_ruang = $this->id_ruang;
        $model->save();
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_d_ruang' => Yii::t('app', 'Id D Ruang'),
            'id_ruang' => Yii::t('app', 'Ruang'),
            'id_pegawai' => Yii::t('app', 'Pegawai'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuang()
    {
        return $this->hasOne(Ruang::className(), ['id_ruang' => 'id_ruang']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'id_pegawai']);
    }
}
