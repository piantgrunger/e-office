<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UsulKenaikanPangkat;

/**
 * UsulKenaikanPangkatSearch represents the model behind the search form of `app\models\UsulKenaikanPangkat`.
 */
class UsulKenaikanPangkatSearch extends UsulKenaikanPangkat
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_usul_kenaikan_pangkat', 'id_pegawai', 'id_jenis_kenaikan_pangkat'], 'integer'],
            [['tanggal_efektif', 'catatan'], 'safe'],
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
        $query = UsulKenaikanPangkat::find()
                ->innerJoin('tb_m_pegawai', 'tb_m_pegawai.id_pegawai=tb_mt_usul_kenaikan_pangkat.id_pegawai')

            ->leftJoin('tb_m_satuan_kerja', 'tb_m_satuan_kerja.id_satuan_kerja=tb_m_pegawai.id_satuan_kerja');



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
            'id_usul_kenaikan_pangkat' => $this->id_usul_kenaikan_pangkat,
            'id_pegawai' => $this->id_pegawai,
            'tanggal_efektif' => $this->tanggal_efektif,
            'id_jenis_kenaikan_pangkat' => $this->id_jenis_kenaikan_pangkat,
        ]);

        $query->andFilterWhere(['like', 'catatan', $this->catatan]);
        if (!is_null(Yii::$app->user->identity->id_satuan_kerja)) {
            $query->andWhere('tb_m_pegawai.id_satuan_kerja='.Yii::$app->user->identity->id_satuan_kerja);
        }

        return $dataProvider;
    }
}
