<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\KelasJabatan;

/**
 * KelasJabatanSearch represents the model behind the search form of `app\models\KelasJabatan`.
 */
class KelasJabatanSearch extends KelasJabatan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_kelas_jabatan', 'kelas_jabatan'], 'integer'],
            [['tpp_statis', 'beban_kerja', 'prestasi_kerja', 'tempat_bertugas', 'kondisi_kerja', 'kelangkaan_profesi', 'pertimbangan_lainnya'], 'number'],
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
        $query = KelasJabatan::find();

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
            'id_kelas_jabatan' => $this->id_kelas_jabatan,
            'kelas_jabatan' => $this->kelas_jabatan,
            'tpp_statis' => $this->tpp_statis,
            'beban_kerja' => $this->beban_kerja,
            'prestasi_kerja' => $this->prestasi_kerja,
            'tempat_bertugas' => $this->tempat_bertugas,
            'kondisi_kerja' => $this->kondisi_kerja,
            'kelangkaan_profesi' => $this->kelangkaan_profesi,
            'pertimbangan_lainnya' => $this->pertimbangan_lainnya,
        ]);

        return $dataProvider;
    }
}
