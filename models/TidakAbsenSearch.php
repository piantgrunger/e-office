<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TidakAbsen;

/**
 * TidakAbsenSearch represents the model behind the search form of `app\models\TidakAbsen`.
 */
class TidakAbsenSearch extends TidakAbsen
{
    /**
     * @inheritdoc
     */
   public $nip;

    public function rules()
    {
        return [
            [['id', 'id_pegawai'], 'integer'],
            [['tgl_absen','nip'], 'safe'],
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
        $query = TidakAbsen::find()
          ->leftJoin('tb_m_pegawai','tb_m_pegawai.id_pegawai=tb_mt_tidak_absen.id_pegawai')
            ->leftJoin('tb_m_jabatan_fungsional','tb_m_pegawai.id_jabatan_fungsional=tb_m_jabatan_fungsional.id_jabatan_fungsional');

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
        
            
            
            

      
        $query->andFilterWhere(['like', 'nip',$this->nip]);
       
        $query->orderBy(new \yii\db\Expression('tgl_absen desc,tb_m_pegawai.id_satuan_kerja,case when id_eselon is null then 99 else id_eselon end '));

        return $dataProvider;
    }
}
