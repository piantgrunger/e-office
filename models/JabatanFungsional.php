<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tb_m_jabatan_fungsional".
 *
 * @property int    $id_jabatan_fungsional
 * @property string $kode_jabatan_fungsional
 * @property string $nama_jabatan_fungsional
 * @property string $ruang_awal
 * @property string $ruang_akhir
 */
class JabatanFungsional extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_m_jabatan_fungsional';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_jabatan_fungsional','status_jabatan','id_satuan_kerja'], 'required'],

            [['nama_jabatan_fungsional','kelas_jabatan' ], 'string', 'max' => 100],
            [['id_unit_kerja'],'safe'],
            [['ruang_awal', 'ruang_akhir'], 'string', 'max' => 4],
            [['nilai_jabatan', 'ikkd', 'tpp_dinamis', 'tpp_statis', 'tambahan_tunjangan_kinerja','id_eselon'
            , 'beban_kerja', 
            'prestasi_kerja', 
            'tempat_bertugas', 
            'kondisi_kerja', 
            'kelangkaan_profesi', 
            'pertimbangan_lainnya', 
            'jml_kebutuhan',
            'pembulatan'
        ], 'number'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_jabatan_fungsional' => Yii::t('app', 'Id Jabatan'),

            'nama_jabatan_fungsional' => Yii::t('app', 'Nama Jabatan'),
            'ruang_awal' => Yii::t('app', 'Ruang Awal'),
            'ruang_akhir' => Yii::t('app', 'Ruang Akhir'),
        'tpp_statis' => 'TPP',
        ];
    }

    public function getUnit_kerja()
    {
        return $this->hasOne(UnitKerja::className(), ['id_unit_kerja' => 'id_unit_kerja']);
    }

    public function getNama_unit_kerja()
    {
        return is_null($this->unit_kerja) ? '' : $this->unit_kerja->nama_unit_kerja;
    }

    public function getSatuan_kerja()
    {
        return $this->hasOne(SatuanKerja::className(), ['id_satuan_kerja' => 'id_satuan_kerja']);
    }

    public function getEselon()
    {
        return $this->hasOne(Eselon::className(), ['id_eselon' => 'id_eselon']);
    }
    public function getNama_satuan_kerja()
    {
        return is_null($this->satuan_kerja) ? '' : $this->satuan_kerja->nama_satuan_kerja;
    }

    public function getNama_eselon()
    {
        return is_null($this->eselon) ? '' : $this->eselon->nama_eselon;
    }

    public function getJumlah_pegawai()
    {
        return Pegawai::find()->where(['id_jabatan_fungsional'=>$this->id_jabatan_fungsional])->
        andWhere(['in','jenis_pegawai',['Pegawai Negeri Sipil','Calon Pegawai Negeri Sipil']])
        ->andWhere("id_satuan_kerja <>0")->count();
    }
}
