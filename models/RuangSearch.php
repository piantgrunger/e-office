<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ruang;

/**
 * RuangSearch represents the model behind the search form of `app\models\Ruang`.
 */
class RuangSearch extends Ruang
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ruang'], 'integer'],
            [['kode_ruang', 'nama_ruang', 'keterangan'], 'safe'],
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
        $query = Ruang::find();

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
            'id_ruang' => $this->id_ruang,
        ]);

        $query->andFilterWhere(['like', 'kode_ruang', $this->kode_ruang])
            ->andFilterWhere(['like', 'nama_ruang', $this->nama_ruang])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
