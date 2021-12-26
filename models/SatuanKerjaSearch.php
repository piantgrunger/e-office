<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SatuanKerja;

/**
 * SatuanKerjaSearch represents the model behind the search form of `app\models\SatuanKerja`.
 */
class SatuanKerjaSearch extends SatuanKerja
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_satuan_kerja'], 'integer'],
            [['nama_satuan_kerja'], 'safe'],
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
        $query = SatuanKerja::find();

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
            'id_satuan_kerja' => $this->id_satuan_kerja,
        ]);

        $query->andFilterWhere(['like', 'nama_satuan_kerja', $this->nama_satuan_kerja]);

        return $dataProvider;
    }
}
