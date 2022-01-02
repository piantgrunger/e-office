<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "disposisi".
 *
 * @property int $id
 * @property int $id_surat_masuk
 * @property int $id_pegawai
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
            [['id_surat_masuk', 'id_pegawai', 'tanggal_disposisi', 'status_disposisi', 'catatan_disposisi'], 'required'],
            [['id_surat_masuk', 'id_pegawai', 'id_parent'], 'integer'],
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
            'id_pegawai' => 'Tujuan Disposisi',
            'id_user' => 'Pembuat Disposisi',
            'tanggal_disposisi' => 'Tanggal Disposisi',
            'status_disposisi' => 'Status Disposisi',
            'catatan_disposisi' => 'Catatan Disposisi',
            'tanggal_diterima' => 'Tanggal Diterima',
            'jawaban_disposisi' => 'Jawaban Disposisi',
        ];
    }

    public function getPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'id_pegawai']);
    }

    public function getSuratMasuk()
    {
        return $this->hasOne(SuratMasuk::className(), ['id' => 'id_surat_masuk']);
    }

    public function getLabel_disposisi()
    {
        $label = [
            'Belum Diterima' => 'secondary',
            'Sudah Dibaca' => 'info',
            'Di Disposisikan' => 'warning',
            'Sudah Dikerjakan' => 'success',
        ];
        return "<label class='badge badge-".$label[$this->status_disposisi]."'>".$this->status_disposisi."</label>";
    }
}
