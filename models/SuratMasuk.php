<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "surat_masuk".
 *
 * @property int $id
 * @property string $nomor_surat
 * @property int $id_jenis_surat
 * @property string $sifat
 * @property string $tgl_surat
 * @property string $tgl_terima
 * @property string $asal_surat
 * @property string $perihal
 * @property string|null $file_surat
 *
 * @property JenisSurat $jenisSurat
 */
class SuratMasuk extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    private $_old_file;
    private $_berkas = ['file_surat'];
      
    public function saveOld()
    {
        foreach ($this->_berkas as $file) {
            $this->_old_file[$file] = $this->$file;
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            foreach ($this->_berkas as $file) {
                $this->upload($file);
            }
        
            
            return true;
        } else {
            return false;
        }
    }


    
    public function upload($fieldName)
    {
        $path = Yii::getAlias('@app') . '/web/document/';
        //s  die($fieldName);
        $image = UploadedFile::getInstance($this, $fieldName);
        if (!empty($image) && $image->size !== 0) {
            $fileNames = $fieldName .md5(date("Y-m-d H:n:s")) . '.' . $image->extension;

            if ($image->saveAs($path . $fileNames)) {
                $this->attributes = [$fieldName => $fileNames];
                return true;
            } else {
                return false;
                $this->attributes = [$fieldName => $this->_old_file[$fieldName]];
            }
        } else {
            $this->attributes = [$fieldName => $this->_old_file[$fieldName]];
            return true;
        }
    }



    public static function tableName()
    {
        return 'surat_masuk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nomor_surat', 'id_jenis_surat', 'sifat', 'tgl_surat', 'tgl_terima', 'asal_surat', 'perihal','id_satuan_kerja'], 'required'],
            [['id_jenis_surat'], 'integer'],
            [['tgl_surat', 'tgl_terima'], 'safe'],
            [['nomor_surat', 'sifat', 'asal_surat',], 'string', 'max' => 100],
            [$this->_berkas,'file','skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 1024 * 1024 * 100, 'tooBig' => 'File tidak boleh lebih dari 100MB'  ],
            [['id_jenis_surat'], 'exist', 'skipOnError' => true, 'targetClass' => JenisSurat::className(), 'targetAttribute' => ['id_jenis_surat' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nomor_surat' => 'Nomor Surat',
            'id_jenis_surat' => 'Jenis Surat',
            'sifat' => 'Sifat',
            'tgl_surat' => 'Tgl Surat',
            'tgl_terima' => 'Tgl Terima',
            'asal_surat' => 'Asal Surat',
            'perihal' => 'Perihal',
            'file_surat' => 'File Surat',
        ];
    }

    /**
     * Gets query for [[JenisSurat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getJenisSurat()
    {
        return $this->hasOne(JenisSurat::className(), ['id' => 'id_jenis_surat']);
    }

    public function getDisposisi()
    {
        return $this->hasMany(Disposisi::className(), ['id_surat_masuk' => 'id']);
    }
}
