<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_m_saldo_cuti".
 *
 * @property int $id
 * @property int $id_pegawai
 * @property int $saldo_2018
 * @property int $saldo_2019
 */
class SaldoCuti extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_m_saldo_cuti';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pegawai', 'saldo_2018', 'saldo_2019'], 'integer'],
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
            'saldo_2018' => 'Saldo 2018',
            'saldo_2019' => 'Saldo 2019',
        ];
    }
}
