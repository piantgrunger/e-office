<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\HitungTunjangan;

/**
 * HitungTunjanganSearch represents the model behind the search form of `app\models\HitungTunjangan`.
 */
class HitungTunjanganSearch extends HitungTunjangan
{
    /**
     * @inheritdoc
     */


    public function rules()
    {
        return [
            [['id_hitung_tunjangan'], 'integer'],
            [['tgl_awal', 'tgl_akhir','id_satuan_kerja'], 'safe'],
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
        $query = HitungTunjangan::find();

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
            'id_hitung_tunjangan' => $this->id_hitung_tunjangan,
            'tgl_awal' => $this->tgl_awal,
            'tgl_akhir' => $this->tgl_akhir,
        ]);
        if (!is_null(Yii::$app->user->identity->id_satuan_kerja)) {
            $query->andWhere("id_satuan_kerja=" . Yii::$app->user->identity->id_satuan_kerja);
        } else {
            if (!is_null(Yii::$app->user->identity->pegawai)) {
                if (!is_null(Yii::$app->user->identity->pegawai->satuanKerja)) {
                    $query->andWhere("id_satuan_kerja=" . Yii::$app->user->identity->pegawai->id_satuan_kerja);
                }
            }
        }
       $query->andFilterWhere(['id_satuan_kerja'=>$this->id_satuan_kerja]);

        return $dataProvider;
    }
}
