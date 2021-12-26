<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%tb_mt_banding}}".
 *
 * @property int        $id_banding
 * @property string     $tgl_banding
 * @property int        $id_pegawai
 * @property int        $id_atasan
 * @property int        $id_absen
 * @property string     $alasan
 * @property string     $file
 * @property string     $status_banding
 * @property TbMtAbsen  $absen
 * @property TbMPegawai $atasan
 * @property TbMPegawai $pegawai
 */
class Banding extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tb_mt_banding}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tgl_banding','id_absen'], 'required'],
            [['tgl_banding'], 'safe'],
            [['id_pegawai', 'id_atasan', 'id_absen'], 'integer'],
            [['alasan'], 'string'],
             [['id_absen'],'unique','message' => 'Absen Sudah diajukan tidak dapat diajukan ulang' ],
            [['status_banding'], 'string', 'max' => 255],
            [['status_banding'] ,'default', 'value' =>'Belum Diapprove'],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf,doc,docx,txt,,xls,xlsx', 'maxSize' => 512000000],

            [['id_absen'], 'exist', 'skipOnError' => true, 'targetClass' => Absen::className(), 'targetAttribute' => ['id_absen' => 'id_absen']],
            [['id_atasan'], 'exist', 'skipOnError' => true, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['id_atasan' => 'id_pegawai']],
            [['id_pegawai'], 'exist', 'skipOnError' => true, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['id_pegawai' => 'id_pegawai']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_banding' => Yii::t('app', 'Id Banding'),
            'tgl_banding' => Yii::t('app', 'Tgl Banding'),
            'id_pegawai' => Yii::t('app', 'Pegawai'),
            'id_atasan' => Yii::t('app', 'Id Atasan'),
            'id_absen' => Yii::t('app', 'Id Absen'),
            'alasan' => Yii::t('app', 'Alasan'),
            'file' => Yii::t('app', 'File'),
            'status_banding' => Yii::t('app', 'Status Banding'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAbsen()
    {
        return $this->hasOne(Absen::className(), ['id_absen' => 'id_absen']);
    }

    public function getKet()
    {
        return Yii::$app->formatter->asDate($this->absen->tgl_absen).' Potongan '.\round($this->absen->total_jam_potong).' Jam ';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAtasan()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'id_atasan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'id_pegawai']);
    }

    public function getNama_atasan()
    {
        return is_null($this->atasan) ? '' : $this->atasan->nama_lengkap;
    }

    public function getNama_pegawai()
    {
        return is_null($this->pegawai) ? '' : $this->pegawai->nama_lengkap;
    }
    public function upload($fieldName)
    {
        $path = Yii::getAlias('@app') . '/web/document/';

        //s  die($fieldName);
        $image = UploadedFile::getInstance($this, $fieldName);


        if (!empty($image) && $image->size !== 0) {
            $fileNames = md5($this->id_absen) . '.' . $image->extension;
            if ($image->saveAs($path . $fileNames)) {
                $this->attributes = array($fieldName => $fileNames);

                return true;
            } else {
                return false;
            }
        } else {
            if ($fieldName === 'foto') {
                $this->attributes = array($fieldName => $this->old_foto);
            }

            return true;
        }
    }
}
