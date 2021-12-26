<?php

namespace app\models;

use Yii;
use mdm\behaviors\ar\RelationTrait;

/**
 * This is the model class for table "tb_m_shift".
 *
 * @property int $id_shift
 * @property string $nama_shift
 *
 * @property TbDShift[] $tbDShifts
 */
class Shift extends \yii\db\ActiveRecord
{
    use RelationTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_m_shift';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_shift'], 'required'],
            [['nama_shift'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_shift' => 'Id Shift',
            'nama_shift' => 'Nama Shift',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getListDetShift()
    {
        return $this->hasMany(DetShift::className(), ['id_shift' => 'id_shift']);
    }
    public function setListDetShift($value)
    {
        return $this->loadRelated('listDetShift', $value);
    }
}
