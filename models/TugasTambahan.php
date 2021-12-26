<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "tb_mt_tugas_tambahan".
 *
 * @property int        $id_tugas_tambahan
 * @property int        $bulan
 * @property int        $tahun
 * @property string     $uraian_tugas
 * @property string     $file_pendukung
 * @property string     $status
 * @property int        $id_pegawai
 * @property int        $id_penilai
 * @property TbMPegawai $penilai
 * @property TbMPegawai $pegawai
 */
class TugasTambahan extends \yii\db\ActiveRecord
{
    public $old_file_pendukung;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_mt_tugas_tambahan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bulan', 'tahun', 'uraian_tugas',  'id_pegawai', 'id_penilai'], 'required'],
            [['bulan', 'tahun', 'id_pegawai', 'id_penilai'], 'integer'],
            [['uraian_tugas'], 'string'],
            [['file_pendukung'], 'string', 'max' => 300],
            [['status'], 'string', 'max' => 255],
            [['status'], 'string'],
            [['status'], 'default', 'value' => 'Diajukan'],
            [['file_pendukung'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg,bmp,jpeg,xls,xlsx,doc,docx,pdf', 'maxSize' => 512000000, 'maxFiles' => 1],

            [['id_penilai'], 'exist', 'skipOnError' => true, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['id_penilai' => 'id_pegawai']],
            [['id_pegawai'], 'exist', 'skipOnError' => true, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['id_pegawai' => 'id_pegawai']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tugas_tambahan' => Yii::t('app', 'Id Tugas Tambahan'),
            'bulan' => Yii::t('app', 'Bulan'),
            'tahun' => Yii::t('app', 'Tahun'),
            'uraian_tugas' => Yii::t('app', 'Uraian Tugas'),
            'file_pendukung' => Yii::t('app', 'File Pendukung'),
            'status' => Yii::t('app', 'Status'),
            'id_pegawai' => Yii::t('app', 'Id Pegawai'),
            'id_penilai' => Yii::t('app', 'Id Penilai'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPenilai()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'id_penilai']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'id_pegawai']);
    }

    public function upload($fieldName)
    {
        $path = Yii::getAlias('@app').'/web/document/';

        //s  die($fieldName);
        $image = UploadedFile::getInstance($this, $fieldName);

        if (!empty($image) && $image->size !== 0) {
            $fileNames = 'TugasTambahan'.($this->id_pegawai.date('Ymd').$this->bulan.$this->tahun).'.'.$image->extension;

            if ($image->saveAs($path.$fileNames)) {
                $this->attributes = array($fieldName => $fileNames);

                return true;
            } else {
                return false;
            }
        } else {
            if ($fieldName === 'file_pendukung') {
                $this->attributes = array($fieldName => $this->old_file_pendukung);
            }

            return true;
        }
    }
}
