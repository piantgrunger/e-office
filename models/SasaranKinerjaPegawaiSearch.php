<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SasaranKinerjaPegawai;

/**
 * SasaranKinerjaPegawaiSearch represents the model behind the search form of `app\models\SasaranKinerjaPegawai`.
 */
class SasaranKinerjaPegawaiSearch extends SasaranKinerjaPegawai
{
    /**
     * @inheritdoc
     */
  public $nama_pegawai; 
  public $status_skp;
  public $id_satuan_kerja;
    public function rules()
    {
        return [
            [['id_skp', 'id_pegawai', 'id_penilai', 'kuantitas', 'waktu', 'tahun'], 'integer'],
            [['uraian_tugas', 'satuan_kuantitas', 'satuan_waktu','nama_pegawai','status_skp','id_satuan_kerja'], 'safe'],
            [['angka_kredit', 'biaya'], 'number'],
            
            [['tahun'],'default' ,'value' =>date("Y")]
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
    public function search($params, $jenis = 0)
    {
        $query = SasaranKinerjaPegawai::find()
              ->innerJoin('tb_m_pegawai', 'tb_m_pegawai.id_pegawai=tb_mt_skp.id_pegawai')
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
            'id_skp' => $this->id_skp,
            'tb_mt_skp.id_pegawai' => $this->id_pegawai,
            'id_penilai' => $this->id_penilai,
            'angka_kredit' => $this->angka_kredit,
            'kuantitas' => $this->kuantitas,
            'waktu' => $this->waktu,
            'biaya' => $this->biaya,
            'tahun' => $this->tahun,
            
        ]);

        $query->andFilterWhere(['like', 'uraian_tugas', $this->uraian_tugas])
            ->andFilterWhere(['like', 'satuan_kuantitas', $this->satuan_kuantitas])
           ->andFilterWhere(['like', 'satuan_waktu', $this->satuan_waktu])
           ->andFilterWhere(['like', 'nama', $this->nama_pegawai])
           ->andFilterWhere([ 'tb_m_pegawai.id_satuan_kerja'=> $this->id_satuan_kerja])
          
          ;
        
      if (is_null(Yii::$app->user->identity->id_pegawai)) {
            $query->andWhere('tb_m_pegawai.id_satuan_kerja is not null');
        } elseif ($jenis == 0) {
            $query->andWhere(['tb_mt_skp.id_pegawai' => Yii::$app->user->identity->id_pegawai]);
        } elseif ($jenis == 1) {
            $query->andWhere(['tb_mt_skp.id_penilai' => Yii::$app->user->identity->id_pegawai]);
        }

        if ($jenis==-1) {
            $query->select(['tb_mt_skp.id_pegawai','tb_m_satuan_kerja.nama_satuan_kerja','tb_mt_skp.id_penilai','status_verifikasi','tb_mt_skp.keterangan','tahun'])->distinct()
                     ->innerJoin('tb_m_satuan_kerja', 'tb_m_pegawai.id_satuan_kerja=tb_m_satuan_kerja.id_satuan_kerja')
              ->orderBy('nama_satuan_kerja,tb_mt_skp.id_pegawai,nama_satuan_kerja')
              ;
          
          
           if (isset($this->status_skp)) {
            $statusData= SasaranKinerjaPegawai::find()->select('id_pegawai')
              ->distinct()
              ->where(['like','status_skp',$this->status_skp]);
           
             
            //$query->andFilterWhere(['in','tb_mt_skp.id_pegawai',$statusData ]);

        }  
             
            // die($query->createCommand()->getRawSql());
                 
          
        } else {
           $query->orderBy('tb_m_pegawai.id_satuan_kerja,tb_mt_skp.id_pegawai');
           
        }
      
       
      

        return $dataProvider;
    }
}
