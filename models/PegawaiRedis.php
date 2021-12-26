<?php

namespace app\models;

use DateTime;
use Yii;
use yii\web\UploadedFile;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use mdm\behaviors\ar\RelationTrait;


/**
 * This is the model class for table "tb_m_pegawai".
 *
 * @property int                  $id_pegawai
 * @property string               $nip
 * @property string               $nik
 * @property string               $nama
 * @property string               $gelar_depan
 * @property string               $gelar_belakang
 * @property string               $alamat
 * @property int                  $id_unit_kerja
 * @property int                  $id_jabatan_fungsional
 * @property string               $jenis_kelamin
 * @property string               $tempat_lahir
 * @property string               $tanggal_lahir
 * @property TbMJabatanFungsional $jabatanFungsional
 * @property TbMUnitKerja         $unitKerja
 */
class PegawaiRedis extends \yii\redis\ActiveRecord
{
 
    /**
     * {@inheritdoc}
     */
  public static function primaryKey()
  {
    return ['id_pegawai'];
  }
    public function attributes()
    {
      return [     
            'id_pegawai',
            'nip',
      'nik',
      'nama_lengkap',
      'alamat',
      'nama_jabatan',
      'jenis_kelamin',
      'tempat_lahir',
      'tanggal_lahir',
      'nama_satuan_kerja',
      'kode_golongan',
        'id_shift',
        'foto','agama'
     ] ; 
    }  
    public function rules()
    {
        return [
         [ [     
            'id_pegawai',
            'nip',
      'nik',
      'nama_lengkap',
      'alamat',
      'nama_jabatan',
      'jenis_kelamin',
      'tempat_lahir',
      'tanggal_lahir',
      'nama_satuan_kerja',
      'kode_golongan',
           'id_shift',
                  'id_shift',
        'foto','agama'
 
     ] ,'string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pegawai' => Yii::t('app', 'Id Pegawai'),
            'id_shift' => Yii::t('app', 'Shift'),

            'nip' => Yii::t('app', 'Nip'),
            'nik' => Yii::t('app', 'Nik'),
        ];
    }

    
}
