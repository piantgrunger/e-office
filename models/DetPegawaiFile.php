<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tb_d_pegawai_file".
 *
 * @property int $id_d_pangkat
 * @property string $jenis
 * @property string $uraian1
 * @property string $uraian2
 * @property int $id_pegawai
 * @property string $tanggal1
 * @property string $tanggal2
 * @property int $id_jabatan
 * @property int $id_pangkat
 * @property string $file
 */
class DetPegawaiFile extends \yii\db\ActiveRecord
{
    public $index;
    public $old_file;
    public $file_pendukung;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_d_pegawai_file';
    }


    /**
     * {@inheritdoc}
     */

    public function beforeSave($insert)
    {
        $this->old_file = $this->file;

        if (parent::beforeSave($insert)) {
            if (! $this->upload('file')) {
                //die($this->old_file);
                $this->file= $this->old_file;
            }

            return true;
        } else {
            return false;
        }
    }
    public function rules()
    {
        return [
            [['id_pegawai', 'id_jabatan', 'id_pangkat','index'], 'integer'],
            [['tanggal1', 'tanggal2','old_file','file'], 'safe'],
            [['jenis', 'uraian1', 'uraian2'], 'string', 'max' => 50],
            [['file_pendukung'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf,doc,docx,txt,xls,xlsx', 'maxSize' => 512000000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_d_pangkat' => Yii::t('app', 'Id D Pangkat'),
            'jenis' => Yii::t('app', 'Jenis'),
            'uraian1' => Yii::t('app', 'Uraian1'),
            'uraian2' => Yii::t('app', 'Uraian2'),
            'id_pegawai' => Yii::t('app', 'Id Pegawai'),
            'tanggal1' => Yii::t('app', 'Tanggal1'),
            'tanggal2' => Yii::t('app', 'Tanggal2'),
            'id_jabatan' => Yii::t('app', 'Id Jabatan'),
            'id_pangkat' => Yii::t('app', 'Id Pangkat'),
            'file' => Yii::t('app', 'File'),
        ];
    }

    public function behaviors()
    {
        return [
            'tanggal_lahirBeforeSave' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'tanggal1',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'tanggal1',
                ],

                'value' => function () {
                    return implode('-', array_reverse(explode('-', $this->tanggal1)));
                },
            ],


            'tmtBeforeSave' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'tanggal2',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'tanggal2',
                ],

                'value' => function () {
                    return implode('-', array_reverse(explode('-', $this->tanggal2)));
                },
            ],
        ];
    }

    public function getGolongan()
    {
        return $this->hasOne(Golongan::className(), ['id_golongan' => 'id_pangkat']);
    }

    public function upload($fieldName)
    {
        $path = Yii::getAlias('@app').'/web/media/kelengkapan/';
        //   die($fieldName);

     //    die($fieldName);
        $image = UploadedFile::getInstance($this, "[$this->index]file_pendukung");

        if (!empty($image) && $image->size !== 0) {
            $fileNames = $fieldName.($this->id_pegawai)."-".$this->jenis.$this->index.'.'.$image->extension;

            if ($image->saveAs($path.$fileNames)) {

                $this->attributes = array($fieldName => $fileNames);
                return true;
            } else {
              return false;
            }
        }
        return false;
    }
}
