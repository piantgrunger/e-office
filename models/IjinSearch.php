<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ijin;

/**
 * IjinSearch represents the model behind the search form of `app\models\Ijin`.
 */
class IjinSearch extends Ijin
{
    public $nip;
    public $nama_pegawai;
    public $id_satuan_kerja;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ijin', 'id_jenis_absen', 'id_absen', 'id_pegawai'], 'integer'],
            [['tgl_absen', 'alasan', 'file_pendukung', 'status' ,'nama_pegawai','nip','id_satuan_kerja'], 'safe'],
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
        $query = Ijin::find()
        ->innerJoin('tb_m_pegawai', 'tb_m_pegawai.id_pegawai=tb_mt_ijin.id_pegawai')
          ->leftJoin('tb_m_jabatan_fungsional', 'tb_m_jabatan_fungsional.id_jabatan_fungsional=tb_m_pegawai.id_jabatan_fungsional')
            ->leftJoin('tb_m_golongan', 'tb_m_golongan.id_golongan=tb_m_pegawai.id_golongan')
            ->leftJoin('tb_m_eselon', 'tb_m_eselon.id_eselon=tb_m_jabatan_fungsional.id_eselon')
            ->leftJoin('tb_m_jenis_absen', 'tb_m_jenis_absen.id_jenis_absen=tb_mt_ijin.id_jenis_absen')

            ->leftJoin('tb_m_satuan_kerja', 'tb_m_satuan_kerja.id_satuan_kerja=tb_m_pegawai.id_satuan_kerja');


        // add conditions that should always apply here
        $query->orderBy([new \yii\db\Expression('status, tgl_absen desc,Coalesce(nama_satuan_kerja,\'zzzzzzzzzz\'),coalesce(nama_eselon,\'zzzzzz\'),kode_golongan desc')]);

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
            'id_ijin' => $this->id_ijin,
            'id_jenis_absen' => $this->id_jenis_absen,
            'id_absen' => $this->id_absen,
            'id_pegawai' => $this->id_pegawai,
            'tgl_absen' => $this->tgl_absen,
            'tb_m_pegawai.id_satuan_kerja'=>$this->id_satuan_kerja
        ]);

        $query->andFilterWhere(['like', 'alasan', $this->alasan])
            ->andFilterWhere(['like', 'file_pendukung', $this->file_pendukung])
            ->andFilterWhere(['like', 'status', $this->status]);
        $query->andFilterWhere(['like', 'nama', $this->nama_pegawai]);
        $query->andFilterWhere(['like', 'nip', $this->nip]);
        if (!is_null(Yii::$app->user->identity->id_satuan_kerja)) {
            $query->andWhere('tb_m_pegawai.id_satuan_kerja='.Yii::$app->user->identity->id_satuan_kerja);
        }

        return $dataProvider;
    }
}
