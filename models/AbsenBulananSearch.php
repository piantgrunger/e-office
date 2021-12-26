<?php

namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider ;
use app\jobs\GenerateAbsenBulananJob;


/**
 * AbsenBulananSearch represents the model behind the search form of `app\models\AbsenBulanan`.
 */
class AbsenBulananSearch extends AbsenBulanan
{
    /**
     * {@inheritdoc}
     */
    public $id_satuan_kerja;

    public function rules()
    {
        return [
            [['bulan', 'tahun', 'id_pegawai'], 'integer'],
        [['id_satuan_kerja', 'bulan', 'tahun','nama_satuan_kerja'], 'safe'],
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
    public function generateTable($params) {
        $this->load($params);
         $model = AbsenBulanan::find()->where(['bulan'=>$this->bulan,'tahun'=>$this->tahun,'id_satuan_kerja'=>$this->id_satuan_kerja])->one();
        if (is_null($model)) {
          //  Yii::$app->db->createCommand("insert into tb_mt_absen_bulanan select '',id_satuan_kerja, v.* from vw_absen_bulanan v inner join tb_m_pegawai p on p.id_pegawai = v.id_pegawai where id_satuan_kerja=$this->id_satuan_kerja and bulan= $this->bulan and tahun= $this->tahun ")->execute();
           Yii::$app->queue->push(new GenerateAbsenBulananJob([
                'bulan' => $this->bulan,
                'tahun' => $this->tahun,
                'id_satuan_kerja' => $this->id_satuan_kerja,
             ]));
        
        } else {
           Yii::$app->session->setFlash('error', 'Laporan Tidak Dapat Dibuat Karena Sudah Ada');

        }

    }

    public function search($params)
    {
        $query = AbsenBulanan::find()->select(['tb_mt_absen_bulanan.id_satuan_kerja','bulan','tahun'])
          ->innerJoin('tb_m_satuan_kerja','tb_mt_absen_bulanan.id_satuan_kerja=tb_m_satuan_kerja.id_satuan_kerja')
            ->distinct()
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

  //      $this->generateTable();
//        $query->orderBy([new \yii\db\Expression('Coalesce(nama_satuan_kerja,\'zzzzzzzzzz\'),coalesce(nama_eselon,\'zzzzzz\'),kode_golongan desc')]);
     
       $query->andFilterWhere(['like', 'tb_m_satuan_kerja.nama_satuan_kerja', $this->nama_satuan_kerja]);
    

     if (!is_null(Yii::$app->user->identity->id_satuan_kerja)) {
       $query->andWhere('tb_m_satuan_kerja.id_satuan_kerja='.Yii::$app->user->identity->id_satuan_kerja);
   }

        return $dataProvider;
    }
}
