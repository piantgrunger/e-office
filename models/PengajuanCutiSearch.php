<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PengajuanCuti;

/**
 * PengajuanCutiSearch represents the model behind the search form of `app\models\PengajuanCuti`.
 */
class PengajuanCutiSearch extends PengajuanCuti
{
    public $id_satuan_kerja;
   public $nip;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pengajuan_cuti', 'id_pegawai', 'id_atasan', 'id_kepala', 'id_jenis_absen','id_satuan_kerja'], 'integer'],
            [['alasan', 'tanggal_awal', 'tanggal_akhir', 'alamat', 'telepon','nip'], 'safe'],
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
    public function search($params,$mode=0)
    {
        $query = PengajuanCuti::find()
        ->innerJoin('tb_m_pegawai', 'tb_m_pegawai.id_pegawai=tb_mt_pengajuan_cuti.id_pegawai')
                       ->leftJoin('tb_m_jabatan_fungsional', 'tb_m_jabatan_fungsional.id_jabatan_fungsional=tb_m_pegawai.id_jabatan_fungsional')
            ->leftJoin('tb_m_golongan', 'tb_m_golongan.id_golongan=tb_m_pegawai.id_golongan')
            ->leftJoin('tb_m_eselon', 'tb_m_eselon.id_eselon=tb_m_jabatan_fungsional.id_eselon')
              ->leftJoin('tb_m_satuan_kerja', 'tb_m_satuan_kerja.id_satuan_kerja=tb_m_pegawai.id_satuan_kerja')

        ;
        ;

           // add conditions that should always apply here
        $query->orderBy([new \yii\db\Expression('Coalesce(nama_satuan_kerja,\'zzzzzzzzzz\'),tanggal_awal desc,coalesce(nama_eselon,\'zzzzzz\'),kode_golongan desc')]);

   
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
            'id_pengajuan_cuti' => $this->id_pengajuan_cuti,
            'id_pegawai' => $this->id_pegawai,
            'id_atasan' => $this->id_atasan,
            'id_kepala' => $this->id_kepala,
            'id_jenis_absen' => $this->id_jenis_absen,
            'tb_m_satuan_kerja.id_satuan_kerja' => $this->id_satuan_kerja,
          
           
            'tanggal_awal' => $this->tanggal_awal,
            'tanggal_akhir' => $this->tanggal_akhir,
        ]);

        $query->andFilterWhere(['like', 'alasan', $this->alasan])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'telepon', $this->telepon])
            ->andFilterWhere(['like', 'nip', $this->nip])
          
            ->andFilterWhere(['like', 'tb_m_pegawai.id_satuan_kerja', $this->id_satuan_kerja])
       
            ;

                 if (!is_null(Yii::$app->user->identity->id_pegawai)) {
                     if ($mode == 0) {
                         $query->andWhere(['tb_m_pegawai.id_pegawai' => Yii::$app->user->identity->id_pegawai]);
                     }elseif ($mode == 1) {

                         $query->andWhere(['id_atasan' => Yii::$app->user->identity->id_pegawai]);
                     } else {
                         $query->andWhere(['id_kepala' => Yii::$app->user->identity->id_pegawai]);

                     }
                 }
                 if ($mode === -1) {

                    $query->andWhere(['stat_disposisi_admin' => 1 ]);
                 }

        return $dataProvider;
    }
}
