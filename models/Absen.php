<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%tb_mt_absen}}".
 *
 * @property int           $id_absen
 * @property int           $id_jenis_absen
 * @property int           $id_pegawai
 * @property string        $tgl_absen
 * @property string        $masuk_kerja
 * @property string        $pulang_kerja
 * @property string        $terlambat_kerja
 * @property string        $pulang_awal
 * @property TbMJenisAbsen $jenisAbsen
 * @property TbMPegawai    $pegawai
 */
class Absen extends \yii\db\ActiveRecord
{
    public $tgl_awal;
    public $tgl_akhir;
    public $ket;
    public $id_absen_terlambat;
   public $latitude;
   public $longitude;
  
   // public $nama_jenis_absen;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tb_mt_absen}}';
    }

    /**
     * {@inheritdoc}
     */

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            if (!is_null($this->pegawai)) {
                $id_satuan_kerja = $this->pegawai->id_satuan_kerja;
                if ($this->jenisAbsen->status_hadir =='Hadir') {
                    \Yii::$app->db->createCommand("update tb_m_satuan_kerja set tanggal_absen_terakhir = '" . $this->tgl_absen . "' where id_satuan_kerja=$id_satuan_kerja and coalesce(tanggal_absen_terakhir,'1990-1-1') < '" . $this->tgl_absen . "'")->execute();
                }
            }
        }

       
      
      
      
      
      
    }

  
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['Cuti'] = ['id_jenis_absen','id_pegawai','tgl_absen','tgl_awal','tgl_akhir','file_pendukung','alasan'];//Scenario Values Only Accepted
        return $scenarios;
    }

    public function rules()
    {
        return [
            [['id_jenis_absen', 'id_pegawai', 'tgl_absen'], 'required'],
            [['id_jenis_absen', 'id_pegawai'], 'integer'],
            [['masuk_kerja', 'pulang_kerja', 'tgl_awal', 'tgl_akhir' , 'id_absen_terlambat','latitude','posisi_masuk','posisi_pulang','id_pengajuan_cuti'], 'safe'],
            [['alasan'], 'string'],
            [['longitude'],'cekJarak'],
            [['file_pendukung'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf,doc,docx,txt,xls,xlsx', 'maxSize' => 512000000],
            [['file_pendukung','alasan'], 'required', 'on' =>'Cuti'],
         //   [['masuk_kerja', 'pulang_kerja'], 'datetime', 'format' => 'php:H:i:s'],
            [['terlambat_kerja', 'pulang_awal'], 'number'],
            [['masuk_kerja'], 'hitungJamTerlambat'],
            [['pulang_kerja'], 'hitungJamPulang'],
         //   [[ 'tgl_absen', 'id_pegawai'],'unique','comboNotUnique' =>'Absen Karyawan Ini Sudah Ada', 'targetAttribute' => ['tgl_awal', 'tgl_akhir', 'id_satuan_kerja']]


            [['id_jenis_absen'], 'exist', 'skipOnError' => true, 'targetClass' => JenisAbsen::className(), 'targetAttribute' => ['id_jenis_absen' => 'id_jenis_absen']],
            [['id_pegawai'], 'exist', 'skipOnError' => true, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['id_pegawai' => 'id_pegawai']],
        ];
    }
  private function distance($lat1, $lon1, $lat2, $lon2) {
  $R = 6371; // Radius of the earth in km
  $dLat = deg2rad($lat2 - $lat1); // deg2rad below
  $dLon = deg2rad($lon2 - $lon1);
  $a =
    sin($dLat / 2) * sin($dLat / 2) +
    cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
    sin($dLon / 2) * sin($dLon / 2);

  $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
  $d = $R * $c; // Distance in km
  return $d;
} 

   private function deg2rad($deg) {
    return $deg * pi / 180;
  }
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'tgl_absenBeforeSave' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'tgl_absen',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'tgl_absen',
                ],

                'value' => function () {
                    return implode('-', array_reverse(explode('-', $this->tgl_absen)));
                },
            ],
            'bedezign\yii2\audit\AuditTrailBehavior',
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_absen' => Yii::t('app', 'Id Absen'),
            'id_jenis_absen' => Yii::t('app', ' Jenis Absen'),
            'id_pegawai' => Yii::t('app', ' Pegawai'),
            'tgl_absen' => Yii::t('app', 'Tgl Absen'),
            'masuk_kerja' => Yii::t('app', 'Masuk Kerja'),
            'pulang_kerja' => Yii::t('app', 'Pulang Kerja'),
            'terlambat_kerja' => Yii::t('app', 'Terlambat Kerja (Menit)'),
            'pulang_awal' => Yii::t('app', 'Pulang Awal (Menit)'),
        ];
    }
    public static function hitungPotongan($terlambat,$jenis='masuk') 
    {

        if ($terlambat>0 and $terlambat<31)
        {
            return 0.5;

        }
        elseif ($terlambat>=31 and $terlambat<61)
        {
            return 1;
            
        }
        
        elseif ($terlambat>=61 and $terlambat<91)
        {
            return 1.25;
            
        }
        
        elseif ($terlambat>=90)
        {
            if($jenis=='pulang'){
            return 1.55;
            }
            else
            {
            return 1.5;
            }
            
        }
        else
        return 0;
        

        
        


    }
      
       public function cekJarak($attribute, $params)
    {
         $latKantor=$this->pegawai->satuanKerja->latitude;
         $longKantor=$this->pegawai->satuanKerja->longitude;
         if(is_null($latKantor)||is_null($longKantor)) {
           
           Yii::$app->session->setFlash('error', 'SKPD Belum di Setting Untuk Absen Manual');
             $this->addError('error', 'SKPD Belum di Setting Untuk Absen Manual');
          return false;
           
         }
      if(($this->latitude=="-")||($this->longitude=="-")) {
           
           Yii::$app->session->setFlash('error', 'Update Aplikasi / Setujui Permintaan Lokasi  Untuk Absen Manual');
             $this->addError('error', 'Update Aplikasi Anda Untuk Absen Manual');
          return false;
           
         }
   
         if (
           ($this->pegawai->satuanKerja->cek_lokasi==1) 
           && 
            ($this->pegawai->isWfh()==0 )
          && 
           ( !$this->pegawai->isEselon2()
           )
         
         )         
         {

         if ($this->distance($this->latitude, $this->longitude, $latKantor, $longKantor) > $this->pegawai->satuanKerja->radius )
         {
            Yii::$app->session->setFlash('error','Posisi Anda Terlalu Jauh Untuk Absen Manual');
             $this->addError('error','Posisi Anda Terlalu Jauh Untuk Absen Manual');
    
            return false;
           
         }
         
         }
         
         
         
         
         
         
       }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function hitungJamTerlambat($attribute, $params)
    {
        $hari = date('w', strtotime($this->tgl_absen)) -1;
        $satuanKerja = strtolower($this->pegawai->nama_satuan_kerja);
        if ($this->jenisAbsen->status_hadir == 'Hadir') {
            $shift = DetShift::find()->where(['id_shift' => $this->pegawai->id_shift, 'hari' => $hari])->one();


            if ($hari == 4) {
                $toleransi =  1.5;
            } else {
                $toleransi = 1;
            }
            if (!is_null($shift)) {
                if (((strtotime($this->masuk_kerja) - strtotime($shift->jam_masuk)) / 3600) < -1 * $toleransi) {
                    $this->alasan = "Masuk Sebelum Toleransi Pukul: ".$this->masuk_kerja;
                    $this->masuk_kerja = null;
                    $this->terlambat_kerja = 0;
                } elseif (((strtotime($this->masuk_kerja) - strtotime($shift->jam_masuk)) / 60) > 0.001) {
                    $this->terlambat_kerja = ceil((strtotime($this->masuk_kerja) - strtotime($shift->jam_masuk)) / 60);
                } else {
                    $this->terlambat_kerja = 0;
                }
            } else {
                $this->terlambat_kerja =0;
            }
        } else {
            if ($this->scenario !== 'Cuti') {
                $this->masuk_kerja = '00:00';
                $this->terlambat_kerja = 0;
            }
        }
        $this->persen_terlambat = self::hitungPotongan($this->terlambat_kerja);

        return true;
    }

    public function hitungJamPulang($attribute, $params)
    {
        $hari = date('w', strtotime($this->tgl_absen))-1;
        if ($this->jenisAbsen->status_hadir == 'Hadir') {
            $toleransi =1.5;
            $shift = DetShift::find()->where(['id_shift' => $this->pegawai->id_shift, 'hari' => $hari])->one();

            if (!is_null($shift)) {
                // if (((strtotime($this->pulang_kerja) - strtotime($shift->jam_pulang)) / 60) >  $toleransi) {
                //     $this->alasan = "Pulang Melebihi Toleransi Pukul: ".$this->pulang_kerja;
                //     $this->pulang_kerja = null;
                //     $this->pulang_awal = 0;
                // } else

                if (((strtotime($this->pulang_kerja) - strtotime($shift->jam_pulang)) / 60) < 0) {
                    $this->pulang_awal = ceil(abs(strtotime($shift->jam_pulang) - strtotime($this->pulang_kerja)) / 60);
                } else {
                    $this->pulang_awal = 0;
                }
            } else {
                $this ->pulang_awal=0;
            }
        } else {
            if ($this->scenario !== 'Cuti') {
                $this->pulang_kerja = '00:00';
                $this->pulang_awal = 0;
            }
        }
        $this->persen_pulang_awal = self::hitungPotongan($this->pulang_awal,'pulang');


        return true;
    }

    public function getJenisAbsen()
    {
        return $this->hasOne(JenisAbsen::className(), ['id_jenis_absen' => 'id_jenis_absen']);
    }

    public function getNama_jenis_absen()
    {
        return is_null($this->jenisAbsen) ? '' : $this->jenisAbsen->nama_jenis_absen;
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
        return is_null($this->pegawai) ? '' : '' . $this->pegawai->nama_lengkap;
    }

    public function getNip()
    {
        return is_null($this->pegawai) ? '' : '' . $this->pegawai->nip;
    }

    public function upload($fieldName)
    {
        $path = Yii::getAlias('@app') . '/web/media/';

        //s  die($fieldName);
        $image = UploadedFile::getInstance($this, $fieldName);

        if (!empty($image) && $image->size !== 0) {
            $fileNames = 'Absen' . $this->id_pegawai . $this->tgl_absen . md5(microtime()) . '.' . $image->extension;
            if ($image->saveAs($path . $fileNames)) {
                $this->attributes = [$fieldName => $fileNames];

                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
}
