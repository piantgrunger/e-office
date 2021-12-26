<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_d_shift".
 *
 * @property int $id_shift
 * @property int $id_d_shift
 * @property int $hari
 * @property string $jam_masuk
 * @property string $jam_pulang
 *
 * @property TbMShift $shift
 */
class DetShift extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_d_shift';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'hari', 'jam_masuk', 'jam_pulang'], 'required'],
            [['id_shift', 'hari'], 'integer'],
//            [['jam_masuk', 'jam_pulang'], 'safe'],
      //   [['jam_masuk', 'jam_pulang'], 'datetime', 'format' => 'php:H:i:s' ],
        
            [['id_shift'], 'exist', 'skipOnError' => true, 'targetClass' => Shift::className(), 'targetAttribute' => ['id_shift' => 'id_shift']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_shift' => 'Id Shift',
            'id_d_shift' => 'Id D Shift',
            'hari' => 'Hari',
            'jam_masuk' => 'Jam Masuk',
            'jam_pulang' => 'Jam Pulang',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShift()
    {
        return $this->hasOne(Shift::className(), ['id_shift' => 'id_shift']);
    }
    public function init()
    {
        if ($this->isNewRecord) {
            $this->jam_masuk = '00:00:00';
            $this->jam_pulang = '09:00:00';
        }
        parent::init();
    }
}
