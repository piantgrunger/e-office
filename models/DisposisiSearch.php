<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Disposisi;

/**
 * DisposisiSearch represents the model behind the search form of `app\models\Disposisi`.
 */
class DisposisiSearch extends Disposisi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_surat_masuk', 'id_pegawai', 'id_parent'], 'integer'],
            [['tanggal_disposisi', 'status_disposisi', 'catatan_disposisi', 'tanggal_diterima', 'jawaban_disposisi'], 'safe'],
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
        $query = Disposisi::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['tanggal_disposisi'=>SORT_DESC]]
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
            'id_surat_masuk' => $this->id_surat_masuk,
            'tanggal_disposisi' => $this->tanggal_disposisi,
            'tanggal_diterima' => $this->tanggal_diterima,
            'id_pegawai' => $this->id_pegawai,
            'id_parent' => $this->id_parent,
        ]);

        $query->andFilterWhere(['like', 'status_disposisi', $this->status_disposisi])
            ->andFilterWhere(['like', 'catatan_disposisi', $this->catatan_disposisi])
            ->andFilterWhere(['like', 'jawaban_disposisi', $this->jawaban_disposisi]);

        if (Yii::$app->user->identity->pegawai) {
            $query->andFilterWhere(['like', 'id_pegawai', Yii::$app->user->identity->id_pegawai]);
        }

        return $dataProvider;
    }
}
