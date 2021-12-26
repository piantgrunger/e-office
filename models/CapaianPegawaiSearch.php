<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CapaianPegawai;

/**
 * CapaianPegawaiSearch represents the model behind the search form of `app\models\CapaianPegawai`.
 */
class CapaianPegawaiSearch extends TotalCapaianPegawai
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pegawai', 'id_satuan_kerja', 'tahun', 'bulan'], 'integer'],
            [['nip', 'nama'], 'safe'],
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
        $query = TotalCapaianPegawai::find()   
          ->innerJoin('tb_m_pegawai', 'tb_m_pegawai.id_pegawai=vw_total_capaian.id_pegawai')
          ->leftJoin('tb_m_jabatan_fungsional', 'tb_m_jabatan_fungsional.id_jabatan_fungsional=tb_m_pegawai.id_jabatan_fungsional')
            ->leftJoin('tb_m_golongan', 'tb_m_golongan.id_golongan=tb_m_pegawai.id_golongan')
            ->leftJoin('tb_m_eselon', 'tb_m_eselon.id_eselon=tb_m_jabatan_fungsional.id_eselon')
        

          
          

   ;

            // add conditions that should always apply here
        $query->orderBy([new \yii\db\Expression('coalesce(nama_eselon,\'zzzzzz\'),kode_golongan desc')]);

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
            'vw_total_capaian.id_pegawai' => $this->id_pegawai,
            'vw_total_capaian.id_satuan_kerja' => $this->id_satuan_kerja,
            'tahun' => $this->tahun,
            'bulan' => $this->bulan

        ]);

        $query->andFilterWhere(['like', 'nip', $this->nip])
            ->andFilterWhere(['like', 'nama', $this->nama]);
        if (!is_null(Yii::$app->user->identity->id_satuan_kerja)) {
            $query->andWhere('vw_total_capaian.id_satuan_kerja=' . Yii::$app->user->identity->id_satuan_kerja);
        } elseif (!is_null(Yii::$app->user->identity->pegawai)) {
            $query->andWhere('vw_total_capaian.id_pegawai=' . Yii::$app->user->identity->pegawai->id_pegawai);
        }

        return $dataProvider;
    }
}
