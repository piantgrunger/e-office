<?php

namespace app\models;

use DateTime;
use Yii;
use yii\web\UploadedFile;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use mdm\behaviors\ar\RelationTrait;
use app\helpers\myhelpers;

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
class Pegawai extends \yii\db\ActiveRecord
{
    use RelationTrait;
    public $old_foto;
    public $old_tmt;
    public $old_file_sk_cpns;
    public $old_file_sk_pns;
    public $old_file_kartu_pegawai;
    public $old_file_sk_pangkat;

    /**
     * {@inheritdoc}
     */
    
    public function saveRedis()
    {
       
       
         $redis = PegawaiRedis::find()->where(['id_pegawai'=> $this->id_pegawai ])->one();
        if (is_null($redis)) {
            $redis = new PegawaiRedis();
        }
    //   var_dump($redis->attributes);
        $att = [
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
         'foto',
          'agama'
          ] ;
        foreach ($att as $key) {
            if ($key <>'') {
                 $redis->$key= $this->$key;
            }
        }
            $redis->save(false);
   
      
    
    }
    

    public function behaviors()
    {
        return [
            'tanggal_lahirBeforeSave' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'tanggal_lahir',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'tanggal_lahir',
                ],

                'value' => function ($model) {
                    return $this->scenario=='data_pribadi'? $this->tanggal_lahir : implode('-', array_reverse(explode('-', $this->tanggal_lahir)));
                },
            ],

            'tmtBeforeSave' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'tmt',
                   ActiveRecord::EVENT_BEFORE_UPDATE => 'tmt',
                ],

                'value' => function () {
                    return $this->scenario=='data_pribadi'? $this->tmt : implode('-', array_reverse(explode('-', $this->tmt)));
                },
            ],
          
            'tglmasukBeforeSave' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'tanggal_masuk',
                   ActiveRecord::EVENT_BEFORE_UPDATE => 'tanggal_masuk',
                ],

                'value' => function () {
                    return $this->scenario=='data_pribadi'? $this->tanggal_masuk : implode('-', array_reverse(explode('-', $this->tanggal_masuk)));
                },
            ],
          
            'tmt_pangkatBeforeSave' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'tmt_pangkat',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'tmt_pangkat',
                ],

                'value' => function ($model) {
                    return $this->scenario=='data_pribadi'? $this->tmt_pangkat : implode('-', array_reverse(explode('-', $this->tmt_pangkat)));
                },
            ],
        ];
    }

    public static function tableName()
    {
        return 'tb_m_pegawai';
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['data_pribadi'] = ['agama','status_perkawinan','gaji_pokok'];//Scenario Values Only Accepted
             $scenarios['delete'] = ['status','id_satuan_kerja','id_unit_kerja'];//Scenario Values Only Accepted
             $scenarios['sync'] = ['id_jabatan_fugsional','status_perkawinan','list_file'];//Scenario Values Only Accepted
	
	    return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'alamat', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'jenis_pegawai', 'tmt','status_shift','agama'], 'required'],
            [['alamat'], 'string'],
           [['nip'],'unique'],
           [['id_jabatan_fungsional'],'cekKebutuhan'],
          
            [['id_unit_kerja', 'id_satuan_kerja', 'id_jabatan_fungsional', 'id_shift','id_penilai','id_atasan_penilai','id_penilai_non_struktural','id_atasan_penilai_non_struktural'], 'integer'],
            [['tanggal_lahir', 'id_jabatan_tambahan', 'id_atasan','id_atasan_non_struktural','status','id_ruang','status_plt','telepon','tmt_pangkat','agama','status_perkawinan','gaji_pokok','tanggal_masuk','list_file','last_sync'], 'safe'],
            [['nip', 'gelar_depan', 'gelar_belakang'], 'string', 'max' => 50],
            [['nik'], 'string', 'max' => 50],
            [['nama', 'jenis_kelamin', 'tempat_lahir', 'kode_checklog'], 'string', 'max' => 255],
            [['foto', 'file_sk_pns', 'file_sk_cpns', 'file_kartu_pegawai', 'file_sk_pangkat', 'file_ijazah',
             'file_sp_tugas_belajar', 'file_sk_jabatan', 'file_sp_tugas', 'file_angka_kredit',
                    'file_sk_kenaikan_jabatan',
                    'file_sk_kenaikan_gaji_berkala',
                   'transkrip_nilai',
            ], 'file', 'skipOnEmpty' => true, 'extensions' => 'png,jpg,bmp,jpeg', 'maxSize' => 512000000, 'maxFiles' => 15],

            [['id_jabatan_fungsional'], 'exist', 'skipOnError' => true, 'targetClass' => JabatanFungsional::className(), 'targetAttribute' => ['id_jabatan_fungsional' => 'id_jabatan_fungsional']],
            [['id_unit_kerja'], 'exist', 'skipOnError' => true, 'targetClass' => UnitKerja::className(), 'targetAttribute' => ['id_unit_kerja' => 'id_unit_kerja']],
            [['id_golongan'], 'exist', 'skipOnError' => true, 'targetClass' => Golongan::className(), 'targetAttribute' => ['id_golongan' => 'id_golongan']],
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
            'nama' => Yii::t('app', 'Nama'),
            'gelar_depan' => Yii::t('app', 'Gelar Depan'),
            'gelar_belakang' => Yii::t('app', 'Gelar Belakang'),
            'alamat' => Yii::t('app', 'Alamat'),
            'id_unit_kerja' => Yii::t('app', 'Unit Kerja'),
            'id_jabatan_fungsional' => Yii::t('app', 'Jabatan'),
            'jenis_kelamin' => Yii::t('app', 'Jenis Kelamin'),
            'tempat_lahir' => Yii::t('app', 'Tempat Lahir'),
            'tanggal_lahir' => Yii::t('app', 'Tanggal Lahir'),
            'id_golongan' => 'Pangkat',

            'nama_golongan' => 'Pangkat',
           'jabatanFungsional.status_jabatan'=>'Status Jabatan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function cekKebutuhan($attribute, $params)
    {
        if(($this->jumlah_pegawai) > $this->jabatanFungsional->jml_kebutuhan)
        {
            $this->addError($attribute, 'Jumlah Jabatan '.$this->jabatanFungsional->nama_jabatan_fungsional.' Melebihi Kebutuhan');
            return faLse;
        }

    }   

    public function getJumlah_pegawai()
    {
        $jmlPegawai = Pegawai::find()->where(['id_jabatan_fungsional'=> $this->id_jabatan_fungsional ])->andWhere(['<>','id_pegawai',$this->id_pegawai])->count(); 
    }

    public function getJabatanFungsional()
    {
        return $this->hasOne(JabatanFungsional::className(), ['id_jabatan_fungsional' => 'id_jabatan_fungsional']);
    }

    public function getJabatanTambahan()
    {
        return $this->hasOne(JabatanTambahan::className(), ['id_jabatan_tambahan' => 'id_jabatan_tambahan']);
    }

    public function getNama_lengkap()
    {
        return $this->gelar_depan . ' ' . $this->nama . ' ' . $this->gelar_belakang;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnitKerja()
    {
        return $this->hasOne(UnitKerja::className(), ['id_unit_kerja' => 'id_unit_kerja']);
    }

    public function getSatuanKerja()
    {
        return $this->hasOne(SatuanKerja::className(), ['id_satuan_kerja' => 'id_satuan_kerja']);
    }

    public function getShift()
    {
        return $this->hasOne(detShift::className(), ['id_shift' => 'id_shift']);
    }

    public function getGolongan()
    {
        return $this->hasOne(Golongan::className(), ['id_golongan' => 'id_golongan']);
    }

    public function getRiwayat_jabatan()
    {
        return $this->hasMany(RiwayatJabatan::className(), ['id_pegawai' => 'id_pegawai'])->orderBy('tmt desc');
    }

    public function getRiwayat_diklat()
    {
        return $this->hasMany(RiwayatDiklat::className(), ['id_pegawai' => 'id_pegawai'])->orderBy('tgl_mulai desc');
    }

    public function getPangkat()
    {
        return is_null($this->golongan) ? '' : $this->golongan->nama_golongan . ' ( ' . $this->golongan->kode_golongan . ' )  ';
    }

    public function getKode_golongan()
    {
        return is_null($this->golongan) ? '' : $this->golongan->kode_golongan;
    }

    public function getNama_golongan()
    {
        return is_null($this->golongan) ? '' : $this->golongan->nama_golongan;
    }

    public function getNama_jabatan()
    {
        return is_null($this->jabatanFungsional) ? '' : (is_null($this->status_plt)?'':$this->status_plt) . ' ' . $this->jabatanFungsional->nama_jabatan_fungsional;
    }
    public function getNama_jabatan_skp()
    {
        if($this->status_plt !== 'Plt.')
        {  
         return is_null($this->jabatanFungsional) ? '' : (is_null($this->status_plt)?'':$this->status_plt) . ' ' . $this->jabatanFungsional->nama_jabatan_fungsional;
        } else
        {
           $jabatan = RiwayatJabatan::find()->where(['id_pegawai'=>$this->id_pegawai])->andWhere(['!=','id_jabatan',$this->id_jabatan_fungsional])->orderBy('tmt desc')->one();
          
         return ((is_null($this->status_plt)?'':$this->status_plt) . ' ' . $this->jabatanFungsional->nama_jabatan_fungsional)."/".(is_null($jabatan->jabatanFungsional) ? '' :  $jabatan->nama_jabatan);
          
        }  
    }

    public function getEselon()
    {
        if (!is_null($this->jabatanFungsional)) {
            return is_null($this->jabatanFungsional->eselon) ? '' : ' ( ' . $this->jabatanFungsional->nama_eselon . ' )';
        } else {
            return '';
        }
    }

    public function getNama_jabatan_tambahan()
    {
        return is_null($this->jabatanTambahan) ? '' : $this->jabatanTambahan->nama_jabatan;
    }

    public function getNama_unit_kerja()
    {
        return is_null($this->unitKerja) ? '' : $this->unitKerja->nama_unit_kerja;
    }

    public function getNama_satuan_kerja()
    {
        return is_null($this->satuanKerja) ? '' : $this->satuanKerja->nama_satuan_kerja;
    }

    public function upload($fieldName)
    {
        $path = Yii::getAlias('@app') . '/web/media/';

        //s  die($fieldName);
        $image = UploadedFile::getInstance($this, $fieldName);

        if (!empty($image) && $image->size !== 0) {
            if ($this->nip !== '') {
                $fileNames = md5($this->nip) . '.' . $image->extension;
            } else {
                $fileNames = md5($this->id_pegawai) . '.' . $image->extension;
            }
            if ($image->saveAs($path . $fileNames)) {
                $this->attributes = [$fieldName => $fileNames];

                return true;
            } else {
                return false;
            }
        } else {
            if ($fieldName === 'foto') {
                $this->attributes = [$fieldName => $this->old_foto];
            }

            return true;
        }
    }

    public function uploadKelengkapan($fieldName)
    {
        $path = Yii::getAlias('@app') . '/web/media/kelengkapan/';
        //   die($fieldName);

        //s  die($fieldName);
        $image = UploadedFile::getInstance($this, $fieldName);

        if (!empty($image) && $image->size !== 0) {
            if ($this->nip !== '') {
                $fileNames = $fieldName . ($this->nip) . '.' . $image->extension;
            } else {
                $fileNames = $fieldName . md5($this->id_pegawai) . '.' . $image->extension;
            }
            if ($image->saveAs($path . $fileNames)) {
                $this->attributes = [$fieldName => $fileNames];

                return true;
            } else {
                return false;
            }
        } else {
            if ($fieldName === 'file_sk_cpns') {
                $this->attributes = [$fieldName => $this->old_file_sk_cpns];
            }
            if ($fieldName === 'file_sk_pns') {
                $this->attributes = [$fieldName => $this->old_file_sk_pns];
            }
            if ($fieldName === 'file_kartu_pegawai') {
                $this->attributes = [$fieldName => $this->old_file_kartu_pegawai];
            }

            return true;
        }
    }

    public function uploadKelengkapanMultiple($fieldName)
    {
        $path = Yii::getAlias('@app') . '/web/media/kelengkapan/';
        //   die($fieldName);
        $value = '';
        $images = UploadedFile::getInstances($this, $fieldName);
        if (count($images) > 0) {
            $path = Yii::getAlias('@app') . '/web/media/';
            //   FileHelper::unlink($path . '*-' . md5($this->id_lokasi) . '*');
            $i = 0;
            foreach ($images as $image) {
                ++$i;
                if (!empty($image) && $image->size !== 0) {
                    $fileNames = $i . '-' . md5($this->id_pegawai) . "-$fieldName" . '.' . $image->extension;
                    if ($image->saveAs($path . $fileNames)) {
                        $value = $value . $fileNames . '&&';
                    } else {
                        return false;
                    }
                }
            }
        }
        if ($value !== '') {
            $this->attributes = [$fieldName => $value];
        }

        return true;
    }

    public function getAtasan()
    {
        return $this->hasOne(JabatanFungsional::className(), ['id_jabatan_fungsional' => 'id_atasan']);
    }

    public function getNama_atasan()
    {
        return is_null($this->atasan) ? '' : $this->atasan->nama_jabatan_fungsional;
    }

    public function getPegawai_atasan()
    {
        if (!is_null($this->id_atasan)) {
            return $this->hasOne(Pegawai::className(), ['id_jabatan_fungsional' => 'id_atasan'])->where('id_satuan_kerja<>0 ');
        } else {
            return $this->hasOne(Pegawai::className(), ['id_jabatan_tambahan' => 'id_atasan_non_struktural'])->where('id_satuan_kerja=' . $this->id_satuan_kerja);
        }
    }

    public function getPenilai()
    {
        return $this->hasOne(JabatanFungsional::className(), ['id_jabatan_fungsional' => 'id_penilai']);
    }

    public function getNama_penilai()
    {
        return is_null($this->penilai) ? '' : $this->penilai->nama_jabatan_fungsional;
    }

    public function getPegawai_penilai()
    {
        if (!is_null($this->id_penilai)) {
            return $this->hasOne(Pegawai::className(), ['id_jabatan_fungsional' => 'id_penilai'])->where('id_satuan_kerja<>0 ');
        } else {
            return $this->hasOne(Pegawai::className(), ['id_jabatan_tambahan' => 'id_penilai_non_struktural'])->where('id_satuan_kerja=' . $this->id_satuan_kerja);
        }
    }

    public function getAtasan_penilai()
    {
        return $this->hasOne(JabatanFungsional::className(), ['id_jabatan_fungsional' => 'id_atasan_penilai']);
    }

    public function getNama_atasan_penilai()
    {
        return is_null($this->atasan_penilai) ? '' : $this->atasan_penilai->nama_jabatan_fungsional;
    }

    public function getPegawai_atasan_penilai()
    {
        if (!is_null($this->id_atasan_penilai)) {
             return $this->hasOne(Pegawai::className(), ['id_jabatan_fungsional' => 'id_atasan_penilai'])->where('id_satuan_kerja<>0 ');
        } else {
            return $this->hasOne(Pegawai::className(), ['id_jabatan_tambahan' => 'id_atasan_penilai_non_struktural'])->where('id_satuan_kerja=' . $this->id_satuan_kerja);
        }
    }
 

    public function getPegawai_kepala()
    {
        return Pegawai::find()->
        innerJoin('tb_m_satuan_kerja', 'tb_m_satuan_kerja.id_pimpinan=id_jabatan_fungsional or tb_m_satuan_kerja.id_kepala=id_pegawai')
        ->where(['tb_m_satuan_kerja.id_satuan_kerja'=>$this->id_satuan_kerja])

          ->one();
    }

    public function getIs_atasan()
    {
        $pegawai = Pegawai::find()->select('id_pegawai')->where(['id_atasan' => $this->id_jabatan_fungsional   ])->one();
        if (is_null($pegawai) && !is_null($this->id_jabatan_tambahan)) {
            $pegawai = Pegawai::find()->select('id_pegawai')->where(['id_atasan_non_struktural' => $this->id_jabatan_tambahan,'id_satuan_kerja'=>$this->id_satuan_kerja])->one();
        }

        return (!is_null($pegawai));
    }

    public function getIs_pimpinan()
    {
        $pegawai = SatuanKerja::find()->select('id_satuan_kerja')->where(['id_pimpinan' => $this->id_jabatan_fungsional])->one();
        if (is_null($pegawai)) {
            $pegawai = SatuanKerja::find()->select('id_satuan_kerja')->where(['id_kepala' => $this->id_pegawai])->one();
        }
        return !is_null($pegawai);
    }
    public function getDetailFilePangkat()
    {
        return $this->hasMany(DetPegawaiFilePangkat::className(), ['id_pegawai' => 'id_pegawai'])->where("jenis='sk_pangkat'");
    }

    public function getDetailFileJabatan()
    {
        return $this->hasMany(DetPegawaiFileJabatan::className(), ['id_pegawai' => 'id_pegawai'])->where("jenis='sk_jabatan'");
    }
    public function getDetailFileSpmt()
    {
        return $this->hasMany(DetPegawaiFileSpmt::className(), ['id_pegawai' => 'id_pegawai'])->where("jenis='spmt'");
    }
    public function getDetailFileGaji()
    {
        return $this->hasMany(DetPegawaiFileGaji::className(), ['id_pegawai' => 'id_pegawai'])->where("jenis='sk_gaji'");
    }
    public function getDetailFileIjazah()
    {
        return $this->hasMany(DetPegawaiFileIjazah::className(), ['id_pegawai' => 'id_pegawai'])->where("jenis='ijazah'");
    }
    public function getDetailFileTranskrip()
    {
        return $this->hasMany(DetPegawaiFileTranskrip::className(), ['id_pegawai' => 'id_pegawai'])->where("jenis='transkrip'");
    }

    public function setDetailFilePangkat($value)
    {
        return $this->loadRelated('detailFilePangkat', $value);
    }

    public function setDetailFileJabatan($value)
    {
        return $this->loadRelated('detailFileJabatan', $value);
    }

    public function setDetailFileSpmt($value)
    {
        return $this->loadRelated('detailFileSpmt', $value);
    }

    public function setDetailFileGaji($value)
    {
        return $this->loadRelated('detailFileGaji', $value);
    }

    public function setDetailFileIjazah($value)
    {
        return $this->loadRelated('detailFileIjazah', $value);
    }

    public function setDetailFileTranskrip($value)
    {
        return $this->loadRelated('detailFileTranskrip', $value);
    }
    public function getRuang()
    {
        return $this->hasOne(DetRuang::className(), ['id_ruang' => 'id_ruang']);
    }
    public function getMasa_kerja()
    {

        $date1 = ($this->jenis_pegawai=="Pegawai Negeri Sipil" || $this->jenis_pegawai=='Calon Pegawai Negeri Sipil') ? strtotime(substr($this->nip, 8, 4) . '-' . substr($this->nip, 12, 2) . '-01')
          : strtotime($this->tanggal_masuk)
          
          ;
      

        $date2 =  strtotime(date('Y-m-d'));


// Formulate the Difference between two dates
        $diff = abs($date2 - $date1);


// To get the year divide the resultant date into
// total seconds in a year (365*60*60*24)
        $years = floor($diff / (365*60*60*24));


// To get the month, subtract it with years and
// divide the resultant date into
// total seconds in a month (30*60*60*24)
        $months = floor(($diff - $years * 365*60*60*24)
                               / (30*60*60*24));


// To get the day, subtract it with years and
// months and divide the resultant date into
// total seconds in a days (60*60*24)
        $days = floor(($diff - $years * 365*60*60*24 -
             $months*30*60*60*24)/ (60*60*24));



// Print the result
        return "$years Tahun $months Bulan $days Hari";
    }
   public function getMasa_kerja_pensiun()
    {

    $date1 = ($this->jenis_pegawai=="Pegawai Negeri Sipil" || $this->jenis_pegawai=='Calon Pegawai Negeri Sipil') ? strtotime(substr($this->nip, 8, 4) . '-' . substr($this->nip, 12, 2) . '-01')
          : strtotime($this->tanggal_masuk)
          
          ;
   

        $date2 =  strtotime($this->pensiun);
     



// Formulate the Difference between two dates
        $diff = abs($date2 - $date1);


// To get the year divide the resultant date into
// total seconds in a year (365*60*60*24)
        $years = floor($diff / (365*60*60*24));


// To get the month, subtract it with years and
// divide the resultant date into
// total seconds in a month (30*60*60*24)
        $months = floor(($diff - $years * 365*60*60*24)
                               / (30*60*60*24));


// To get the day, subtract it with years and
// months and divide the resultant date into
// total seconds in a days (60*60*24)
        $days = floor(($diff - $years * 365*60*60*24 -
             $months*30*60*60*24)/ (60*60*24));



// Print the result
        return "$years Tahun $months Bulan $days Hari";
    }
    public function getMasa_kerja_tahun()
    {

    $date1 = ($this->jenis_pegawai=="Pegawai Negeri Sipil" || $this->jenis_pegawai=='Calon Pegawai Negeri Sipil') ? strtotime(substr($this->nip, 8, 4) . '-' . substr($this->nip, 12, 2) . '-01')
          : strtotime($this->tanggal_masuk)
          
          ;

        $date2 =  strtotime(date("Y-m-d"));     



        $diff = abs($date2 - $date1);

        $years = floor($diff / (365*60*60*24));





// Print the result
        return $years;
    }
    public function getPensiun()
    {
        $tgl =strtotime($this->tanggal_lahir);

        if (!is_null($this->jabatanFungsional)) {
            if (!is_null($this->jabatanFungsional->eselon)) {
                if (($this->jabatanFungsional->eselon->nama_eselon == 'II.a') || ($this->jabatanFungsional->eselon->nama_eselon == 'II.b')) {
                    $pensiun= date('Y-m-d', strtotime('+60 year', $tgl));
                } else {
                    $pensiun= date('Y-m-d', strtotime('+58 year', $tgl));
                }
            } else {
                if (strpos(strtoupper($this->nama_jabatan), 'UTAMA') !==false) {
                    $pensiun= date('Y-m-d', strtotime('+65 year', $tgl));
                } elseif (strpos(strtoupper($this->nama_jabatan), 'MADYA') !==false) {
                    $pensiun= date('Y-m-d', strtotime('+60 year', $tgl));
                } else {
                    $pensiun= date('Y-m-d', strtotime('+58 year', $tgl));
                }
            }
        } else {
            $pensiun= date('Y-m-d', strtotime('+58 year', $tgl));
        }

        return date('Y-m-1', strtotime('next month', strtotime($pensiun)));
    }


    public function getSaldoCuti()
    {
        return $this->hasOne(SaldoCuti::className(), ['id_pegawai'=>'id_pegawai']);
    }

    public function getStatus_skp()
    {
        $model = SasaranKinerjaPegawai::find()->where(['id_pegawai'=>$this->id_pegawai ,'tahun' =>date('Y') ])->all();
        if (count($model)==0) {
            $text= 'Belum Membuat SKP';
        }elseif (count($model)< 5) {
            $text= 'Belum Isi SKP Masih Membuat '.count($model).' SKP';
        } else {
            $text= 'Sudah isi SKP';
        }
      
      $tot=0;
      for ($i=1; $i<=12; $i++) {
                    $detail=SasaranKinerjaPegawai::find()
                   
                    ->joinWith('detailSasaranKinerjaPegawai')
                    ->where(['id_pegawai'=>$this->id_pegawai,'tahun'=>date('Y'),'bulan'=>$i])->sum('tb_dt_skp.kuantitas');
                    if (is_null($detail) || ($detail==0)) {
                        $tot++ ;
                }
      }
      if($tot>0)
      {
         $text .= " Belum ada Uraian Kegiatan Untuk $tot Bulan";
      }  
      return $text;
    }

       public function getSisaCuti()
        {
            $saldo = 0;
           $saldo2=0;
            
            $tahun = date('Y');
           $saldo2=0;
           $saldo1=0;
        
              $saldo2 =0;
           
            if (($tahun-2) >= 2019) {
                $saldo2 = 12- (Absen::find()->where("date_format(tgl_absen,'%Y')= " .($tahun-2))
                ->andWhere(['id_pegawai'=>$this->id_pegawai])
                ->andWhere(['id_jenis_absen'=>'10'])
    
                  ->sum('1'));
              
                      $saldo2 = ($saldo2>6?6:($saldo2<0?0:$saldo2));
            }
            if (($tahun-1) > 2019) {
                $saldo1 = 12- (Absen::find()->where("date_format(tgl_absen,'%Y')= " . ($tahun-1))
                ->andWhere(['id_pegawai'=>$this->id_pegawai])
                ->andWhere(['id_jenis_absen'=>'10'])
    
                  ->sum('1'));
                  $saldo1 = ($saldo1>6?6:($saldo1<0?0:$saldo1));
            }
          
            $saldo +=12- (Absen::find()->where("date_format(tgl_absen,'%Y')= " . ($tahun))
            ->andWhere(['id_pegawai'=>$this->id_pegawai])
            ->andWhere(['id_jenis_absen'=>'10'])
    
            ->sum('1'));
    
            return $saldo+$saldo1+$saldo2;
        
    
    }
  
    public function isWfh()
    {
        $model =WorkFromHome::find()->where([ 'tanggal_wfh'=>date('Y-m-d') ,'id_pegawai'=> $this->id_pegawai])->all();
    
        return count($model);
    }

    public function getDetailPasangan()
    {
        return $this->hasMany(DetPegawaiPasangan::className(), ['id_pegawai' => 'id_pegawai']);
    }

    public function setDetailPasangan($value)
    {
        return $this->loadRelated('detailPasangan', $value);
    }

    public function getDetailAnak()
    {
        return $this->hasMany(DetPegawaiAnak::className(), ['id_pegawai' => 'id_pegawai']);
    }

    public function setDetailAnak($value)
    {
        return $this->loadRelated('detailAnak', $value);
    }

  public function getUser()
  {
    return $this->hasOne(User::className(),['id_pegawai'=>'id_pegawai']);
  }

}
