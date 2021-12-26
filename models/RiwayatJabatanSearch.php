<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RiwayatJabatan;

/**
 * RiwayatJabatanSearch represents the model behind the search form of `app\models\RiwayatJabatan`.
 */
class RiwayatJabatanSearch extends RiwayatJabatan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_riwayat_jabatan', 'id_pegawai', 'id_jabatan'], 'integer'],
            [['nama_jabatan', 'unit_kerja', 'tmt', 'no_sk', 'pejabat'], 'safe'],
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
        $query = RiwayatJabatan::find();

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
            'id_riwayat_jabatan' => $this->id_riwayat_jabatan,
            'id_pegawai' => $this->id_pegawai,
            'id_jabatan' => $this->id_jabatan,
            'tmt' => $this->tmt,
        ]);

        $query->andFilterWhere(['like', 'nama_jabatan', $this->nama_jabatan])
            ->andFilterWhere(['like', 'unit_kerja', $this->unit_kerja])
            ->andFilterWhere(['like', 'no_sk', $this->no_sk])
            ->andFilterWhere(['like', 'pejabat', $this->pejabat]);

        return $dataProvider;
    }
}
