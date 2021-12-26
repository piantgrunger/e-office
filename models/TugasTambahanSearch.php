<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TugasTambahanSearch represents the model behind the search form of `app\models\TugasTambahan`.
 */
class TugasTambahanSearch extends TugasTambahan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tugas_tambahan', 'bulan', 'tahun', 'id_pegawai', 'id_penilai'], 'integer'],
            [['uraian_tugas', 'file_pendukung', 'status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $jenis = 0)
    {
        $query = TugasTambahan::find();

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
            'id_tugas_tambahan' => $this->id_tugas_tambahan,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'id_pegawai' => $this->id_pegawai,
            'id_penilai' => $this->id_penilai,
        ]);

        if ($jenis == 0) {
            $query->andWhere(['id_pegawai' => Yii::$app->user->identity->id_pegawai]);
        } else {
            $query->andWhere(['id_penilai' => Yii::$app->user->identity->id_pegawai]);
        }

        $query->andFilterWhere(['like', 'uraian_tugas', $this->uraian_tugas])
            ->andFilterWhere(['like', 'file_pendukung', $this->file_pendukung])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
