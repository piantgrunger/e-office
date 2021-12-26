<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\JabatanTambahan;

/**
 * JabatanTambahanSearch represents the model behind the search form of `app\models\JabatanTambahan`.
 */
class JabatanTambahanSearch extends JabatanTambahan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_jabatan_tambahan'], 'integer'],
            [['nama_jabatan'], 'safe'],
            [['tambahan_tpp'], 'number'],
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
        $query = JabatanTambahan::find();

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
            'id_jabatan_tambahan' => $this->id_jabatan_tambahan,
            'tambahan_tpp' => $this->tambahan_tpp,
        ]);

        $query->andFilterWhere(['like', 'nama_jabatan', $this->nama_jabatan]);

        return $dataProvider;
    }
}
