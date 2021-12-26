<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\HariLibur;

/**
 * HariLiburSearch represents the model behind the search form of `app\models\HariLibur`.
 */
class HariLiburSearch extends HariLibur
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_hari_libur'], 'integer'],
            [['nama_hari_libur', 'tanggal_libur'], 'safe'],
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
        $query = HariLibur::find();

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
            'id_hari_libur' => $this->id_hari_libur,
            'tanggal_libur' => $this->tanggal_libur,
        ]);

        $query->andFilterWhere(['like', 'nama_hari_libur', $this->nama_hari_libur]);

        return $dataProvider;
    }
}
