<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Skorsing;

/**
 * SkorsingSearch represents the model behind the search form of `app\models\Skorsing`.
 */
class SkorsingSearch extends Skorsing
{
    /**
     * @inheritdoc
     */
    public $nip;
    public $nama_pegawai;

    public function rules()
    {
        return [
            [['id_skorsing', 'id_pegawai'], 'integer'],
            [['tanggal_awal', 'tanggal_akhir', 'keterangan' ,'nip' ,'nama_pegawai'], 'safe'],
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
        $query = Skorsing::find()
        ->innerJoin('tb_m_pegawai', 'tb_m_pegawai.id_pegawai=tb_mt_skorsing.id_pegawai')
            ->leftJoin('tb_m_satuan_kerja', 'tb_m_satuan_kerja.id_satuan_kerja=tb_m_pegawai.id_satuan_kerja')
;

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
            'id_skorsing' => $this->id_skorsing,
            'id_pegawai' => $this->id_pegawai,
            'tanggal_awal' => $this->tanggal_awal,
            'tanggal_akhir' => $this->tanggal_akhir,
        ]);
        if (!is_null(Yii::$app->user->identity->id_satuan_kerja)) {
            $query->andWhere('tb_m_pegawai.id_satuan_kerja='.Yii::$app ->user->identity->id_satuan_kerja);
        } elseif (!is_null(Yii::$app->user->identity->pegawai)) {
            $query->andWhere('tb_m_pegawai.id_pegawai='.Yii::$app ->user->identity->pegawai->id_pegawai);
        }

        $query->andFilterWhere(['like', 'keterangan', $this->keterangan]);
        $query->andFilterWhere(['like', 'nip', $this->nip]);
        $query->andFilterWhere(['like', 'nama', $this->nama_pegawai]);

        return $dataProvider;
    }
}
