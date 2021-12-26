<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\JenisKenaikanPangkat;

/**
 * JenisKenaikanPangkatSearch represents the model behind the search form of `app\models\JenisKenaikanPangkat`.
 */
class JenisKenaikanPangkatSearch extends JenisKenaikanPangkat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_jenis_kenaikan_pangkat'], 'integer'],
            [['jenis_kenaikan_pangkat', 'syarat'], 'safe'],
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
        $query = JenisKenaikanPangkat::find();

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
            'id_jenis_kenaikan_pangkat' => $this->id_jenis_kenaikan_pangkat,
        ]);

        $query->andFilterWhere(['like', 'jenis_kenaikan_pangkat', $this->jenis_kenaikan_pangkat])
            ->andFilterWhere(['like', 'syarat', $this->syarat]);

        return $dataProvider;
    }
}
