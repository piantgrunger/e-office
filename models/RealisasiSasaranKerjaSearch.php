<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * RealisasiSasaranKerjaSearch represents the model behind the search form of `app\models\RealisasiSasaranKerja`.
 */
class RealisasiSasaranKerjaSearch extends RealisasiSasaranKerja
{
    /**
     * {@inheritdoc}
     */
  public $tahun;
  public $bulan;
  public $pegawai;

  public $uraian_tugas;
     
    public function rules()
    {
        return [
            [['id_realisasi', 'id_skp', 'id_d_skp','tahun','bulan'], 'integer'],
            [['kuantitas'], 'number'],
            [['file_pendukung','pegawai','uraian_tugas','status_realisasi'], 'safe'],
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
        $query = RealisasiSasaranKerja::find()
        ->innerJoin('tb_mt_skp', 'tb_mt_skp.id_skp = tb_mt_realisasi.id_skp')
        ->innerJoin('tb_dt_skp', 'tb_dt_skp.id_d_skp = tb_mt_realisasi.id_d_skp')
          
           ->innerJoin('tb_m_pegawai', 'tb_m_pegawai.id_pegawai=tb_mt_skp.id_pegawai');

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
            'id_realisasi' => $this->id_realisasi,
            'id_skp' => $this->id_skp,
            'id_d_skp' => $this->id_d_skp,
            'kuantitas' => $this->kuantitas,
         'tahun' => $this->tahun,
          'bulan' => $this->bulan,
          'status_realisasi' => $this->status_realisasi,
          
                       
          

        ]);

        $query->andFilterWhere(['like', 'file_pendukung', $this->file_pendukung]);
        $query->andFilterWhere(['like', 'uraian_tugas', $this->uraian_tugas]);       
      $query->andFilterWhere(['like', 'nama', $this->pegawai]);
      
      
      
           
      if (is_null(Yii::$app->user->identity->id_pegawai)) {
            $query->andWhere('tb_m_pegawai.id_pegawai is not null');
        } elseif ($jenis == 0) {
            $query->andWhere(['tb_m_pegawai.id_pegawai' => Yii::$app->user->identity->id_pegawai]);
        } else {
            $query->andWhere(['tb_mt_skp.id_penilai' => Yii::$app->user->identity->id_pegawai]);
        }



        return $dataProvider;
    }
}
