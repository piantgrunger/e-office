<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PegawaiSearch represents the model behind the search form of `app\models\Pegawai`.
 */
class PegawaiSearch extends Pegawai
{
    /**
     * {@inheritdoc}
     */
    public $nama_lengkap;
    public $nama_golongan;
    public $nama_jabatan;
    public $nama_satuan_kerja;
    public $searchWord ;
    public $dataShown;
    public function rules()
    {
        return [
            [['id_pegawai', 'id_unit_kerja', 'id_jabatan_fungsional'], 'integer'],
            [['nip', 'nik', 'nama', 'gelar_depan', 'gelar_belakang', 'alamat', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'nama_lengkap', 'nama_golongan', 'nama_jabatan', 'nama_satuan_kerja','searchWord','dataShown', 'id_satuan_kerja'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $jenis)
    {
        $query = Pegawai::find()
        ->leftJoin('tb_m_jabatan_fungsional', 'tb_m_jabatan_fungsional.id_jabatan_fungsional=tb_m_pegawai.id_jabatan_fungsional')
            ->leftJoin('tb_m_golongan', 'tb_m_golongan.id_golongan=tb_m_pegawai.id_golongan')
            ->leftJoin('tb_m_eselon', 'tb_m_eselon.id_eselon=tb_m_jabatan_fungsional.id_eselon')

            ->leftJoin('tb_m_satuan_kerja', 'tb_m_satuan_kerja.id_satuan_kerja=tb_m_pegawai.id_satuan_kerja')

        ;

        // add conditions that should always apply here

        $this->load($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->dataShown,
            ],
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->orderBy([new \yii\db\Expression('Coalesce(nama_satuan_kerja,\'zzzzzzzzzz\'),coalesce(nama_eselon,\'zzzzzz\'),kode_golongan desc')]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id_pegawai' => $this->id_pegawai,
            'tb_m_pegawai.id_satuan_kerja' => $this->id_satuan_kerja,

            'id_jabatan_fungsional' => $this->id_jabatan_fungsional,
            'tanggal_lahir' => $this->tanggal_lahir,
        ]);

        $query->andFilterWhere(['like', 'nip', $this->nip])
            ->andFilterWhere(['like', 'nik', $this->nik])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'gelar_depan', $this->gelar_depan])
            ->andFilterWhere(['like', 'gelar_belakang', $this->gelar_belakang])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'jenis_kelamin', $this->jenis_kelamin])
            ->andFilterWhere(['like', 'tempat_lahir', $this->tempat_lahir])
        ->andFilterWhere(['like', 'nama_jabatan_fungsional', $this->nama_jabatan])
            ->andFilterWhere(['like', 'nama_satuan_kerja', $this->nama_satuan_kerja])


           ->andFilterWhere(['like', 'nama_golongan', $this->nama_golongan])
            ->andFilterWhere(['like', 'nama', $this->nama_lengkap]);

        if ($this->searchWord !==null) {
            $query->andFilterWhere(['or',['like', 'nama',$this->searchWord],['like', 'nama_satuan_kerja',$this->searchWord] ]);
            $query->orWhere(['or', ['like', 'nama_jabatan_fungsional', $this->searchWord], ['like', 'nama_golongan', $this->searchWord]]);
            $query->orWhere(['or', ['like', 'nip', $this->searchWord], ['like', 'nik', $this->searchWord]]);
        }
 if ($jenis === 0) {
            $query->andWhere("jenis_pegawai in
            ('Pegawai Negeri Sipil')");
        }
        if ($jenis === -1) {
            $query->andWhere("jenis_pegawai in
            ('Pegawai Negeri Sipil','Calon Pegawai Negeri Sipil' )");
        }
        if ($jenis === 2) {
            $query->andWhere("jenis_pegawai = 'Pegawai Negeri Sipil'");
            $query->andWhere(new \yii\db\Expression(" 
            
            
            DATE_FORMAT(  date_add(case when tb_m_eselon.nama_eselon in('II.a','II.b') then DATE_ADD(tanggal_lahir,INTERVAL 60 YEAR) 
            when nama_jabatan_fungsional like '%UTAMA' then DATE_ADD(tanggal_lahir,INTERVAL 65 YEAR)
            when nama_jabatan_fungsional like '%MADYA' then DATE_ADD(tanggal_lahir,INTERVAL 60 YEAR)
            else DATE_ADD(tanggal_lahir,INTERVAL 58 YEAR)
            end , INTERVAL 1 MONTH ) ,'%Y%m') = ".date('Ym')));
        
            $query->orderBy([new \yii\db\Expression("case when tb_m_eselon.nama_eselon in('II.a','II.b') then DATE_ADD(tanggal_lahir,INTERVAL 60 YEAR) 
            when nama_jabatan_fungsional like '%UTAMA' then DATE_ADD(tanggal_lahir,INTERVAL 65 YEAR)
            when nama_jabatan_fungsional like '%MADYA' then DATE_ADD(tanggal_lahir,INTERVAL 60 YEAR)
            else DATE_ADD(tanggal_lahir,INTERVAL 58 YEAR)
            end
            ")]);
        }
    
        if ($jenis === 1) {
            $query->andWhere("jenis_pegawai <> 'Pegawai Negeri Sipil'");
        }

        $query->andWhere('coalesce(tb_m_pegawai.id_satuan_kerja,0) <>0');
        if (!is_null(Yii::$app->user->identity->id_satuan_kerja)) {
            $query->andWhere('tb_m_pegawai.id_satuan_kerja=' . Yii::$app->user->identity->id_satuan_kerja);
        }
        if (!is_null(Yii::$app->user->identity->id_ruang)) {
            $query->andWhere('tb_m_pegawai.id_ruang=' . Yii::$app->user->identity->id_ruang);
        }
        return $dataProvider;
    }
}
