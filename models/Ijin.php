<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "tb_mt_ijin".
 *
 * @property int $id_ijin
 * @property int $id_jenis_absen
 * @property int $id_absen
 * @property int $id_pegawai
 * @property string $tgl_absen
 * @property string $alasan
 * @property string $file_pendukung
 *
 * @property TbMtAbsen $absen
 * @property TbMJenisAbsen $jenisAbsen
 * @property TbMPegawai $pegawai
 */
class Ijin extends \yii\db\ActiveRecord
{
    public $tgl_awal;
    public $tgl_akhir;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_mt_ijin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_jenis_absen', 'id_pegawai', 'tgl_absen', 'alasan'], 'required'],
            [['id_jenis_absen', 'id_absen', 'id_pegawai'], 'integer'],
            [['tgl_absen','tgl_awal','tgl_akhir','status'], 'safe'],
            [['alasan' ,'status'], 'string'],
            [['file_pendukung'], 'string', 'max' => 100],
            [['id_absen'], 'exist', 'skipOnError' => true, 'targetClass' => Absen::className(), 'targetAttribute' => ['id_absen' => 'id_absen']],
            [['id_jenis_absen'], 'exist', 'skipOnError' => true, 'targetClass' => JenisAbsen::className(), 'targetAttribute' => ['id_jenis_absen' => 'id_jenis_absen']],
            [['id_pegawai'], 'exist', 'skipOnError' => true, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['id_pegawai' => 'id_pegawai']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_ijin' => Yii::t('app', 'Id Ijin'),
            'id_jenis_absen' => Yii::t('app', 'Id Jenis Absen'),
            'id_absen' => Yii::t('app', 'Id Absen'),
            'id_pegawai' => Yii::t('app', 'Id Pegawai'),
            'tgl_absen' => Yii::t('app', 'Tgl Absen'),
            'alasan' => Yii::t('app', 'Alasan'),
            'file_pendukung' => Yii::t('app', 'File Pendukung'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAbsen()
    {
        return $this->hasOne(Absen::className(), ['id_absen' => 'id_absen']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJenisAbsen()
    {
        return $this->hasOne(JenisAbsen::className(), ['id_jenis_absen' => 'id_jenis_absen']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'id_pegawai']);
    }
    public function getNama_pegawai()
    {
        return is_null($this->pegawai) ? '' : ''.$this->pegawai->nama_lengkap;
    }

    public function getNip()
    {
        return is_null($this->pegawai) ? '' : ''.$this->pegawai->nip;
    }
    public function getNama_jenis_absen()
    {
        return is_null($this->jenisAbsen) ? '' : $this->jenisAbsen->nama_jenis_absen;
    }


    public function upload($fieldName)
    {
        $path = Yii::getAlias('@app').'/web/media/';

        //s  die($fieldName);
        $image = UploadedFile::getInstance($this, $fieldName);

        if (!empty($image) && $image->size !== 0) {
            $fileNames = 'Absen'.md5($this->id_absen).'.'.$image->extension;
            if ($image->saveAs($path.$fileNames)) {
                $this->attributes = array($fieldName => $fileNames);

                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
}
