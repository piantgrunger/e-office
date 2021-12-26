<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;


use Yii;

/**
 * This is the model class for table "{{%tb_mt_hitung_tunjangan}}".
 *
 * @property int    $id_hitung_tunjangan
 * @property string $tgl_awal
 * @property string $tgl_akhir
 *
 */
class HitungTunjangan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}

     */
    public $bulan;
    public $tahun;

    // public function behaviors()
    // {
    //     return [


    //             "tgl_akhirBeforeSave" => [
    //                 "class" => TimestampBehavior::className(),
    //                 "attributes" => [
    //                     ActiveRecord::EVENT_BEFORE_INSERT => "tgl_akhir",
    //                     ActiveRecord::EVENT_BEFORE_UPDATE => "tgl_akhir",
    //                 ],

    //                 "value" => function () {
    //                     return implode("-", array_reverse(explode("-", $this->tgl_akhir)));
    //                 }



    //             ],






    //             "tgl_awalBeforeSave" => [
    //                 "class" => TimestampBehavior::className(),
    //                 "attributes" => [
    //                     ActiveRecord::EVENT_BEFORE_INSERT => "tgl_awal",
    //                     ActiveRecord::EVENT_BEFORE_UPDATE => "tgl_awal",
    //                 ],

    //                 "value" => function () {
    //                     return implode("-", array_reverse(explode("-", $this->tgl_awal)));
    //                 }



    //             ],




    //         ];
    // }

    public static function tableName()
    {
        return '{{%tb_mt_hitung_tunjangan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tgl_awal', 'tgl_akhir', 'id_satuan_kerja','bulan','tahun'], 'required'],
            [['status_proses'], 'safe'],
            [['tgl_awal', 'tgl_akhir', 'id_satuan_kerja'],'unique','comboNotUnique' =>'Perhitungan Tunjangan SKPD ini Sudah Dilakukan,Hapus Dulu Perhitungan yang Ada'  , 'targetAttribute' => ['tgl_awal', 'tgl_akhir', 'id_satuan_kerja']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_hitung_tunjangan' => Yii::t('app', 'Id Tambahan Penghasilan Pegawai'),
            'tgl_awal' => Yii::t('app', 'Tanggal Awal'),
            'tgl_akhir' => Yii::t('app', 'Tanggal Akhir'),
        ];
    }

    public function cekValidasi()
    {
        $this->tgl_awal=$this->tahun . '-' . $this->bulan . '-1';
        $date = new \DateTime($this->tgl_awal);
        $date->modify('last day of this month');
        $this->tgl_akhir=$date->format('Y-m-d');
        if (is_null(Validasi::find()->where(['id_satuan_kerja' => $this->id_satuan_kerja, 'periode' => date('m-Y', strtotime($this->tgl_awal))])->one())
              &&($this->satuanKerja->status_cek_absen=='Ya')

        ) {
            Yii::$app->session->setFlash('error', 'Data Tidak Dapat Diproses Karena Satuan Kerja Belum di Validasi pada Periode Ini');
            return false;
        } else {
            return true;
        }
    }
    public function getSatuanKerja()
    {
        return $this->hasOne(SatuanKerja::className(), ['id_satuan_kerja' => 'id_satuan_kerja']);
    }

    public function getNama_satuan_kerja()
    {
        return is_null($this->satuanKerja) ? '' : $this->satuanKerja->nama_satuan_kerja;
    }

    public function getDetailHitungTunjangan()
    {
        $data = $this->hasMany(DetHitungTunjangan::className(), ['id_hitung_tunjangan' => 'id_hitung_tunjangan'])
        ->leftJoin('tb_m_pegawai', 'tb_dt_hitung_tunjangan.id_pegawai = tb_m_pegawai.id_pegawai')
        ->leftJoin('tb_m_golongan', 'tb_m_golongan.id_golongan = tb_m_pegawai.id_golongan')
        ->leftJoin('tb_m_jabatan_fungsional', 'tb_m_jabatan_fungsional.id_jabatan_fungsional = tb_m_pegawai.id_jabatan_fungsional')
        ->leftJoin('tb_m_eselon', 'tb_m_eselon.id_eselon = tb_m_jabatan_fungsional.id_eselon')

        ;
        if ((!is_null(Yii::$app->user->identity->pegawai))
        && (is_null(Yii::$app->user->identity->id_satuan_kerja))) {
            $data->where('tb_m_pegawai.id_pegawai=' . Yii::$app->user->identity->pegawai->id_pegawai);
        }
        $data->orderBy(new \yii\db\Expression("coalesce(nama_eselon,'zzzzz') , kode_golongan desc"));

        return $data;
    }
    public function getTotal_tpp_sebelum_pajak()
    {
        $data = $this->hasMany(DetHitungTunjangan::className(), ['id_hitung_tunjangan' => 'id_hitung_tunjangan']);

        if ((!is_null(Yii::$app->user->identity->pegawai))
            && (is_null(Yii::$app->user->identity->id_satuan_kerja))) {
            $data->where('id_pegawai=' . Yii::$app->user->identity->pegawai->id_pegawai);
        }
        $data = $data->all();
        $jumlah = 0;
        foreach ($data as $dt) {
            $jumlah+=(str_replace('.', '', \Yii::$app->formatter->asDecimal($dt->total_tunjangan, 0)));
        }
        return round($jumlah, 0);
    }

    public function getTotal_pajak()
    {
        $data = $this->hasMany(DetHitungTunjangan::className(), ['id_hitung_tunjangan' => 'id_hitung_tunjangan']);

        if ((!is_null(Yii::$app->user->identity->pegawai))
            && (is_null(Yii::$app->user->identity->id_satuan_kerja))) {
            $data->where('id_pegawai=' . Yii::$app->user->identity->pegawai->id_pegawai);
        }


        foreach ($data as $dt) {
            $pajak+=($dt->pajak);
        }
        return round($pajak, 0);
    }


    public function getTotal_tpp_setelah_pajak()
    {
        $data = $this->hasMany(DetHitungTunjangan::className(), ['id_hitung_tunjangan' => 'id_hitung_tunjangan']);

        if ((!is_null(Yii::$app->user->identity->pegawai))
            && (is_null(Yii::$app->user->identity->id_satuan_kerja))) {
            $data->where('id_pegawai=' . Yii::$app->user->identity->pegawai->id_pegawai);
        }
        $data = $data->all();
        $pajak = 0;
        foreach ($data as $dt) {
            $pajak += ($dt->total_netto);
        }
        return round($pajak, 0);
    }

    public function getPeriode_perhitungan()
    {
        return \app\helpers\myhelpers::getMonth2Digit(date('m', strtotime($this->tgl_awal))) . ' ' . date('Y', strtotime($this->tgl_awal));
    }
}
