<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Eselon;

/**
 * EselonSearch represents the model behind the search form of `app\models\Eselon`.
 */
class EselonSearch extends Eselon
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_eselon'], 'integer'],
            [['nama_eselon'], 'safe'],
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
        $query = Eselon::find();

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
            'id_eselon' => $this->id_eselon,
            'nilai_jabatan' => $this->nilai_jabatan,
            'ikkd' => $this->ikkd,
            'tpp_dinamis' => $this->tpp_dinamis,
            'tpp_statis' => $this->tpp_statis,
        ]);

        $query->andFilterWhere(['like', 'nama_eselon', $this->nama_eselon]);

        return $dataProvider;
    }
}
