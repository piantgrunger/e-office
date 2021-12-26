<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\LevelJabatan;

/**
 * LevelJabatanSearch represents the model behind the search form of `app\models\LevelJabatan`.
 */
class LevelJabatanSearch extends LevelJabatan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_level_jabatan', 'kelas_level_jabatan'], 'integer'],
            [['nama_level_jabatan'], 'safe'],
            [['nilai_jabatan', 'ikkd', 'tpp_dinamis', 'tpp_statis'], 'number'],
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
        $query = LevelJabatan::find();

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
            'id_level_jabatan' => $this->id_level_jabatan,
            'kelas_level_jabatan' => $this->kelas_level_jabatan,
            'nilai_jabatan' => $this->nilai_jabatan,
            'ikkd' => $this->ikkd,
            'tpp_dinamis' => $this->tpp_dinamis,
            'tpp_statis' => $this->tpp_statis,
        ]);

        $query->andFilterWhere(['like', 'nama_level_jabatan', $this->nama_level_jabatan]);

        return $dataProvider;
    }
}
