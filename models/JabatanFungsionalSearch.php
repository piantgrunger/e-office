<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * JabatanFungsionalSearch represents the model behind the search form of `app\models\JabatanFungsional`.
 */
class JabatanFungsionalSearch extends JabatanFungsional
{
    /**
     * {@inheritdoc}
     */
       public  $nama_satuan_kerja;
       public  $nama_unit_kerja;
       
     public function rules()
    {
        return [
            [['id_jabatan_fungsional'], 'integer'],
            [['nama_jabatan_fungsional','nama_satuan_kerja','nama_unit_kerja' ,'ruang_awal', 'ruang_akhir','status_jabatan'], 'safe'],
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
    public function search($params)
    {
        $query = JabatanFungsional::find()
        ->leftJoin('tb_m_satuan_kerja','tb_m_satuan_kerja.id_satuan_kerja=tb_m_jabatan_fungsional.id_satuan_kerja')
        ->leftJoin('tb_m_unit_kerja','tb_m_unit_kerja.id_unit_kerja=tb_m_jabatan_fungsional.id_unit_kerja');

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
            'id_jabatan_fungsional' => $this->id_jabatan_fungsional,
        ]);

        $query->andFilterWhere(['like', 'nama_jabatan_fungsional', $this->nama_jabatan_fungsional])
        ->andFilterWhere(['like', 'nama_satuan_kerja', $this->nama_satuan_kerja])
        ->andFilterWhere(['like', 'nama_unit_kerja', $this->nama_unit_kerja])  
            ->andFilterWhere(['like', 'ruang_awal', $this->ruang_awal])
            ->andFilterWhere(['like', 'ruang_akhir', $this->ruang_akhir])
                ->andFilterWhere(['like', 'status_jabatan', $this->status_jabatan]);

        return $dataProvider;
    }
}
