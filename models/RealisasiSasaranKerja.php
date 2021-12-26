<?php

namespace app\models;

use app\helpers\myhelpers;
use yii\web\UploadedFile;
use Yii;

/**
 * This is the model class for table "tb_mt_realisasi".
 *
 * @property int     $id_realisasi
 * @property int     $id_skp
 * @property int     $id_d_skp
 * @property string  $kuantitas
 * @property string  $file_pendukung
 * @property TbMtSkp $skp
 * @property TbDtSkp $dSkp
 */
class RealisasiSasaranKerja extends \yii\db\ActiveRecord
{
    public $old_file_pendukung;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_mt_realisasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_skp', 'id_d_skp', 'kuantitas'], 'required'],
            [['id_skp', 'id_d_skp'], 'integer'],
         //   ['id_skp', 'unique', 'comboNotUnique' => 'Sasaran Kerja Pada Bulan Ini Telah Dibuat.', 'targetAttribute' => ['id_skp', 'id_d_skp']],
            [['kuantitas','biaya'], 'number'],
             [['kualitas_realisasi'] ,'number','max' =>90,'min'=>76],
            [['kualitas_realisasi'], 'required', 'when' => function ($model) {
                return $model->status_realisasi == 'Disetujui';
            },
            'whenClient' => "function () {
                return $('#realisasisasarankerja-status_realisasi').val() == 'Disetujui';
            }", ],
            [['status_realisasi'], 'string'],
            [['status_realisasi'], 'default', 'value' => 'Diajukan'],

            [['file_pendukung'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg,bmp,jpeg,xls,xlsx,doc,docx,pdf', 'maxSize' => 512000000, 'maxFiles' => 1],
            [['id_skp'], 'exist', 'skipOnError' => true, 'targetClass' => SasaranKinerjaPegawai::className(), 'targetAttribute' => ['id_skp' => 'id_skp']],
            [['id_d_skp'], 'exist', 'skipOnError' => true, 'targetClass' => DetSasaranKinerjaPegawai::className(), 'targetAttribute' => ['id_d_skp' => 'id_d_skp']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_realisasi' => Yii::t('app', 'Id Realisasi'),
            'id_skp' => Yii::t('app', 'Sasaran Kinerja'),
            'id_d_skp' => Yii::t('app', 'Bulan Realisasi'),
            'kuantitas' => Yii::t('app', 'Kuantitas'),
            'file_pendukung' => Yii::t('app', 'File Pendukung'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSkp()
    {
        return $this->hasOne(SasaranKinerjaPegawai::className(), ['id_skp' => 'id_skp']);
    }

    public function getUraian_tugas()
    {
        return $this->skp->uraian_tugas;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getD_skp()
    {
        return $this->hasOne(DetSasaranKinerjaPegawai::className(), ['id_d_skp' => 'id_d_skp']);
    }

    public function getBulan()
    {
        return  myhelpers::getmonth($this->d_skp->bulan);
    }

    public function getKuantitas_skp()
    {
        return  $this->d_skp->kuantitas;
    }

    public function getSatuan()
    {
        return  $this->d_skp->satuan_kuantitas;
    }

    public function upload($fieldName)
    {
        $path = Yii::getAlias('@app').'/web/document/';

        //s  die($fieldName);
        $image = UploadedFile::getInstance($this, $fieldName);

        if (!empty($image) && $image->size !== 0) {
            $fileNames = 'Realisasi'.($this->id_skp.$this->d_skp->bulan.$this->skp->tahun).'.'.$image->extension;

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
