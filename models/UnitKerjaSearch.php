<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UnitKerja;

/**
 * UnitKerjaSearch represents the model behind the search form of `app\models\UnitKerja`.
 */
class UnitKerjaSearch extends UnitKerja
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_unit_kerja'], 'integer'],
            [['kode_unit_kerja', 'nama_unit_kerja'], 'safe'],
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
        $query = UnitKerja::find();

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
            'id_unit_kerja' => $this->id_unit_kerja,
        ]);

        $query->andFilterWhere(['like', 'kode_unit_kerja', $this->kode_unit_kerja])
            ->andFilterWhere(['like', 'nama_unit_kerja', $this->nama_unit_kerja]);

        return $dataProvider;
    }
}
