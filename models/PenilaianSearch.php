<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Penilaian;

/**
 * PenilaianSearch represents the model behind the search form of `app\models\Penilaian`.
 */
class PenilaianSearch extends Penilaian
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_penilaian', 'bulan', 'tahun', 'id_pegawai', 'id_penilai'], 'integer'],
            [['orientasi_pelayanan', 'integritas', 'komitmen', 'disiplin', 'kerjasama', 'kepemimpinan', 'jumlah', 'rata_rata'], 'number'],
            [['status'], 'safe'],
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
        $query = Penilaian::find();

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
            'id_penilaian' => $this->id_penilaian,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'orientasi_pelayanan' => $this->orientasi_pelayanan,
            'integritas' => $this->integritas,
            'komitmen' => $this->komitmen,
            'disiplin' => $this->disiplin,
            'kerjasama' => $this->kerjasama,
            'kepemimpinan' => $this->kepemimpinan,
            'jumlah' => $this->jumlah,
            'rata_rata' => $this->rata_rata,
            'id_pegawai' => $this->id_pegawai,
            'id_penilai' => $this->id_penilai,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status]);

        if (!is_null(Yii::$app->user->identity->id_pegawai)) {
            if (Yii::$app->user->identity->is_atasan) {
                $query->where("id_penilai=". Yii::$app->user->identity->id_pegawai);
            } else {
                $query->where("id_pegawai=" . Yii::$app->user->identity->id_pegawai);
            }
        }

        return $dataProvider;
    }
}
