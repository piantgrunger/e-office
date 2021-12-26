<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\JadwalKerja;

/**
 * JadwalKerjaSearch represents the model behind the search form of `app\models\JadwalKerja`.
 */
class JadwalKerjaSearch extends JadwalKerja
{
    public $nama_pegawai;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pegawai'], 'integer'],
            [['tanggal', 'jam_masuk', 'jam_pulang',"nama_pegawai"], 'safe'],
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
        $query = JadwalKerja::find()
            ->innerJoin('tb_m_pegawai', 'tb_m_pegawai.id_pegawai=tb_m_jadwal_kerja.id_pegawai')

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
            'id_pegawai' => $this->id_pegawai,
            'tanggal' => $this->tanggal,
            'jam_masuk' => $this->jam_masuk,
            'jam_pulang' => $this->jam_pulang,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama_pegawai]);
        if (!is_null(Yii::$app->user->identity->id_satuan_kerja)) {
            $query->andWhere('tb_m_pegawai.id_satuan_kerja=' . Yii::$app->user->identity->id_satuan_kerja);
        } elseif (!is_null(Yii::$app->user->identity->pegawai)) {
            $query->andWhere('tb_m_pegawai.id_pegawai=' . Yii::$app->user->identity->pegawai->id_pegawai);
        }
        if (!is_null(Yii::$app->user->identity->id_satuan_kerja)) {
            $query->andWhere('tb_m_pegawai.id_satuan_kerja=' . Yii::$app->user->identity->id_satuan_kerja);
        }
        if (!is_null(Yii::$app->user->identity->id_ruang)) {
            $query->andWhere('tb_m_pegawai.id_ruang=' . Yii::$app->user->identity->id_ruang);
        }
        return $dataProvider;
    }
}
