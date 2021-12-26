<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "tb_mt_pengajuan_cuti".
 *
 * @property int $id_pengajuan_cuti
 * @property int $id_pegawai
 * @property int $id_atasan
 * @property int $id_kepala
 * @property string $alasan
 * @property int $id_jenis_absen
 * @property int $jumlah_hari
 * @property string $tanggal_awal
 * @property string $tanggal_akhir
 * @property string $alamat
 * @property string $telepon
 *
 * @property TbMPegawai $pegawai
 * @property TbMPegawai $atasan
 * @property TbMPegawai $kepala
 * @property TbMJenisAbsen $jenisAbsen
 */
class PengajuanCuti extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $alasan1;
  
    public static function tableName()
    {
        return 'tb_mt_pengajuan_cuti';
    }
  
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
        [['id_pegawai', 'tanggal_awal', 'tanggal_akhir'], 'required'],
        [['id_pegawai', 'id_atasan', 'id_kepala', 'id_jenis_absen','jumlah_hari','stat_disposisi_admin','id_atasan2','id_sekretaris' ], 'integer'],
        [['alasan', 'alamat','keterangan','keterangan_atasan2','keterangan_sekretaris','keterangan_kepala','keterangan_admin','no_surat'], 'string'],
          [['id_jenis_absen'],'setAlasan'],
         [['jumlah_hari'],'checkHari','except'=>'no_surat'] ,
        [['tanggal_awal', 'tanggal_akhir','status','alasan1'], 'safe'],
     //   [[ 'tanggal_awal', 'tanggal_akhir'] ,'setHari'],
        [['telepon'], 'string', 'max' => 255],
        [['file_pendukung'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf,jpg,jpeg,png', 'maxSize' => 512000000],
        [['id_pegawai'], 'exist', 'skipOnError' => true, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['id_pegawai' => 'id_pegawai']],
        [['id_atasan'], 'exist', 'skipOnError' => true, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['id_atasan' => 'id_pegawai']],
        [['id_kepala'], 'exist', 'skipOnError' => true, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['id_kepala' => 'id_pegawai']],
        [['id_jenis_absen'], 'exist', 'skipOnError' => true, 'targetClass' => JenisAbsen::className(), 'targetAttribute' => ['id_jenis_absen' => 'id_jenis_absen']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getPosisi_status()
    {
        switch ($this->status) {
            case  'Belum Diapprove' :
                return 0;
            case 'Diterima Atasan' :
               return 1;
            case 'Cuti Diterima' :
              return 2;
        }
    }

    public function scenarios() {

        $scenarios = parent::scenarios();

        $scenarios['no_surat'] = ['no_surat'];

        return $scenarios;

    }
  
    public function getJumlah_hariHitung()
    {
      
        $taw =  implode('-', array_reverse(explode('-', $this->tanggal_awal)));
        $tak =  implode('-', array_reverse(explode('-', $this->tanggal_akhir)));
      
        if ($taw <> '') {
            $data =Yii::$app->db->createCommand("select count(tanggal) as jumlah from tp_tanggal t
                          inner join tb_d_shift s on s.hari=WEEKDAY(t.tanggal) and s.jam_masuk <>'00:00'
                          inner join tb_m_pegawai p on p.id_shift = s.id_shift
                          where t.tanggal >= '" . $taw . "' and t.tanggal<= '" . $tak . "'
                          and p.id_pegawai =" . $this->id_pegawai)->queryOne();
            return $data['jumlah'];
        }
        
      
        return 0;
    }
    public function setAlasan($attribute, $params)
    {
        if ($this->id_jenis_absen==11) {
            $this->alasan = $this->alasan1;
        }
         return true;
    }

    public function behaviors()
    {
        return [


            'tanggal_akhirBeforeSave' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'tanggal_akhir',
                   ActiveRecord::EVENT_BEFORE_UPDATE => 'tanggal_akhir',

                  ],

                'value' => function () {
                    return $this->scenario=='no_surat'?$this->tanggal_akhir: implode('-', array_reverse(explode('-', $this->tanggal_akhir)));
                }



            ],






            'tanggal_awalBeforeSave' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'tanggal_awal',
                  ActiveRecord::EVENT_BEFORE_UPDATE => 'tanggal_awal',
                ],

                'value' => function () {

                    return $this->scenario=='no_surat'?$this->tanggal_awal: implode('-', array_reverse(explode('-', $this->tanggal_awal)));
                }



            ],




        ];
    }

   
    public function setHari()
    {
         $this->jumlah_hari = $this->jumlah_hariHitung;
         return true;
    }
    public function checkHari($attribute, $params)
    {
      
 
      

        if (($this->jumlah_hari > $this->sisaCuti) && ($this->jenis_absen->nama_jenis_absen=='Cuti Tahunan')) {
             $this->addError($attribute, "Cuti Maksimal yang Bisa Diambil $this->sisaCuti Hari");
            return false;
        } elseif (($this->jumlah_hari > 90) && ($this->jenis_absen->nama_jenis_absen=='Cuti Besar' || $this->jenis_absen->nama_jenis_absen=='Cuti Melahirkan')) {
            $this->addError($attribute, 'Cuti Maksimal yang Bisa Diambil 90 Hari');
            return false;
        } elseif (($this->jumlah_hari > 30) && ($this->jenis_absen->nama_jenis_absen=='Cuti Alasan Penting')) {
            $this->addError($attribute, 'Cuti ' . $this->jumlah_hari . 'hari  Maksimal yang Bisa Diambil 30 Hari');
            return false;
        } elseif (($this->jenis_absen->nama_jenis_absen=='Cuti Melahirkan' && $this->pegawai->jenis_kelamin == 'L')) {
            $this->addError('id_jenis_absen', 'Cuti ini Hanya Untuk Wanita');
            return false;
        }
    }
    public function attributeLabels()
    {
        return [
            'id_pengajuan_cuti' => Yii::t('app', 'Id Pengajuan Cuti'),
            'id_pegawai' => Yii::t('app', 'Id Pegawai'),
            'id_atasan' => Yii::t('app', 'Id Atasan'),
            'id_kepala' => Yii::t('app', 'Id Kepala'),
            'alasan' => Yii::t('app', 'Alasan'),
            'id_jenis_absen' => Yii::t('app', 'Jenis Cuti'),
            'jumlah_hari' => Yii::t('app', 'Jumlah Hari'),
            'tanggal_awal' => Yii::t('app', 'Tanggal Awal'),
            'tanggal_akhir' => Yii::t('app', 'Tanggal Akhir'),
            'alamat' => Yii::t('app', 'Alamat'),
            'telepon' => Yii::t('app', 'Telepon'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'id_pegawai']);
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
    public function getKepala()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'id_kepala']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAtasan2()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'id_atasan2']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSekretaris()
    {
        return $this->hasOne(Pegawai::className(), ['id_pegawai' => 'id_sekretaris']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJenis_absen()
    {
        return $this->hasOne(JenisAbsen::className(), ['id_jenis_absen' => 'id_jenis_absen']);
    }

      public function getSisaCuti()
    {
        $saldo = 0;
        $tanggal =   $this->tanggal_awal;
       


        $tahun = substr($tanggal, 0, 4);
        $data = SaldoCuti::find() ->where(['id_pegawai'=>$this->id_pegawai])->one();
        if (!is_null($data)) {
            if (($tahun-2)==2018) {
                if ($data->saldo_2018>=6) {
                    $saldo+=6;
                }
            }
            if ((($tahun-2)==2019) || (($tahun-1)==2019)) {
                if ($data->saldo_2019>=6) {
                    $saldo+=6;
                }
            }
        }

        if ($tahun-2 > 2019) {
             $saldo += 6- (Absen::find()->where("date_format(tgl_absen,'%Y')= " . ($tahun-2))
            ->andWhere(['id_pegawai'=>$this->id_pegawai])
            ->andWhere(['id_jenis_absen'=>'10'])

              ->sum('1'));
        }

        if ($tahun-1 > 2019) {
              $saldo += - (Absen::find()->where("date_format(tgl_absen,'%Y')= " . ($tahun-1))
            ->andWhere(['id_pegawai'=>$this->id_pegawai])
            ->andWhere(['id_jenis_absen'=>'10'])

              ->sum('1'));
        }

            $saldo += 12- (Absen::find()->where("date_format(tgl_absen,'%Y')= " . ($tahun))
            ->andWhere(['id_pegawai'=>$this->id_pegawai])
            ->andWhere(['id_jenis_absen'=>'10'])

              ->sum('1'));

        return $saldo;
    }
    public function getSisaCutiPrint()
    {
      
        $saldo = 0;
        $tanggal =   $this->tanggal_awal;



        $tahun = substr($tanggal, 0, 4);
        $data = SaldoCuti::find() ->where(['id_pegawai'=>$this->id_pegawai])->one();
        if (!is_null($data)) {
            if (($tahun-2)==2018) {
                if ($data->saldo_2018>=6) {
                    $saldo+=6;
                }
            }
            if ((($tahun-2)==2019) || (($tahun-1)==2019)) {
                if ($data->saldo_2019>=6) {
                    $saldo+=6;
                }
            }
        }

        if ($tahun-2 > 2019) {
           $saldo += 6- (Absen::find()->where("date_format(tgl_absen,'%Y')= " . ($tahun-2))
            ->andWhere(['id_pegawai'=>$this->id_pegawai])
            ->andWhere(['id_jenis_absen'=>'10'])

              ->sum('1'));
        }

        if ($tahun-1 > 2019) {
           $saldo += 6- (Absen::find()->where("date_format(tgl_absen,'%Y')= " . ($tahun-1))
            ->andWhere(['id_pegawai'=>$this->id_pegawai])
            ->andWhere(['id_jenis_absen'=>'10'])

              ->sum('1'));
        }

       $saldo += 12- (Absen::find()->where("date_format(tgl_absen,'%Y')= " . ($tahun))
            ->andWhere(['id_pegawai'=>$this->id_pegawai])
            ->andWhere(['id_jenis_absen'=>'10'])

              ->sum('1'));

        return ($saldo<0?0:$saldo);
    }

    public function getSisaCutiPrint2Tahun()
    {
      if($this->pegawai->masa_kerja_tahun < 1) {
        return 0;
      }
        $saldo = 0;
        $tanggal =   $this->tanggal_awal;



        $tahun = substr($tanggal, 0, 4);
        $data = SaldoCuti::find() ->where(['id_pegawai'=>$this->id_pegawai])->one();
        if (!is_null($data)) {
            if (($tahun-2)==2018) {
                if ($data->saldo_2018>=6) {
                    $saldo+=6;
                }
            }
            if (($tahun-2)==2019) {
                if ($data->saldo_2019>=6) {
                    $saldo+=6;
                }
            }
        } else {
          $saldo =6;
        }
      

        if ($tahun-2 > 2019) {
              $saldo += 12- (Absen::find()->where("date_format(tgl_absen,'%Y')= " . ($tahun-2))
            ->andWhere(['id_pegawai'=>$this->id_pegawai])
            ->andWhere(['id_jenis_absen'=>'10'])

              ->sum('1'));
        }


           return ($saldo>6?6:($saldo<0?0:$saldo));
    }

    public function getSisaCutiPrint1Tahun()
    {
      if($this->pegawai->masa_kerja_tahun < 1) {
        return 0;
      }
      
        $saldo = 0;
        $tanggal =   $this->tanggal_awal;



        $tahun = substr($tanggal, 0, 4);
        $data = SaldoCuti::find() ->where(['id_pegawai'=>$this->id_pegawai])->one();
        if (!is_null($data)) {
            if (($tahun-1)==2019) {
                if ($data->saldo_2019>=6) {
                    $saldo+=6;
                }
            }
        }

        if ($tahun-1 > 2019) {
        $saldo += 12- (Absen::find()->where("date_format(tgl_absen,'%Y')= " . ($tahun-1))
            ->andWhere(['id_pegawai'=>$this->id_pegawai])
            ->andWhere(['id_jenis_absen'=>'10'])

              ->sum('1'));
        }


        return ($saldo>6?6:($saldo<0?0:$saldo));
    }

    public function getSisaCutiPrintTahun()
    {
        $saldo = 0;
        $tanggal =   $this->tanggal_awal;

      
        $tahun = substr($tanggal, 0, 4);



        $saldo += 12- (Absen::find()->where("date_format(tgl_absen,'%Y')= " . ($tahun))
            ->andWhere(['id_pegawai'=>$this->id_pegawai])
            ->andWhere(['id_jenis_absen'=>'10'])
           ->andWhere(['<>','coalesce(id_pengajuan_cuti,0)',$this->id_pengajuan_cuti])
                       
              ->sum('1'));


        return ($saldo<0?0:$saldo);
    }


    public function getPegawai_lain_cuti()
    {
        return PengajuanCuti::find()
        ->innerJoin('tb_m_pegawai', 'tb_m_pegawai.id_pegawai = tb_mt_pengajuan_cuti.id_pegawai')
        ->where(['<>', 'id_pengajuan_cuti',$this->id_pengajuan_cuti])
        ->andWhere(['<=','tanggal_awal',$this->tanggal_awal])
        ->andWhere(['>=','tanggal_akhir',$this->tanggal_awal])
        ->andWhere(['tb_mt_pengajuan_cuti.status'=>'Cuti Diterima'])
        ->andWhere(['id_satuan_kerja'=> $this->pegawai->id_satuan_kerja ])
        ->all();
    }

  
    public function upload($fieldName)
    {
        $path = Yii::getAlias('@app') . '/web/media/';

        //s  die($fieldName);
        $image = UploadedFile::getInstance($this, $fieldName);

        if (!empty($image) && $image->size !== 0) {
            $fileNames = 'Cuti' . $this->id_pegawai . $this->id_jenis_absen . md5(microtime()) . '.' . $image->extension;
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
