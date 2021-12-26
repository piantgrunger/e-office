<?php

namespace app\models;
use mdm\behaviors\ar\RelationTrait;

use Yii;

/**
 * This is the model class for table "tb_m_ruang".
 *
 * @property int $id_ruang
 * @property string $kode_ruang
 * @property string $nama_ruang
 * @property string $keterangan
 */
class Ruang extends \yii\db\ActiveRecord
{
    use RelationTrait;
    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return 'tb_m_ruang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_ruang', 'nama_ruang'], 'required'],
            [['keterangan'], 'string'],
            [['kode_ruang', 'nama_ruang'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_ruang' => Yii::t('app', 'Id Ruang'),
            'kode_ruang' => Yii::t('app', 'Kode Ruang'),
            'nama_ruang' => Yii::t('app', 'Nama Ruang'),
            'keterangan' => Yii::t('app', 'Keterangan'),
        ];
    }

    public function getListDetRuang()
    {
        return $this->hasMany(DetRuang::className(), ['id_ruang' => 'id_ruang']);
    }
    public function setListDetRuang($value)
    {
        return $this->loadRelated('listDetRuang', $value);
    }

  
}
