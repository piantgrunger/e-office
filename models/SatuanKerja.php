<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "tb_m_satuan_kerja".
 *
 * @property int $id_satuan_kerja
 * @property string $nama_satuan_kerja
 */
class SatuanKerja extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $file;
    public $old_file;

    public static function tableName()
    {
        return 'tb_m_satuan_kerja';
    }

    public function beforeSave($insert)
    {
        $this->old_file = $this->file_header;

        if (parent::beforeSave($insert)) {
            if (! $this->upload('file_header')) {
                //die($this->old_file);
                $this->file_header= $this->old_file;
            }

            return true;
        } else {
            return false;
        }
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_satuan_kerja' ,'checklog_key'], 'required'],
            [['nama_satuan_kerja'], 'string', 'max' => 100],
            [['tanggal_absen_terakhir','alamat_kantor','telp_fax','website','email','status_cek_absen','keterangan'],'string'],
            [['id_pimpinan','id_kepala','alamat_kantor','telp_fax','website','email','latitude','longitude','radius','cek_lokasi','id_pejabat_pemberi_cuti','id_sekretaris'],'safe'],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpeg,jpg,png,bmp', 'maxSize' => 512000000]

        ];
    }

    public function getStatus_validasi_bulan_ini()
    {
        return !(is_null(Validasi::find()->where(['id_satuan_kerja'=>$this->id_satuan_kerja,'periode'=>date('mm-YYYY') ])->one()));
    }

    public function getPimpinan()
    {
        return $this->hasOne(JabatanFungsional::className(), ['id_jabatan_fungsional'=>'id_pimpinan']);
    }

    public function getPersonPimpinan()
    {
        if (is_null($this->id_kepala)) {
            return $this->hasOne(Pegawai::className(), ['id_jabatan_fungsional'=>'id_pimpinan'])->where(['id_satuan_kerja'=>$this->id_satuan_kerja]);
        } else {
            return $this->hasOne(Pegawai::className(), ['id_pegawai'=>'id_kepala']);
        }
    }
    public function getPejabatPemberiCuti()
    {
            return $this->hasOne(Pegawai::className(), ['id_pegawai'=>'id_pejabat_pemberi_cuti']);
      
    }  
  
    public function getSekretaris()
    {
            return $this->hasOne(Pegawai::className(), ['id_pegawai'=>'id_sekretaris']);
      
    }  

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_satuan_kerja' => Yii::t('app', 'Id Satuan Kerja'),
            'nama_satuan_kerja' => Yii::t('app', 'Nama Satuan Kerja'),
            'pimpinan.nama_jabatan_fungsional' =>'Jabatan Pimpinan',
            'personPimpinan.nama_lengkap' =>'Nama Pejabat Pimpinan Satuan Kerja',
           'alasan' =>'Alasan Tidak Hitung Absen',
                'sekretaris.nama_lengkap' => "Sekretaris",
            'pejabatPemberiCuti.nama_lengkap' => 'Pejabat Pemberi Cuti',
      

        ];
    }

        public function upload($fieldName)
    {
        $path = Yii::getAlias('@app').'/web/media/satuan-kerja/';
        //   die($fieldName);

     //    die($fieldName);
        $image = UploadedFile::getInstance($this, "file");

        if (!empty($image) && $image->size !== 0) {
            $fileNames = $fieldName.$this->nama_satuan_kerja.'.'.$image->extension;

            if ($image->saveAs($path.$fileNames)) {

                $this->attributes = array($fieldName => $fileNames);
                return true;
            } else {
              return false;
            }
        }
        return false;
    }
  
  public function getTanggal_absen_terakhir1()
  {
     $tgl = explode('-', date('Y-m-d'));
     return '2021-12-30';
               
  }
  public function getJumlahPegawai()
  {
      return Pegawai::find()->where(['id_satuan_kerja'=>$this->id_satuan_kerja])->count();
  }

  public function getAdminTPP()
    {
            return $this->hasMany(Pegawai::className(), ['id_satuan_kerja'=>'id_satuan_kerja'])
              ->innerJoin('tb_m_jabatan_tambahan',"tb_m_jabatan_tambahan.id_jabatan_tambahan=tb_m_pegawai.id_jabatan_tambahan ")
              ->where("tb_m_jabatan_tambahan.nama_jabatan = 'admin tpp' ")
              ;
      
    }  
  
   public function getVerifikatorTelaah()
   {
            return Pegawai::find()
              ->innerJoin('tb_m_jabatan_tambahan',"tb_m_jabatan_tambahan.id_jabatan_tambahan=tb_m_pegawai.id_jabatan_tambahan ")
              ->where("tb_m_jabatan_tambahan.nama_jabatan = 'Verifikator Presensi Pada BKPP' ")
              ->one()
              ;
     
   } 
  
     public function getKasubbagTelaah()
   {
            return Pegawai::find()
              ->innerJoin('tb_m_jabatan_fungsional',"tb_m_jabatan_fungsional.id_jabatan_fungsional=tb_m_pegawai.id_jabatan_fungsional ")
              ->where("tb_m_jabatan_fungsional.nama_jabatan_fungsional = 'KEPALA SUB BIDANG DISIPLIN, KESEJAHTERAAN DAN PERLINDUNGAN APARATUR' ")
              ->one()
              ;
     
   } 

}
