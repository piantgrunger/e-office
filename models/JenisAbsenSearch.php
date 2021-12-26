<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\JenisAbsen;

/**
 * JenisAbsenSearch represents the model behind the search form of `app\models\JenisAbsen`.
 */
class JenisAbsenSearch extends JenisAbsen
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_jenis_absen'], 'integer'],
            [['nama_jenis_absen', 'status_hadir'], 'safe'],
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
        $query = JenisAbsen::find();

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
            'id_jenis_absen' => $this->id_jenis_absen,
        ]);

        $query->andFilterWhere(['like', 'nama_jenis_absen', $this->nama_jenis_absen])
            ->andFilterWhere(['like', 'status_hadir', $this->status_hadir]);

        return $dataProvider;
    }
}
