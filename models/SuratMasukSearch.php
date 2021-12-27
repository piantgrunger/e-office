<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SuratMasuk;

/**
 * SuratMasukSearch represents the model behind the search form of `app\models\SuratMasuk`.
 */
class SuratMasukSearch extends SuratMasuk
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_jenis_surat'], 'integer'],
            [['nomor_surat', 'sifat', 'tgl_surat', 'tgl_terima', 'asal_surat', 'perihal', 'file_surat'], 'safe'],
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
        $query = SuratMasuk::find();

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
            'id' => $this->id,
            'id_jenis_surat' => $this->id_jenis_surat,
            'tgl_surat' => $this->tgl_surat,
            'tgl_terima' => $this->tgl_terima,
        ]);

        $query->andFilterWhere(['like', 'nomor_surat', $this->nomor_surat])
            ->andFilterWhere(['like', 'sifat', $this->sifat])
            ->andFilterWhere(['like', 'asal_surat', $this->asal_surat])
            ->andFilterWhere(['like', 'perihal', $this->perihal])
            ->andFilterWhere(['like', 'file_surat', $this->file_surat]);

        return $dataProvider;
    }
}
