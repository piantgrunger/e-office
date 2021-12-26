<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Golongan;

/**
 * GolonganSearch represents the model behind the search form of `app\models\Golongan`.
 */
class GolonganSearch extends Golongan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_golongan'], 'integer'],
            [['kode_golongan', 'nama_golongan'], 'safe'],
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
        $query = Golongan::find();

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
            'id_golongan' => $this->id_golongan,
            'nilai_jabatan' => $this->nilai_jabatan,
            'ikkd' => $this->ikkd,
            'tpp_dinamis' => $this->tpp_dinamis,
            'tpp_statis' => $this->tpp_statis,
        ]);

        $query->andFilterWhere(['like', 'kode_golongan', $this->kode_golongan])
            ->andFilterWhere(['like', 'nama_golongan', $this->nama_golongan]);

        return $dataProvider;
    }
}
