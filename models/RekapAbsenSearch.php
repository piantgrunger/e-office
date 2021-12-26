<?php

namespace app\models;

use yii\base\Model;
use Yii;
use yii\data\ActiveDataProvider;
use app\models\RekapAbsen;
use app\jobs\GenerateRekapAbsenJob;


/**
 * RekapAbsenSearch represents the model behind the search form of `app\models\RekapAbsen`.
 */
class RekapAbsenSearch extends RekapAbsen
{
    /**
     * {@inheritdoc}
     */
    public $id_satuan_kerja;

   public $nama_satuan_kerja;

    public function rules()
    {
        return [
            [['bulan', 'tahun', 'id_pegawai'], 'integer'],
            [['id_satuan_kerja', 'bulan', 'tahun','nama_satuan_kerja','tanpa_keterangan'], 'safe'],
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

    public function generateTable($params) {
        $this->load($params);
         $model = RekapAbsen::find()->where(['bulan'=>$this->bulan,'tahun'=>$this->tahun,'id_satuan_kerja'=>$this->id_satuan_kerja])->one();
        if (is_null($model)) {
            //Yii::$app->db->createCommand("insert into tb_mt_rekap_absen select '',id_satuan_kerja, v.* from vw_rekap_absen v inner join tb_m_pegawai p on p.id_pegawai = v.id_pegawai where id_satuan_kerja=$this->id_satuan_kerja and bulan= $this->bulan and tahun= $this->tahun ")->execute();
            Yii::$app->queue->push(new GenerateRekapAbsenJob([
                'bulan' => $this->bulan,
                'tahun' => $this->tahun,
                'id_satuan_kerja' => $this->id_satuan_kerja,
             ]));
        
        } else {
           Yii::$app->session->setFlash('error', 'Laporan Tidak Dapat Dibuat Karena Sudah Ada');

        }

    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params,$allTk=0)
    { 
          if($allTk==0) {
      
            $query = RekapAbsen::find()->select(['tb_mt_rekap_absen.id_satuan_kerja','bulan','tahun'])
                   ->innerJoin('tb_m_satuan_kerja','tb_mt_rekap_absen.id_satuan_kerja=tb_m_satuan_kerja.id_satuan_kerja')
            ->distinct()
      
                 ;
          }else {
            $query = RekapAbsen::find()
                   ->innerJoin('tb_m_satuan_kerja','tb_mt_rekap_absen.id_satuan_kerja=tb_m_satuan_kerja.id_satuan_kerja');
            
          }
       

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
      
        
         $query->andFilterWhere(['like', 'tb_m_satuan_kerja.nama_satuan_kerja', $this->nama_satuan_kerja]);
         $query->andFilterWhere([
           'bulan' => $this->bulan,
           'tahun' => $this->tahun,
           'id_satuan_kerja' => $this->id_satuan_kerja
           
         ]);
       if($allTk!=0) {
         $query->andWhere('tanpa_keterangan > 0');
       }
      
       

  if (!is_null(Yii::$app->user->identity->id_satuan_kerja)) {
       $query->andWhere('tb_m_satuan_kerja.id_satuan_kerja='.Yii::$app->user->identity->id_satuan_kerja);
   }

        return $dataProvider;
    }
}
