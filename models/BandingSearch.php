<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * BandingSearch represents the model behind the search form of `app\models\Banding`.
 */
class BandingSearch extends Banding
{
    /**
     * {@inheritdoc}
     */

    public $nama_pegawai;
    public $bulan;
    public $tahun;
    public $nip;
    public $id_satuan_kerja;
    public function rules()
    {
        return [
            [['id_banding', 'id_pegawai', 'id_atasan', 'id_absen'], 'integer'],
            [['tgl_banding', 'alasan', 'file', 'status_banding','nama_pegawai','nip'], 'safe'],
            [['bulan','tahun','id_satuan_kerja'], 'number'],
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
    public function search($params, $mode = 0)
    {
        $query = Banding::find()
        ->innerJoin('tb_m_pegawai', 'tb_m_pegawai.id_pegawai=tb_mt_banding.id_pegawai')
        ->leftJoin('tb_m_jabatan_fungsional', 'tb_m_jabatan_fungsional.id_jabatan_fungsional=tb_m_pegawai.id_jabatan_fungsional')
          ->leftJoin('tb_m_golongan', 'tb_m_golongan.id_golongan=tb_m_pegawai.id_golongan')
          ->leftJoin('tb_m_eselon', 'tb_m_eselon.id_eselon=tb_m_jabatan_fungsional.id_eselon')
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
            'id_banding' => $this->id_banding,
            'tgl_banding' => $this->tgl_banding,
            'tb_m_pegawai.id_pegawai' => $this->id_pegawai,
            'id_atasan' => $this->id_atasan,
            'id_absen' => $this->id_absen,
        ]);

        $query->andFilterWhere(['like', 'alasan', $this->alasan])
            ->andFilterWhere(['like', 'file', $this->file])
            ->andFilterWhere(['like', 'status_banding', $this->status_banding]);
            $query->andFilterWhere(['like', 'nama', $this->nama_pegawai]);
            $query->andFilterWhere(['like', 'nip', $this->nip]);
            $query->andWhere('month(tgl_banding)=' . $this->bulan);
            $query->andWhere('year(tgl_banding)=' . $this->tahun);

            $query->andFilterWhere(['like','tb_m_pegawai.id_satuan_kerja' , $this->id_satuan_kerja]);
        if (!is_null(Yii::$app->user->identity->id_pegawai)) {
            if ($mode == 0) {
                $query->andWhere(['tb_m_pegawai.id_pegawai' => Yii::$app->user->identity->id_pegawai]);
            } else {
                $query->andWhere(['tb_mt_banding.id_atasan' => Yii::$app->user->identity->id_pegawai]);
            }
        }

        return $dataProvider;
    }
}
