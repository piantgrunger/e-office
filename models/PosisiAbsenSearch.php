<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PosisiAbsen;

/**
 * PosisiAbsenSearch represents the model behind the search form of `app\models\PosisiAbsen`.
 */
class PosisiAbsenSearch extends PosisiAbsen
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_satuan_kerja'], 'integer'],
            [['periode', 'tgl_absen_terakhir'], 'safe'],
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
    public function search($params, $id)
    {
        $query = PosisiAbsen::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
          'id_satuan_kerja' => $id,
            'tgl_absen_terakhir' => $this->tgl_absen_terakhir,
        ]);



        $query->andFilterWhere(['like', 'periode', $this->periode]);
       $query->andWhere("tgl_absen_terakhir >='2019-01-01' ");
    //   $query->andWhere("year(tgl_absen_terakhir) =".date("Y"));
       

       

        return $dataProvider;
    }
}
