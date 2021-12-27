<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "disposisi".
 *
 * @property int $id
 * @property int $id_surat_masuk
 * @property int $id_jabatan
 * @property int|null $id_user
 * @property string $tanggal_disposisi
 * @property string $status_disposisi
 * @property string $catatan_disposisi
 * @property string|null $tanggal_diterima
 * @property string|null $jawaban_disposisi
 */
class Disposisi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'disposisi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_surat_masuk', 'id_jabatan', 'tanggal_disposisi', 'status_disposisi', 'catatan_disposisi'], 'required'],
            [['id_surat_masuk', 'id_jabatan', 'id_user'], 'integer'],
            [['tanggal_disposisi', 'tanggal_diterima'], 'safe'],
            [['catatan_disposisi', 'jawaban_disposisi'], 'string'],
            [['status_disposisi'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_surat_masuk' => 'Id Surat Masuk',
            'id_jabatan' => 'Tujuan Disposisi',
            'id_user' => 'Pembuat Disposisi',
            'tanggal_disposisi' => 'Tanggal Disposisi',
            'status_disposisi' => 'Status Disposisi',
            'catatan_disposisi' => 'Catatan Disposisi',
            'tanggal_diterima' => 'Tanggal Diterima',
            'jawaban_disposisi' => 'Jawaban Disposisi',
        ];
    }
}
