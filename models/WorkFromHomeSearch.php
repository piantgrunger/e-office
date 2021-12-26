<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WorkFromHome;

/**
 * WorkFromHomeSearch represents the model behind the search form of `app\models\WorkFromHome`.
 */
class WorkFromHomeSearch extends WorkFromHome
{
    public $nama_pegawai;
    public $nip;
    public $id_satuan_kerja;
    public $bulan;
    public $tahun;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_wfh', 'id_pegawai','id_satuan_kerja','bulan','tahun'], 'integer'],
            [['tanggal_wfh', 'nama_pegawai','nip'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = WorkFromHome::find()
            ->innerJoin('tb_m_pegawai', 'tb_m_pegawai.id_pegawai=tb_mt_wfh.id_pegawai')
          ->leftJoin('tb_m_jabatan_fungsional', 'tb_m_jabatan_fungsional.id_jabatan_fungsional=tb_m_pegawai.id_jabatan_fungsional')
            ->leftJoin('tb_m_golongan', 'tb_m_golongan.id_golongan=tb_m_pegawai.id_golongan')
            ->leftJoin('tb_m_eselon', 'tb_m_eselon.id_eselon=tb_m_jabatan_fungsional.id_eselon')


            ->leftJoin('tb_m_satuan_kerja', 'tb_m_satuan_kerja.id_satuan_kerja=tb_m_pegawai.id_satuan_kerja')
;

          $query->orderBy([new \yii\db\Expression('Coalesce(nama_satuan_kerja,\'zzzzzzzzzz\'),coalesce(nama_eselon,\'zzzzzz\'),kode_golongan desc,tanggal_wfh desc')]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_wfh' => $this->id_wfh,
            'id_pegawai' => $this->id_pegawai,
            'tanggal_wfh' => $this->tanggal_wfh,
            'tb_m_pegawai.id_satuan_kerja'=> $this->id_satuan_kerja,
        ]);
      
        if (!is_null(Yii::$app->user->identity->id_satuan_kerja)) {
            $query->andWhere('tb_m_pegawai.id_satuan_kerja='.Yii::$app->user->identity->id_satuan_kerja);
        } elseif (!is_null(Yii::$app->user->identity->pegawai)) {
            $query->andWhere('tb_m_pegawai.id_pegawai='.Yii::$app->user->identity->pegawai->id_pegawai);
        }
        $query->andFilterWhere(['like', 'nama', $this->nama_pegawai]);
        $query->andFilterWhere(['like', 'nip', $this->nip]);
        $query->andWhere('month(tanggal_wfh)=' . $this->bulan);
        $query->andWhere('year(tanggal_wfh)=' . $this->tahun);


        return $dataProvider;
    }
}
